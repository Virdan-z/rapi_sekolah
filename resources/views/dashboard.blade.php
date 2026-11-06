@extends('layouts.rapi')

@section('title', 'Dashboard Admin')

@section('page-title', 'Dashboard')

@section('breadcrumb', 'RAPI-Sekolah / Dashboard Admin')


@push('styles')
<style>
    /* HERO */

    .dashboard-hero {
        position: relative;
        overflow: hidden;

        padding: 34px;
        margin-bottom: 25px;

        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 25px;

        border-radius: 20px;

        color: white;
        background: linear-gradient(
            115deg,
            #2563eb,
            #4f46e5 55%,
            #7c3aed
        );

        box-shadow: 0 12px 30px rgba(79, 70, 229, .15);
    }

    .dashboard-hero::after {
        content: "";

        position: absolute;
        width: 250px;
        height: 250px;

        top: -130px;
        right: -50px;

        border: 1px solid rgba(255,255,255,.15);
        border-radius: 50%;
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    .hero-badge {
        display: inline-block;

        padding: 7px 12px;
        margin-bottom: 15px;

        border: 1px solid rgba(255,255,255,.3);
        border-radius: 30px;

        background: rgba(255,255,255,.12);

        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1px;
    }

    .hero-title {
        font-size: clamp(24px, 3vw, 34px);
        line-height: 1.3;
        font-weight: 800;
    }

    .hero-description {
        margin-top: 12px;

        color: #e0e7ff;
        font-size: 13px;
        line-height: 1.8;
    }

    .hero-actions {
        position: relative;
        z-index: 1;

        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .hero-button {
        min-height: 43px;
        padding: 0 17px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border: 1px solid rgba(255,255,255,.35);
        border-radius: 10px;

        background: rgba(255,255,255,.12);
        color: white;

        font-size: 12px;
        font-weight: 700;

        transition: .2s;
    }

    .hero-button.primary {
        background: white;
        border-color: white;
        color: #3730a3;
    }

    .hero-button:hover {
        transform: translateY(-2px);
    }

    /* STATISTIK */

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
    }

    .stat-card {
        display: block;
        padding: 22px;

        background: white;
        border: 1px solid #e5eaf2;
        border-radius: 15px;

        transition: .25s;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(15,23,42,.06);
    }

    .stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .stat-label {
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
    }

    .stat-icon {
        width: 42px;
        height: 42px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        border-radius: 12px;
        font-size: 20px;
    }

    .stat-number {
        margin-top: 18px;

        color: #111827;
        font-size: 33px;
        font-weight: 800;
    }

    .stat-description {
        margin-top: 6px;
        color: #94a3b8;
        font-size: 11px;
    }

    .stat-blue {
        background: #eff6ff;
        color: #2563eb;
    }

    .stat-green {
        background: #ecfdf5;
        color: #059669;
    }

    .stat-orange {
        background: #fff7ed;
        color: #ea580c;
    }

    .stat-purple {
        background: #f5f3ff;
        color: #7c3aed;
    }

    /* BAGIAN AKSES CEPAT */

    .section-heading {
        margin: 32px 0 17px;
    }

    .section-heading h2 {
        color: #172033;
        font-size: 18px;
        font-weight: 800;
    }

    .section-heading p {
        margin-top: 6px;
        color: #94a3b8;
        font-size: 12px;
    }

    .quick-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 17px;
    }

    .quick-card {
        display: flex;
        align-items: center;
        gap: 15px;

        padding: 22px;

        background: white;
        border: 1px solid #e5eaf2;
        border-radius: 15px;

        transition: .25s;
    }

    .quick-card:hover {
        transform: translateY(-3px);
        border-color: #bfdbfe;
        box-shadow: 0 10px 25px rgba(15,23,42,.05);
    }

    .quick-icon {
        width: 48px;
        height: 48px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        border-radius: 13px;
        font-size: 22px;
    }

    .quick-info h3 {
        color: #1e293b;
        font-size: 13px;
        font-weight: 800;
    }

    .quick-info p {
        margin-top: 7px;

        color: #94a3b8;
        font-size: 11px;
        line-height: 1.6;
    }

    .quick-arrow {
        margin-left: auto;
        color: #94a3b8;
        font-size: 22px;
    }

    @media (max-width: 1100px) {
        .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .dashboard-hero {
            align-items: flex-start;
            flex-direction: column;
        }
    }

    @media (max-width: 600px) {
        .dashboard-hero {
            padding: 24px 20px;
        }

        .stats-grid,
        .quick-grid {
            grid-template-columns: 1fr;
        }

        .hero-title {
            font-size: 25px;
        }

        .hero-actions {
            width: 100%;
        }

        .hero-button {
            flex: 1;
        }
    }
