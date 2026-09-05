# Kopi Kita — Task.md

Dokumen ini dibuat sebagai panduan implementasi **step-by-step** dari PRD Kopi Kita. Urutan task dibuat supaya project bisa dikerjakan bertahap dan setiap tahap menghasilkan fitur yang dapat diuji.

---

# Phase 1 — Project Setup

## 1.1 Initialize Laravel

* [x] Buat project Laravel 13.
* [x] Konfigurasi PHP 8.4+.
* [ ] Konfigurasi MySQL 8.
* [x] Konfigurasi `.env`.
* [x] Konfigurasi `APP_NAME=Kopi Kita`.
* [x] Konfigurasi `APP_URL`.
* [x] Konfigurasi database.
* [x] Konfigurasi timezone `Asia/Jakarta`.

## 1.2 Frontend Setup

* [x] Install dan konfigurasi Tailwind CSS 4.
* [x] Konfigurasi Blade.
* [x] Konfigurasi Alpine.js.
* [x] Setup layout utama customer.
* [x] Setup layout dashboard Admin.

## 1.3 Development Tools

* [x] Install Laravel Debugbar.
* [x] Install Laravel Pail.
* [x] Install Laravel Pint.
* [x] Pastikan testing environment berjalan.

## 1.4 Initial Git

* [x] Initialize repository.
* [x] Buat `.gitignore`.
* [x] Buat initial commit setelah project berhasil dijalankan.
* [x] Jangan commit/push perubahan berikutnya sebelum dilakukan review.

---

# Phase 2 — Authentication & Initial Admin Setup

## 2.1 Authentication

* [ ] Install dan konfigurasi Laravel Breeze.
* [ ] Gunakan fitur **Login** dari Laravel Breeze.
* [ ] Gunakan fitur **Logout** dari Laravel Breeze.
* [ ] Hapus seluruh fitur **Register** bawaan Laravel Breeze.
* [ ] Hapus route `/register`.
* [ ] Hapus controller, request, view, dan logic registration yang tidak digunakan.
* [ ] Buat middleware authentication untuk user yang sudah login.
* [ ] Proteksi seluruh route dashboard menggunakan middleware `auth`.
* [ ] Pastikan customer dapat mengakses halaman customer tanpa login.

## 2.2 User

* [ ] Gunakan tabel `users` standar Laravel.
* [ ] Tidak menggunakan Spatie Permission.
* [ ] Tidak menggunakan role pada sistem.
* [ ] Tidak menambahkan kolom `role` pada tabel `users`.
* [ ] Tidak membuat Admin Seeder.
* [ ] Tidak membuat user/admin melalui seeder.
* [ ] User pertama yang dibuat melalui `/setup-admin` dianggap sebagai admin sistem.
* [ ] Tidak menyediakan public registration.

## 2.3 Initial Admin Setup

* [ ] Buat route `GET /setup-admin`.
* [ ] Buat halaman **Setup Admin**.
* [ ] Tampilan dan field Setup Admin dibuat seperti halaman Register Breeze.
* [ ] Form Setup Admin memiliki:

  * [ ] Name
  * [ ] Email
  * [ ] Password
  * [ ] Password Confirmation
  * [ ] Setup Key
* [ ] Buat Setup Key berupa string acak sepanjang **32 karakter**.
* [ ] Simpan Setup Key pada `.env`.
* [ ] Expose Setup Key melalui file configuration, misalnya `config/app.php`.
* [ ] Controller tidak membaca `env()` secara langsung.
* [ ] Validasi seluruh input Setup Admin.
* [ ] Validasi Setup Key dengan value yang tersimpan di configuration.
* [ ] Jika valid, buat user pertama pada tabel `users`.
* [ ] Setelah user berhasil dibuat, redirect ke halaman login.

## 2.4 Initial Setup Redirect

* [ ] Buat mekanisme untuk mengecek apakah tabel `users` masih kosong.
* [ ] Jika **belum ada user sama sekali**, aplikasi harus mengarahkan user ke `/setup-admin`.
* [ ] Berlaku ketika aplikasi pertama kali dijalankan dengan database kosong.
* [ ] Jika sudah terdapat minimal satu user, `/setup-admin` tidak boleh digunakan lagi.
* [ ] Jika `/setup-admin` diakses setelah user pertama sudah dibuat, redirect ke halaman login.
* [ ] Jika user sudah login lalu mencoba mengakses `/setup-admin`, redirect ke dashboard.
* [ ] Pastikan Setup Admin hanya dapat dilakukan **satu kali**.

