<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'RAPI-Sekolah')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #2864c5;
            --primary-hover: #1d4ed8;
            --sidebar: #172337;
            --sidebar-hover: #26364d;
            --background: #f5f7fb;
            --white: #ffffff;
            --text: #1e293b;
            --muted: #64748b;
            --border: #dce4ef;
        }

        body {
            min-height: 100vh;
            background: var(--background);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        input,
        select,
        textarea {
            font: inherit;
        }

        button {
            cursor: pointer;
        }

        /* SIDEBAR */

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;

            display: flex;
            flex-direction: column;

            width: 255px;
            height: 100vh;

            background: var(--sidebar);
            color: var(--white);

            transition: transform 0.25s ease;
        }

        .sidebar-brand {
            padding: 25px 20px;
            border-bottom: 1px solid #2c394d;
        }

        .brand-text h2 {
            color: var(--white);
            font-size: 21px;
            font-weight: 700;
        }

        .brand-text p {
            margin-top: 7px;
            color: #cbd5e1;
            font-size: 12px;
        }

        .sidebar-menu {
            flex: 1;
            overflow-y: auto;
            padding: 24px 13px;
        }

        .sidebar-section {
            margin-bottom: 25px;
        }

        .sidebar-section-title {
            margin: 0 12px 13px;
            color: #94a3b8;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }

        .sidebar-link {
            display: block;
            margin-bottom: 5px;
            padding: 13px 14px;

            border-radius: 6px;

            color: #e2e8f0;
            font-size: 14px;
            font-weight: 500;

            transition: background 0.2s ease;
        }

        .sidebar-link:hover {
            background: var(--sidebar-hover);
            color: var(--white);
        }

        .sidebar-link.active {
            background: var(--primary);
            color: var(--white);
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid #2c394d;

            color: #cbd5e1;
            font-size: 12px;
            line-height: 1.8;
        }

        .sidebar-footer strong {
            color: var(--white);
        }

        /* MAIN AREA */

        .main-area {
            min-height: 100vh;
            margin-left: 255px;
        }

        /* TOPBAR */

        .topbar {
            position: sticky;
            top: 0;
            z-index: 900;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;

            min-height: 76px;
            padding: 16px 30px;

            background: var(--white);
            border-bottom: 1px solid var(--border);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }

        .topbar-heading h1 {
            color: var(--text);
            font-size: 23px;
            font-weight: 700;
        }

        .topbar-heading p {
            margin-top: 6px;
            color: var(--muted);
            font-size: 12px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .topbar-user {
            text-align: right;
        }

        .topbar-user strong {
            display: block;
            color: var(--text);
            font-size: 13px;
            font-weight: 600;
        }

        .topbar-user span {
            display: block;
            margin-top: 5px;
            color: var(--muted);
            font-size: 12px;
        }

        .logout-button {
            padding: 10px 16px;

            border: none;
            border-radius: 5px;

            background: #dc4444;
            color: var(--white);

            font-size: 12px;
            font-weight: 600;

            transition: background 0.2s ease;
        }

        .logout-button:hover {
            background: #c53030;
        }

        .login-button {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 5px;
            background: var(--primary);
            color: var(--white);
            font-size: 12px;
        }

        .login-button:hover {
            background: var(--primary-hover);
        }

        .menu-toggle {
            display: none;
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: 5px;
            background: var(--white);
            color: var(--text);
            font-size: 13px;
        }

        /* PAGE CONTENT */

        .page-container {
            width: 100%;
            max-width: 1600px;
            margin: 0 auto;
            padding: 28px 30px;
        }

        .page-footer {
            padding: 20px 30px;
            border-top: 1px solid var(--border);

            color: #94a3b8;
            text-align: center;
            font-size: 11px;
        }

        /* ALERT */

        .alert {
            margin-bottom: 20px;
            padding: 13px 16px;
            border: 1px solid transparent;
            border-radius: 6px;
            font-size: 13px;
            line-height: 1.6;
        }

        .alert-success {
            border-color: #bbf7d0;
            background: #f0fdf4;
            color: #166534;
        }

        .alert-error {
            border-color: #fecaca;
            background: #fef2f2;
            color: #991b1b;
        }

        .alert-warning {
            border-color: #fde68a;
            background: #fffbeb;
            color: #92400e;
        }

        /* RESPONSIVE */

        .sidebar-overlay {
            display: none;
        }

        @media (max-width: 900px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                z-index: 950;
                background: rgba(15, 23, 42, 0.45);
            }

            .main-area {
                margin-left: 0;
            }

            .menu-toggle {
                display: inline-block;
            }

            .topbar {
                padding: 15px 18px;
            }

            .page-container {
                padding: 22px 18px;
            }

            .page-footer {
                padding: 18px;
            }
        }

        @media (max-width: 520px) {
            .topbar {
                gap: 10px;
            }

            .topbar-heading h1 {
                font-size: 18px;
            }

            .topbar-heading p {
                font-size: 10px;
            }

            .topbar-user {
                display: none;
            }

            .topbar-right {
                gap: 8px;
            }

            .logout-button {
                padding: 9px 11px;
            }

            .page-container {
                padding: 16px 12px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    @php
        $currentUser = auth()->user();

        $role = strtolower(
            $currentUser->role
            ?? $currentUser->level
            ?? 'tamu'
        );

        $userName = $currentUser->name
            ?? $currentUser->nama
            ?? $currentUser->email
            ?? 'Pengunjung';

        $roleNames = [
            'admin' => 'Administrator',
            'pic' => 'Petugas / PIC',
            'guru' => 'Guru',
            'siswa' => 'Siswa',
            'tamu' => 'Tamu',
        ];

        $roleName = $roleNames[$role] ?? ucfirst($role);
    @endphp

    {{-- SIDEBAR --}}

    <aside class="sidebar" id="sidebar">

        <div class="sidebar-brand">
            <div class="brand-text">
                <h2>RAPI-Sekolah</h2>
                <p>Sistem Informasi Sekolah</p>
            </div>
        </div>

        <nav class="sidebar-menu">

            {{-- MENU UMUM --}}

            <div class="sidebar-section">
                <div class="sidebar-section-title">
                    Menu Umum
                </div>

                @if(\Illuminate\Support\Facades\Route::has('public.agenda'))
                    <a
                        href="{{ route('public.agenda') }}"
                        class="sidebar-link {{ request()->routeIs('public.agenda') ? 'active' : '' }}"
                    >
                        Agenda Publik
                    </a>
                @endif
            </div>

            {{-- MENU ADMIN --}}

            @if($role === 'admin')
                <div class="sidebar-section">

                    <div class="sidebar-section-title">
                        Administrator
                    </div>

                    @if(\Illuminate\Support\Facades\Route::has('dashboard'))
                        <a
                            href="{{ route('dashboard') }}"
                            class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        >
                            Dashboard
                        </a>
                    @endif

                    @if(\Illuminate\Support\Facades\Route::has('admin.rooms.index'))
                        <a
                            href="{{ route('admin.rooms.index') }}"
                            class="sidebar-link {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}"
                        >
                            Kelola Ruangan
                        </a>
                    @endif

                    @if(\Illuminate\Support\Facades\Route::has('admin.events.index'))
                        <a
                            href="{{ route('admin.events.index') }}"
                            class="sidebar-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}"
                        >
                            Kelola Agenda
                        </a>
                    @endif

                    @if(\Illuminate\Support\Facades\Route::has('admin.users.index'))
                        <a
                            href="{{ route('admin.users.index') }}"
                            class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                        >
                            Kelola Pengguna
                        </a>
                    @endif

                    @if(\Illuminate\Support\Facades\Route::has('admin.complaints.index'))
                        <a
                            href="{{ route('admin.complaints.index') }}"
                            class="sidebar-link {{ request()->routeIs('admin.complaints.*') ? 'active' : '' }}"
                        >
                            Pengaduan
                        </a>
                    @endif

                </div>
            @endif

            {{-- MENU PIC --}}

            @if($role === 'pic')
                <div class="sidebar-section">

                    <div class="sidebar-section-title">
                        Petugas / PIC
                    </div>

                    @if(\Illuminate\Support\Facades\Route::has('pic.dashboard'))
                        <a
                            href="{{ route('pic.dashboard') }}"
                            class="sidebar-link {{ request()->routeIs('pic.dashboard') ? 'active' : '' }}"
                        >
                            Dashboard
                        </a>
                    @endif

                    @if(\Illuminate\Support\Facades\Route::has('pic.events.index'))
                        <a
                            href="{{ route('pic.events.index') }}"
                            class="sidebar-link {{ request()->routeIs('pic.events.*') ? 'active' : '' }}"
                        >
                            Agenda
                        </a>
                    @endif

                    @if(\Illuminate\Support\Facades\Route::has('pic.complaints.index'))
                        <a
                            href="{{ route('pic.complaints.index') }}"
                            class="sidebar-link {{ request()->routeIs('pic.complaints.*') ? 'active' : '' }}"
                        >
                            Pengaduan
                        </a>
                    @endif

                </div>
            @endif

            {{-- MENU GURU --}}

            @if($role === 'guru')
                <div class="sidebar-section">

                    <div class="sidebar-section-title">
                        Guru
                    </div>

                    @if(\Illuminate\Support\Facades\Route::has('guru.dashboard'))
                        <a
                            href="{{ route('guru.dashboard') }}"
                            class="sidebar-link {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}"
                        >
                            Dashboard
                        </a>
                    @endif

                    @if(\Illuminate\Support\Facades\Route::has('guru.events.index'))
                        <a
                            href="{{ route('guru.events.index') }}"
                            class="sidebar-link {{ request()->routeIs('guru.events.index', 'guru.events.show') ? 'active' : '' }}"
                        >
                            Agenda Saya
                        </a>
                    @endif

                    @if(\Illuminate\Support\Facades\Route::has('guru.events.create'))
                        <a
                            href="{{ route('guru.events.create') }}"
                            class="sidebar-link {{ request()->routeIs('guru.events.create') ? 'active' : '' }}"
                        >
                            Buat Agenda
                        </a>
                    @endif

                    @if(\Illuminate\Support\Facades\Route::has('guru.complaints.index'))
                        <a
                            href="{{ route('guru.complaints.index') }}"
                            class="sidebar-link {{ request()->routeIs('guru.complaints.index', 'guru.complaints.show') ? 'active' : '' }}"
                        >
                            Pengaduan Saya
                        </a>
                    @endif

                    @if(\Illuminate\Support\Facades\Route::has('guru.complaints.create'))
                        <a
                            href="{{ route('guru.complaints.create') }}"
                            class="sidebar-link {{ request()->routeIs('guru.complaints.create') ? 'active' : '' }}"
                        >
                            Buat Pengaduan
                        </a>
                    @endif

                </div>
            @endif

            {{-- MENU SISWA --}}

            @if($role === 'siswa')
                <div class="sidebar-section">

                    <div class="sidebar-section-title">
                        Siswa
                    </div>

                    @if(\Illuminate\Support\Facades\Route::has('siswa.dashboard'))
                        <a
                            href="{{ route('siswa.dashboard') }}"
                            class="sidebar-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}"
                        >
                            Dashboard
                        </a>
                    @endif

                    @if(\Illuminate\Support\Facades\Route::has('siswa.events.index'))
                        <a
                            href="{{ route('siswa.events.index') }}"
                            class="sidebar-link {{ request()->routeIs('siswa.events.*') ? 'active' : '' }}"
                        >
                            Daftar Agenda
                        </a>
                    @endif

                </div>
            @endif

        </nav>

        <div class="sidebar-footer">
            <strong>RAPI-Sekolah</strong><br>
            Sistem Informasi Agenda Sekolah<br>
            &copy; {{ date('Y') }}
        </div>

    </aside>

    {{-- OVERLAY MOBILE --}}

    <div
        class="sidebar-overlay"
        id="sidebarOverlay"
        onclick="toggleSidebar()"
    ></div>

    {{-- AREA UTAMA --}}

    <div class="main-area">

        {{-- NAVBAR --}}

        <header class="topbar">

            <div class="topbar-left">

                <button
                    type="button"
                    class="menu-toggle"
                    onclick="toggleSidebar()"
                    aria-label="Buka menu"
                >
                    Menu
                </button>

                <div class="topbar-heading">
                    <h1>@yield('page-title', 'Dashboard')</h1>

                    <p>
                        RAPI-Sekolah
                        @hasSection('breadcrumb')
                            / @yield('breadcrumb')
                        @endif
                    </p>
                </div>

            </div>

            <div class="topbar-right">

                @auth
                    <div class="topbar-user">
                        <strong>{{ $userName }}</strong>
                        <span>{{ $roleName }}</span>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit" class="logout-button">
                            Logout
                        </button>
                    </form>
                @else
                    @if(\Illuminate\Support\Facades\Route::has('login'))
                        <a href="{{ route('login') }}" class="login-button">
                            Login
                        </a>
                    @endif
                @endauth

            </div>

        </header>

        {{-- KONTEN HALAMAN --}}

        <main class="page-container">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
            @endif

            @yield('content')

        </main>

        {{-- FOOTER --}}

        <footer class="page-footer">
            RAPI-Sekolah — Sistem Informasi Agenda dan Penjadwalan Sekolah
        </footer>

    </div>

    {{-- JAVASCRIPT --}}

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        }

        document.querySelectorAll('.sidebar-link').forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth <= 900) {
                    document.getElementById('sidebar').classList.remove('open');
                    document.getElementById('sidebarOverlay').classList.remove('show');
                }
            });
        });
    </script>

    @stack('scripts')

</body>
</html>