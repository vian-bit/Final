# Fitur Manual Attendance untuk Admin

## Deskripsi
Fitur ini memungkinkan admin untuk melakukan check-in dan check-out manual untuk user. Berguna untuk mengatasi human error seperti:
- User lupa check-in/check-out
- Masalah teknis pada device user
- User tidak bisa akses sistem
- Koreksi waktu attendance

## Fitur Utama

### 1. Individual Manual Check-In/Check-Out
Admin dapat melakukan check-in atau check-out untuk user secara individual dengan menentukan waktu yang spesifik.

### 2. Bulk Check-In All Users
Admin dapat melakukan check-in untuk SEMUA user yang memiliki jadwal hari ini sekaligus dengan satu klik.

### 3. Bulk Check-Out All Users
Admin dapat melakukan check-out untuk SEMUA user yang sudah check-in hari ini sekaligus dengan satu klik.

## Cara Menggunakan

### Individual Check-In:
1. Login sebagai Admin
2. Buka menu "🔧 Manual Attendance"
3. Cari user yang ingin di-check-in
4. Klik tombol "Check In" pada baris user tersebut
5. Muncul modal dengan waktu default (waktu sekarang)
6. Ubah waktu jika perlu
7. Klik "Confirm Check In"
8. ✅ User berhasil check-in dengan waktu yang ditentukan

### Individual Check-Out:
1. Login sebagai Admin
2. Buka menu "🔧 Manual Attendance"
3. Cari user yang sudah check-in dan ingin di-check-out
4. Klik tombol "Check Out" pada baris user tersebut
5. Muncul modal dengan waktu default (waktu sekarang)
6. Ubah waktu jika perlu
7. Klik "Confirm Check Out"
8. ✅ User berhasil check-out dengan waktu yang ditentukan

### Bulk Check-In All Users:
1. Login sebagai Admin
2. Buka menu "🔧 Manual Attendance"
3. Klik tombol "Check In All Users" di bagian atas
4. Muncul konfirmasi
5. Klik "OK"
6. ✅ Semua user dengan jadwal hari ini akan di-check-in dengan waktu sekarang

### Bulk Check-Out All Users:
1. Login sebagai Admin
2. Buka menu "🔧 Manual Attendance"
3. Klik tombol "Check Out All Users" di bagian atas
4. Muncul konfirmasi
5. Klik "OK"
6. ✅ Semua user yang sudah check-in akan di-check-out dengan waktu sekarang

## Informasi yang Ditampilkan

Tabel menampilkan:
- **User**: Nama dan tipe (Intern/Daily Worker)
- **Department**: Departemen user
- **Shift**: Nama shift dan jam kerja
- **Check In**: Waktu check-in (jika sudah)
- **Check Out**: Waktu check-out (jika sudah)
- **Status**: Present, Late, atau Absent
- **Actions**: Tombol check-in/check-out

## Validasi & Rules

### Individual Check-In:
- User harus punya jadwal hari ini
- User belum check-in sebelumnya
- Waktu check-in harus format HH:MM
- Status otomatis dihitung (Present/Late) berdasarkan toleransi shift

### Individual Check-Out:
- User harus sudah check-in
- User belum check-out sebelumnya
- Waktu check-out harus format HH:MM

### Bulk Check-In:
- Hanya memproses user yang punya jadwal hari ini
- Skip user yang sudah check-in
- Menggunakan waktu sekarang untuk semua user
- Menampilkan jumlah user yang berhasil dan di-skip

### Bulk Check-Out:
- Hanya memproses user yang sudah check-in
- Skip user yang sudah check-out
- Menggunakan waktu sekarang untuk semua user
- Menampilkan jumlah user yang berhasil

## Authorization

- **Admin**: Hanya bisa manage user di departemen sendiri
- **Superuser**: Bisa manage semua user di semua departemen

## Use Cases

### Case 1: User Lupa Check-In Pagi
```
Scenario: User lupa check-in saat datang pagi
Solution:
1. Admin buka Manual Attendance
2. Cari user tersebut
3. Klik "Check In"
4. Set waktu sesuai jam user datang (misal: 08:00)
5. Confirm
Result: User ter-record check-in jam 08:00
```

