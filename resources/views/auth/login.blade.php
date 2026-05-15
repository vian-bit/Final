@extends('layouts.app')
@section('title', 'Login — GranDhika Attendance')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4"
    style="background: linear-gradient(135deg, #3a2a1a 0%, #6b4f35 55%, #9b7b5a 100%);">

    <div class="w-full max-w-md">
        <!-- Brand -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 rounded-full mx-auto mb-5 flex items-center justify-center"
                style="background:#fff; box-shadow:0 0 0 3px rgba(201,168,76,0.5), 0 8px 24px rgba(58,42,26,0.3);">
                @if(file_exists(public_path('images/logo.png')))
                <img src="{{ asset('images/logo.png') }}" alt="GranDhika" class="w-12 h-12 object-contain">
                @else
                <svg class="w-10 h-10" fill="none" stroke="#6b4f35" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                @endif
            </div>
            <h1 class="font-header text-2xl" style="color:#faf8f5; letter-spacing:0.12em;">GranDhika</h1>
            <div class="mt-1 text-xs tracking-widest uppercase" style="color:rgba(201,168,76,0.8); letter-spacing:0.2em;">Attendance System</div>
        </div>

        <!-- Card -->
        <div class="gh-card">
            <div class="gh-card-header text-center">
                <h2 class="font-header" style="letter-spacing:0.1em;">Welcome Back</h2>
                <p class="text-xs mt-1" style="color:rgba(250,248,245,0.6); letter-spacing:0.06em;">Sign in to your account</p>
            </div>
            <div class="gh-card-body">
                @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
                @endif
                @if($errors->any())
                <div class="alert alert-error">
                    @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="gh-label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="gh-input" placeholder="email@grandhika.com" required autofocus>
                    </div>

                    <div class="mb-6">
                        <label class="gh-label">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="passwordInput"
                                class="gh-input" style="padding-right:44px;" placeholder="••••••••" required>
                            <button type="button" onclick="togglePassword()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 transition"
                                style="color:var(--gray-300);">
                                <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg id="eyeOffIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.163-3.592M6.53 6.533A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.966 9.966 0 01-4.077 5.198M15 12a3 3 0 00-3-3m0 0a3 3 0 00-2.121.879M3 3l18 18"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-full py-3 font-header" style="letter-spacing:0.12em; font-size:0.8rem;">
                        Sign In
                    </button>
                </form>
            </div>
        </div>

        <p class="text-center text-xs mt-6" style="color:rgba(250,248,245,0.35); letter-spacing:0.06em;">
            &copy; {{ date('Y') }} GranDhika Hotels &amp; Resorts
        </p>
    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('passwordInput');
    const on = document.getElementById('eyeIcon');
    const off = document.getElementById('eyeOffIcon');
    if (input.type === 'password') {
        input.type = 'text'; on.classList.add('hidden'); off.classList.remove('hidden');
    } else {
        input.type = 'password'; on.classList.remove('hidden'); off.classList.add('hidden');
    }
}
</script>
@endsection
