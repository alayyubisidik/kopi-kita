# Phase 16 — Admin Order Management

## 16.1 Order List

*** [ ] Admin dapat melihat daftar seluruh order.**

*** [ ] Tampilkan Order code.**

*** [ ] Tampilkan Customer name.**

*** [ ] Tampilkan Order type (online/offline).**

*** [ ] Tampilkan Total order.**

*** [ ] Tampilkan Payment method (midtrans/cash/qris).**

*** [ ] Tampilkan Payment status (pending/success/failed/expired).**

*** [ ] Tampilkan Tanggal dan Waktu order (created_at).**

*** [ ] Tampilkan Status order (processing/completed).**

*** [ ] Sediakan fitur pencarian berdasarkan Order code dan Customer name.**

*** [ ] Sediakan filter berdasarkan Order type, Payment method, Payment status, dan Order status.**

*** [ ] Tampilkan dalam bentuk tabel yang rapi dan responsive.**

*** [ ] Gunakan pagination untuk membatasi jumlah data per halaman.**

---

## 16.2 Order Detail

*** [ ] Admin dapat melihat detail setiap order.**

*** [ ] Tampilkan Order code, Customer name, Order type, Total, Payment method, Payment status, dan Tanggal order.**

*** [ ] Tampilkan daftar Product yang dipesan (Product list).**

*** [ ] Tampilkan Quantity setiap product.**

*** [ ] Tampilkan Customization (options) yang dipilih untuk setiap product.**

*** [ ] Tampilkan Notes atau catatan tambahan dari customer.**

*** [ ] Tampilkan Subtotal dan Total akhir order.**

*** [ ] Tampilkan informasi lengkap mengenai Payment (midtrans response, paid_at, dll jika relevan).**

*** [ ] Tampilkan status operasional order saat ini.**

*** [ ] Pastikan tampilan detail order mudah dibaca dan diorganisir dengan baik.**

---

## 16.3 Order Processing

*** [ ] Order baru masuk setelah pembayaran berhasil. Sistem tidak membutuhkan status `Pending Payment` sebagai order workflow.**

*** [ ] Gunakan status operasional minimal sesuai database `orders.status` (enum: processing, completed).**

*** [ ] Order secara default masuk dengan status `processing`.**

*** [ ] Admin dapat menandai order menjadi `completed` ketika order sudah selesai.**

*** [ ] Sediakan tombol atau action untuk mengubah status order.**

*** [ ] Pastikan perubahan status tersimpan di database.**

*** [ ] Status pembayaran (di tabel `payments`) tetap disimpan terpisah dari status proses order (di tabel `orders`).**

*** [ ] Tambahkan log aktivitas (menggunakan Activitylog) saat admin mengubah status order.**

*** [ ] Tampilkan notifikasi (toast) setelah status berhasil diubah.**

---

## 16.4 Route & Controller Setup

*** [ ] Buat `AdminOrderController` di namespace `App\Http\Controllers\Admin`.**

*** [ ] Buat route `GET /admin/orders` untuk halaman list order.**

*** [ ] Gunakan named route, misalnya `admin.orders.index`.**

*** [ ] Buat route `GET /admin/orders/{order}` untuk halaman detail order.**

*** [ ] Gunakan named route, misalnya `admin.orders.show`.**

*** [ ] Buat route `PATCH /admin/orders/{order}/status` untuk mengupdate status order.**

*** [ ] Gunakan named route, misalnya `admin.orders.update-status`.**

*** [ ] Pastikan seluruh route order protected oleh middleware admin (auth).**

---

## 16.5 UI & User Experience

*** [ ] Gunakan layout admin yang sudah ada.**

*** [ ] Gunakan Tailwind CSS 4 dan komponen UI yang konsisten dengan halaman admin lainnya.**

*** [ ] Gunakan badge berwarna untuk membedakan status order (misal: kuning untuk processing, hijau untuk completed).**

*** [ ] Gunakan badge berwarna untuk membedakan payment status.**

*** [ ] Sediakan konfirmasi (modal) sebelum admin mengubah status order menjadi completed.**

*** [ ] Pastikan halaman order list dan detail responsive pada berbagai ukuran layar.**

*** [ ] Tampilkan empty state jika belum ada order yang masuk.**

---

## 16.6 Validation & Security

*** [ ] Validasi request perubahan status hanya menerima nilai 'processing' atau 'completed'.**

*** [ ] Pastikan order yang sudah 'completed' tidak dapat diubah kembali menjadi 'processing' (jika diperlukan kebijakan tersebut, atau berikan peringatan).**

*** [ ] Validasi hanya admin yang terautentikasi yang dapat mengakses fitur ini.**

*** [ ] Cegah manipulasi parameter ID order melalui URL (tampilkan 404 jika order tidak ditemukan).**

---

## 16.7 Testing & Verification

*** [ ] Pastikan daftar order menampilkan semua data dengan benar sesuai filter.**

*** [ ] Pastikan pencarian berdasarkan Order code dan Customer name berfungsi.**

*** [ ] Pastikan halaman detail menampilkan semua informasi order, item, dan payment dengan benar.**

*** [ ] Pastikan admin dapat mengubah status order dari `processing` menjadi `completed`.**

*** [ ] Pastikan status order tersimpan dengan benar di database.**

*** [ ] Pastikan notifikasi keberhasilan muncul setelah mengubah status.**

*** [ ] Pastikan order dengan status `completed` tertampil dengan benar di list dan detail.**

*** [ ] Pastikan tidak ada N+1 query problem saat menampilkan order list dan detail (gunakan eager loading untuk `order_items`, `payments`, dll).**