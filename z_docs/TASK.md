# Kopi Kita — Task.md

Dokumen ini dibuat sebagai panduan implementasi **step-by-step** dari PRD Kopi Kita. Urutan task dibuat supaya project bisa dikerjakan bertahap dan setiap tahap menghasilkan fitur yang dapat diuji.

---

# Phase 1 — Project Setup

## 1.1 Initialize Laravel

* [ ] Buat project Laravel 13.
* [ ] Konfigurasi PHP 8.4+.
* [ ] Konfigurasi MySQL 8.
* [ ] Konfigurasi `.env`.
* [ ] Konfigurasi `APP_NAME=Kopi Kita`.
* [ ] Konfigurasi `APP_URL`.
* [ ] Konfigurasi database.
* [ ] Konfigurasi timezone `Asia/Jakarta`.

## 1.2 Frontend Setup

* [ ] Install dan konfigurasi Tailwind CSS 4.
* [ ] Konfigurasi Blade.
* [ ] Konfigurasi Alpine.js.
* [ ] Setup layout utama customer.
* [ ] Setup layout dashboard Admin.

## 1.3 Development Tools

* [ ] Install Laravel Debugbar.
* [ ] Install Laravel Pail.
* [ ] Install Laravel Pint.
* [ ] Pastikan testing environment berjalan.

## 1.4 Initial Git

* [ ] Initialize repository.
* [ ] Buat `.gitignore`.
* [ ] Buat initial commit setelah project berhasil dijalankan.
* [ ] Jangan commit/push perubahan berikutnya sebelum dilakukan review.

---

# Phase 2 — Authentication & Admin Setup

## 2.1 Admin Authentication

* [ ] Install Laravel Breeze.
* [ ] Implement login Admin.
* [ ] Implement logout.
* [ ] Buat middleware authentication.
* [ ] Proteksi seluruh route dashboard.

## 2.2 Admin User

* [ ] Buat migration `users`.
* [ ] Buat Admin seeder.
* [ ] Buat mekanisme initial admin setup.
* [ ] Pastikan customer tidak membutuhkan authentication.

> Catatan: sistem hanya memiliki satu role internal (Admin), sehingga tidak dibutuhkan package role/permission. Proteksi dashboard cukup menggunakan middleware `auth` bawaan Laravel.

---

# Phase 3 — Database Foundation

Buat migration dan model dasar.

## 3.1 Categories

* [ ] Buat migration `categories`.
* [ ] Buat model `Category`.
* [ ] Tambahkan:

  * [ ] name
  * [ ] slug
  * [ ] description
  * [ ] is_active

## 3.2 Products

* [ ] Buat migration `products`.
* [ ] Buat model `Product`.
* [ ] Tambahkan:

  * [ ] category_id
  * [ ] name
  * [ ] slug
  * [ ] description
  * [ ] price
  * [ ] is_available
  * [ ] is_customizable

## 3.3 Option Groups

* [ ] Buat migration `option_groups`.
* [ ] Buat model `OptionGroup`.
* [ ] Tambahkan:

  * [ ] name
  * [ ] description
  * [ ] selection_type
  * [ ] min_selection
  * [ ] max_selection
  * [ ] is_active

Contoh selection type:

```text
single
multiple
```

## 3.4 Options

* [ ] Buat migration `options`.
* [ ] Buat model `Option`.
* [ ] Tambahkan:

  * [ ] option_group_id
  * [ ] name
  * [ ] additional_price
  * [ ] is_available
  * [ ] sort_order

## 3.5 Product Option Groups

* [ ] Buat pivot `product_option_groups`.
* [ ] Hubungkan Product dengan OptionGroup.
* [ ] Pastikan satu product dapat memiliki banyak option group.
* [ ] Pastikan satu option group dapat digunakan pada banyak product.

---

# Phase 4 — Product Media

## 4.1 Media Library

* [ ] Install Spatie Laravel Media Library.
* [ ] Tambahkan media support pada Product.
* [ ] Buat collection `product-images`.
* [ ] Validasi format gambar.
* [ ] Validasi ukuran file.

## 4.2 Product Image

* [ ] Upload image saat create product.
* [ ] Replace image saat edit.
* [ ] Delete image saat product dihapus.
* [ ] Tampilkan fallback image jika product tidak memiliki image.

---

# Phase 5 — Category Management

## 5.1 Category CRUD

* [ ] Buat `CategoryController`.
* [ ] Buat route dashboard categories.
* [ ] Buat halaman index.
* [ ] Buat halaman create.
* [ ] Buat halaman edit.
* [ ] Implement delete.
* [ ] Implement validation.

