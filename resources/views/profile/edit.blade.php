@extends('layouts.app')
@section('title', 'Edit Profil')
@section('content')
<div class="max-w-xl space-y-5">

    {{-- Info Profil --}}
    <div class="gh-card">
        <div class="gh-card-header">
            <h1 class="font-header" style="letter-spacing:0.1em;">Edit Profil</h1>
        </div>
        <div class="gh-card-body">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf @method('PUT')

                <div class="mb-4">
                    <label class="gh-label">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="gh-input" required>
                    @error('name')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
                </div>

                <div class="mb-4">
                    <label class="gh-label">Email</label>
                    <div class="flex items-center overflow-hidden rounded-md border" style="border-color:var(--gray-300);">
                        <input type="text" id="emailPrefix" oninput="syncEmail()"
                            value="{{ old('email', explode('@', $user->email)[0]) }}"
                            placeholder="username"
                            class="flex-1 px-3 py-2.5 text-sm focus:outline-none" style="background:transparent; color:var(--brown-900);" required>
                        <span class="px-3 py-2.5 text-sm border-l select-none" style="background:var(--cream-200); color:var(--gray-500); border-color:var(--cream-200); font-size:0.8rem;">@grandhika.com</span>
                    </div>
                    <input type="hidden" name="email" id="emailFull" value="{{ old('email', $user->email) }}">
                    @error('email')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
                </div>
                <script>
                    function syncEmail() {
                        const prefix = document.getElementById('emailPrefix').value.trim();
                        document.getElementById('emailFull').value = prefix ? prefix + '@grandhika.com' : '';
                    }
                    syncEmail();
                </script>

                <div class="mb-6">
                    <label class="gh-label">Nomor WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx" class="gh-input">
                </div>

                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>

    {{-- Ganti Password --}}
    <div class="gh-card">
        <div class="gh-card-header">
            <h2 class="font-header" style="letter-spacing:0.1em;">Ganti Password</h2>
        </div>
        <div class="gh-card-body">
            @if(session('password_success'))
            <div class="alert alert-success">{{ session('password_success') }}</div>
            @endif

            <form method="POST" action="{{ route('profile.change-password') }}">
                @csrf

                <div class="mb-4">
                    <label class="gh-label">Password Saat Ini</label>
                    <input type="password" name="current_password" class="gh-input" required>
                    @error('current_password')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
                </div>

                <div class="mb-4">
                    <label class="gh-label">Password Baru</label>
                    <input type="password" name="new_password" class="gh-input" required>
                    @error('new_password')<p class="text-xs mt-1" style="color:#b91c1c;">{{ $message }}</p>@enderror
                </div>

                <div class="mb-6">
                    <label class="gh-label">Konfirmasi Password Baru</label>
                    <input type="password" name="new_password_confirmation" class="gh-input" required>
                </div>

                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Simpan Password
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
