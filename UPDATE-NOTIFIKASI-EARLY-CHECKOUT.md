# Update: Notifikasi Early Checkout untuk User

## Perubahan yang Dilakukan

### 1. Notifikasi di User Dashboard ✅

User sekarang akan melihat notifikasi status early checkout request mereka di dashboard:

#### Status: PENDING (Menunggu Approval)
- **Warna**: Kuning
- **Icon**: ⏳
- **Pesan**: "Your request to checkout at [TIME] is waiting for admin approval"
- **Info Tambahan**: Menampilkan alasan yang diisi user (jika ada)

#### Status: APPROVED (Disetujui)
- **Warna**: Hijau
- **Icon**: ✅
- **Pesan**: "Your early checkout at [TIME] has been approved by [ADMIN NAME]"
- **Info Tambahan**: Menampilkan catatan dari admin (jika ada)

#### Status: REJECTED (Ditolak)
- **Warna**: Merah
- **Icon**: ❌
- **Pesan**: "Your request to checkout at [TIME] has been rejected by [ADMIN NAME]"
- **Info Penting**: "Please wait until your shift ends at [SHIFT END TIME] to checkout"
- **Alasan Penolakan**: Ditampilkan dalam box merah dengan background highlight

### 2. Prevent Duplicate Request ✅

Jika user sudah punya request yang rejected, mereka tidak bisa submit request baru sampai:
- Shift selesai (bisa checkout normal)
- Atau admin approve request yang ada

### 3. Error Message yang Jelas ✅

Saat user coba checkout early setelah di-reject:
```
"Your early checkout request was rejected. Please wait until shift ends at [TIME]"
```

## Contoh Tampilan

### Notifikasi Pending
```
⏳ Early Checkout Request Pending
Your request to checkout at 14:30:00 is waiting for admin approval.
Your reason: Ada keperluan keluarga mendesak
```

### Notifikasi Approved
```
✅ Early Checkout Request Approved
Your early checkout at 14:30:00 has been approved by Admin FO.
Admin notes: Approved, semoga lancar
```

### Notifikasi Rejected
```
❌ Early Checkout Request Rejected
Your request to checkout at 14:30:00 has been rejected by Admin FO.
Please wait until your shift ends at 17:00:00 to checkout.

Reason for rejection: Masih ada pekerjaan yang harus diselesaikan hari ini
```

## Flow Lengkap

### Scenario 1: Request Approved
1. User submit early checkout request → Status: PENDING
2. User lihat notifikasi kuning "waiting for approval"
3. Admin approve request
4. User refresh dashboard → Notifikasi berubah hijau "approved"
5. Attendance user otomatis ter-update dengan checkout time

### Scenario 2: Request Rejected
1. User submit early checkout request → Status: PENDING
2. User lihat notifikasi kuning "waiting for approval"
3. Admin reject request dengan alasan
4. User refresh dashboard → Notifikasi berubah merah "rejected"
5. User lihat alasan penolakan dari admin
6. User tidak bisa submit request baru
7. User harus tunggu sampai shift selesai untuk checkout normal

### Scenario 3: Request Pending Lama
1. User submit early checkout request → Status: PENDING
2. User lihat notifikasi kuning "waiting for approval"
3. User coba checkout lagi → Error: "request is waiting for admin approval"
4. User harus tunggu admin approve/reject dulu

## Testing

### Test 1: Lihat Notifikasi Pending
```bash
1. Login sebagai user
2. Check in
3. Submit early checkout request
4. Refresh dashboard
5. ✅ Harus muncul notifikasi kuning
```

### Test 2: Lihat Notifikasi Approved
```bash
1. Login sebagai admin
2. Approve early checkout request user
3. Logout, login sebagai user
4. Buka dashboard
5. ✅ Harus muncul notifikasi hijau dengan nama admin
```

### Test 3: Lihat Notifikasi Rejected
```bash
1. Login sebagai admin
2. Reject early checkout request dengan alasan
3. Logout, login sebagai user
4. Buka dashboard
5. ✅ Harus muncul notifikasi merah dengan alasan penolakan
```

### Test 4: Prevent Duplicate After Reject
```bash
1. User punya request yang rejected
2. User coba checkout early lagi
3. ✅ Harus muncul error message
4. ✅ Request baru tidak dibuat
```

## Files Modified

1. **app/Http/Controllers/DashboardController.php**
   - Tambah query untuk ambil early checkout request
   - Pass data ke view

2. **app/Http/Controllers/AttendanceController.php**
   - Update logic untuk cek rejected request
   - Prevent duplicate request

3. **resources/views/dashboard/user.blade.php**
   - Tambah 3 jenis notifikasi (pending, approved, rejected)
   - Styling dengan warna berbeda

4. **resources/views/layouts/app.blade.php**
   - Tambah styling untuk info message (biru)

## Benefits

1. **Transparansi**: User tau status request mereka
2. **Komunikasi**: User bisa baca alasan penolakan dari admin
3. **User Experience**: Tidak perlu tanya-tanya ke admin
4. **Efisiensi**: Admin tidak perlu kasih tau manual ke user

---

**Status**: ✅ COMPLETED
**Date**: March 10, 2026
**Version**: 1.1
