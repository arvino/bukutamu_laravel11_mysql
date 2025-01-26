# Buku Tamu Laravel 11

Aplikasi buku tamu modern yang dibangun dengan Laravel 11, menampilkan antarmuka yang bersih untuk mengelola catatan pengunjung secara digital.

## Struktur Proyek
```
bukutamu_laravel11/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php
│   │   │   ├── Auth/
│   │   │   │   └── AuthController.php
│   │   │   ├── BukutamuController.php
│   │   │   └── ProfileController.php
│   │   └── Middleware/
│   │       └── CheckRole.php
│   └── Models/
│       ├── Bukutamu.php
│       └── Member.php
├── config/
│   └── auth.php
├── database/
│   ├── migrations/
│   │   ├── 2024_03_20_000001_create_members_table.php
│   │   ├── 2024_03_20_000002_create_bukutamus_table.php
│   │   └── 2024_03_20_000003_update_members_table.php
│   └── seeders/
│       └── AdminSeeder.php
├── resources/
│   └── views/
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   └── members/
│       │       ├── edit.blade.php
│       │       └── index.blade.php
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       ├── bukutamu/
│       │   ├── form.blade.php
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       ├── layouts/
│       │   └── app.blade.php
│       └── profile/
│           └── edit.blade.php
└── routes/
    ├── auth.php
    └── web.php
```

## Gambaran Umum

Aplikasi ini menyediakan solusi digital untuk mengelola catatan pengunjung dengan fitur-fitur berikut:
- Pendaftaran pengunjung digital
- Dashboard admin untuk manajemen pengunjung
- Statistik pengunjung real-time
- Fungsi ekspor data pengunjung
- Desain responsif untuk semua perangkat
- Pencarian dan filter data pengunjung
- Validasi data secara real-time
- Keamanan data yang terjamin

## Detail Komponen Aplikasi

### 1. Struktur Database
- **Tabel members**:
  - `id`: Primary key
  - `nama`: Nama lengkap member
  - `email`: Email (unique, untuk login)
  - `phone`: Nomor telepon
  - `password`: Password terenkripsi
  - `role`: Role user (member/admin)
  - `email_verified_at`: Timestamp verifikasi email
  - Timestamps standar Laravel

- **Tabel bukutamus**:
  - `id`: Primary key
  - `member_id`: Foreign key ke tabel members
  - `messages`: Pesan buku tamu
  - `gambar`: Path file gambar (opsional)
  - Timestamps standar Laravel

### 2. Fitur Autentikasi
- Menggunakan Laravel's built-in authentication
- Verifikasi email wajib untuk member
- Login menggunakan email dan password
- Remember me functionality
- Password reset capability

### 3. Role dan Permissions
- **Admin**: 
  - Akses penuh ke semua fitur
  - Manajemen member
  - Export data
  - Hapus entri buku tamu
- **Member**: 
  - CRUD buku tamu sendiri
  - Edit profil
  - Batasan 1 post per hari
- **Guest**: 
  - Lihat daftar buku tamu
  - Lihat detail entri

### 4. Pengelolaan File
- Upload gambar menggunakan Laravel Storage
- Validasi tipe file dan ukuran
- Generate thumbnail
- Hapus file otomatis saat update/delete
- Penyimpanan di public disk

### 5. Sistem Validasi
- Server-side validation di semua form
- Custom validation rules
- Error messages dalam bahasa Indonesia
- Validasi real-time untuk:
  - Format email
  - Kekuatan password
  - Ukuran file
  - Tipe file gambar

### 6. API Endpoints
- Authentication menggunakan Laravel Sanctum
- CRUD operations untuk buku tamu
- Response format yang konsisten
- Rate limiting untuk keamanan
- Dokumentasi API tersedia

### 7. Fitur Keamanan
- CSRF protection di setiap form
- XSS prevention
- SQL injection prevention
- Validasi file upload
- Password hashing
- Rate limiting
- Session security
- Middleware authentication

### 8. Frontend Features
- Bootstrap 5 untuk UI modern
- jQuery untuk interaksi dinamis
- SweetAlert2 untuk notifikasi
- Responsive design untuk semua device
- Form validation client-side
- Image preview
- Date picker
- Search dan filter

## Pengaturan Lingkungan

### Pengaturan VSCode
1. Pasang ekstensi berikut:
   - PHP Intelephense (untuk dukungan PHP yang lebih baik)
   - Laravel Blade Formatter (format file blade)
   - Laravel Snippets (potongan kode Laravel)
   - Laravel Artisan (menjalankan perintah artisan)
   - Laravel Blade Snippets (potongan kode blade)
   - PHP Debug (debug aplikasi PHP)
   - Git Lens (integrasi git yang lebih baik)
   - PHP Namespace Resolver (impor namespace otomatis)