## 2.5 Setup Key

* [ ] Tambahkan konfigurasi environment:

```env
ADMIN_SETUP_KEY=32_CHARACTER_RANDOM_STRING
```

* [ ] Tambahkan konfigurasi pada file config, misalnya:

```php
'admin_setup_key' => env('ADMIN_SETUP_KEY'),
```

* [ ] Gunakan `config('app.admin_setup_key')` ketika melakukan validasi.
* [ ] Jangan hardcode Setup Key di source code.
* [ ] Jangan menyimpan Setup Key ke database.
* [ ] Jangan menampilkan Setup Key ke frontend.
* [ ] Jangan commit `.env` ke repository.

## 2.6 Security & Access Rules

| Kondisi                          | `/setup-admin`        |
| -------------------------------- | --------------------- |
| Belum ada user                   | Bisa diakses          |
| Belum ada user + Setup Key salah | Ditolak               |
| Belum ada user + Setup Key benar | Admin dibuat          |
| Sudah ada user + belum login     | Redirect ke login     |
| Sudah ada user + sudah login     | Redirect ke dashboard |

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

Tentu, berikut versi yang sudah menghapus **4.6** dan **4.7**.

# Phase 4 (2) — Dashboard Layout & UI Foundation

## 4.1 Dashboard View Structure

* [ ] Pindahkan view dashboard dari `resources/views/dashboard.blade.php` ke `resources/views/dashboard/index.blade.php`.

* [ ] Pastikan route dashboard mengarah ke `dashboard.index`.

* [ ] Pastikan `DashboardController` menggunakan view `dashboard.index`.

## 4.2 Dashboard Layout

* [ ] Buat atau gunakan `resources/views/layouts/app.blade.php` sebagai layout utama dashboard.

* [ ] Buat struktur layout menggunakan `@yield('content')`.

* [ ] Buat partial navbar.

* [ ] Buat partial topbar.

* [ ] Buat partial footer.

* [ ] Pastikan halaman `dashboard/index.blade.php` menggunakan `layouts.app`.

* [ ] Pastikan navbar, topbar, dan footer tampil pada seluruh halaman dashboard.

## 4.3 Dashboard Navigation

* [ ] Buat navigasi dasar dashboard.

* [ ] Tambahkan link Dashboard.

* [ ] Siapkan struktur navigasi untuk fitur yang akan dibuat pada phase berikutnya.

* [ ] Pastikan link menggunakan named route Laravel.

* [ ] Tandai menu halaman yang sedang aktif.

## 4.4 Dashboard UI Foundation

* [ ] Gunakan desain sederhana dan minimal.

* [ ] Gunakan warna utama putih dan biru.

* [ ] Gunakan Tailwind CSS 4 yang sudah dikonfigurasi.

* [ ] Gunakan Lucide Icons untuk icon.

* [ ] Pastikan layout responsive pada desktop, tablet, dan mobile.

* [ ] Hindari animasi dan visual yang kompleks.

* [ ] Fokus pada struktur layout dan usability, bukan detail visual.

## 4.5 Dashboard Content

* [ ] Buat halaman dashboard sederhana.

* [ ] Tampilkan heading dashboard.

* [ ] Tampilkan informasi ringkasan sederhana yang diperlukan.

* [ ] Gunakan card sederhana untuk informasi dashboard.

* [ ] Jangan implementasikan statistik kompleks sebelum fitur utama selesai.

### Prinsip UI untuk Phase berikutnya

> **Feature First, UI Later**

Untuk sementara jangan mengejar desain yang terlalu kompleks. Setiap CRUD cukup menggunakan **table, form, button, status badge, search/filter jika diperlukan, dan responsive dasar**.

Setelah seluruh fitur aplikasi selesai, baru dibuat fase khusus untuk **UI Polish/Refactoring**.


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

### Product Controller & Route

*** [ ] Buat `ProductController` di namespace `App\Http\Controllers\Dashboard`.**

*** [ ] Gunakan resource controller untuk Product.**

*** [ ] Daftarkan `Route::resource('products', ProductController::class)->except(['show'])` pada route dashboard.**

*** [ ] Gunakan named route dengan prefix `dashboard.products.*`.**

