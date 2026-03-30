@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="max-w-xl mx-auto space-y-6">

    {{-- Info Profil --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-xl font-bold mb-4">Edit Profil</h1>

        @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-300 text-green-800 rounded p-3 text-sm">✅ {{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 mb-1 text-sm">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:border-blue-500 @error('name') border-red-400 @enderror" required>
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1 text-sm">Email</label>
                <div class="flex items-center border rounded-lg overflow-hidden focus-within:border-blue-500 @error('email') border-red-400 @enderror">
                    <input type="text" id="emailPrefix" oninput="syncEmail()"
                        value="{{ old('email', explode('@', $user->email)[0]) }}"
                        placeholder="username"
                        class="flex-1 px-3 py-2 text-sm focus:outline-none" required>
                    <span class="px-3 py-2 bg-gray-100 text-gray-500 text-sm border-l select-none">@grandhika.com</span>
                </div>
                <input type="hidden" name="email" id="emailFull" value="{{ old('email', $user->email) }}">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1 text-sm">Nomor WhatsApp</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx"
                    class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:border-blue-500">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 text-sm">
                Simpan Perubahan
            </button>
        </form>

        <script>
            function syncEmail() {
                const prefix = document.getElementById('emailPrefix').value.trim();
                document.getElementById('emailFull').value = prefix ? prefix + '@grandhika.com' : '';
            }
            syncEmail();
        </script>
    </div>

    {{-- Ganti Password --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold mb-4">Ganti Password</h2>

        @if(session('password_success'))
        <div class="mb-4 bg-green-50 border border-green-300 text-green-800 rounded p-3 text-sm">✅ {{ session('password_success') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.change-password') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 mb-1 text-sm">Password Saat Ini</label>
                <input type="password" name="current_password"
                    class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:border-blue-500 @error('current_password') border-red-400 @enderror" required>
                @error('current_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1 text-sm">Password Baru</label>
                <input type="password" name="new_password"
                    class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:border-blue-500 @error('new_password') border-red-400 @enderror" required>
                @error('new_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1 text-sm">Konfirmasi Password Baru</label>
                <input type="password" name="new_password_confirmation"
                    class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:border-blue-500" required>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 text-sm">
                Simpan Password
            </button>
        </form>
    </div>

</div>
@endsection