## 5.2 Category Rules

* [ ] Name wajib diisi.
* [ ] Slug harus unik.
* [ ] Category yang memiliki product aktif tidak boleh dihapus sembarangan.
* [ ] Gunakan status active/inactive untuk kebutuhan nonaktif.

## 5.3 Category UI

* [ ] Table category.
* [ ] Search category.
* [ ] Status badge.
* [ ] Action edit.
* [ ] Action delete.

---

# Phase 6 — Option Group Management

## 6.1 Option Group CRUD

* [ ] Buat `OptionGroupController`.
* [ ] Buat index.
* [ ] Buat create.
* [ ] Buat edit.
* [ ] Implement delete.
* [ ] Implement validation.

## 6.2 Selection Rules

Admin dapat menentukan:

```text
Single
Multiple
```

Contoh:

```text
Temperature
Single

Size
Single

Syrup
Multiple

Topping
Multiple
```

## 6.3 Selection Limits

Untuk `multiple`:

* [ ] Support minimum selection.
* [ ] Support maximum selection.
* [ ] Allow unlimited selection ketika max tidak ditentukan.

---

# Phase 7 — Option Management

## 7.1 Option CRUD

* [ ] Buat `OptionController`.
* [ ] Tambah option ke option group.
* [ ] Edit option.
* [ ] Delete option.
* [ ] Set additional price.
* [ ] Set availability.
* [ ] Set sort order.

## 7.2 Option Availability

Admin dapat mengubah:

```text
Available
Unavailable
```

Option unavailable:

* [ ] Tetap tampil di customer.
* [ ] Disabled pada customer UI.
* [ ] Tidak dapat dipilih.
* [ ] Tidak dapat masuk ke cart.

---

# Phase 8 — Product Management

## 8.1 Product CRUD

* [ ] Buat `ProductController`.
* [ ] Create product.
* [ ] Edit product.
* [ ] Delete product.
* [ ] Detail product.
* [ ] Upload product image.
* [ ] Set category.
* [ ] Set price.
* [ ] Set description.
* [ ] Set availability.
* [ ] Set customizable/non-customizable.

## 8.2 Product Customization

Pada halaman create/edit product:

* [ ] Tampilkan seluruh option group.
* [ ] Admin memilih option group yang digunakan.
* [ ] Admin menentukan urutan option group.
* [ ] Simpan relasi product dan option group.

Contoh:

```text
Spanish Latte

[x] Temperature
[x] Size
[x] Sugar Level
[x] Ice Level
[x] Syrup
[x] Topping
```

Roti:

```text
Roti Coklat

[ ] Temperature
[ ] Size
[ ] Sugar Level
[ ] Ice Level
[ ] Syrup
[ ] Topping
```

## 8.3 Product Availability

* [ ] Toggle Available/Unavailable.
* [ ] Product unavailable tetap muncul di customer.
* [ ] Product unavailable tidak dapat dipesan.

---

# Phase 9 — Customer Menu

## 9.1 Customer Layout

* [ ] Buat public layout.
* [ ] Header Kopi Kita.
* [ ] Cart button.
* [ ] Category navigation.
* [ ] Responsive mobile-first layout.

## 9.2 Product Listing

* [ ] Tampilkan kategori.
* [ ] Tampilkan product image.
* [ ] Tampilkan product name.
* [ ] Tampilkan price.
* [ ] Tampilkan availability.
* [ ] Disable unavailable product.

## 9.3 Search

* [ ] Search product berdasarkan nama.
* [ ] Search menggunakan database query.
* [ ] Tampilkan empty state.

## 9.4 Category Filter

* [ ] Filter berdasarkan category.
* [ ] Support `All`.
* [ ] Preserve search/filter state.

---

# Phase 10 — Product Detail & Customization UI

## 10.1 Product Detail

Ketika customer memilih product:

* [ ] Tampilkan image.
* [ ] Tampilkan name.
* [ ] Tampilkan description.
* [ ] Tampilkan base price.
* [ ] Tampilkan option groups.

## 10.2 Single Option

Untuk option group `single`:

* [ ] Radio/select behavior.
* [ ] Wajib pilih sesuai `min_selection`.
* [ ] Tampilkan additional price.

## 10.3 Multiple Option

Untuk `multiple`:

* [ ] Checkbox behavior.
* [ ] Validate min selection.
* [ ] Validate max selection.
* [ ] Update total harga secara dinamis.

## 10.4 Quantity

* [ ] Quantity increment.
* [ ] Quantity decrement.
* [ ] Minimum quantity = 1.

## 10.5 Additional Note