*** [ ] Gunakan route `index` untuk menampilkan daftar product.**

*** [ ] Gunakan route `create` untuk form tambah product.**

*** [ ] Gunakan route `store` untuk menyimpan product baru.**

*** [ ] Gunakan route `edit` untuk form edit product.**

*** [ ] Gunakan route `update` untuk memperbarui product.**

*** [ ] Gunakan route `destroy` untuk menghapus product.**

### Product Index

*** [ ] Buat view `resources/views/dashboard/products/index.blade.php`.**

*** [ ] Tampilkan daftar product dalam bentuk table.**

*** [ ] Tampilkan kolom image product.**

*** [ ] Tampilkan nama product.**

*** [ ] Tampilkan category product.**

*** [ ] Tampilkan harga product.**

*** [ ] Tampilkan availability product.**

*** [ ] Tampilkan status customization product.**

*** [ ] Tampilkan action Edit dan Delete.**

*** [ ] Tambahkan tombol Add Product.**

*** [ ] Gunakan named route untuk seluruh action.**

### Product Create

*** [ ] Buat view `resources/views/dashboard/products/create.blade.php`.**

*** [ ] Buat form menggunakan method `POST`.**

*** [ ] Tambahkan field nama product.**

*** [ ] Tambahkan field SKU jika kolom SKU tersedia pada schema product.**

*** [ ] Tambahkan field category.**

*** [ ] Tambahkan field price.**

*** [ ] Tambahkan field description.**

*** [ ] Tambahkan field image.**

*** [ ] Tambahkan field availability.**

*** [ ] Tambahkan pilihan customizable/non-customizable.**

*** [ ] Tambahkan section Product Customization untuk memilih option group.**

*** [ ] Tampilkan validation error pada setiap field yang memiliki error.**

*** [ ] Pertahankan input menggunakan `old()` ketika validasi gagal.**

### Product Store

*** [ ] Validasi seluruh input product sebelum penyimpanan.**

*** [ ] Validasi category harus merupakan category yang tersedia.**

*** [ ] Validasi price harus berupa angka dan tidak boleh negatif.**

*** [ ] Validasi image hanya menerima format image yang diperbolehkan.**

*** [ ] Simpan product setelah seluruh validation berhasil.**

*** [ ] Simpan image product menggunakan mekanisme media yang sudah digunakan project jika tersedia.**

*** [ ] Simpan relasi category product.**

*** [ ] Simpan status availability.**

*** [ ] Simpan status customizable.**

*** [ ] Simpan relasi option group yang dipilih pada product.**

*** [ ] Redirect ke halaman product setelah berhasil.**

*** [ ] Tampilkan success notification setelah product berhasil dibuat.**

### Product Edit

*** [ ] Buat view `resources/views/dashboard/products/edit.blade.php`.**

*** [ ] Tampilkan seluruh data product yang sedang diedit.**

*** [ ] Isi form menggunakan data product existing.**

*** [ ] Tampilkan image product existing jika tersedia.**

*** [ ] Tampilkan category yang sedang digunakan.**

*** [ ] Tampilkan price existing.**

*** [ ] Tampilkan description existing.**

*** [ ] Tampilkan availability existing.**

*** [ ] Tampilkan status customizable existing.**

*** [ ] Tampilkan option group yang sudah terhubung dengan product.**

*** [ ] Tampilkan seluruh option group agar admin dapat menambah atau menghapus relasi.**

### Product Update

*** [ ] Validasi data menggunakan aturan yang sama dengan proses create.**

*** [ ] Update data dasar product.**

*** [ ] Update category product.**

*** [ ] Update price product.**

*** [ ] Update description product.**

*** [ ] Update availability product.**

*** [ ] Update status customizable product.**

*** [ ] Update image product jika admin mengupload image baru.**

*** [ ] Sinkronisasi relasi option group product.**

*** [ ] Jangan menghapus image existing jika admin tidak mengupload image baru.**

*** [ ] Redirect ke halaman product setelah berhasil.**

*** [ ] Tampilkan success notification setelah product berhasil diperbarui.**

### Product Delete

*** [ ] Tambahkan action Delete pada product index.**

*** [ ] Gunakan HTTP method `DELETE`.**

*** [ ] Tambahkan CSRF protection.**

*** [ ] Hapus product melalui `ProductController@destroy`.**

