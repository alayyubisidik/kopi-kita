# Phase 2 - Security Rules Documentation

## Setup Admin Security Rules

| Kondisi                          | `/setup-admin`        |
| -------------------------------- | --------------------- |
| Belum ada user                   | Bisa diakses          |
| Belum ada user + Setup Key salah | Ditolak               |
| Belum ada user + Setup Key benar | Admin dibuat          |
| Sudah ada user + belum login     | Redirect ke login     |
| Sudah ada user + sudah login     | Redirect ke dashboard |

## Authentication Rules

1. **Dashboard Protection**
   - Semua route dashboard dilindungi oleh `auth` middleware
   - Customer pages dapat diakses tanpa login (welcome page)

2. **Register Feature Removal**
   - Route `/register` dihapus
   - Controller `RegisteredUserController` dihapus
   - View `register.blade.php` dihapus
   - Tidak ada public registration

3. **User Management**
   - Menggunakan tabel `users` standar Laravel
   - Tidak menggunakan Spatie Permission
   - Tidak ada kolom `role` pada tabel users
   - Tidak ada Admin Seeder
   - User pertama dibuat melalui `/setup-admin`

## Setup Key Configuration

- Setup Key: `7285abc06e19abb7930615857e92da1b` (32 karakter)
- Disimpan di `.env` sebagai `ADMIN_SETUP_KEY`
- Di-expose melalui `config('app.admin_setup_key')`
- Tidak di-hardcode di source code
- Tidak disimpan ke database
- Tidak ditampilkan ke frontend

## Middleware Implementation

Middleware `CheckFirstUserSetup` mengimplementasikan:
1. Redirect ke `/setup-admin` jika belum ada user
2. Redirect ke login/dashboard jika sudah ada user
3. Setup hanya bisa dilakukan satu kali

## Testing Notes

Untuk testing Phase 2:
1. Pastikan database `users` tabel kosong
2. Akses aplikasi - harus redirect ke `/setup-admin`
3. Buat admin pertama dengan setup key yang benar
4. Setelah admin dibuat, `/setup-admin` tidak bisa diakses lagi
5. Login dengan admin yang baru dibuat
6. Dashboard harus bisa diakses
7. Customer pages (/) harus tetap bisa diakses tanpa login