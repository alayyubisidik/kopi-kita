# Phase 16 — Admin Order Management

## 16.1 Order Routes & Controller

*** [ ] Buat `Admin\OrderController`.**

*** [ ] Buat route dashboard `/admin/orders` (index, show, update).**

*** [ ] Gunakan middleware `auth`.**

*** [ ] Pastikan route terproteksi dengan baik.**

*** [ ] Gunakan named route yang konsisten.**

---

## 16.2 Order List View (Index)

*** [ ] Buat halaman `resources/views/admin/orders/index.blade.php`.**

*** [ ] Tampilkan daftar pesanan (order list) dalam bentuk tabel.**

*** [ ] Ambil data order dari database beserta relasi `payments`.**

*** [ ] Urutkan data berdasarkan waktu terbaru (latest).**

*** [ ] Gunakan pagination (misal 15 atau 20 item per halaman).**

*** [ ] Kolom tabel yang harus ada:**
- Order Code
- Customer Name
- Order Type (Online/Offline)
- Total Amount
- Payment Method
- Payment Status
- Order Status (Processing, Ready, Completed)
- Created At
- Action (tombol untuk melihat detail).**

*** [ ] Gunakan badge/label berwarna untuk status (misal: hijau untuk Completed, kuning untuk Processing/Ready, abu-abu untuk Offline).**

---

## 16.3 Order List Filters & Search

*** [ ] Tambahkan fitur pencarian berdasarkan Order Code atau Customer Name.**

*** [ ] Tambahkan filter berdasarkan Order Status.**

*** [ ] Tambahkan filter berdasarkan Payment Status.**

*** [ ] Tambahkan filter berdasarkan Order Type.**

*** [ ] Pastikan query database efisien saat memfilter data.**

---

## 16.4 Order Detail View (Show)

*** [ ] Buat halaman `resources/views/admin/orders/show.blade.php`.**

*** [ ] Ambil data order beserta relasi `order_items`, `order_item_options`, dan `payments`.**

*** [ ] Tampilkan informasi utama order:**
- Order Code
- Waktu Transaksi
- Customer Name
- Order Type
- Total Amount.**

*** [ ] Tampilkan daftar item pesanan (`order_items`):**
- Nama Produk
- Harga Produk
- Kuantitas
- Catatan (Note)
- Subtotal Item.**

*** [ ] Tampilkan kustomisasi untuk setiap item (`order_item_options`):**
- Nama Option Group
- Nama Option
- Additional Price.**

*** [ ] Tampilkan informasi pembayaran (dari tabel `payments`):**
- Payment Method
- Payment Status
- Amount
- Timestamp (Paid At).**

*** [ ] Tampilkan status pesanan (Order Status).**

---

## 16.5 Order Status Update

*** [ ] Sediakan UI (misalnya tombol atau dropdown) pada halaman detail untuk mengupdate Order Status.**

*** [ ] Status workflow yang didukung:**
1. Paid / Processing
2. Ready
3. Completed.**

*** [ ] Jangan menggunakan status `Pending Payment` dalam workflow operasional order ini, karena order online masuk setelah pembayaran berhasil.**

*** [ ] Buat route dan method di controller (misal `PATCH /admin/orders/{order}/status`) untuk menangani update.**

*** [ ] Validasi perubahan status (hanya status yang valid yang diizinkan).**

*** [ ] Tampilkan flash message / notifikasi sukses setelah status diupdate.**

*** [ ] Saat status diubah ke `Ready`, pastikan ada trigger atau event yang bisa di-hook untuk Phase 17 (Browser Notification).**

---

## 16.6 Validation & Security

*** [ ] Validasi request untuk update status order.**

*** [ ] Pastikan hanya order yang valid (ada di database) yang bisa diubah.**

*** [ ] Gunakan route model binding.**

*** [ ] Hindari N+1 query problem pada halaman index dan show dengan eager loading relasi yang dibutuhkan.**

---

## 16.7 UI / UX Polish (Admin Order)

*** [ ] Gunakan layout admin/dashboard yang sudah ada.**

*** [ ] Terapkan desain sederhana dan bersih dengan warna utama biru dan putih.**

*** [ ] Gunakan Tailwind CSS 4.**

*** [ ] Gunakan ikon yang relevan (misal Lucide Icons) untuk action button (view, update).**

*** [ ] Desain tabel responsif.**

# Phase 17 — Browser Notification

## 17.1 Notification Architecture & Strategy

*** [ ] Gunakan teknologi browser push notification standar (misal Push API / Service Workers atau pustaka sederhana jika memungkinkan tanpa backend kompleks, namun dalam konteks ini, pertimbangkan notifikasi berbasis session/polling atau Server-Sent Events (SSE) / WebSockets/Pusher/Laravel Reverb jika realtime diperlukan). **Pastikan pendekatan teknis ditentukan dan disepakati (misal: Laravel Reverb).**

*** [ ] Notifikasi ditargetkan kepada customer yang sedang menunggu pesanannya (di halaman frontend/order tracker).**

*** [ ] Sistem tidak menggunakan SMS, WhatsApp, atau Email.**

---

## 17.2 Notification Permission Request

*** [ ] Minta izin (permission) notifikasi dari browser customer.**

*** [ ] Jangan meminta izin langsung saat halaman pertama kali dibuka (mengganggu UX).**

*** [ ] Minta izin pada momen yang tepat, contoh: setelah customer berhasil checkout atau di halaman "Payment Success / Order Tracking".**

*** [ ] Buat tombol atau prompt UI kustom yang mengedukasi customer mengapa notifikasi dibutuhkan ("Nyalakan notifikasi untuk mengetahui kapan pesananmu siap").**

*** [ ] Handle kondisi ketika customer menolak izin (blokir) dengan fallback UI yang memberitahu mereka untuk cek halaman secara berkala.**

---

## 17.3 Ready Notification Implementation

*** [ ] Buat event di Laravel, misalnya `OrderReadyEvent`, yang di-trigger (dispatch) pada saat Admin mengubah status order menjadi `Ready` (di Phase 16).**

*** [ ] Tangkap event tersebut di frontend customer yang terkait dengan order tersebut.**

*** [ ] Saat event diterima dan izin notifikasi diberikan, tampilkan system notification (Browser Notification).**

*** [ ] Isi notifikasi harus jelas dan sesuai panduan:**
- Title: "Pesanan Siap!" (atau sejenisnya)
- Body: "[ORDER-CODE] sudah siap. Silakan ambil pesanan Anda."

*** [ ] Pastikan notifikasi hanya dikirim ke customer yang memiliki order tersebut (implementasi channel/room per order).**

---

## 17.4 Frontend Listener & Service Worker

*** [ ] Buat atau konfigurasi Service Worker (jika menggunakan Push API murni) atau inisialisasi listener JS (Echo/Reverb) di halaman frontend customer.**

*** [ ] Pastikan koneksi/subscription hanya aktif ketika order belum `Completed`.**

*** [ ] Uji notifikasi di berbagai browser (Chrome, Firefox, Safari) dan perhatikan batasan HTTPS (Push Notification biasanya wajib HTTPS, pastikan ada solusi untuk local dev seperti ngrok atau konfigurasi herd).**

---

## 17.5 On-Page Fallback

*** [ ] Jika browser tidak mendukung notifikasi atau permission ditolak, pastikan UI halaman order tracking (jika ada) bisa melakukan auto-update atau polling secara berkala (fallback) saat order berubah menjadi `Ready`.**

*** [ ] Tampilkan juga notifikasi in-app (Toast/Alert) di layar browser (DOM) bersamaan dengan system notification.**