*** [ ] Hapus relasi product dengan option group sebelum atau ketika product dihapus sesuai foreign key/database relationship.**

*** [ ] Hapus media/image product jika menggunakan media library.**

*** [ ] Tampilkan success notification setelah product berhasil dihapus.**

---

## 8.2 Product Form Fields

*** [ ] Field `name` digunakan untuk nama product.**

*** [ ] Field `category_id` digunakan untuk menentukan category product.**

*** [ ] Field `price` digunakan untuk harga dasar product.**

*** [ ] Field `description` digunakan untuk deskripsi product.**

*** [ ] Field `image` digunakan untuk image utama product.**

*** [ ] Field `is_available` digunakan untuk menentukan product dapat dipesan atau tidak.**

*** [ ] Field `is_customizable` digunakan untuk menentukan apakah product memiliki customization atau tidak.**

*** [ ] Pastikan nama field form sesuai dengan nama attribute/model yang digunakan.**

*** [ ] Pastikan field yang bersifat boolean memiliki nilai default yang jelas.**

---

## 8.3 Product Category

*** [ ] Ambil seluruh category yang tersedia dari database untuk form product.**

*** [ ] Tampilkan category menggunakan select/dropdown.**

*** [ ] Admin wajib memilih category ketika membuat product.**

*** [ ] Pada halaman edit, tampilkan category product yang sedang digunakan sebagai selected value.**

*** [ ] Pastikan product hanya dapat menggunakan category yang valid.**

---

## 8.4 Product Image

*** [ ] Sediakan input upload image pada form create product.**

*** [ ] Sediakan input upload image pada form edit product.**

*** [ ] Validasi file sebagai image.**

*** [ ] Tentukan batas ukuran file sesuai konfigurasi aplikasi.**

*** [ ] Simpan image menggunakan media storage yang digunakan project.**

*** [ ] Tampilkan preview/image existing pada halaman edit jika tersedia.**

*** [ ] Jika admin mengganti image, gunakan image baru sebagai image product.**

*** [ ] Jika admin tidak mengganti image, pertahankan image existing.**

---

## 8.5 Product Availability

*** [ ] Tambahkan toggle/status `Available` dan `Unavailable` pada product.**

*** [ ] Admin dapat mengubah availability melalui halaman create/edit product.**

*** [ ] Product `Available` dapat ditampilkan sebagai product yang dapat dipesan customer.**

*** [ ] Product `Unavailable` tetap tersimpan di database.**

*** [ ] Product `Unavailable` tetap ditampilkan pada catalog customer.**

*** [ ] Product `Unavailable` tidak dapat ditambahkan ke cart/order.**

*** [ ] Tampilkan status availability menggunakan badge pada dashboard.**

*** [ ] Tampilkan status `Unavailable` pada catalog customer agar customer mengetahui product sedang tidak tersedia.**

---

## 8.6 Product Customization

### Option Group Selection

*** [ ] Pada form create/edit product, ambil seluruh option group yang tersedia.**

*** [ ] Tampilkan seluruh option group dalam daftar checkbox.**

*** [ ] Admin dapat memilih option group yang digunakan oleh product.**

*** [ ] Admin dapat memilih lebih dari satu option group.**

*** [ ] Admin dapat tidak memilih option group jika product tidak memiliki customization.**

*** [ ] Product tanpa option group dianggap tidak memiliki customization.**

### Contoh Product dengan Customization

```text
Spanish Latte

[x] Temperature
[x] Size
[x] Sugar Level
[x] Ice Level
[x] Syrup
[x] Topping
```

### Contoh Product tanpa Customization

```text
Roti Coklat

[ ] Temperature
[ ] Size
[ ] Sugar Level
[ ] Ice Level
[ ] Syrup
[ ] Topping
```

---

## 8.7 Product Option Group Relationship

*** [ ] Gunakan tabel pivot `product_option_groups` untuk menyimpan relasi product dengan option group.**

*** [ ] Product dapat memiliki banyak option group.**

*** [ ] Option group dapat digunakan oleh banyak product.**

*** [ ] Pastikan relationship Product → OptionGroup tersedia pada model `Product`.**

*** [ ] Pastikan relationship OptionGroup → Product tersedia pada model `OptionGroup`.**

*** [ ] Saat product dibuat, simpan seluruh option group yang dipilih.**

*** [ ] Saat product diedit, sinkronkan option group menggunakan relasi `sync()`.**

