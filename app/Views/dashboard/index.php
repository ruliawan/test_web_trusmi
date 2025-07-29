<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?= base_url('assets/styles.css') ?>">
    <script src="<?= base_url('assets/app.js') ?>"></script>
</head>
<body>
    <div class="row mt-3">
        <div class="container">
            <div class="d-flex flex-row col-md-12">
                <div class="col-md-6">
                    <h3 class="text-center">Dashboard KPI</h3>
                    <canvas id="dashboard_kpi" width="800" height="400"></canvas>
                </div>
                <div class="col-md-6">
                    <h3 class="text-center">Dashboard Persentase Ontime</h3>
                    <canvas id="dashboard_percentage_ontime" width="800" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function () {
        $.ajax({
            url: "/get_kpi", 
            method: "GET",
            dataType: 'JSON',
            success: function (response) {
                const nama_karyawan = response.map(item => item.nama_karyawan);
                
                const sales_pencapaian = response.map(item => parseFloat(item.sales_pencapaian));
                const sales_total_bobot = response.map(item => parseFloat(item.sales_total_bobot));
                
                const report_pencapaian = response.map(item => parseFloat(item.report_pencapaian));
                const report_total_bobot = response.map(item => parseFloat(item.report_total_bobot));
                
                const total_kpi = response.map(item => parseFloat(item.total_kpi_score));

                const ctx = document.getElementById('dashboard_kpi').getContext('2d');
                const chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: nama_karyawan,
                        datasets: [
                            {
                                label: 'Sales Pencapaian (%)',
                                backgroundColor: '#4e73df',
                                data: sales_pencapaian
                            },
                            {
                                label: 'Sales Total Bobot (%)',
                                backgroundColor: '#1cc88a',
                                data: sales_total_bobot
                            },
                            {
                                label: 'Report Pencapaian (%)',
                                backgroundColor: '#36b9cc',
                                data: report_pencapaian
                            },
                            {
                                label: 'Report Total Bobot (%)',
                                backgroundColor: '#f6c23e',
                                data: report_total_bobot
                            },
                            {
                                label: 'Total KPI Score (%)',
                                backgroundColor: '#e74a3b',
                                data: total_kpi
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            tooltip: {
                                mode: 'index',
                                intersect: false
                            }
                        },
                        interaction: {
                            mode: 'nearest',
                            axis: 'x',
                            intersect: false
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100
                            }
                        }
                    }
                });
            },
            error:function(response) {}
        });

        $.ajax({
            type: "GET",
            url: "/get_percentage_ontime",
            dataType: "JSON",
            success: function (response) {
                const nama_karyawan = response.map(item => item.karyawan);
                const ontime = response.map(item => parseFloat(item.persentase_ontime));
                const late = response.map(item => parseFloat(item.persentase_late));

                const ctx = document.getElementById('dashboard_percentage_ontime').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: nama_karyawan,
                        datasets: [
                            {
                                label: 'On-Time (%)',
                                backgroundColor: '#1cc88a',
                                data: ontime
                            },
                            {
                                label: 'Late (%)',
                                backgroundColor: '#e74a3b',
                                data: late
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            tooltip: {
                                mode: 'index',
                                intersect: false
                            }
                        },
                        interaction: {
                            mode: 'nearest',
                            axis: 'x',
                            intersect: false
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100
                            }
                        }
                    }
                });
            },
            error: function(response) {}
        });
    });
</script>
</html>