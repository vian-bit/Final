<?php

namespace App\Http\Controllers;

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
        if ($schedule->date->startOfDay()->lt(today())) {
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
        if ($schedule->date->startOfDay()->lt(today())) {
            return redirect()->route('schedules.index')
                ->with('error', 'Jadwal hari lampau tidak dapat diubah.');
        }

        $validated = $request->validate([
            'shift_id' => 'required|exists:shifts,id',
            'notes'    => 'nullable|string',
        ]);

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
