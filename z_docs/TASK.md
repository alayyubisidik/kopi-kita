
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