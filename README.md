# 📊 Test Web Trusmi

Untuk test ini saya menggunakan framework [CodeIgniter 4](https://codeigniter.com/) dengan frontend modern menggunakan:

- [Chart.js](https://www.chartjs.org/) — untuk visualisasi grafik
- [Bootstrap](https://getbootstrap.com/) — untuk styling responsif
- [jQuery](https://jquery.com/) — untuk DOM & interaktivitas
- Semua library frontend dikelola dengan **NPM**

---

## ✅ Prasyarat

Sebelum menjalankan project ini, pastikan sudah meng-install:

- PHP 7.4 atau lebih baru
- Composer
- Node.js & NPM
- MySQL / MariaDB (untuk database)
- Web server (Apache/Nginx) atau bisa gunakan `php spark serve`

---

## 🚀 Langkah Menjalankan Project

### 1. Clone Repository

```bash
git clone https://github.com/ruliawan/test_web_trusmi.git
cd test_web_trusmi
```

### 2. Clone Repository

```bash
composer install
```

### 3. Clone Repository

```bash
npm install
```

### 4. Compile Asset Frontend

```bash
npm run dev   # untuk development
# atau
npm run build # untuk production
```
Pastikan file hasil build masuk ke folder public/assets atau folder tujuan yang telah kamu atur di config.

### 5. Konfigurasi Database
Buka file app/Config/Database.php, lalu edit bagian berikut:
```bash
public $default = [
    'DSN'      => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'nama_database',
    'DBDriver' => 'MySQLi',
    'DBPrefix' => '',
    'pConnect' => false,
    'DBDebug'  => (ENVIRONMENT !== 'production'),
    'cacheOn'  => false,
    'cacheDir' => '',
    'charset'  => 'utf8',
    'DBCollat' => 'utf8_general_ci',
    'swapPre'  => '',
    'encrypt'  => false,
    'compress' => false,
    'strictOn' => false,
    'failover' => [],
    'port'     => 3306,
];
```

### 6. Jalankan Server
```bash
php spark serve
Akses melalui:
http://localhost:8080
```