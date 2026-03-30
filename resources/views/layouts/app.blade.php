<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Grandhika Intern and Daily Worker Attendance')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .mobile-menu { transform: translateX(-100%); transition: transform 0.3s ease-in-out; }
        .mobile-menu.active { transform: translateX(0); }
        .overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 40; }
        .overlay.active { display: block; }
    </style>
</head>
<body class="bg-gray-100">
    @auth
    <!-- Navbar -->
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="px-4">
            <div class="flex justify-between items-center py-3">
                <button onclick="toggleMenu()" class="lg:hidden p-2 hover:bg-blue-700 rounded">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div class="flex items-center gap-2">
                    @if(file_exists(public_path('images/logo.png')))
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8 object-contain brightness-0 invert">
                    @endif
                    <div class="text-lg lg:text-xl font-bold truncate">Grandhika Attendance</div>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('profile.edit') }}" class="hidden sm:inline text-sm hover:underline">{{ Auth::user()->name }}</a>
                    <a href="{{ route('profile.edit') }}" class="sm:hidden text-sm">👤</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="overlay" id="overlay" onclick="toggleMenu()"></div>

    <!-- Mobile Sidebar -->
    <aside class="mobile-menu fixed top-0 left-0 w-64 h-full bg-white shadow-lg z-50 lg:hidden overflow-y-auto" id="mobileMenu">
        <div class="p-4 bg-blue-600 text-white flex justify-between items-center">
            <span class="font-bold">Menu</span>
            <button onclick="toggleMenu()" class="p-1 hover:bg-blue-700 rounded">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <ul class="p-4 space-y-2">
            <li><a href="{{ route('dashboard') }}" class="block px-4 py-3 hover:bg-blue-100 rounded">📊 Dashboard</a></li>
            @if(Auth::user()->isSuperuser())
            <li><a href="{{ route('departments.index') }}" class="block px-4 py-3 hover:bg-blue-100 rounded">🏢 Departments</a></li>
            @endif
            @if(Auth::user()->isSuperuser() || Auth::user()->isAdmin())
            <li><a href="{{ route('users.index') }}" class="block px-4 py-3 hover:bg-blue-100 rounded">👥 User Management</a></li>
            <li><a href="{{ route('shifts.index') }}" class="block px-4 py-3 hover:bg-blue-100 rounded">⏰ Work Shifts</a></li>
            <li><a href="{{ route('schedules.calendar') }}" class="block px-4 py-3 hover:bg-blue-100 rounded">📅 Manage Schedule</a></li>
            <li><a href="{{ route('manual-attendance.index') }}" class="block px-4 py-3 hover:bg-blue-100 rounded">🔧 Manual Attendance</a></li>
            <li><a href="{{ route('early-checkout.index') }}" class="block px-4 py-3 hover:bg-blue-100 rounded">🔔 Early Checkout</a></li>
            @else
            <li><a href="{{ route('schedules.calendar') }}" class="block px-4 py-3 hover:bg-blue-100 rounded">📅 My Schedule</a></li>
            @endif
            <li><a href="{{ route('attendances.index') }}" class="block px-4 py-3 hover:bg-blue-100 rounded">✅ Attendance</a></li>
            <li><a href="{{ route('profile.edit') }}" class="block px-4 py-3 hover:bg-blue-100 rounded">👤 Edit Profil</a></li>
        </ul>
    </aside>

    <div class="lg:container lg:mx-auto px-2 sm:px-4 py-4 lg:py-6">
        <div class="flex gap-4 lg:gap-6">
            <!-- Desktop Sidebar -->
            <aside class="hidden lg:block w-64 bg-white rounded-lg shadow p-4 sticky top-4 h-fit">
                <ul class="space-y-2">
                    <li><a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-blue-100 rounded">📊 Dashboard</a></li>
                    @if(Auth::user()->isSuperuser())
                    <li><a href="{{ route('departments.index') }}" class="block px-4 py-2 hover:bg-blue-100 rounded">🏢 Departments</a></li>
                    @endif
                    @if(Auth::user()->isSuperuser() || Auth::user()->isAdmin())
                    <li><a href="{{ route('users.index') }}" class="block px-4 py-2 hover:bg-blue-100 rounded">👥 User Management</a></li>
                    <li><a href="{{ route('shifts.index') }}" class="block px-4 py-2 hover:bg-blue-100 rounded">⏰ Work Shifts</a></li>
                    <li><a href="{{ route('schedules.calendar') }}" class="block px-4 py-2 hover:bg-blue-100 rounded">📅 Manage Schedule</a></li>
                    <li><a href="{{ route('manual-attendance.index') }}" class="block px-4 py-2 hover:bg-blue-100 rounded">🔧 Manual Attendance</a></li>
                    <li><a href="{{ route('early-checkout.index') }}" class="block px-4 py-2 hover:bg-blue-100 rounded">🔔 Early Checkout</a></li>
                    @else
                    <li><a href="{{ route('schedules.calendar') }}" class="block px-4 py-2 hover:bg-blue-100 rounded">📅 My Schedule</a></li>
                    @endif
                    <li><a href="{{ route('attendances.index') }}" class="block px-4 py-2 hover:bg-blue-100 rounded">✅ Attendance</a></li>
                    <li><a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-blue-100 rounded">👤 Edit Profil</a></li>
                </ul>
            </aside>

            <main class="flex-1 min-w-0">
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">{{ session('error') }}</div>
                @endif
                @if(session('info'))
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4 text-sm">{{ session('info') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            const overlay = document.getElementById('overlay');
            menu.classList.toggle('active');
            overlay.classList.toggle('active');
        }
        document.querySelectorAll('#mobileMenu a').forEach(link => {
            link.addEventListener('click', () => toggleMenu());
        });
    </script>
    @endauth

    @guest
    @yield('content')
    @endguest
</body>
</html>
