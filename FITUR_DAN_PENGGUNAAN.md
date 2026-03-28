# Panduan Fitur dan Penggunaan Sistem Absensi Hotel

## Daftar Isi
1. [Role dan Hak Akses](#role-dan-hak-akses)
2. [Fitur Superuser](#fitur-superuser)
3. [Fitur Admin Departemen](#fitur-admin-departemen)
4. [Fitur User](#fitur-user)
5. [Workflow Sistem](#workflow-sistem)

---

## Role dan Hak Akses

### 1. Superuser
- Akses penuh ke seluruh sistem
- Mengelola semua departemen
- Membuat akun admin departemen
- Melihat semua data absensi
- Tidak terikat pada departemen tertentu

### 2. Admin Departemen
- Mengelola user di departemennya
- Membuat shift kerja
- Mengatur jadwal kerja user
- Melihat dan export laporan absensi departemen
- Tidak bisa membuat admin lain

### 3. User (Magang/Daily Worker)
- Melihat jadwal shift pribadi
- Melakukan check-in dan check-out
- Melihat riwayat absensi pribadi
- Tidak bisa mengakses data user lain

---

## Fitur Superuser

### 1. Manajemen Departemen

**Tambah Departemen Baru:**
1. Login sebagai superuser
2. Klik menu "Departemen"
3. Klik "Tambah Departemen"
4. Isi form:
   - Nama Departemen (contoh: Front Office)
   - Kode (contoh: FO)
   - Deskripsi (opsional)
5. Klik "Simpan"

**Edit/Hapus Departemen:**
- Klik "Edit" untuk mengubah data
- Klik "Hapus" untuk menghapus (hati-hati, akan menghapus data terkait)

### 2. Manajemen Admin

**Buat Akun Admin:**
1. Klik menu "Manajemen User"
2. Klik "Tambah User"
3. Isi form:
   - Nama
   - Email
   - Password
   - Role: Pilih "Admin"
   - Departemen: Pilih departemen yang akan dikelola
4. Klik "Simpan"

### 3. Monitoring Global

Dashboard superuser menampilkan:
- Total departemen
- Total admin
- Total user
- Absensi hari ini (semua departemen)

---

## Fitur Admin Departemen

### 1. Manajemen User

**Tambah User Baru:**
1. Login sebagai admin
2. Klik menu "Manajemen User"
3. Klik "Tambah User"
4. Isi form:
   - Nama
   - Email
   - Password
   - Role: Pilih "User"
   - Departemen: Otomatis departemen admin
   - Tipe User: Magang atau Daily Worker
   - Tanggal Mulai Kerja
5. Klik "Simpan"

**Edit User:**
- Update data user
- Ubah status aktif/nonaktif
- Reset password

### 2. Manajemen Shift

**Buat Shift Kerja:**
1. Klik menu "Shift Kerja"
2. Klik "Tambah Shift"
3. Isi form:
   - Nama Shift (contoh: Shift Pagi)
   - Jam Mulai (contoh: 08:00)
   - Jam Selesai (contoh: 16:00)
   - Toleransi Keterlambatan (contoh: 15 menit)
4. Klik "Simpan"

**Contoh Shift:**
- Shift Pagi: 08:00 - 16:00
- Shift Siang: 14:00 - 22:00
- Shift Malam: 22:00 - 06:00

### 3. Penjadwalan Kerja

**Assign Jadwal ke User:**
1. Klik menu "Jadwal Kerja"
2. Klik "Tambah Jadwal"
3. Pilih:
   - User yang akan dijadwalkan
   - Shift yang akan digunakan
   - Tanggal kerja
4. Klik "Simpan"

**Tips Penjadwalan:**
- Buat jadwal minimal H-1
- Satu user hanya bisa punya 1 jadwal per hari
- User akan melihat jadwal di dashboard mereka

### 4. Monitoring Absensi

**Lihat Data Absensi:**
1. Klik menu "Absensi"
2. Filter berdasarkan tanggal jika perlu
3. Lihat status: Present (hadir), Late (terlambat), Absent (tidak hadir)

**Export Laporan:**
1. Klik "Export Laporan"
2. Pilih rentang tanggal
3. Download laporan dalam format yang tersedia

### 5. Dashboard Admin

Menampilkan:
- Total user di departemen
- Jadwal hari ini
- Jumlah hadir
- Jumlah terlambat

---

## Fitur User

### 1. Lihat Jadwal

Dashboard user menampilkan:
- Jadwal shift hari ini
- Jam kerja
- Status absensi

### 2. Check-In (Absen Masuk)

**Cara Check-In:**
1. Login ke sistem
2. Di dashboard, lihat jadwal hari ini
3. Klik tombol "Check In"
4. Sistem akan mencatat waktu check-in

**Ketentuan:**
- Check-in hanya bisa dilakukan jika ada jadwal
- Jika terlambat melebihi toleransi, status menjadi "Late"
- Hanya bisa check-in 1x per hari

### 3. Check-Out (Absen Pulang)

**Cara Check-Out:**
1. Setelah selesai kerja
2. Klik tombol "Check Out"
3. Sistem akan mencatat waktu check-out

**Ketentuan:**
- Harus check-in dulu sebelum check-out
- Hanya bisa check-out 1x per hari

### 4. Riwayat Absensi

User dapat melihat:
- 5 absensi terakhir
- Tanggal, jam check-in, jam check-out
- Status kehadiran

---

## Workflow Sistem

### Setup Awal (Superuser)

1. Login sebagai superuser
2. Buat departemen (FO, HK, F&B, ENG)
3. Buat akun admin untuk setiap departemen
4. Logout

### Setup Departemen (Admin)

1. Login sebagai admin departemen
2. Buat shift kerja (pagi, siang, malam)
3. Buat akun user (magang/daily worker)
4. Atur tanggal mulai kerja user

### Operasional Harian (Admin)

1. Buat jadwal kerja untuk user
2. Assign shift sesuai kebutuhan
3. Monitor absensi real-time
4. Cek user yang belum absen

### Operasional Harian (User)

1. Login pagi hari
2. Cek jadwal shift
3. Check-in saat mulai kerja
4. Check-out saat selesai kerja

### Pelaporan (Admin)

1. Akses menu Absensi
2. Filter berdasarkan periode
3. Export laporan
4. Terima rekap otomatis via WhatsApp (jika dikonfigurasi)

---

## Tips Penggunaan

### Untuk Admin:
- Buat jadwal minimal H-1 agar user bisa persiapan
- Gunakan toleransi keterlambatan yang wajar (10-15 menit)
- Export laporan secara berkala untuk arsip
- Monitor user yang sering terlambat

### Untuk User:
- Cek jadwal setiap hari
- Check-in tepat waktu
- Jangan lupa check-out
- Hubungi admin jika ada masalah jadwal

### Best Practices:
- Backup database secara rutin
- Update password secara berkala
- Gunakan email yang valid untuk recovery
- Aktifkan notifikasi WhatsApp untuk monitoring

---

## FAQ

**Q: Bagaimana jika user lupa check-in?**
A: Admin dapat menambahkan absensi manual atau user harus lapor ke admin.

**Q: Apakah bisa check-in dari HP?**
A: Ya, sistem responsive dan bisa diakses dari browser HP.

**Q: Bagaimana cara ubah shift yang sudah dijadwalkan?**
A: Hapus jadwal lama, buat jadwal baru dengan shift yang benar.

**Q: Apakah bisa export ke Excel?**
A: Fitur export dapat dikustomisasi sesuai kebutuhan.

**Q: Bagaimana jika user pindah departemen?**
A: Admin bisa edit data user dan ubah departemennya.

---

## Kontak Support

Untuk bantuan lebih lanjut, hubungi:
- IT Support Hotel
- Developer Sistem
- Admin Departemen masing-masing
