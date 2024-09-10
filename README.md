<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# ✨ Application ABD Party App


## 📌 Fitur

-   Manajemen pengguna dengan sistem RBAC (Role-Based Access Controll)
-   Master (Data Product)
-   Graphic Base Reporting
-   Transaction Invoice by digital
-   Proses Approvel Order product
-   Export

# Storage Setting Company Profile
-    clients
-    service

## 🛠 Teknologi

-   [Laravel v10](https://laravel.com/docs/10.x)
-   [Bootstrap](https://getbootstrap.com/)

Untuk menjalankan aplikasi ini, sistem minimal yang dibutuhkan adalah sebagai berikut:

-   PHP 8.1 atau yang lebih tinggi
-   MySQL 5.7 atau yang lebih tinggi
-   Composer
-   Node.js 18 atau yang lebih tinggi
-   NPM 7 atau yang lebih tinggi

## 💻 Cara Install dan Menjalankan Aplikasi

1. Clone repository ini dengan perintah

```
git clone https://github.com/adittia12/abd-party-app.git
```

2. Masuk ke direktori aplikasi dengan perintah

```
cd abd-party-app
```

3. Salin file .env.example menjadi .env dengan perintah

```
cp .env.example .env
```

4. Sesuaikan konfigurasi database pada file .env sesuai dengan database yang akan digunakan

5. Jalankan perintah

```
composer install
```

untuk menginstal semua package PHP yang dibutuhkan

6. Jalankan perintah

```
npm install
```

untuk menginstal semua package JavaScript yang dibutuhkan

7. Jalankan perintah

```
php artisan key:generate
```

untuk menghasilkan application key yang diperlukan

8. Jalankan perintah

```
php artisan storage:link
```

untuk membuat symbolic link ke direktori storage

9. Jalankan perintah

```
php artisan migrate --seed
```

untuk menjalankan migrasi database dan menambahkan data awal. Kamu bisa merubah data awal pada file database/seeders/

10. Jalankan perintah

```
php artisan serve
```

untuk menjalankan aplikasi pada http://localhost:8000/

Sekarang kamu bisa mengakses aplikasi ini pada http://localhost:8000/
