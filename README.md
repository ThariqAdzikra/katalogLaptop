# 💻 Katalog Laptop ERP System

Sebuah sistem manajemen katalog dan transaksi laptop berbasis web yang dikembangkan menggunakan **Laravel**.  
Sistem ini berfungsi untuk memberikan katalog produk kepada calon pembeli, sekaligus membantu pegawai dalam mengelola **pembelian dari supplier, stok produk, penjualan, serta transaksi kasir internal**.

---

## 🚀 Tech Stack
- **Framework:** Laravel 12  
- **Language:** PHP 8.3  
- **Frontend:** Bootstrap 5, Blade Template  
- **Database:** MySQL  
- **Environment:** Composer, NPM, Vite  

---

## ⚙️ Fitur Utama

### 👥 Manajemen Pengguna
- Role: **Super Admin** & **Pegawai**
- Autentikasi & otorisasi dengan Laravel Breeze

### 💻 Modul Katalog
- Menampilkan daftar laptop untuk calon pembeli  
- Pencarian & filter berdasarkan merek atau spesifikasi  

### 📦 Modul Stok
- Menampilkan daftar produk lengkap dengan jumlah stok  
- Indikator stok menipis & habis  
- Fitur CRUD produk dan upload gambar  

### 🛒 Modul Pembelian
- Mengelola transaksi pembelian dari supplier  
- Perhitungan total harga otomatis  
- Riwayat pembelian disimpan sebagai log  

### 💰 Modul Penjualan (Kasir)
- Tampilan kasir 2 kolom interaktif  
- Penambahan produk dinamis  
- Perhitungan total otomatis (real-time)  
- Pilihan metode pembayaran: **Cash**, **Transfer**, **QRIS**  
- Preview QRIS dummy  
- Pengurangan stok otomatis setelah transaksi  

### 📊 Laporan Penjualan
- Rekap data penjualan berdasarkan tanggal atau metode pembayaran  
- Ringkasan total penjualan harian/bulanan  

---

## 🧩 Cara Instalasi

1. **Clone Repository**
   ``bash
   git clone https://github.com/username/katalogLaptop.git
   cd katalogLaptop
``

2. **Install Dependencies**

   ```bash
   composer install
   npm install && npm run dev
   ```

3. **Konfigurasi Environment**

   * Duplikat file `.env.example` menjadi `.env`
   * Atur koneksi database:

     ``env
     DB_DATABASE=katalog_laptop
     DB_USERNAME=root
     DB_PASSWORD=
     ``

4. **Generate Key & Migrasi Database**

   ``bash
   php artisan key:generate
   php artisan migrate --seed
   ``

5. **Jalankan Server**

   ``bash
   php artisan serve
   ``

---

## 🔐 Akun Default

| Role        | Email                                             | Password |
| ----------- | ------------------------------------------------- | -------- |
| Super Admin | [admin@example.com](mailto:admin@example.com)     | password |
| Pegawai     | [pegawai@example.com](mailto:pegawai@example.com) | password |

---

## 📜 Lisensi

Project ini dibuat **for educational purpose only**
Tidak diperjualbelikan dan ditujukan untuk kebutuhan akademik Universitas Riau.

---

## 👨‍💻 Tim Pengembang

**Kelompok 3**
*Mata Kuliah Pengembangan Sistem Informasi Berbasis Web Lanjut*
Fakultas Matematika dan Ilmu Pengetahuan Alam – Universitas Riau

---
