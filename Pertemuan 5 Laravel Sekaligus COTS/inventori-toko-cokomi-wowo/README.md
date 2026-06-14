# 🏪 Inventori Toko Cokomi & Wowo

> Sistem manajemen inventari berbasis web untuk Toko Cokomi & Wowo — dibangun menggunakan **Laravel 13** dengan autentikasi **Laravel Breeze**.

---

## 📋 Deskripsi Project

Aplikasi web ini dirancang untuk membantu **Pak Cokomi** dan **Mas Wowo** dalam mengelola inventari produk toko mereka secara digital. Dengan sistem ini, pengelolaan stok barang menjadi lebih mudah, terorganisir, dan efisien.

### ✨ Fitur Utama

| Fitur | Deskripsi |
|-------|-----------|
| 🔐 **Sistem Login** | Autentikasi menggunakan Laravel Breeze |
| 📊 **Dashboard** | Statistik ringkas: total produk, aktif, stok menipis, habis |
| 📦 **CRUD Produk** | Tambah, lihat, edit, hapus produk |
| 🔍 **Pencarian & Filter** | Filter berdasarkan nama, kategori, dan status |
| ↕️ **Sorting** | Urutkan berdasarkan nama, harga, atau stok |
| 📄 **Paginasi** | Tampil 10 produk per halaman |
| 🗑️ **Modal Konfirmasi** | Konfirmasi animasi sebelum menghapus data |
| 🖼️ **Upload Foto** | Upload foto produk (maks. 2MB) |
| 🏷️ **Auto SKU** | Generate kode SKU otomatis jika dikosongkan |
| 📱 **Responsive** | Tampilan mobile-friendly |
| 🌙 **Dark Mode** | Mendukung mode gelap |

---

## 🛠️ Teknologi yang Digunakan

- **Framework:** Laravel 13
- **Auth:** Laravel Breeze (Blade stack)
- **Frontend:** Blade Templating, Tailwind CSS, Alpine.js
- **Database:** SQLite (bawaan Laravel, mudah dipakai lokal)
- **Asset Bundler:** Vite
- **Testing Data:** Database Factory & Seeder (Faker)

---

## 🚀 Cara Menjalankan Project

### Prasyarat
Pastikan sudah terinstall:
- PHP >= 8.2
- Composer
- Node.js & NPM

### Langkah Instalasi

```bash
# 1. Masuk ke direktori project
cd inventori-toko-cokomi-wowo

# 2. Install dependensi PHP
composer install

# 3. Install dependensi Node.js
npm install

# 4. Salin file environment
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Jalankan migrasi + seeder (isi data contoh)
php artisan migrate --seed

# 7. Buat symbolic link storage
php artisan storage:link

# 8. Build asset frontend
npm run build

# 9. Jalankan server lokal
php artisan serve
```

Buka di browser: **http://localhost:8000**

---

## 👤 Akun Default (Seeder)

| Nama | Email | Password |
|------|-------|----------|
| Pak Cokomi | `cokomi@toko.com` | `password123` |
| Mas Wowo | `wowo@toko.com` | `password123` |

> Kedua akun dapat langsung digunakan untuk login setelah menjalankan seeder.

---

## 🗂️ Struktur Database

### Tabel `products`

| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| `id` | bigint | Primary key |
| `name` | varchar(255) | Nama produk |
| `category` | varchar(255) | Kategori produk |
| `description` | text | Deskripsi produk |
| `price` | decimal(12,2) | Harga jual (Rp) |
| `cost_price` | decimal(12,2) | Harga modal (Rp) |
| `stock` | integer | Jumlah stok |
| `unit` | varchar | Satuan (pcs, kg, liter, dll.) |
| `sku` | varchar(50) | Kode SKU (unique) |
| `image` | varchar | Nama file gambar |
| `is_active` | boolean | Status aktif/nonaktif |
| `created_at` | timestamp | Waktu dibuat |
| `updated_at` | timestamp | Waktu diperbarui |

### Kategori Produk yang Tersedia
- Makanan & Minuman
- Sembako
- Kebersihan & Perawatan
- Elektronik
- Pakaian
- Alat Tulis
- Obat & Kesehatan
- Lainnya

---

## 📁 Struktur Direktori Penting

```
inventori-toko-cokomi-wowo/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── ProductController.php   # CRUD produk
│   └── Models/
│       └── Product.php                  # Model produk
├── database/
│   ├── factories/
│   │   └── ProductFactory.php           # Factory data random
│   ├── migrations/
│   │   └── ..._create_products_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── UserSeeder.php               # Seeder Pak Cokomi & Mas Wowo
│       └── ProductSeeder.php            # 15 produk nyata + 25 random
├── resources/
│   └── views/
│       ├── dashboard.blade.php          # Halaman dashboard
│       └── products/
│           ├── index.blade.php          # Data table produk
│           ├── create.blade.php         # Form tambah produk
│           ├── edit.blade.php           # Form edit produk
│           └── show.blade.php           # Detail produk
└── routes/
    └── web.php                          # Route aplikasi
```

---

## 🔗 Daftar Route

| Method | URI | Nama | Keterangan |
|--------|-----|------|-----------|
| GET | `/` | — | Redirect ke dashboard/login |
| GET | `/dashboard` | `dashboard` | Halaman utama (auth) |
| GET | `/products` | `products.index` | Daftar produk |
| GET | `/products/create` | `products.create` | Form tambah |
| POST | `/products` | `products.store` | Simpan produk baru |
| GET | `/products/{id}` | `products.show` | Detail produk |
| GET | `/products/{id}/edit` | `products.edit` | Form edit |
| PUT | `/products/{id}` | `products.update` | Update produk |
| DELETE | `/products/{id}` | `products.destroy` | Hapus produk |

> Semua route produk dilindungi middleware `auth`.

---

## 🌱 Data Seeder

Setelah menjalankan `php artisan db:seed`, database akan terisi dengan:

- **2 User** default (Pak Cokomi & Mas Wowo)
- **15 Produk manual** yang representatif (Indomie, Beras, Minyak Goreng, dll.)
- **20 Produk random** dihasilkan oleh `ProductFactory`
- **5 Produk** dengan stok habis

**Total: 40 produk** siap pakai saat pertama kali membuka aplikasi.

---

## 📝 Catatan Tambahan

- Project menggunakan **SQLite** sebagai database default (file `database/database.sqlite`) — tidak perlu setup MySQL/server database terpisah.
- Foto produk disimpan di `storage/app/public/products/` dan dapat diakses via `public/storage/products/`.
- Laravel Breeze menyediakan halaman **Register, Login, Forgot Password**, dan **Profile**.

---

## 👨‍💻 Pembuat

**Muhammad Ragiel Prastyo**  
NIM: 2311102183  
Mata Kuliah: Praktikum Aplikasi Berbasis Platform  
Semester 6 — Pertemuan 5

---

*"Please wok bantuin biar mas Cokomi bisa belanja di toko nya mas Wowo" — dan sekarang bisa! 🎉*
