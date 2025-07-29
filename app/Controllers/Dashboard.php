<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    public function index()
    {
        return view('dashboard/index');
    }

    public function get_kpi() {
        $db = \Config\Database::connect();

        $query = $db->query("
            WITH base AS (
                SELECT 
                    karyawan,
                    kpi,
                    COUNT(*) AS target,
                    COUNT(*) AS actual,
                    SUM(CASE WHEN aktual > deadline THEN 1 ELSE 0 END) AS late
                FROM table_kpi_marketing
                GROUP BY karyawan, kpi
            ),
            scored AS (
                SELECT 
                    karyawan,
                    kpi,
                    target,
                    actual,
                    ROUND(CASE WHEN target = 0 THEN 0 ELSE 100.0 * actual / target END) AS pencapaian_persen,
                    CASE WHEN kpi = 'Sales' THEN 50 WHEN kpi = 'Report' THEN 50 END AS bobot_kpi,
                    late,
                    ROUND(
                        (CASE WHEN target = 0 THEN 0 ELSE (actual / target) END * 
                            CASE WHEN kpi = 'Sales' THEN 0.5 WHEN kpi = 'Report' THEN 0.5 END * 100
                        ) + 
                        (CASE WHEN kpi = 'Sales' THEN late * -7 WHEN kpi = 'Report' THEN late * -5 END)
                    ) AS skor_total_bobot
                FROM base
            ),
            pivot AS (
                SELECT
                    k1.karyawan AS nama_karyawan,

                    -- SALES
                    k1.target AS sales_target,
                    k1.actual AS sales_actual,
                    CONCAT(k1.pencapaian_persen, '%') AS sales_pencapaian,
                    CONCAT(k1.bobot_kpi, '%') AS sales_bobot_kpi,
                    k1.late AS sales_jumlah_late,
                    CONCAT(k1.skor_total_bobot, '%') AS sales_total_bobot,

                    -- REPORT
                    k2.target AS report_target,
                    k2.actual AS report_actual,
                    CONCAT(COALESCE(k2.pencapaian_persen, 0), '%') AS report_pencapaian,
                    CONCAT(COALESCE(k2.bobot_kpi, 0), '%') AS report_bobot_kpi,
                    COALESCE(k2.late, 0) AS report_jumlah_late,
                    CONCAT(COALESCE(k2.skor_total_bobot, 0), '%') AS report_total_bobot,

                    -- TOTAL KPI
                    (COALESCE(k1.skor_total_bobot, 0) + COALESCE(k2.skor_total_bobot, 0)) AS total_kpi_score
                FROM scored k1
                LEFT JOIN scored k2 
                    ON k1.karyawan = k2.karyawan AND k2.kpi = 'Report'
                WHERE k1.kpi = 'Sales'
            )

            SELECT * FROM pivot
            ORDER BY total_kpi_score DESC
        ");

        return $this->response->setJSON($query->getResult());
    }


    public function get_percentage_ontime() {
        $db = \Config\Database::connect();

        $query = $db->query("
            SELECT 
                `karyawan`,
                COUNT(*) AS total_task,
                SUM(CASE WHEN `aktual` <= `deadline` THEN 1 ELSE 0 END) AS total_ontime,
                SUM(CASE WHEN `aktual` > `deadline` THEN 1 ELSE 0 END) AS total_late,
                CONCAT(ROUND(
                    CASE 
                        WHEN COUNT(*) = 0 THEN 0
                        ELSE 100.0 * SUM(CASE WHEN `aktual` <= `deadline` THEN 1 ELSE 0 END) / COUNT(*) 
                    END), '%') AS persentase_ontime,
                CONCAT(ROUND(
                    CASE 
                        WHEN COUNT(*) = 0 THEN 0
                        ELSE 100.0 * SUM(CASE WHEN `aktual` > `deadline` THEN 1 ELSE 0 END) / COUNT(*) 
                    END), '%') AS persentase_late
            FROM `table_kpi_marketing`
            GROUP BY `karyawan`
            ORDER BY `karyawan`
        ");

        $result = $query->getResult();

        return $this->response->setJSON($result);
    }

}
