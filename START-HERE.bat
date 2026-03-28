@echo off
color 0A
title Sistem Absensi Hotel - Menu Utama

:menu
cls
echo ========================================
echo   SISTEM ABSENSI HOTEL
echo   Menu Utama
echo ========================================
echo.
echo IMPORTANT: Pastikan Laragon RUNNING!
echo Check MySQL status harus hijau di Laragon
echo.
echo [1] Install Aplikasi (Pertama Kali)
echo [2] Migrasi Database
echo [3] Jalankan Server (Localhost Only)
echo [4] Reset Database (Hapus Semua Data)
echo [5] Kirim Laporan WhatsApp
echo [6] Jalankan Scheduler (Background)
echo [7] Clear Cache
echo [8] Optimize untuk Production
echo [9] Buka Dokumentasi
echo.
echo LAN ACCESS:
echo [L] Server LAN (Akses dari Device Lain)
echo [I] Check IP Address
echo [W] Allow Firewall (Run as Admin)
echo.
echo UPDATE:
echo [U] Update dan Restart Server
echo [Q] Quick Restart (Fast)
echo [C] Clear Cache Only
echo.
echo TROUBLESHOOTING:
echo [E] Fix Error 419 - Page Expired
echo [F] Fix Migration Error (Table already exists)
echo [M] Fix MySQL Not Running
echo [H] Hapus Database Manual
echo [T] Test Manual Attendance Feature
echo.
echo [0] Keluar
echo.
echo ========================================
set /p choice="Pilih menu: "

if "%choice%"=="1" goto install
if "%choice%"=="2" goto migrate
if "%choice%"=="3" goto serve
if "%choice%"=="4" goto reset
if "%choice%"=="5" goto whatsapp
if "%choice%"=="6" goto scheduler
if "%choice%"=="7" goto cache
if "%choice%"=="8" goto optimize
if "%choice%"=="9" goto docs
if /i "%choice%"=="L" goto servelan
if /i "%choice%"=="I" goto checkip
if /i "%choice%"=="W" goto firewall
if /i "%choice%"=="U" goto update
if /i "%choice%"=="Q" goto quickrestart
if /i "%choice%"=="C" goto clearcache
if /i "%choice%"=="E" goto error419
if /i "%choice%"=="F" goto fix
if /i "%choice%"=="M" goto mysqlfix
if /i "%choice%"=="H" goto hapus
if /i "%choice%"=="T" goto testmanual
if "%choice%"=="0" goto exit
goto menu

:install
cls
call 1-install.bat
goto menu

:migrate
cls
call 2-migrate.bat
goto menu

:serve
cls
call 3-serve.bat
goto menu

:reset
cls
call 4-reset-database.bat
goto menu

:whatsapp
cls
call 5-send-whatsapp-report.bat
goto menu

:scheduler
cls
call 6-run-scheduler.bat
goto menu

:cache
cls
call 7-clear-cache.bat
goto menu

:optimize
cls
call 8-optimize.bat
goto menu

:update
cls
call UPDATE-DAN-RESTART.bat
goto menu

:quickrestart
cls
call QUICK-RESTART.bat
goto menu

:clearcache
cls
call CLEAR-CACHE-ONLY.bat
goto menu

:servelan
cls
call SERVE-LAN.bat
goto menu

:checkip
cls
call CHECK-IP.bat
goto menu

:firewall
cls
echo ========================================
echo ALLOW FIREWALL
echo ========================================
echo.
echo Opening ALLOW-FIREWALL.bat...
echo.
echo IMPORTANT:
echo Right-click the file and select
echo "Run as administrator"
echo.
pause
start ALLOW-FIREWALL.bat
goto menu

:error419
cls
call FIX-419-ERROR.bat
goto menu

:docs
cls
echo ========================================
echo DOKUMENTASI
echo ========================================
echo.
echo Membuka dokumentasi...
if exist "QUICK_START.md" start QUICK_START.md
if exist "INSTALASI.md" start INSTALASI.md
if exist "FITUR_DAN_PENGGUNAAN.md" start FITUR_DAN_PENGGUNAAN.md
echo.
pause
goto menu

:fix
cls
call FIX-MIGRATION-ERROR.bat
goto menu

:hapus
cls
call HAPUS-DATABASE.bat
goto menu

:mysqlfix
cls
call FIX-MYSQL-NOT-RUNNING.bat
goto menu

:testmanual
cls
call CHECK-MANUAL-ATTENDANCE.bat
goto menu

:exit
cls
echo.
echo Terima kasih telah menggunakan Sistem Absensi Hotel!
echo.
timeout /t 2 /nobreak > nul
exit
