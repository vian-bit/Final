@extends('layouts.app')

@section('title', 'Add User')

@section('content')
<div class="bg-white rounded-lg shadow p-4 md:p-6">
    <h1 class="text-xl md:text-2xl font-bold mb-4 md:mb-6">Add New User</h1>

    <form method="POST" action="{{ route('users.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 mb-2 text-sm md:text-base">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" 
                class="w-full px-3 md:px-4 py-2 border rounded-lg text-sm md:text-base focus:outline-none focus:border-blue-500" required>
            @error('name')
            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2 text-sm md:text-base">Email</label>
            <div class="flex items-center border rounded-lg overflow-hidden focus-within:border-blue-500">
                <input type="text" id="emailPrefix" oninput="syncEmail()"
                    value="{{ old('email') ? explode('@', old('email'))[0] : '' }}"
                    placeholder="username"
                    class="flex-1 px-3 md:px-4 py-2 text-sm md:text-base focus:outline-none" required>
                <span class="px-3 py-2 bg-gray-100 text-gray-500 text-sm md:text-base border-l select-none">@grandhika.com</span>
            </div>
            <input type="hidden" name="email" id="emailFull" value="{{ old('email', '') }}">
            @error('email')
            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <script>
            function syncEmail() {
                const prefix = document.getElementById('emailPrefix').value.trim();
                document.getElementById('emailFull').value = prefix ? prefix + '@grandhika.com' : '';
            }
            syncEmail();
        </script>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2 text-sm md:text-base">
                WhatsApp Number
                <span class="text-gray-400 font-normal text-xs">(untuk notifikasi otomatis, contoh: 08123456789)</span>
            </label>
            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx"
                class="w-full px-3 md:px-4 py-2 border rounded-lg text-sm md:text-base focus:outline-none focus:border-blue-500">
            @error('phone')
            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2 text-sm md:text-base">Password</label>
            <input type="password" name="password" 
                class="w-full px-3 md:px-4 py-2 border rounded-lg text-sm md:text-base focus:outline-none focus:border-blue-500" required>
            @error('password')
            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2 text-sm md:text-base">Role</label>
            <select name="role" id="roleSelect" onchange="handleRoleChange(this.value)"
                class="w-full px-3 md:px-4 py-2 border rounded-lg text-sm md:text-base focus:outline-none focus:border-blue-500" required>
                <option value="">Select Role</option>
                @if(Auth::user()->isSuperuser())
                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                @endif
                <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
            </select>
            @error('role')
            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2 text-sm md:text-base">Department</label>
            <select name="department_id" class="w-full px-3 md:px-4 py-2 border rounded-lg text-sm md:text-base focus:outline-none focus:border-blue-500" required>
                <option value="">Select Department</option>
                @foreach($departments as $dept)
                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </select>
            @error('department_id')
            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2 text-sm md:text-base">User Type</label>
            <select name="user_type" id="userTypeSelect"
                class="w-full px-3 md:px-4 py-2 border rounded-lg text-sm md:text-base focus:outline-none focus:border-blue-500">
                <option value="">Select Type</option>
                <option value="magang" {{ old('user_type') === 'magang' ? 'selected' : '' }}>Intern</option>
                <option value="daily_worker" {{ old('user_type') === 'daily_worker' ? 'selected' : '' }}>Daily Worker</option>
                <option value="admin" {{ old('user_type') === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('user_type')
            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <script>
            function handleRoleChange(role) {
                const sel = document.getElementById('userTypeSelect');
                const internOpt   = sel.querySelector('option[value="magang"]');
                const dailyOpt    = sel.querySelector('option[value="daily_worker"]');
                const adminOpt    = sel.querySelector('option[value="admin"]');

                if (role === 'admin') {
                    internOpt.style.display = 'none';
                    dailyOpt.style.display  = 'none';
                    adminOpt.style.display  = '';
                    sel.value = 'admin';
                } else {
                    internOpt.style.display = '';
                    dailyOpt.style.display  = '';
                    adminOpt.style.display  = 'none';
                    if (sel.value === 'admin') sel.value = '';
                }
            }
            handleRoleChange(document.getElementById('roleSelect').value);
        </script>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2 text-sm md:text-base">Start Date</label>
            <input type="date" name="start_date" value="{{ old('start_date') }}" 
                class="w-full px-3 md:px-4 py-2 border rounded-lg text-sm md:text-base focus:outline-none focus:border-blue-500">
            @error('start_date')
            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col md:flex-row gap-3 md:gap-4">
            <button type="submit" class="bg-blue-600 text-white px-4 md:px-6 py-2 rounded-lg hover:bg-blue-700 text-sm md:text-base">
                Save
            </button>
            <a href="{{ route('users.index') }}" class="bg-gray-300 text-gray-700 px-4 md:px-6 py-2 rounded-lg hover:bg-gray-400 text-center text-sm md:text-base">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
