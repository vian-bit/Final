@echo off
chcp 65001 >nul
color 0A
title Check and Fix Sessions Table

echo ========================================
echo CHECK AND FIX SESSIONS TABLE
echo ========================================
echo.
echo Mengecek apakah tabel sessions ada...
echo.

php artisan tinker --execute="try { DB::table('sessions')->count(); echo 'Tabel sessions: ADA ✓'; } catch (Exception $e) { echo 'Tabel sessions: TIDAK ADA ✗'; echo PHP_EOL; echo 'Error: ' . $e->getMessage(); }"

echo.
echo ========================================
echo.
echo Apakah tabel sessions TIDAK ADA?
echo Jika ya, kita akan buat tabelnya.
echo.
set /p create="Buat tabel sessions? (Y/N): "

if /i "%create%"=="Y" (
    echo.
    echo Membuat tabel sessions...
    echo.
    
    php artisan tinker --execute="Schema::create('sessions', function ($table) { $table->string('id')->primary(); $table->foreignId('user_id')->nullable()->index(); $table->string('ip_address', 45)->nullable(); $table->text('user_agent')->nullable(); $table->longText('payload'); $table->integer('last_activity')->index(); }); echo 'Tabel sessions berhasil dibuat!';"
    
    echo.
    echo ========================================
    echo SELESAI!
    echo ========================================
    echo.
    echo Tabel sessions sudah dibuat.
    echo Sekarang restart server dan coba lagi.
) else (
    echo.
    echo Dibatalkan.
)

echo.
pause
