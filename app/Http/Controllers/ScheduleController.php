<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $schedules = Schedule::with(['user', 'shift'])
            ->when($user->isAdmin(), function($q) use ($user) {
                $q->whereHas('user', function($query) use ($user) {
                    $query->where('department_id', $user->department_id);
                });
            })
            ->when($request->date, function($q) use ($request) {
                $q->whereDate('date', $request->date);
            })
            ->orderBy('date', 'desc')
            ->paginate(20);

        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        $user = Auth::user();
        
        $users = User::where('role', 'user')
            ->when($user->isAdmin(), function($q) use ($user) {
                $q->where('department_id', $user->department_id);
            })
            ->get();
            
        $shifts = Shift::when($user->isAdmin(), function($q) use ($user) {
            $q->where('department_id', $user->department_id);
        })->get();

        return view('schedules.create', compact('users', 'shifts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'shift_id' => 'required|exists:shifts,id',
            'date'    => 'required|date',
            'notes'   => 'nullable|string',
        ]);

        Schedule::create($validated);

        return redirect()->route('schedules.index')
            ->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit(Schedule $schedule)
    {
        // Tidak boleh edit jadwal hari lampau
        if ($schedule->date->startOfDay()->lt(now('Asia/Jakarta')->startOfDay())) {
            return redirect()->route('schedules.index')
                ->with('error', 'Jadwal hari lampau tidak dapat diubah.');
        }

        $user = Auth::user();

        $users = User::where('role', 'user')
            ->when($user->isAdmin(), function ($q) use ($user) {
                $q->where('department_id', $user->department_id);
            })
            ->get();

        $shifts = Shift::when($user->isAdmin(), function ($q) use ($user) {
            $q->where('department_id', $user->department_id);
        })->get();

        return view('schedules.edit', compact('schedule', 'users', 'shifts'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        // Tidak boleh edit jadwal hari lampau
        if ($schedule->date->startOfDay()->lt(now('Asia/Jakarta')->startOfDay())) {
            return redirect()->route('schedules.index')
                ->with('error', 'Jadwal hari lampau tidak dapat diubah.');
        }

        $validated = $request->validate([
            'shift_id' => 'required|exists:shifts,id',
            'notes'    => 'nullable|string',
        ]);

        // Jika shift berubah dan sudah ada attendance, hapus attendance lama (user check-in ulang)
        if ($schedule->shift_id != $validated['shift_id']) {
            Attendance::where('schedule_id', $schedule->id)->delete();
        }

        $schedule->update($validated);

        return redirect()->route('schedules.index')
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedules.index')
            ->with('success', 'Jadwal berhasil dihapus');
    }
}
