# TP7DPBO2025C1

Saya Yazid Madarizel dengan NIM 2305328 mengerjakan soal TP 7 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.

---

# Desain Program

![tp7 drawio](https://github.com/user-attachments/assets/f3bcbba2-681c-42a6-9d3f-1a4f717a4d72)


Sistem ini merupakan aplikasi manajemen pusat kebugaran yang dibangun menggunakan PHP. Sistem ini mempermudah pengelolaan data alat fitness, anggota, pelatih, serta sesi latihan. Berikut adalah penjelasan mengenai desain dan alur program:

---

## Struktur Kelas

### Kelas Equipment.php
- Bertanggung jawab untuk mengelola data alat fitness
- Menyimpan informasi seperti nama, kategori, status, dan tanggal perawatan
- Menyediakan fungsi untuk tambah, ubah, hapus, dan cari alat

### Kelas Member.php
- Mengelola data anggota pusat kebugaran
- Menyimpan nama, email, nomor telepon, tipe keanggotaan, tanggal bergabung, dan tanggal kadaluarsa
- Mendukung fungsi tambah, edit, hapus, dan pencarian anggota

### Kelas Trainer.php
- Menyimpan data pelatih seperti nama, kontak, dan spesialisasi
- Berperan penting dalam pengelolaan sesi latihan bersama anggota

### Kelas Session.php
- Menghubungkan anggota dengan pelatih dalam sesi latihan
- Menyimpan data tanggal, waktu mulai, waktu selesai, status, dan catatan sesi
- Mengelola status sesi: Dijadwalkan, Selesai, atau Dibatalkan

### Kelas Database.php
- Menyediakan koneksi ke basis data
- Menggunakan PDO dan statement yang telah dipersiapkan untuk keamanan

---

## Struktur Basis Data

### Tabel `equipment`
- id (PK)
- name
- category
- status
- purchase_date
- last_maintenance

### Tabel `members`
- id (PK)
- name
- email
- phone
- membership_type
- join_date
- expiry_date

### Tabel `trainers`
- id (PK)
- name
- email
- phone
- specialization

### Tabel `sessions`
- id (PK)
- member_id (FK)
- trainer_id (FK)
- session_date
- start_time
- end_time
- status
- notes

---

## Struktur Folder

```
fitness-center-management/
├── class/
│   ├── Equipment.php
│   ├── Member.php
│   ├── Trainer.php
│   └── Session.php
├── config/
│   └── db.php
├── view/
│   ├── header.php
│   ├── footer.php
│   ├── equipment.php
│   ├── members.php
│   ├── trainers.php
│   └── sessions.php
├── index.php
└── style.css
```

---

## Alur Program

### Inisialisasi
- Program dimulai dari `index.php`
- Sistem terhubung dengan database
- Header dan footer dimuat sebagai layout utama

### Navigasi dan Routing
- Parameter `?page=` pada URL menentukan tampilan halaman
- Sistem akan memuat halaman seperti: `equipment`, `members`, `trainers`, `sessions`
- Parameter tambahan digunakan untuk aksi edit, hapus, dan pencarian

### Operasi CRUD
- **Tambah**: Form mengirim data dengan metode POST, lalu disimpan ke database
- **Lihat**: Data ditampilkan dalam bentuk tabel
- **Ubah**: Form diisi otomatis dengan data lama, kemudian diperbarui di database
- **Hapus**: Disertai konfirmasi sebelum data dihapus

### Fungsi Pencarian
- Setiap halaman memiliki form pencarian
- Kata kunci digunakan untuk memfilter hasil
- Pencarian diimplementasikan di dalam kelas model masing-masing

### Alur Antarmuka Pengguna
- Halaman dashboard menyediakan navigasi ke semua modul
- Tiap modul memiliki:
  - Form pencarian
  - Tabel data
  - Form tambah/edit
  - Tombol aksi
- Pesan sukses atau error ditampilkan untuk memberikan umpan balik

### Manajemen Sesi Latihan
- Sesi latihan menghubungkan anggota dengan pelatih
- Formulir sesi berisi dropdown untuk memilih anggota dan pelatih
- Status sesi: Dijadwalkan, Selesai, Dibatalkan

---

## Keamanan
- Menggunakan PDO dan prepared statements untuk mencegah SQL Injection
- Validasi dan sanitasi input dari pengguna
- Escaping HTML untuk mencegah serangan XSS

---

## Dokumentasi

https://github.com/user-attachments/assets/ebd5a771-003a-47fc-829d-9744cd3ddd30