*** [ ] Jika admin menghapus pilihan option group dari form edit, relasi tersebut juga dihapus dari pivot.**

*** [ ] Jika admin menambahkan option group baru, relasi baru ditambahkan ke pivot.**

---

## 8.8 Product Option Group Ordering

*** [ ] Sediakan mekanisme untuk menentukan urutan option group pada product.**

*** [ ] Urutan option group disimpan pada field ordering yang tersedia pada pivot `product_option_groups`.**

*** [ ] Urutan harus dimulai dari nilai yang konsisten, misalnya `1`.**

*** [ ] Admin dapat menentukan urutan option group.**

*** [ ] Saat product ditampilkan, option group harus mengikuti urutan yang tersimpan.**

*** [ ] Jangan menggunakan urutan berdasarkan nama option group.**

*** [ ] Jangan menggunakan urutan ID database sebagai urutan tampilan.**

### Contoh

```text
Spanish Latte

1. Temperature
2. Size
3. Sugar Level
4. Ice Level
5. Syrup
6. Topping
```

---

## 8.9 Customizable Product Logic

*** [ ] Product dengan `is_customizable = true` dapat memiliki option group.**

*** [ ] Product dengan `is_customizable = false` tidak membutuhkan option group.**

*** [ ] Jika product ditandai non-customizable, option group yang sebelumnya terhubung harus dilepas.**

*** [ ] Jika product ditandai customizable, admin dapat memilih option group yang digunakan.**

*** [ ] Jangan membuat option group baru ketika membuat product.**

*** [ ] Product hanya memilih option group yang sudah tersedia di database.**

---

## 8.10 Product Detail

*** [ ] Sediakan halaman detail product jika diperlukan untuk melihat informasi lengkap product di dashboard.**

*** [ ] Tampilkan nama product.**

*** [ ] Tampilkan image product.**

*** [ ] Tampilkan category.**

*** [ ] Tampilkan harga dasar.**

*** [ ] Tampilkan description.**

*** [ ] Tampilkan availability.**

*** [ ] Tampilkan status customizable.**

*** [ ] Tampilkan option group yang digunakan product.**

*** [ ] Tampilkan option group berdasarkan urutan pivot.**

*** [ ] Tampilkan options yang terdapat pada setiap option group.**

---

## 8.11 Product Validation

*** [ ] Product name wajib diisi.**

*** [ ] Category wajib dipilih.**

*** [ ] Price wajib diisi.**

*** [ ] Price harus berupa angka valid.**

*** [ ] Price tidak boleh bernilai negatif.**

*** [ ] Description dapat bersifat optional jika tidak diwajibkan oleh schema.**

*** [ ] Image harus berupa file image yang valid.**

*** [ ] Option group yang dipilih harus benar-benar tersedia di database.**

*** [ ] Order option group harus berupa angka valid.**

*** [ ] Pastikan validation create dan update konsisten.**

---

## 8.12 Product Management UI

*** [ ] Gunakan table sederhana untuk product index.**

*** [ ] Gunakan form sederhana untuk create/edit.**

*** [ ] Gunakan button standar untuk Create, Edit, dan Delete.**

*** [ ] Gunakan badge untuk status Available/Unavailable.**

*** [ ] Gunakan badge atau label untuk Customizable/Non-customizable.**

*** [ ] Gunakan Lucide Icons untuk action icon.**

*** [ ] Gunakan Tailwind CSS 4 yang sudah dikonfigurasi.**

*** [ ] Pastikan form responsive.**

*** [ ] Jangan membuat UI product customization yang kompleks pada phase ini.**

*** [ ] Fokus pada fungsi CRUD dan relationship database.**

---

## 8.13 Product Management Verification

*** [ ] Pastikan admin dapat membuat product baru.**

*** [ ] Pastikan admin dapat mengedit product.**

*** [ ] Pastikan admin dapat menghapus product.**

*** [ ] Pastikan category product tersimpan dengan benar.**

*** [ ] Pastikan price product tersimpan dengan benar.**

*** [ ] Pastikan image product tersimpan dan ditampilkan dengan benar.**

*** [ ] Pastikan availability dapat diubah.**

*** [ ] Pastikan product unavailable tetap dapat dilihat pada dashboard dan catalog customer.**

*** [ ] Pastikan product unavailable tidak dapat dipesan.**

