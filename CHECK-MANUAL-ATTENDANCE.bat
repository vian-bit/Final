@echo off
chcp 65001 >nul
echo ========================================
echo CHECK MANUAL ATTENDANCE SETUP
echo ========================================
echo.

echo [1/5] Checking if routes exist...
php artisan route:list --name=manual-attendance --columns=method,uri,name
echo.

echo [2/5] Checking if controller file exists...
if exist "app\Http\Controllers\AttendanceController.php" (
    echo ✓ AttendanceController.php exists
) else (
    echo ✗ AttendanceController.php NOT FOUND
)
echo.

echo [3/5] Checking if view file exists...
if exist "resources\views\attendances\manual.blade.php" (
    echo ✓ manual.blade.php exists
) else (
    echo ✗ manual.blade.php NOT FOUND
)
echo.

echo [4/5] Checking for syntax errors...
php -l app\Http\Controllers\AttendanceController.php
echo.

echo [5/5] Testing database connection...
php artisan tinker --execute="echo 'Users count: ' . \App\Models\User::count();"
echo.

echo ========================================
echo SETUP CHECK COMPLETE
echo ========================================
echo.
echo To access Manual Attendance:
echo 1. Make sure server is running (run START-HERE.bat)
echo 2. Login as Admin or Superuser
echo 3. Go to: http://localhost:8000/manual-attendance
echo    OR click "🔧 Manual Attendance" in menu
echo.
echo If you see an error, please copy the error message
echo and describe what happens when you try to access the page.
echo.
pause
