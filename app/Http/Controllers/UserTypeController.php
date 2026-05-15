<?php

namespace App\Http\Controllers;

use App\Models\UserType;
use Illuminate\Http\Request;

class UserTypeController extends Controller
{
    public function index()
    {
        $userTypes = UserType::withCount('users')->get();
        return view('user-types.index', compact('userTypes'));
    }

    public function create()
    {
        return view('user-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $validated['code'] = $this->generateCode($validated['name']);

        UserType::create($validated);

        return redirect()->route('user-types.index')
            ->with('success', 'User type berhasil ditambahkan');
    }

    public function edit(UserType $userType)
    {
        return view('user-types.edit', compact('userType'));
    }

    public function update(Request $request, UserType $userType)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'is_active'   => 'boolean',
        ]);

        $oldCode = $userType->code;
        $newCode = $this->generateCode($validated['name'], $userType->id);
        $validated['code'] = $newCode;

        $userType->update($validated);

        // Update users that reference the old code if code changed
        if ($oldCode !== $userType->code) {
            \App\Models\User::where('user_type', $oldCode)->update(['user_type' => $userType->code]);
        }

        return redirect()->route('user-types.index')
            ->with('success', 'User type berhasil diupdate');
    }

    private function generateCode(string $name, ?int $excludeId = null): string
    {
        $base = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '_', trim($name)));
        $base = trim($base, '_');
        $code = $base;
        $i = 2;

        while (UserType::where('code', $code)->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))->exists()) {
            $code = $base . '_' . $i++;
        }

        return $code;
    }

    public function destroy(UserType $userType)
    {
        if ($userType->users()->count() > 0) {
            return redirect()->route('user-types.index')
                ->with('error', 'Tidak dapat menghapus user type yang masih digunakan oleh ' . $userType->users()->count() . ' user');
        }

        $userType->delete();
        return redirect()->route('user-types.index')
            ->with('success', 'User type berhasil dihapus');
    }
}