### Case 2: Sistem Error Saat Jam Pulang
```
Scenario: Sistem error saat jam pulang, semua user tidak bisa check-out
Solution:
1. Admin buka Manual Attendance
2. Klik "Check Out All Users"
3. Confirm
Result: Semua user ter-record check-out dengan waktu sekarang
```

### Case 3: User Sakit Tapi Sudah Bekerja dari Rumah
```
Scenario: User sakit tapi sudah bekerja dari rumah, perlu di-record attendance
Solution:
1. Admin buka Manual Attendance
2. Check-in user dengan waktu mulai kerja
3. Check-out user dengan waktu selesai kerja
Result: Attendance user ter-record meskipun tidak di kantor
```

### Case 4: Koreksi Waktu Check-In yang Salah
```
Scenario: User check-in jam 08:30 tapi sebenarnya datang jam 08:00
Solution:
1. Admin tidak bisa edit attendance yang sudah ada
2. Perlu hapus attendance lama dari database (manual)
3. Lalu buat attendance baru dengan waktu yang benar
Note: Fitur edit attendance bisa ditambahkan di future update
```

## Response Messages

### Success Messages:
- "Manual check-in successful for [User Name]"
- "Manual check-out successful for [User Name]"
- "Bulk check-in completed: X users checked in, Y users skipped"
- "Bulk check-out completed: X users checked out"

### Error Messages:
- "User has no schedule today"
- "User has already checked in today"
- "User has not checked in yet"
- "User has already checked out today"

## Security & Audit

### Logging (Future Enhancement):
- Log semua manual attendance actions
- Record admin yang melakukan action
- Timestamp action
- Reason field (optional)

### Audit Trail:
Untuk audit, bisa cek:
1. Siapa admin yang melakukan manual attendance
2. Kapan dilakukan
3. User mana yang di-affect
4. Waktu attendance yang di-set

## Mobile Responsive

Halaman ini sudah mobile-friendly:
- Tabel scrollable horizontal di mobile
- Tombol stack vertical di mobile
- Modal responsive
- Touch-friendly buttons

## Future Enhancements

1. **Edit Attendance**: Fitur untuk edit attendance yang sudah ada
2. **Delete Attendance**: Fitur untuk hapus attendance
3. **Reason Field**: Tambah field alasan untuk manual attendance
4. **Audit Log**: Log semua manual actions
5. **Notification**: Notif ke user saat admin melakukan manual attendance
6. **Bulk Actions dengan Filter**: Bulk action hanya untuk user tertentu
7. **Time Range Validation**: Validasi waktu tidak boleh di masa depan
8. **Attendance History**: Lihat history manual attendance

## Routes

```php
GET  /manual-attendance                    - Halaman manual attendance
POST /manual-attendance/check-in           - Manual check-in individual
POST /manual-attendance/check-out          - Manual check-out individual
POST /manual-attendance/bulk-check-in      - Bulk check-in all users
POST /manual-attendance/bulk-check-out     - Bulk check-out all users
```

## Testing

### Test 1: Individual Check-In
```
1. Login sebagai admin
2. Buka Manual Attendance
3. Klik "Check In" pada user yang belum check-in
4. Set waktu 08:00
5. Confirm
6. ✅ User ter-record check-in jam 08:00
```

### Test 2: Individual Check-Out
```
1. Login sebagai admin
2. Buka Manual Attendance
3. Klik "Check Out" pada user yang sudah check-in
4. Set waktu 17:00
5. Confirm
6. ✅ User ter-record check-out jam 17:00
```

### Test 3: Bulk Check-In
```
1. Login sebagai admin
2. Buka Manual Attendance
3. Klik "Check In All Users"
4. Confirm
5. ✅ Semua user dengan jadwal ter-record check-in
```

### Test 4: Bulk Check-Out
```
1. Login sebagai admin
2. Buka Manual Attendance
3. Klik "Check Out All Users"
4. Confirm
5. ✅ Semua user yang sudah check-in ter-record check-out
```

### Test 5: Validation - Already Checked In
```
1. Login sebagai admin
2. Buka Manual Attendance
3. Klik "Check In" pada user yang sudah check-in
4. ✅ Muncul error: "User has already checked in today"
```

---

**Status**: ✅ IMPLEMENTED
**Date**: March 10, 2026
**Version**: 1.0
