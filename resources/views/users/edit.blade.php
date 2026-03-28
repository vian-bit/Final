@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="bg-white rounded-lg shadow p-4 md:p-6">
    <h1 class="text-xl md:text-2xl font-bold mb-4 md:mb-6">Edit User</h1>

    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 mb-2 text-sm md:text-base">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                class="w-full px-3 md:px-4 py-2 border rounded-lg text-sm md:text-base focus:outline-none focus:border-blue-500" required>
            @error('name')
            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2 text-sm md:text-base">Email</label>
            <div class="flex items-center border rounded-lg overflow-hidden focus-within:border-blue-500">
                <input type="text" id="emailPrefix" oninput="syncEmail()"
                    value="{{ old('email', explode('@', $user->email)[0]) }}"
                    placeholder="username"
                    class="flex-1 px-3 md:px-4 py-2 text-sm md:text-base focus:outline-none" required>
                <span class="px-3 py-2 bg-gray-100 text-gray-500 text-sm md:text-base border-l select-none">@grandhika.com</span>
            </div>
            <input type="hidden" name="email" id="emailFull" value="{{ old('email', $user->email) }}">
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
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx"
                class="w-full px-3 md:px-4 py-2 border rounded-lg text-sm md:text-base focus:outline-none focus:border-blue-500">
            @error('phone')
            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2 text-sm md:text-base">
                WhatsApp LID
                <span class="text-gray-400 font-normal text-xs">(isi otomatis saat user chat ke bot, atau isi manual jika perlu)</span>
            </label>
            <input type="text" name="wa_lid" value="{{ old('wa_lid', $user->wa_lid) }}" placeholder="contoh: 239603793526837"
                class="w-full px-3 md:px-4 py-2 border rounded-lg text-sm md:text-base focus:outline-none focus:border-blue-500 bg-gray-50">
            @if($user->wa_lid)
            <p class="text-green-600 text-xs mt-1">✅ LID tersimpan — bot WA sudah bisa mengenali nomor ini</p>
            @else
            <p class="text-gray-400 text-xs mt-1">Kosong — akan terisi otomatis saat user pertama kali chat ke bot</p>
            @endif
            @error('wa_lid')
            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2 text-sm md:text-base">Password (Leave blank to keep current)</label>
            <input type="password" name="password" 
                class="w-full px-3 md:px-4 py-2 border rounded-lg text-sm md:text-base focus:outline-none focus:border-blue-500">
            @error('password')
            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2 text-sm md:text-base">Department</label>
            <select name="department_id" class="w-full px-3 md:px-4 py-2 border rounded-lg text-sm md:text-base focus:outline-none focus:border-blue-500" required>
                <option value="">Select Department</option>
                @foreach($departments as $dept)
                <option value="{{ $dept->id }}" {{ $user->department_id == $dept->id ? 'selected' : '' }}>
                    {{ $dept->name }}
                </option>
                @endforeach
            </select>
            @error('department_id')
            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        @if($user->role == 'user')
        <div class="mb-4">
            <label class="block text-gray-700 mb-2 text-sm md:text-base">User Type</label>
            <select name="user_type" class="w-full px-3 md:px-4 py-2 border rounded-lg text-sm md:text-base focus:outline-none focus:border-blue-500">
                <option value="">Select Type</option>
                <option value="magang" {{ $user->user_type == 'magang' ? 'selected' : '' }}>Intern</option>
                <option value="daily_worker" {{ $user->user_type == 'daily_worker' ? 'selected' : '' }}>Daily Worker</option>
            </select>
            @error('user_type')
            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2 text-sm md:text-base">Start Date</label>
            <input type="date" name="start_date" value="{{ old('start_date', $user->start_date?->format('Y-m-d')) }}" 
                class="w-full px-3 md:px-4 py-2 border rounded-lg text-sm md:text-base focus:outline-none focus:border-blue-500">
            @error('start_date')
            <p class="text-red-500 text-xs md:text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        @endif

        <div class="mb-4">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }} class="mr-2 w-4 h-4">
                <span class="text-gray-700 text-sm md:text-base">Active</span>
            </label>
        </div>

        <div class="flex flex-col md:flex-row gap-3 md:gap-4">
            <button type="submit" class="bg-blue-600 text-white px-4 md:px-6 py-2 rounded-lg hover:bg-blue-700 text-sm md:text-base">
                Update
            </button>
            <a href="{{ route('users.index') }}" class="bg-gray-300 text-gray-700 px-4 md:px-6 py-2 rounded-lg hover:bg-gray-400 text-center text-sm md:text-base">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
