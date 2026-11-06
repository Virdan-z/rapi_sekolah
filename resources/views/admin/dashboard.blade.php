@extends('layouts.rapi')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Dashboard Admin')

@section('content')

<style>
    .dashboard-welcome {
        background: #ffffff;
        padding: 28px;
        border-radius: 8px;
        margin-bottom: 28px;
    }

    .dashboard-welcome h2 {
        font-size: 25px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 10px;
    }

    .dashboard-welcome p {
        color: #64748b;
        font-size: 14px;
        line-height: 1.7;
        margin-bottom: 22px;
    }

    .dashboard-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .dashboard-button {
        display: inline-block;
        padding: 11px 17px;
        background: #2864c5;
        color: #ffffff;
        border-radius: 5px;
        font-size: 13px;
        text-decoration: none;
        transition: background 0.2s;
    }

    .dashboard-button:hover {
        background: #1d4ed8;
        color: #ffffff;
    }

    .dashboard-button.secondary {
        background: #ffffff;
        color: #2864c5;
        border: 1px solid #2864c5;
    }

    .dashboard-button.secondary:hover {
        background: #eff6ff;
    }

    .dashboard-section-title {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 7px;
    }

    .dashboard-section-description {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 20px;
        line-height: 1.6;
    }

    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 30px;
    }

    .dashboard-stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 22px;
    }

    .dashboard-stat-card p {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 18px;
    }

    .dashboard-stat-card h3 {
        font-size: 32px;
        color: #1e293b;
        font-weight: 700;
        margin-bottom: 9px;
    }

    .dashboard-stat-card small {
        color: #94a3b8;
        font-size: 12px;
    }

    .dashboard-quick-links {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .dashboard-quick-card {
        display: block;
        padding: 22px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        text-decoration: none;
        transition: border-color 0.2s, background 0.2s;
    }

    .dashboard-quick-card:hover {
        border-color: #2864c5;
        background: #fafdff;
    }

    .dashboard-quick-card h3 {
        color: #1e293b;
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 9px;
    }

    .dashboard-quick-card p {
        color: #64748b;
        font-size: 13px;
        line-height: 1.7;
        margin-bottom: 15px;
    }

    .dashboard-quick-card span {
        color: #2864c5;
        font-size: 13px;
        font-weight: 600;
    }

    @media (max-width: 1100px) {
        .dashboard-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .dashboard-quick-links {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .dashboard-welcome {
            padding: 22px;
        }

        .dashboard-welcome h2 {
            font-size: 22px;
        }

        .dashboard-stats,
        .dashboard-quick-links {
            grid-template-columns: 1fr;
        }
    }
</style>



<section>
    <h2 class="dashboard-section-title">Ringkasan Data</h2>

    <p class="dashboard-section-description">
        Informasi jumlah data yang tercatat dalam sistem.
    </p>

    <div class="dashboard-stats">

        <div class="dashboard-stat-card">
            <p>Total Ruangan</p>
            <h3>{{ $totalRooms }}</h3>
            <small>Ruangan terdaftar</small>
        </div>

        <div class="dashboard-stat-card">
            <p>Total Agenda</p>
            <h3>{{ $totalEvents }}</h3>
            <small>Agenda kegiatan sekolah</small>
        </div>

        <div class="dashboard-stat-card">
            <p>Total Pengaduan</p>
            <h3>{{ $totalComplaints }}</h3>
            <small>Pengaduan yang tercatat</small>
        </div>

        <div class="dashboard-stat-card">
            <p>Total Pengguna</p>
            <h3>{{ $totalUsers }}</h3>
            <small>Pengguna terdaftar</small>
        </div>

    </div>
</section>

<section>
    <h2 class="dashboard-section-title">Akses Cepat</h2>

    <p class="dashboard-section-description">
        Pilih menu berikut untuk mengelola data sekolah.
    </p>

    <div class="dashboard-quick-links">

        <a href="{{ route('admin.rooms.index') }}"
           class="dashboard-quick-card">
            <h3>Kelola Ruangan</h3>

            <p>
                Lihat data ruangan, perbarui informasi,
                dan atur fasilitas yang tersedia.
            </p>

            <span>Buka halaman</span>
        </a>

        <a href="{{ route('admin.events.index') }}"
           class="dashboard-quick-card">
            <h3>Kelola Agenda</h3>

            <p>
                Periksa agenda kegiatan dan kelola jadwal
                penggunaan ruangan sekolah.
            </p>

            <span>Buka halaman</span>
        </a>

        <a href="{{ route('admin.users.index') }}"
           class="dashboard-quick-card">
            <h3>Kelola Pengguna</h3>

            <p>
                Lihat dan kelola akun pengguna
                yang terdaftar dalam sistem.
            </p>

            <span>Buka halaman</span>
        </a>

    </div>
</section>

@endsection