* [ ] Textarea catatan.
* [ ] Support maksimal 100 karakter.
* [ ] Character counter.

## 10.6 Dynamic Price

Contoh:

```text
Base Price              Rp19.000
Large                   +Rp3.000
Oreo                    +Rp4.000
Whipped Cream           +Rp6.000
--------------------------------
Item Total              Rp32.000
```

Harga harus dihitung ulang berdasarkan pilihan customer.

---

# Phase 11 — Cart

## 11.1 Cart Storage

* [ ] Implement cart menggunakan session.
* [ ] Tidak membutuhkan database cart.
* [ ] Guest customer dapat menggunakan cart.

## 11.2 Add to Cart

* [ ] Validasi product.
* [ ] Validasi availability.
* [ ] Validasi customization.
* [ ] Validasi option availability.
* [ ] Simpan configuration item.
* [ ] Simpan quantity.
* [ ] Simpan note.

## 11.3 Cart Management

* [ ] View cart.
* [ ] Update quantity.
* [ ] Remove item.
* [ ] Clear cart.
* [ ] Calculate subtotal.
* [ ] Calculate total.

## 11.4 Product Identity

Product yang sama dengan customization berbeda harus dianggap sebagai item berbeda.

Contoh:

```text
Spanish Latte
Large + Oreo

Spanish Latte
Regular + No Ice
```

Keduanya menjadi cart item berbeda.

---

# Phase 12 — Checkout

## 12.1 Checkout Page

Tampilkan:

* [ ] Customer name.
* [ ] Order summary.
* [ ] Product quantity.
* [ ] Customization.
* [ ] Note.
* [ ] Total price.

## 12.2 Customer Name

* [ ] Name wajib diisi.
* [ ] Validasi panjang nama.
* [ ] Sanitasi input.
* [ ] Tidak membutuhkan email atau password.

## 12.3 Checkout Validation

Sebelum membuat payment:

* [ ] Cart tidak boleh kosong.
* [ ] Product harus tersedia.
* [ ] Option harus tersedia.
* [ ] Customization harus valid.
* [ ] Harga harus dihitung ulang server-side.
* [ ] Jangan percaya total dari frontend.

---

# Phase 13 — Payment Integration

## 13.1 Midtrans Configuration

* [ ] Tambahkan credential Midtrans ke `.env`.
* [ ] Buat config payment.
* [ ] Support sandbox environment.
* [ ] Siapkan production configuration.

## 13.2 Payment Transaction

* [ ] Generate unique order/payment reference.
* [ ] Create Midtrans transaction.
* [ ] Kirim amount yang dihitung server-side.
* [ ] Redirect/open Midtrans payment interface.

## 13.3 Payment Callback

* [ ] Implement Midtrans notification endpoint.
* [ ] Verify notification.
* [ ] Handle success.
* [ ] Handle pending.
* [ ] Handle failed.
* [ ] Handle expired.

## 13.4 Payment Security

* [ ] Jangan membuat order produksi sebelum pembayaran berhasil.
* [ ] Validasi amount.
* [ ] Validasi order/payment reference.
* [ ] Pastikan callback bersifat idempotent.

---

# Phase 14 — Order

## 14.1 Order Database

Buat:

```text
orders
order_items
order_item_options
payments
```

## 14.2 Order Creation

Order dibuat ketika payment berhasil.

Simpan:

* [ ] Order code.
* [ ] Customer name.
* [ ] Order type.
* [ ] Total.
* [ ] Created at.

Order type:

```text
online
offline
```

## 14.3 Order Items

Simpan snapshot:

* [ ] Product name.
* [ ] Product price.
* [ ] Quantity.
* [ ] Item subtotal.
* [ ] Note.

## 14.4 Selected Options

Simpan snapshot:

* [ ] Option group name.
* [ ] Option name.
* [ ] Additional price.

Jangan hanya mengandalkan relasi product/options karena harga dan nama product dapat berubah di masa depan.

---

# Phase 15 — Payment Success Page

## 15.1 Success Page

Setelah pembayaran berhasil, tampilkan:

```text
Payment Successful

Terima kasih!

Order:
ORDER-005

Pesanan sedang diproses.
```

* [ ] Tampilkan order code.
* [ ] Tampilkan customer name.
* [ ] Tampilkan order summary.
* [ ] Tampilkan total.
* [ ] Tampilkan informasi pengambilan.

## 15.2 Order Code

* [ ] Generate unique sequential order code.
* [ ] Format:

```text
ORDER-001
ORDER-002
ORDER-003
```

* [ ] Pastikan tidak duplicate.