*** [ ] Pastikan admin dapat memilih option group untuk product.**

*** [ ] Pastikan option group tersimpan pada `product_option_groups`.**

*** [ ] Pastikan option group dapat ditambah/dihapus ketika edit product.**

*** [ ] Pastikan urutan option group tersimpan dan ditampilkan sesuai urutan.**

*** [ ] Pastikan product non-customizable tidak memiliki option group aktif.**

*** [ ] Pastikan validation error ditampilkan dengan benar.**

*** [ ] Pastikan success/error notification berjalan dengan benar.**


# Phase 9 — Customer Menu

## 9.1 Customer Route & Controller

*** [ ] Buat `CustomerMenuController` di namespace `App\Http\Controllers`.**

*** [ ] Buat route public untuk customer menu.**

*** [ ] Gunakan named route untuk halaman customer menu.**

*** [ ] Pastikan halaman customer menu dapat diakses tanpa login.**

*** [ ] Gunakan controller untuk mengambil data category dan product.**

*** [ ] Jangan mengambil data product langsung dari Blade.**

*** [ ] Gunakan eager loading untuk relationship yang diperlukan.**

---

## 9.2 Customer Layout

*** [ ] Buat layout public/customer terpisah dari layout dashboard admin.**

*** [ ] Buat file `resources/views/layouts/customer.blade.php`.**

*** [ ] Gunakan `@yield('content')` untuk content halaman customer.**

*** [ ] Buat header customer.**

*** [ ] Tampilkan nama/brand `Kopi Kita` pada header.**

*** [ ] Buat link/logo yang mengarah ke halaman customer menu.**

*** [ ] Tambahkan tombol Cart pada header.**

*** [ ] Cart button mengarah ke halaman cart menggunakan named route.**

*** [ ] Buat category navigation pada customer menu.**

*** [ ] Pastikan layout dapat digunakan kembali oleh halaman customer berikutnya.**

*** [ ] Gunakan Tailwind CSS 4 yang sudah dikonfigurasi.**

*** [ ] Gunakan Lucide Icons.**

*** [ ] Gunakan desain mobile-first.**

*** [ ] Pastikan layout responsive pada mobile, tablet, dan desktop.**

---

## 9.3 Customer Menu View

*** [ ] Buat view `resources/views/customer/menu/index.blade.php`.**

*** [ ] Gunakan `layouts.customer` sebagai layout.**

*** [ ] Tampilkan heading menu.**

*** [ ] Tampilkan category navigation.**

*** [ ] Tampilkan search product.**

*** [ ] Tampilkan seluruh product sesuai hasil query controller.**

*** [ ] Gunakan card sederhana untuk setiap product.**

*** [ ] Pastikan product card responsive.**

---

## 9.4 Category Navigation

*** [ ] Ambil seluruh category yang memiliki product dari database.**

*** [ ] Tampilkan category pada navigation customer.**

*** [ ] Tambahkan pilihan `All`.**

*** [ ] `All` menampilkan seluruh product.**

*** [ ] Setiap category dapat digunakan sebagai filter product.**

*** [ ] Gunakan parameter query untuk category filter.**

*** [ ] Gunakan `category_id` sebagai nilai filter.**

*** [ ] Jangan menggunakan nama category sebagai identifier utama filter.**

*** [ ] Tandai category yang sedang aktif.**

### Contoh

```text
All | Coffee | Non Coffee | Tea | Food
```

---

## 9.5 Product Listing

*** [ ] Tampilkan product berdasarkan hasil query controller.**

*** [ ] Tampilkan image product.**

*** [ ] Tampilkan nama product.**

*** [ ] Tampilkan category product jika diperlukan.**

*** [ ] Tampilkan harga dasar product.**

*** [ ] Tampilkan availability product.**

*** [ ] Product `Available` dapat dipilih customer.**

*** [ ] Product `Unavailable` tetap ditampilkan.**

*** [ ] Product `Unavailable` harus memiliki visual/status yang membedakannya.**

*** [ ] Disable action pada product unavailable.**

*** [ ] Jangan menyembunyikan product unavailable dari menu.**

---

## 9.6 Product Image

*** [ ] Tampilkan image product dari media/image yang tersimpan.**

*** [ ] Gunakan image default jika product tidak memiliki image.**

*** [ ] Gunakan ukuran/aspect ratio yang konsisten untuk product card.**

