# Fitur Early Checkout dengan Verifikasi Admin

## Deskripsi
Fitur ini memungkinkan user untuk checkout sebelum jam shift selesai, tetapi memerlukan approval dari admin departemen.

## Cara Kerja

### Untuk User:

1. **Checkout Normal (Setelah Jam Shift)**
   - User klik tombol "Check Out Now"
   - Jika sudah lewat jam shift selesai, checkout langsung berhasil
   - Tidak perlu approval admin

2. **Early Checkout (Sebelum Jam Shift Selesai)**
   - User klik tombol "Check Out Now"
   - Muncul modal dengan warning bahwa ini early checkout
   - User bisa isi alasan (optional)
   - Klik "Confirm Check Out"
   - Request dikirim ke admin untuk approval
   - User mendapat notifikasi "Early checkout request submitted. Waiting for admin approval."

### Untuk Admin:

1. **Melihat Request**
   - Login sebagai Admin
   - Di dashboard, akan muncul notifikasi jika ada pending requests
   - Klik menu "🔔 Early Checkout Requests" di sidebar
   - Atau klik tombol "View Requests" di notifikasi dashboard

2. **Approve Request**
   - Klik tombol "Approve" pada request yang ingin disetujui
   - Muncul modal konfirmasi
   - Bisa tambahkan admin notes (optional)
   - Klik "Approve"
   - Attendance user akan otomatis di-update dengan waktu checkout yang diminta

3. **Reject Request**
   - Klik tombol "Reject" pada request yang ingin ditolak
   - Muncul modal konfirmasi
   - WAJIB isi alasan penolakan
   - Klik "Reject"
   - User tidak bisa checkout dan harus tunggu sampai jam shift selesai

## Database

### Tabel: early_checkout_requests

| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| attendance_id | bigint | FK ke tabel attendances |
| user_id | bigint | FK ke tabel users (yang request) |
| approved_by | bigint | FK ke tabel users (admin yang approve/reject) |
| requested_checkout_time | time | Waktu checkout yang diminta |
| shift_end_time | time | Waktu shift seharusnya selesai |
| reason | text | Alasan user (optional) |
| status | enum | pending, approved, rejected |
| admin_notes | text | Catatan dari admin |
| approved_at | timestamp | Waktu di-approve/reject |
| created_at | timestamp | Waktu request dibuat |
| updated_at | timestamp | Waktu terakhir diupdate |

## Routes

```php
// Admin & Superuser only
GET  /early-checkout-requests              - Lihat semua requests
POST /early-checkout/{id}/approve          - Approve request
POST /early-checkout/{id}/reject           - Reject request
```

## Views

1. **resources/views/dashboard/user.blade.php**
   - Modal untuk early checkout
   - Form dengan reason field

2. **resources/views/attendances/early-checkout-requests.blade.php**
   - Tabel list semua requests
   - Modal approve/reject
   - Filter by status (pending/approved/rejected)

3. **resources/views/dashboard/admin.blade.php**
   - Notifikasi badge untuk pending requests

## Testing

### Test Case 1: Normal Checkout
1. Login sebagai user
2. Check in
3. Tunggu sampai lewat jam shift selesai
4. Klik "Check Out Now"
5. ✅ Checkout langsung berhasil tanpa approval

### Test Case 2: Early Checkout
1. Login sebagai user
2. Check in
3. Sebelum jam shift selesai, klik "Check Out Now"
4. Muncul warning early checkout
5. Isi reason (optional)
6. Klik "Confirm Check Out"
7. ✅ Muncul pesan "Early checkout request submitted"

### Test Case 3: Admin Approve
1. Login sebagai admin
2. Buka "Early Checkout Requests"
3. Klik "Approve" pada request
4. Isi admin notes (optional)
5. Klik "Approve"
6. ✅ Request status jadi "approved"
7. ✅ Attendance user ter-update dengan checkout time

### Test Case 4: Admin Reject
1. Login sebagai admin
2. Buka "Early Checkout Requests"
3. Klik "Reject" pada request
4. Isi alasan penolakan (required)
5. Klik "Reject"
6. ✅ Request status jadi "rejected"
7. ✅ Attendance user tidak ter-update

## Keamanan

1. **Authorization**
   - Admin hanya bisa approve/reject request dari user di departemen yang sama
   - Superuser bisa approve/reject semua request

2. **Validation**
   - Cek apakah user sudah check-in
   - Cek apakah belum checkout
   - Cek apakah waktu checkout memang sebelum shift selesai
   - Prevent duplicate request (cek pending request)

## Notifikasi

- Dashboard admin menampilkan jumlah pending requests
- Badge kuning dengan link langsung ke halaman requests
- Real-time update setelah approve/reject

## Future Enhancement

1. Email notification ke user saat request di-approve/reject
2. WhatsApp notification
3. Push notification (jika ada mobile app)
4. History log untuk audit trail
5. Bulk approve/reject
6. Filter dan search di halaman requests
7. Export report early checkout requests

---

**Status**: ✅ IMPLEMENTED
**Date**: March 10, 2026
**Version**: 1.0