</style>
@endpush


@section('content')

    @php
        $dashboardName = auth()->user()->name
            ?? auth()->user()->nama
            ?? 'Administrator';
    @endphp

    <!-- HERO DASHBOARD -->
    <section class="dashboard-hero">

        <div class="hero-content">

            <div class="hero-badge">
                DASHBOARD ADMINISTRATOR
            </div>

            <h1 class="hero-title">
                Selamat datang,<br>
                {{ $dashboardName }}
            </h1>

            <p class="hero-description">
                Kelola ruangan, agenda, pengguna, dan pengaduan
                sekolah dari satu halaman.
            </p>

        </div>

        <div class="hero-actions">

            <a
                href="{{ route('admin.rooms.index') }}"
                class="hero-button primary"
            >
                Kelola Ruangan
            </a>

            <a
                href="{{ route('admin.events.index') }}"
                class="hero-button"
            >
                Kelola Agenda
            </a>

        </div>

    </section>


    <!-- STATISTIK UTAMA -->
    <section class="stats-grid">

        <a
            href="{{ route('admin.rooms.index') }}"
            class="stat-card"
        >
            <div class="stat-top">
                <span class="stat-label">Total Ruangan</span>

                <span class="stat-icon stat-blue">▤</span>
            </div>

            <div class="stat-number">
                {{ $totalRooms ?? 0 }}
            </div>

            <div class="stat-description">
                Ruangan terdaftar
            </div>
        </a>


        <a
            href="{{ route('admin.events.index') }}"
            class="stat-card"
        >
            <div class="stat-top">
                <span class="stat-label">Total Agenda</span>

                <span class="stat-icon stat-green">▣</span>
            </div>

            <div class="stat-number">
                {{ $totalEvents ?? 0 }}
            </div>

            <div class="stat-description">
                Agenda kegiatan sekolah
            </div>
        </a>


        <a
            href="{{ route('admin.complaints.index') }}"
            class="stat-card"
        >
            <div class="stat-top">
                <span class="stat-label">Total Pengaduan</span>

                <span class="stat-icon stat-orange">☷</span>
            </div>

            <div class="stat-number">
                {{ $totalComplaints ?? 0 }}
            </div>

            <div class="stat-description">
                Pengaduan yang tercatat
            </div>
        </a>


        <a
            href="{{ route('admin.users.index') }}"
            class="stat-card"
        >
            <div class="stat-top">
                <span class="stat-label">Total Pengguna</span>

                <span class="stat-icon stat-purple">♙</span>
            </div>

            <div class="stat-number">
                {{ $totalUsers ?? 0 }}
            </div>

            <div class="stat-description">
                Pengguna terdaftar
            </div>
        </a>

    </section>


    <!-- AKSES CEPAT -->
    <section>

        <div class="section-heading">
            <h2>Akses Cepat</h2>

            <p>
                Pilih menu untuk mengelola sistem sekolah.
            </p>
        </div>

        <div class="quick-grid">

            <a
                href="{{ route('admin.rooms.index') }}"
                class="quick-card"
            >
                <span class="quick-icon stat-blue">▤</span>

                <div class="quick-info">
                    <h3>Manajemen Ruangan</h3>

                    <p>
                        Kelola data ruangan sekolah.
                    </p>
                </div>

                <span class="quick-arrow">›</span>
            </a>


            <a
                href="{{ route('admin.events.index') }}"
                class="quick-card"
            >
                <span class="quick-icon stat-green">▣</span>

                <div class="quick-info">
                    <h3>Manajemen Agenda</h3>

                    <p>
                        Kelola dan pantau agenda kegiatan.
                    </p>
                </div>

                <span class="quick-arrow">›</span>
            </a>


            <a
                href="{{ route('admin.complaints.index') }}"
                class="quick-card"
            >
                <span class="quick-icon stat-orange">☷</span>

                <div class="quick-info">
                    <h3>Pengaduan Sekolah</h3>

                    <p>
                        Lihat dan kelola laporan pengaduan.
                    </p>
                </div>

                <span class="quick-arrow">›</span>
            </a>


            <a
                href="{{ route('admin.users.index') }}"
                class="quick-card"
            >
                <span class="quick-icon stat-purple">♙</span>

                <div class="quick-info">
                    <h3>Manajemen Pengguna</h3>

                    <p>
                        Kelola akun dan hak akses pengguna.
                    </p>
                </div>

                <span class="quick-arrow">›</span>
            </a>

        </div>

    </section>

@endsection