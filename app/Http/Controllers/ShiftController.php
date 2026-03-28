<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $shifts = Shift::with('department')
            ->when($user->isAdmin(), function($q) use ($user) {
                $q->where('department_id', $user->department_id);
            })
            ->get();

        return view('shifts.index', compact('shifts'));
    }

    public function create()
    {
        $user = Auth::user();
        $departments = $user->isSuperuser() ? Department::all() : Department::where('id', $user->department_id)->get();
        
        return view('shifts.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'tolerance_minutes' => 'required|integer|min:0',
        ]);

        Shift::create($validated);

        return redirect()->route('shifts.index')
            ->with('success', 'Shift berhasil ditambahkan');
    }

    public function edit(Shift $shift)
    {
        $user = Auth::user();
        $departments = $user->isSuperuser() ? Department::all() : Department::where('id', $user->department_id)->get();
        
        return view('shifts.edit', compact('shift', 'departments'));
    }

    public function update(Request $request, Shift $shift)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'tolerance_minutes' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $shift->update($validated);

        return redirect()->route('shifts.index')
            ->with('success', 'Shift berhasil diupdate');
    }

    public function destroy(Shift $shift)
    {
        $shift->delete();
        return redirect()->route('shifts.index')
            ->with('success', 'Shift berhasil dihapus');
    }
}
