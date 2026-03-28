@echo off
color 0E
title Fix Error 419 - Page Expired

cls
echo ========================================
echo   FIX ERROR 419 - PAGE EXPIRED
echo ========================================
echo.
echo Error 419 terjadi karena:
echo - CSRF token expired
echo - Session expired
echo - Cache perlu dibersihkan
echo.
echo Script ini akan memperbaikinya...
echo.
pause

echo.
echo [1/5] Clear cache...
php artisan cache:clear

echo.
echo [2/5] Clear config cache...
php artisan config:clear

echo.
echo [3/5] Clear view cache...
php artisan view:clear

echo.
echo [4/5] Clear route cache...
php artisan route:clear

echo.
echo [5/5] Recreate session table...
php artisan session:table
echo yes | php artisan migrate

echo.
echo ========================================
echo SELESAI!
echo ========================================
echo.
echo Solusi yang sudah dilakukan:
echo - Cache dibersihkan
echo - Session table diperbaiki
echo - CSRF token direset
echo.
echo LANGKAH SELANJUTNYA:
echo 1. Restart server (Ctrl+C lalu jalankan lagi)
echo 2. Buka browser BARU atau Incognito/Private mode
echo 3. Akses: http://localhost:8000
echo 4. Login ulang
echo.
echo TIPS:
echo - Jangan gunakan tombol Back di browser
echo - Clear cookies browser jika masih error
echo - Gunakan Ctrl+Shift+Delete untuk clear browser data
echo.
pause