*** [ ] Pastikan image responsive.**

---

## 9.7 Product Price

*** [ ] Tampilkan harga dasar product pada product card.**

*** [ ] Format harga dalam Rupiah.**

*** [ ] Harga berasal dari database.**

*** [ ] Jangan menghitung harga customization pada menu listing.**

*** [ ] Harga customization diproses pada flow product customization/cart pada phase berikutnya.**

---

## 9.8 Product Availability

*** [ ] Gunakan status availability product dari database.**

*** [ ] Product available dapat dipilih customer.**

*** [ ] Product unavailable tetap ditampilkan.**

*** [ ] Product unavailable tidak dapat masuk ke cart.**

*** [ ] Jangan hanya mengandalkan disable button pada frontend.**

*** [ ] Availability juga harus divalidasi pada backend ketika product diproses untuk order.**

*** [ ] Tampilkan label `Available` atau `Unavailable`.**

---

## 9.9 Search Product

*** [ ] Tambahkan search input pada halaman customer menu.**

*** [ ] Search berdasarkan nama product.**

*** [ ] Gunakan parameter query `search`.**

*** [ ] Controller membaca parameter `search`.**

*** [ ] Gunakan database query untuk melakukan pencarian.**

*** [ ] Gunakan `LIKE` atau mekanisme database yang sesuai.**

*** [ ] Jangan mengambil seluruh product lalu melakukan filtering menggunakan PHP collection.**

*** [ ] Search dapat digunakan bersamaan dengan category filter.**

*** [ ] Pertahankan nilai search pada input setelah filtering.**

### Contoh

```text
Search: latte

Hasil:
- Spanish Latte
- Vanilla Latte
- Caramel Latte
```

---

## 9.10 Search Empty State

*** [ ] Tampilkan empty state jika search tidak menemukan product.**

*** [ ] Tampilkan pesan bahwa product tidak ditemukan.**

*** [ ] Jangan menampilkan product list kosong tanpa informasi.**

*** [ ] Sediakan action untuk reset search.**

### Contoh

```text
Product tidak ditemukan.

Coba gunakan kata pencarian lain.

[Reset Search]
```

---

## 9.11 Category Filter

*** [ ] Filter product berdasarkan `category_id`.**

*** [ ] Controller menerapkan filter langsung pada database query.**

*** [ ] Jangan mengambil seluruh product lalu melakukan filtering menggunakan PHP.**

*** [ ] Support filter `All`.**

*** [ ] `All` menghapus pembatasan category dari query.**

*** [ ] Pastikan category yang dipilih valid.**

*** [ ] Tangani category yang tidak valid dengan response yang sesuai.**

---

## 9.12 Search & Category Combination

*** [ ] Search dan category filter dapat digunakan secara bersamaan.**

*** [ ] Jika search dan category tersedia, query menerapkan keduanya.**

*** [ ] Jika hanya search tersedia, filter berdasarkan search.**

*** [ ] Jika hanya category tersedia, filter berdasarkan category.**

*** [ ] Jika keduanya tidak tersedia, tampilkan seluruh product.**

### Contoh

```text
Category: Coffee
Search: latte

Hasil:
- Spanish Latte
- Vanilla Latte
- Caramel Latte
```

---

## 9.13 Preserve Search & Filter State

*** [ ] Pertahankan parameter `search` ketika category filter digunakan.**

*** [ ] Pertahankan parameter `category` ketika search digunakan.**

*** [ ] Pastikan URL mencerminkan filter yang sedang aktif.**

*** [ ] Input search menampilkan nilai search aktif.**

*** [ ] Category navigation menampilkan category aktif.**

### Contoh URL

```text
/menu?search=latte&category=2
```

*** [ ] Ketika customer mengganti category, search tetap dipertahankan.**

*** [ ] Ketika customer melakukan search, category tetap dipertahankan.**

*** [ ] Sediakan mekanisme reset filter.**

---

## 9.14 Product Query

*** [ ] Gunakan Eloquent untuk query product.**

*** [ ] Eager load relationship `category` jika digunakan pada view.**

*** [ ] Terapkan search sebelum query dijalankan.**

*** [ ] Terapkan category filter sebelum query dijalankan.**

*** [ ] Jalankan query setelah seluruh filter diterapkan.**

*** [ ] Gunakan ordering product yang konsisten.**

*** [ ] Jangan melakukan query database dari dalam Blade.**

