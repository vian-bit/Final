<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScheduleCalendarController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $month = $request->month ?? now()->format('Y-m');
        $date = Carbon::parse($month . '-01');
        
        if ($user->isUser()) {
            return $this->userCalendar($date);
        } else {
            return $this->adminCalendar($date, $request);
        }
    }

    private function userCalendar($date)
    {
        $user = Auth::user();
        $startDate = $date->copy()->startOfMonth();
        $endDate = $date->copy()->endOfMonth();
        
        $schedules = Schedule::where('user_id', $user->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->with('shift')
            ->get()
            ->keyBy(function($item) {
                return $item->date->format('Y-m-d');
            });
        
        return view('schedules.calendar-user', compact('schedules', 'date'));
    }

    private function adminCalendar($date, $request)
    {
        $user = Auth::user();
        $startDate = $date->copy()->startOfMonth();
        $endDate = $date->copy()->endOfMonth();
        
        $users = User::where('role', 'user')
            ->when($user->isAdmin(), function($q) use ($user) {
                $q->where('department_id', $user->department_id);
            })
            ->where('is_active', true)
            ->get();
        
        $selectedUserId = $request->user_id ?? $users->first()?->id;
        
        $schedules = Schedule::where('user_id', $selectedUserId)
            ->whereBetween('date', [$startDate, $endDate])
            ->with('shift')
            ->get()
            ->keyBy(function($item) {
                return $item->date->format('Y-m-d');
            });
        
        $shifts = Shift::when($user->isAdmin(), function($q) use ($user) {
            $q->where('department_id', $user->department_id);
        })->where('is_active', true)->get();
        
        return view('schedules.calendar-admin', compact('schedules', 'date', 'users', 'selectedUserId', 'shifts'));
    }

    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'month' => 'required|date_format:Y-m',
            'schedules' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $userId = $validated['user_id'];
            $month = $validated['month'];
            
            // Get all dates in the month
            $startDate = Carbon::parse($month . '-01')->startOfMonth();
            $endDate = Carbon::parse($month . '-01')->endOfMonth();
            
            // Hapus hanya schedule yang BELUM punya attendance dan tanggalnya BELUM lewat
            Schedule::where('user_id', $userId)
                ->whereBetween('date', [$startDate, $endDate])
                ->whereDate('date', '>=', today())
                ->whereDoesntHave('attendance')
                ->delete();
            
            // Insert/update schedule (hanya untuk tanggal yang belum punya attendance)
            if (isset($request->schedules) && is_array($request->schedules)) {
                foreach ($request->schedules as $date => $scheduleData) {
                    if (empty($scheduleData['shift_id'])) continue;

                    // Jangan ubah schedule yang sudah punya attendance
                    $existing = Schedule::where('user_id', $userId)
                        ->whereDate('date', $date)
                        ->first();

                    if ($existing && $existing->attendance()->exists()) {
                        continue; // Skip — sudah ada attendance
                    }

                    Schedule::updateOrCreate(
                        ['user_id' => $userId, 'date' => $scheduleData['date']],
                        ['shift_id' => $scheduleData['shift_id']]
                    );
                }
            }
            
            DB::commit();
            return redirect()->back()->with('success', 'Schedule saved successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to save schedule: ' . $e->getMessage());
        }
    }

    public function deleteSchedule(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
        ]);

        Schedule::where('user_id', $validated['user_id'])
            ->whereDate('date', $validated['date'])
            ->delete();

        return redirect()->back()->with('success', 'Schedule deleted successfully');
    }
}
