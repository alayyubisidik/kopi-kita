

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