2. Konfigurasi settings.json:
   ```json
   {
     "php.validate.executablePath": "php",
     "php.suggest.basic": false,
     "editor.formatOnSave": true,
     "blade.format.enable": true,
     "[php]": {
       "editor.defaultFormatter": "bmewburn.vscode-intelephense-client"
     }
   }
   ```

## Persyaratan Sistem

- PHP 8.2 atau lebih tinggi
- MySQL 8.0 atau lebih tinggi
- Composer
- Node.js & NPM
- Git

## Pengaturan Aplikasi

1. Klon repositori:
   ```bash
   git clone https://github.com/arvino/bukutamu_laravel11_mysql.git
   cd bukutamu_laravel11_mysql
   ```

2. Salin file .env.example:
   ```bash
   cp .env.example .env
   ```

3. Pasang dependensi PHP:
   ```bash
   composer install
   ```

4. Pasang paket NPM:
   ```bash
   npm install
   ```

5. Bangun aset frontend:
   ```bash
   npm run build
   ```

6. Konfigurasi database di file .env:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=bukutamu_laravel11
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. Generate kunci aplikasi:
   ```bash
   php artisan key:generate
   ```

8. Jalankan migrasi dan seeder:
   ```bash
   php artisan migrate
   php artisan db:seed --class=AdminSeeder
   ```

9. Jalankan server pengembangan:
   ```bash
   php artisan serve
   ```

## Kredensial Default Admin
- Email: admin@example.com
- Password: password

## Alur Aplikasi

1. **Registrasi Pengunjung**
   - Pengunjung mengisi formulir pendaftaran
   - Sistem melakukan validasi input
   - Data disimpan ke database
   - Menampilkan konfirmasi pendaftaran
   - Pengunjung menerima bukti kunjungan

2. **Manajemen Admin**
   - Login ke dashboard admin
   - Melihat semua catatan pengunjung
   - Fitur filter dan pencarian
   - Ekspor data pengunjung
   - Menghasilkan laporan
   - Mengelola pengaturan sistem

3. **Pemrosesan Data**
   - Validasi data real-time
   - Pencatatan timestamp otomatis
   - Sanitasi data
   - Penyimpanan yang aman
   - Backup data otomatis

## Pengembangan

Untuk memantau perubahan frontend selama pengembangan:
```bash
npm run dev
```

## Lisensi