---

# Phase 16 — Admin Order Management

## 16.1 Order List

Admin dapat melihat:

* [ ] Order code.
* [ ] Customer.
* [ ] Order type.
* [ ] Total.
* [ ] Payment method.
* [ ] Payment status.
* [ ] Created at.

## 16.2 Order Detail

* [ ] Product list.
* [ ] Quantity.
* [ ] Customization.
* [ ] Notes.
* [ ] Total.
* [ ] Payment information.

## 16.3 Order Processing

Karena order baru masuk setelah pembayaran berhasil, sistem tidak membutuhkan status `Pending Payment` sebagai order workflow.

Gunakan status operasional minimal:

```text
Paid / Processing
Ready
Completed
```

* [ ] Admin menandai order sedang diproses.
* [ ] Admin menandai order ready.
* [ ] Admin menandai order completed.

> Status pembayaran tetap disimpan terpisah dari status proses order.

---

# Phase 17 — Browser Notification

## 17.1 Notification Permission

* [ ] Minta browser notification permission pada halaman yang sesuai.
* [ ] Jangan memaksa permission ketika halaman pertama dibuka.

## 17.2 Ready Notification

Ketika order ditandai `Ready`:

* [ ] Kirim browser notification.
* [ ] Tampilkan order code.
* [ ] Informasikan bahwa pesanan siap diambil.

Contoh:

```text
ORDER-005 sudah siap.
Silakan ambil pesanan Anda.
```

## 17.3 Notification Limitation

* [ ] Tidak menggunakan SMS.
* [ ] Tidak menggunakan WhatsApp.
* [ ] Tidak menggunakan email.

---

# Phase 18 — Offline Order

## 18.1 Create Offline Order

Admin dapat membuat order manual.

Input:

* [ ] Customer name.
* [ ] Product.
* [ ] Quantity.
* [ ] Customization.
* [ ] Note.
* [ ] Payment method.

Payment method:

```text
Cash
QRIS
```

## 18.2 Offline Order Validation

* [ ] Product harus tersedia.
* [ ] Option harus tersedia.
* [ ] Customization harus valid.
* [ ] Total dihitung server-side.

## 18.3 Offline Order Payment

Offline order tidak menggunakan Midtrans.

```text
Cash / QRIS
↓
Admin confirms
↓
Order recorded
```

---

# Phase 19 — Sales Dashboard

## 19.1 Dashboard Cards

Tampilkan:

* [ ] Today's Sales.
* [ ] Today's Orders.
* [ ] Online Orders.
* [ ] Offline Orders.
* [ ] Orders in process.
* [ ] Ready Orders.

## 19.2 Sales Overview

* [ ] Sales today.
* [ ] Sales this week.
* [ ] Sales this month.
* [ ] Order count.
* [ ] Revenue.

---

# Phase 20 — Reports

## 20.1 Sales Report

* [ ] Filter date range.
* [ ] Total order.
* [ ] Total revenue.
* [ ] Online revenue.
* [ ] Offline revenue.

## 20.2 Product Report

* [ ] Product quantity sold.
* [ ] Product revenue.
* [ ] Sort best-selling product.

## 20.3 Payment Report

* [ ] Midtrans.
* [ ] Cash.
* [ ] QRIS.
* [ ] Transaction count.
* [ ] Transaction value.

## 20.4 Order Type Report

* [ ] Online.
* [ ] Offline.

## 20.5 Export

* [ ] Export Excel.
* [ ] Export PDF.

---

# Phase 21 — Activity Log

## 21.1 Activity Tracking

Gunakan Spatie Activitylog.

Catat aktivitas penting Admin:

* [ ] Create product.
* [ ] Update product.
* [ ] Delete product.
* [ ] Change product availability.
* [ ] Create option.
* [ ] Update option.
* [ ] Change option availability.
* [ ] Create offline order.
* [ ] Update order.
* [ ] Change order status.

## 21.2 Activity Log Page

* [ ] List activities.
* [ ] Filter user.
* [ ] Filter action.
* [ ] Filter date.

---

# Phase 22 — Validation & Security

## 22.1 Request Validation

Gunakan Form Request untuk:

* [ ] Category.
* [ ] Product.
* [ ] Option Group.
* [ ] Option.
* [ ] Checkout.
* [ ] Offline Order.

## 22.2 Authorization

* [ ] Pastikan seluruh Admin action protected.
* [ ] Customer hanya dapat mengakses public route.
* [ ] Customer tidak dapat mengakses dashboard.
* [ ] Customer tidak dapat mengubah order melalui URL secara langsung.

## 22.3 Price Security

