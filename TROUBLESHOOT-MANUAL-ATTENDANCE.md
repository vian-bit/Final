# Manual Attendance Feature - Troubleshooting Guide

## Feature Overview
The Manual Attendance feature allows Admin and Superuser to manually check-in/check-out users to handle human error cases.

## Access Requirements
- **Role**: Admin or Superuser only
- **URL**: http://localhost:8000/manual-attendance
- **Menu**: Click "🔧 Manual Attendance" in the navigation menu

## Features
1. **Individual Check-In/Check-Out**: Manually check-in or check-out specific users with custom time
2. **Bulk Check-In All**: Check-in all users with schedule today at current time
3. **Bulk Check-Out All**: Check-out all users who have checked in today at current time

## Common Issues & Solutions

### Issue 1: "Page Not Found" or 404 Error
**Solution:**
1. Clear cache: Run `CLEAR-CACHE-ONLY.bat`
2. Restart server: Run `QUICK-RESTART.bat`

### Issue 2: "Access Denied" or Unauthorized
**Cause:** You are logged in as a regular User
**Solution:** 
- Log out and log in as Admin or Superuser
- Demo accounts:
  - Superuser: superuser@hotel.com / password
  - Admin FO: admin.fo@hotel.com / password
  - Admin HK: admin.hk@hotel.com / password

### Issue 3: No Users Showing in the List
**Cause:** No users have schedule for today
**Solution:**
1. Go to "📅 Manage Schedule"
2. Create schedules for users for today's date
3. Return to Manual Attendance page

### Issue 4: "User has no schedule today" Error
**Cause:** The user doesn't have a schedule assigned for today
**Solution:**
1. Go to "📅 Manage Schedule"
2. Assign a shift to the user for today
3. Try manual check-in again

### Issue 5: Bulk Actions Not Working
**Cause:** No users with schedule today, or all already checked in/out
**Solution:**
- Check if users have schedules for today
- Check if users are already checked in (for bulk check-in)
- Check if users are already checked out (for bulk check-out)

## How to Use

### Individual Check-In
1. Find the user in the list
2. Click "Check In" button
3. Adjust the time if needed (defaults to current time)
4. Click "Confirm Check In"

### Individual Check-Out
1. Find the user in the list (must be already checked in)
2. Click "Check Out" button
3. Adjust the time if needed (defaults to current time)
4. Click "Confirm Check Out"

### Bulk Check-In All Users
1. Click "Check In All Users" button at the top
2. Confirm the action
3. All users with schedule today will be checked in at current time

### Bulk Check-Out All Users
1. Click "Check Out All Users" button at the top
2. Confirm the action
3. All users who have checked in today will be checked out at current time

## Testing the Feature

Run `TEST-MANUAL-ATTENDANCE.bat` to verify:
- Routes are registered
- Controller methods exist
- View file exists

## Department Filtering

- **Superuser**: Can see and manage ALL users from all departments
- **Admin**: Can only see and manage users from their own department

## Notes

- Manual attendance bypasses normal validation rules
- Use this feature only for correcting human errors
- The system will still calculate late status based on shift time
- Bulk actions use current time for all users
- Individual actions allow custom time selection

## Need Help?

If the issue persists:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Clear all cache: `CLEAR-CACHE-ONLY.bat`
3. Restart server: `QUICK-RESTART.bat`
4. Check database connection: `TEST-DATABASE-CONNECTION.bat`