Aplikasi ini adalah perangkat lunak open-source yang dilisensikan di bawah [Lisensi MIT](https://opensource.org/licenses/MIT).


## Deployment

### A. Persiapan Server
1. **Spesifikasi Minimum Server**:
   - Ubuntu 20.04 LTS atau lebih tinggi
   - 1GB RAM
   - 20GB Storage
   - PHP 8.2
   - MySQL 8.0
   - Nginx/Apache
   - SSL Certificate

2. **Instalasi Software yang Diperlukan**:
   ```bash
   # Update sistem
   sudo apt update && sudo apt upgrade -y

   # Instalasi PHP dan ekstensi yang diperlukan
   sudo apt install php8.2-fpm php8.2-cli php8.2-mysql php8.2-mbstring \
   php8.2-xml php8.2-curl php8.2-gd php8.2-zip unzip nginx mysql-server

   # Instalasi Composer
   curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer

   # Instalasi Node.js dan NPM
   curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
   sudo apt install -y nodejs
   ```

### B. Konfigurasi Nginx
1. **Buat Konfigurasi Virtual Host**:
   ```nginx
   server {
       listen 80;
       server_name bukutamu.example.com;
       root /var/www/bukutamu/public;

       add_header X-Frame-Options "SAMEORIGIN";
       add_header X-Content-Type-Options "nosniff";

       index index.php;

       charset utf-8;

       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }

       location = /favicon.ico { access_log off; log_not_found off; }
       location = /robots.txt  { access_log off; log_not_found off; }

       error_page 404 /index.php;

       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
           fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
           include fastcgi_params;
       }

       location ~ /\.(?!well-known).* {
           deny all;
       }
   }
   ```

### C. Deployment Aplikasi
1. **Clone Repository**:
   ```bash
   cd /var/www
   git clone https://github.com/arvino/bukutamu_laravel11_mysql.git bukutamu
   cd bukutamu
   ```

2. **Setup Aplikasi**:
   ```bash
   # Install dependencies
   composer install --no-dev --optimize-autoloader
   npm install
   npm run build

   # Set permissions
   sudo chown -R www-data:www-data /var/www/bukutamu
   sudo chmod -R 755 /var/www/bukutamu
   sudo chmod -R 775 /var/www/bukutamu/storage /var/www/bukutamu/bootstrap/cache

   # Setup environment
   cp .env.example .env
   php artisan key:generate
   ```

3. **Konfigurasi Environment**:
   ```env
   APP_NAME="Buku Tamu"
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://bukutamu.example.com

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=bukutamu_prod
   DB_USERNAME=bukutamu_user
   DB_PASSWORD=strong_password

   MAIL_MAILER=smtp
   MAIL_HOST=smtp.example.com
   MAIL_PORT=587
   MAIL_USERNAME=noreply@example.com
   MAIL_PASSWORD=mail_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=noreply@example.com
   MAIL_FROM_NAME="${APP_NAME}"
   ```

4. **Setup Database**:
   ```bash
   # Buat database dan user
   mysql -u root -p
   ```
   ```sql
   CREATE DATABASE bukutamu_prod;
   CREATE USER 'bukutamu_user'@'localhost' IDENTIFIED BY 'strong_password';
   GRANT ALL PRIVILEGES ON bukutamu_prod.* TO 'bukutamu_user'@'localhost';
   FLUSH PRIVILEGES;
   ```
   ```bash
   # Jalankan migrasi
   php artisan migrate --force
   ```

5. **Setup SSL dengan Certbot**:
   ```bash
   sudo apt install certbot python3-certbot-nginx
   sudo certbot --nginx -d bukutamu.example.com
   ```

6. **Setup Cron untuk Scheduled Tasks**:
   ```bash
   sudo crontab -e
   ```
   Tambahkan baris berikut:
   ```
   * * * * * cd /var/www/bukutamu && php artisan schedule:run >> /dev/null 2>&1
   ```

### D. Maintenance dan Backup
1. **Setup Backup Otomatis**:
   ```bash
   # Install backup package
   composer require spatie/laravel-backup

   # Publish konfigurasi
   php artisan vendor:publish --provider="Spatie\Backup\BackupServiceProvider"
   ```

2. **Konfigurasi Backup di config/backup.php**:
   ```php
   'backup' => [
       'name' => env('APP_NAME', 'laravel-backup'),
       'source' => [
           'files' => [
               'include' => [
                   base_path(),
               ],
               'exclude' => [
                   base_path('vendor'),
                   base_path('node_modules'),
               ],
           ],
           'databases' => [
               'mysql',
           ],
       ],
   ],
   ```

3. **Setup Cron untuk Backup**:
   ```
   0 2 * * * cd /var/www/bukutamu && php artisan backup:clean
   5 2 * * * cd /var/www/bukutamu && php artisan backup:run
   ```

### E. Monitoring
1. **Setup Laravel Telescope** (opsional untuk debugging):
   ```bash
   composer require laravel/telescope
   php artisan telescope:install
   php artisan migrate
   ```

2. **Setup Logging ke External Service** (opsional):
   - Papertrail
   - Sentry
   - New Relic

### F. Keamanan
1. **Firewall Setup**:
   ```bash
   sudo ufw allow 22
   sudo ufw allow 80
   sudo ufw allow 443
   sudo ufw enable
   ```

2. **Fail2Ban Setup**:
   ```bash
   sudo apt install fail2ban
   sudo systemctl enable fail2ban
   sudo systemctl start fail2ban
   ```

### G. Update Aplikasi
1. **Proses Update**:
   ```bash
   # Masuk ke maintenance mode
   php artisan down

   # Pull perubahan terbaru
   git pull origin main

   # Update dependencies
   composer install --no-dev --optimize-autoloader
   npm install
   npm run build

   # Jalankan migrasi
   php artisan migrate --force

   # Clear cache
   php artisan optimize:clear
   php artisan optimize

   # Keluar dari maintenance mode
   php artisan up
   ```

### H. Troubleshooting
1. **Check Logs**:
   ```bash
   # Laravel logs
   tail -f /var/www/bukutamu/storage/logs/laravel.log

   # Nginx error logs
   sudo tail -f /var/log/nginx/error.log

   # PHP-FPM logs
   sudo tail -f /var/log/php8.2-fpm.log
   ```

2. **Common Issues**:
   - Permission issues: Periksa kepemilikan file dan folder
   - Cache issues: Clear cache dengan `php artisan optimize:clear`
   - Database connection: Periksa kredensial database
   - Storage link: Jalankan `php artisan storage:link`

## Dibuat Oleh

- **Nama Developer**: Arvino Zulka
- **Email**: arvinozulka@gmail.com
- **Website**: https://www.arvino.my.id/
- **GitHub**: https://github.com/arvino