* [ ] Semua harga final dihitung server-side.
* [ ] Jangan menerima total harga dari browser sebagai sumber kebenaran.
* [ ] Validasi additional price dari database.

## 22.4 Payment Security

* [ ] Verify Midtrans notification.
* [ ] Protect webhook endpoint.
* [ ] Prevent duplicate payment processing.
* [ ] Prevent duplicate order creation.

---

# Phase 23 — UI/UX Polish

## 23.1 Customer UI

* [ ] Responsive mobile-first.
* [ ] Product cards.
* [ ] Category navigation.
* [ ] Search.
* [ ] Customization modal/page.
* [ ] Sticky cart.
* [ ] Checkout summary.
* [ ] Payment success page.
* [ ] Order code display.
* [ ] Empty states.
* [ ] Loading states.
* [ ] Error states.

## 23.2 Admin UI

* [ ] Sidebar.
* [ ] Topbar.
* [ ] Dashboard cards.
* [ ] Tables.
* [ ] Filters.
* [ ] Search.
* [ ] Modal confirmation.
* [ ] Form validation feedback.
* [ ] Toast/Notyf notification.
* [ ] Empty states.

---

# Phase 24 — Testing

## 24.1 Product

* [ ] Create product.
* [ ] Edit product.
* [ ] Delete product.
* [ ] Toggle availability.
* [ ] Upload image.
* [ ] Configure customization.

## 24.2 Customer

* [ ] Browse menu without login.
* [ ] Search product.
* [ ] Filter category.
* [ ] Add customizable product.
* [ ] Add non-customizable product.
* [ ] Select multiple options.
* [ ] Validate required options.
* [ ] Validate unavailable options.
* [ ] Update cart.
* [ ] Checkout.

## 24.3 Payment

* [ ] Successful payment.
* [ ] Failed payment.
* [ ] Pending payment.
* [ ] Expired payment.
* [ ] Duplicate callback.
* [ ] Incorrect amount.

## 24.4 Order

* [ ] Order created only after successful payment.
* [ ] Unique order code.
* [ ] Correct order item snapshot.
* [ ] Correct customization snapshot.
* [ ] Correct total.

## 24.5 Offline Order

* [ ] Create Cash order.
* [ ] Create QRIS order.
* [ ] Verify total.
* [ ] Verify reports.

## 24.6 Notification

* [ ] Browser permission.
* [ ] Ready notification.
* [ ] Verify notification contains correct order code.

---

# Phase 25 — Final Optimization

* [ ] Optimize database queries.
* [ ] Add indexes where needed.
* [ ] Avoid N+1 queries.
* [ ] Eager load relationships.
* [ ] Optimize product images.
* [ ] Review validation.
* [ ] Review authorization.
* [ ] Review payment security.
* [ ] Review responsive layout.
* [ ] Review empty/error/loading states.
* [ ] Run Laravel Pint.
* [ ] Run automated tests.
* [ ] Run production build.
* [ ] Verify `.env.example`.
* [ ] Verify deployment configuration.

---

# Final Project Flow

## Customer

```text
Open Website
↓
Browse Menu
↓
Search / Filter
↓
Select Product
↓
Customize (if available)
↓
Add to Cart
↓
Checkout
↓
Input Name
↓
Midtrans Payment
↓
Payment Success
↓
Order Created
↓
Get ORDER-XXX
↓
Wait
↓
Browser Notification
↓
Customer Called
↓
Pickup
```

## Admin

```text
Login
↓
Dashboard
├── Categories
├── Products
├── Option Groups
├── Options
├── Orders
├── Offline Orders
├── Reports
└── Activity Log
```

## Development Priority

Urutan implementasi yang disarankan:

```text
Phase 1
Project Setup
↓
Phase 2
Admin Authentication
↓
Phase 3
Database Foundation
↓
Phase 4
Media
↓
Phase 5–8
Catalog & Customization
↓
Phase 9–10
Customer Menu
↓
Phase 11
Cart
↓
Phase 12
Checkout
↓
Phase 13
Midtrans
↓
Phase 14–15
Order & Payment Success
↓
Phase 16
Admin Order
↓
Phase 17
Notification
↓
Phase 18
Offline Order
↓
Phase 19–20
Dashboard & Reports
↓
Phase 21
Activity Log
↓
Phase 22–25
Security, UI, Testing & Optimization
```

**Catatan implementasi:** sesuai aturan project sebelumnya, setiap phase sebaiknya diselesaikan dan direview terlebih dahulu sebelum masuk phase berikutnya. Jangan melakukan commit/push perubahan sebelum review.