*** [ ] Hindari N+1 query pada product listing.**

---

## 9.15 Customer Menu Empty State

*** [ ] Tampilkan empty state jika belum terdapat product.**

*** [ ] Tampilkan empty state jika category tidak memiliki product.**

*** [ ] Tampilkan empty state jika search tidak menemukan product.**

*** [ ] Sediakan action reset filter jika diperlukan.**

---

## 9.16 Customer Menu UI

*** [ ] Gunakan warna utama putih dan biru.**

*** [ ] Gunakan desain sederhana dan minimal.**

*** [ ] Gunakan background putih sebagai dasar halaman.**

*** [ ] Gunakan biru sebagai warna utama untuk button, active state, dan elemen penting.**

*** [ ] Gunakan warna netral untuk text dan border pendukung.**

*** [ ] Gunakan product card sederhana tanpa visual yang kompleks.**

*** [ ] Gunakan status badge sederhana untuk availability.**

*** [ ] Gunakan Lucide Icons untuk icon search dan cart.**

*** [ ] Gunakan grid sederhana untuk product listing.**

*** [ ] Pastikan tampilan mobile-first dan responsive.**

*** [ ] Jangan menggunakan animasi kompleks.**

*** [ ] Jangan membuat efek visual berlebihan.**

*** [ ] Jangan melakukan UI polishing pada phase ini.**

*** [ ] Fokus pada fungsi dan usability.**

---

## 9.17 Feature Scope

*** [ ] Phase ini hanya menangani customer menu.**

*** [ ] Jangan implementasikan product customization pada phase ini.**

*** [ ] Jangan implementasikan cart logic pada phase ini.**

*** [ ] Jangan implementasikan checkout pada phase ini.**

*** [ ] Jangan implementasikan payment pada phase ini.**

*** [ ] Jangan implementasikan order processing pada phase ini.**

*** [ ] Jangan implementasikan order tracking pada phase ini.**

*** [ ] Fitur-fitur tersebut dibuat pada phase berikutnya.**

---

## 9.18 Customer Menu Verification

*** [ ] Pastikan customer dapat membuka menu tanpa login.**

*** [ ] Pastikan header customer tampil.**

*** [ ] Pastikan brand `Kopi Kita` tampil.**

*** [ ] Pastikan Cart button tampil.**

*** [ ] Pastikan seluruh category tampil.**

*** [ ] Pastikan `All` menampilkan seluruh product.**

*** [ ] Pastikan product image tampil.**

*** [ ] Pastikan product name tampil.**

*** [ ] Pastikan product price tampil dalam format Rupiah.**

*** [ ] Pastikan product availability tampil.**

*** [ ] Pastikan product unavailable tetap muncul.**

*** [ ] Pastikan product unavailable tidak dapat dipilih/dipesan.**

*** [ ] Pastikan search berdasarkan nama product bekerja.**

*** [ ] Pastikan search menggunakan database query.**

*** [ ] Pastikan search empty state tampil.**

*** [ ] Pastikan category filter bekerja.**

*** [ ] Pastikan `All` bekerja.**

*** [ ] Pastikan kombinasi search + category bekerja.**

*** [ ] Pastikan search state tetap tersimpan ketika category berubah.**

*** [ ] Pastikan category state tetap tersimpan ketika search berubah.**

*** [ ] Pastikan reset filter bekerja.**

*** [ ] Pastikan tidak terjadi N+1 query pada product listing.**

*** [ ] Pastikan halaman responsive pada mobile, tablet, dan desktop.**

*** [ ] Pastikan tampilan menggunakan warna putih dan biru.**

*** [ ] Pastikan UI tetap sederhana dan tidak menghabiskan waktu pada visual polish.**

---

### Prinsip UI untuk Phase berikutnya

> **Feature First, UI Later**

**Seluruh halaman pada phase ini cukup menggunakan UI sederhana dengan kombinasi putih dan biru.**

**Fokus utama adalah memastikan routing, query database, product listing, availability, search, category filter, dan responsive dasar bekerja dengan benar.**

**Jangan mengejar desain final, animasi, micro-interaction, atau visual polish pada phase ini.**

**Setelah seluruh fitur aplikasi selesai, akan dibuat phase khusus untuk `UI Polish / Design Refinement / Refactoring` yang menangani peningkatan visual seluruh aplikasi secara menyeluruh.**


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