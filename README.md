# 🌍 LangkahGlobal Project

Panduan untuk menjalankan **LangkahGlobal**, sebuah project berbasis **Laravel 10** dengan integrasi **TailwindCSS (Vite)**.  
Project ini dikembangkan untuk mendukung pengalaman modern dalam membangun website/blog dengan desain yang responsif, cepat, dan mudah dikembangkan.

LangkahGlobal menggabungkan berbagai teknologi frontend & backend, sehingga memudahkan developer dalam mengelola tampilan, alur data, hingga interaksi pengguna.

---

## ⚡ Teknologi yang Digunakan

<p align="left">
  <img src="https://skillicons.dev/icons?i=laravel" height="40" alt="Laravel"/>  
  <img src="https://skillicons.dev/icons?i=tailwind" height="40" alt="TailwindCSS"/>  
  <img src="https://skillicons.dev/icons?i=vite" height="40" alt="Vite"/>  
  <img src="https://skillicons.dev/icons?i=git" height="40" alt="Git"/>  
  <img src="https://skillicons.dev/icons?i=mysql" height="40" alt="MySQL"/>  
</p>

Tambahan library penting yang digunakan dalam project ini:

-   ⚡ **Alpine.js** → untuk interaktivitas ringan tanpa framework berat
-   🎨 **Flowbite.js** → komponen UI siap pakai untuk Tailwind
-   💡 **SweetAlert2** → notifikasi popup interaktif
-   🔗 **Axios** → komunikasi HTTP (API request & response)
-   🎛️ **PostCSS** → untuk memproses CSS (autoprefixing, nesting, dsb.)

---

## 🚀 Fitur Utama

-   ✅ Menggunakan **Laravel 10** sebagai backend
-   🎨 Styling dengan **TailwindCSS + Flowbite**
-   ⚡ Interaktivitas ringan pakai **Alpine.js**
-   📦 Build & bundling modern dengan **Vite**
-   🔗 API request mudah dengan **Axios**
-   💾 Database terhubung dengan **MySQL**
-   🔔 Notifikasi interaktif via **SweetAlert2**
-   📂 Manajemen source code dengan **Git**

---

## 🔧 Cara Menjalankan di Jaringan Lokal

#### 1. Clone Repository

```bash
git clone https://github.com/4lyaya/Langkah_Global.git
cd visitsmuhero
```

#### 2. Install Dependency

Backend (Laravel)

```bash
composer install
```

Frontend (Vite + Tailwind + Alpine.js)

```bash
npm install
```

#### 3. Konfigurasi Environment

Salin file .env.example menjadi .env:

```bash
cp .env.example .env
```

#### 4. Generate Key & Migrasi Database

```bash
php artisan key:generate
php artisan migrate --seed
```

#### 5. Jalankan Server

Buka 2 terminal

Laravel Backend

```bash
php artisan serve
```

Vite Frondend

```bash
npm run dev
```

#### 6. Akses Website

Buka browser dan akses:

```cpp
http://127.0.0.1:8000
```

---

## 👨‍💻 Kontributor

-   **Akmal Raditya Wijaya** — Web Developper
