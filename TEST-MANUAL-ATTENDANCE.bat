@echo off
echo ========================================
echo TEST MANUAL ATTENDANCE FEATURE
echo ========================================
echo.
echo This will check if manual attendance feature is working...
echo.

echo [1/3] Checking routes...
php artisan route:list --name=manual-attendance
echo.

echo [2/3] Checking controller methods...
php artisan tinker --execute="echo 'Controller exists: ' . (method_exists(\App\Http\Controllers\AttendanceController::class, 'manualAttendance') ? 'YES' : 'NO');"
echo.

echo [3/3] Checking view file...
if exist "resources\views\attendances\manual.blade.php" (
    echo View file exists: YES
) else (
    echo View file exists: NO
)
echo.

echo ========================================
echo TEST COMPLETE
echo ========================================
echo.
echo If all checks passed, the feature should work.
echo Try accessing: http://localhost:8000/manual-attendance
echo.
echo Make sure you are logged in as Admin or Superuser!
echo.
pause
