@extends('layouts.rapi')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('breadcrumb', 'PIC / Dashboard / Tambah')

@section('content')



<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard PIC - RAPI-Sekolah</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 min-h-screen">

    <main class="max-w-7xl mx-auto px-6 py-8">


        {{-- ========================= --}}
        {{-- HERO --}}
        {{-- ========================= --}}
        <section class="relative overflow-hidden
                        bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600
                        rounded-2xl shadow-sm
                        mb-8">

            <div class="absolute -right-20 -top-24
                        w-72 h-72
                        bg-white/10 rounded-full">
            </div>

            <div class="absolute right-40 -bottom-24
                        w-48 h-48
                        bg-white/5 rounded-full">
            </div>


            <div class="relative px-7 py-8 md:px-9 md:py-9">

                <div class="flex flex-col lg:flex-row
                            lg:items-center
                            lg:justify-between
                            gap-6">

                    <div>

                        <span class="inline-block
                                     px-3 py-1
                                     bg-white/15
                                     border border-white/20
                                     rounded-full
                                     text-xs font-semibold
                                     text-green-50
                                     uppercase tracking-wider">

                            Dashboard PIC

                        </span>


                        <h2 class="text-2xl md:text-3xl
                                   font-bold text-white mt-4">

                            Selamat datang, {{ auth()->user()->name }}

                        </h2>


                        <p class="text-green-100 mt-2
                                  max-w-2xl text-sm md:text-base">

                            Kelola agenda, pengaduan, dan ruangan
                            yang menjadi tanggung jawab Anda.

                        </p>

                    </div>


                    <div class="flex flex-wrap gap-3">

                        <a href="{{ route('pic.events.index') }}"
                           class="bg-white
                                  text-green-700
                                  hover:bg-green-50
                                  px-5 py-2.5
                                  rounded-xl
                                  text-sm font-semibold
                                  shadow-sm transition">

                            Kelola Agenda

                        </a>


                        <a href="{{ route('pic.complaints.index') }}"
                           class="bg-green-500/40
                                  border border-white/30
                                  text-white
                                  hover:bg-green-500
                                  px-5 py-2.5
                                  rounded-xl
                                  text-sm font-semibold
                                  transition">

                            Kelola Pengaduan

                        </a>

                    </div>

                </div>


                {{-- STATISTIK MINI --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-8">

                    <div class="bg-white/10
                                border border-white/15
                                backdrop-blur-sm
                                rounded-xl px-4 py-3">

                        <p class="text-xs text-green-100">
                            Ruangan Saya
                        </p>

                        <p class="text-xl font-bold text-white mt-1">
                            {{ $totalRooms }}
                        </p>

                    </div>


                    <div class="bg-white/10
                                border border-white/15
                                backdrop-blur-sm
                                rounded-xl px-4 py-3">

                        <p class="text-xs text-green-100">
                            Total Agenda
                        </p>

                        <p class="text-xl font-bold text-white mt-1">
                            {{ $totalEvents }}
                        </p>

                    </div>


                    <div class="bg-white/10
                                border border-white/15
                                backdrop-blur-sm
                                rounded-xl px-4 py-3">

                        <p class="text-xs text-green-100">
                            Total Pengaduan
                        </p>

                        <p class="text-xl font-bold text-white mt-1">
                            {{ $totalComplaints }}
                        </p>

                    </div>


                    <div class="bg-white/10
                                border border-white/15
                                backdrop-blur-sm
                                rounded-xl px-4 py-3">

                        <p class="text-xs text-green-100">
                            Pengaduan Selesai
                        </p>

                        <p class="text-xl font-bold text-white mt-1">
                            {{ $completedComplaints }}
                        </p>

                    </div>

                </div>

            </div>

        </section>


        {{-- ========================= --}}
        {{-- RINGKASAN AGENDA --}}
        {{-- ========================= --}}
        <section class="mb-8">

            <div class="flex flex-col sm:flex-row
                        sm:items-end sm:justify-between
                        gap-3 mb-4">

                <div>

                    <h3 class="text-xl font-bold text-slate-900">
                        Ringkasan Agenda
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Agenda pada ruangan yang menjadi tanggung jawab Anda.
                    </p>

                </div>


                <a href="{{ route('pic.events.index') }}"
                   class="text-sm font-semibold
                          text-green-600
                          hover:text-green-700">

                    Lihat Semua Agenda

                </a>

            </div>


            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                {{-- TOTAL --}}
                <a href="{{ route('pic.events.index') }}"
                   class="bg-white rounded-xl
                          border border-slate-200
                          border-l-4 border-l-green-500
                          p-6 shadow-sm
                          hover:shadow-md transition">

                    <p class="text-xs font-bold
                              text-green-600
                              uppercase tracking-wider">
                        Total Agenda
                    </p>

                    <div class="flex items-end justify-between gap-4 mt-4">

                        <p class="text-4xl font-bold text-slate-900">
                            {{ $totalEvents }}
                        </p>

                        <p class="text-sm text-slate-400">
                            Semua agenda
                        </p>

                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-100">

                        <p class="text-sm text-slate-500">
                            Agenda pada seluruh ruangan Anda
                        </p>

                    </div>

                </a>


                {{-- DIAJUKAN --}}
                <div class="bg-white rounded-xl
                            border border-slate-200
                            border-l-4 border-l-yellow-500
                            p-6 shadow-sm">

                    <p class="text-xs font-bold
                              text-yellow-600
                              uppercase tracking-wider">
                        Diajukan
                    </p>

                    <div class="flex items-end justify-between gap-4 mt-4">

                        <p class="text-4xl font-bold text-slate-900">
                            {{ $pendingEvents }}
                        </p>

                        <p class="text-sm text-slate-400">
                            Menunggu
                        </p>

                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-100">

                        <p class="text-sm text-slate-500">
                            Menunggu keputusan PIC
                        </p>

                    </div>

                </div>


                {{-- DISETUJUI --}}
                <div class="bg-white rounded-xl
                            border border-slate-200
                            border-l-4 border-l-emerald-500
                            p-6 shadow-sm">

                    <p class="text-xs font-bold
                              text-emerald-600
                              uppercase tracking-wider">
                        Disetujui
                    </p>

                    <div class="flex items-end justify-between gap-4 mt-4">

                        <p class="text-4xl font-bold text-slate-900">
                            {{ $approvedEvents }}
                        </p>

                        <p class="text-sm text-slate-400">
                            Diterima
                        </p>

                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-100">

                        <p class="text-sm text-slate-500">
                            Agenda yang telah disetujui
                        </p>

                    </div>

                </div>

            </div>

        </section>


        {{-- ========================= --}}
        {{-- RINGKASAN PENGADUAN --}}
        {{-- ========================= --}}
        <section class="mb-8">

            <div class="flex flex-col sm:flex-row
                        sm:items-end sm:justify-between
                        gap-3 mb-4">

                <div>

                    <h3 class="text-xl font-bold text-slate-900">
                        Ringkasan Pengaduan
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Progres laporan kerusakan pada ruangan Anda.
                    </p>

                </div>


                <a href="{{ route('pic.complaints.index') }}"
                   class="text-sm font-semibold
                          text-green-600
                          hover:text-green-700">

                    Kelola Pengaduan

                </a>

            </div>


            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                {{-- TOTAL --}}
                <a href="{{ route('pic.complaints.index') }}"
                   class="bg-white rounded-xl
                          border border-slate-200
                          border-t-4 border-t-green-500
                          p-6 shadow-sm
                          hover:shadow-md transition">

                    <p class="text-sm font-semibold text-slate-500">
                        Total Pengaduan
                    </p>

                    <p class="text-4xl font-bold text-slate-900 mt-4">
                        {{ $totalComplaints }}
                    </p>

                    <p class="text-sm text-slate-400 mt-3">
                        Semua laporan
                    </p>

                </a>


                {{-- DILAPORKAN --}}
                <div class="bg-white rounded-xl
                            border border-slate-200
                            border-t-4 border-t-red-500
                            p-6 shadow-sm">

                    <p class="text-sm font-semibold text-slate-500">
                        Dilaporkan
                    </p>

                    <p class="text-4xl font-bold text-red-600 mt-4">
                        {{ $reportedComplaints }}
                    </p>

                    <p class="text-sm text-slate-400 mt-3">
                        Menunggu penanganan
                    </p>

                </div>


                {{-- DIPROSES --}}
                <div class="bg-white rounded-xl
                            border border-slate-200
                            border-t-4 border-t-yellow-500
                            p-6 shadow-sm">

                    <p class="text-sm font-semibold text-slate-500">
                        Diproses
                    </p>

                    <p class="text-4xl font-bold text-yellow-600 mt-4">
                        {{ $processingComplaints }}
                    </p>

                    <p class="text-sm text-slate-400 mt-3">
                        Sedang ditangani
                    </p>

                </div>


                {{-- SELESAI --}}
                <div class="bg-white rounded-xl
                            border border-slate-200
                            border-t-4 border-t-emerald-500
                            p-6 shadow-sm">

                    <p class="text-sm font-semibold text-slate-500">
                        Selesai
                    </p>

                    <p class="text-4xl font-bold text-emerald-600 mt-4">
                        {{ $completedComplaints }}
                    </p>

                    <p class="text-sm text-slate-400 mt-3">
                        Penanganan selesai
                    </p>

                </div>

            </div>

        </section>


        {{-- ========================= --}}
        {{-- MENU UTAMA --}}
        {{-- ========================= --}}
        <section class="mb-8">

            <div class="mb-4">

                <h3 class="text-xl font-bold text-slate-900">
                    Menu PIC
                </h3>

                <p class="text-sm text-slate-500 mt-1">
                    Kelola agenda dan pengaduan pada ruangan tanggung jawab.
                </p>

            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- AGENDA --}}
                <div class="bg-gradient-to-br
                            from-green-50 to-white
                            border border-green-100
                            rounded-2xl p-6">

                    <span class="inline-block
                                 text-xs font-bold uppercase
                                 tracking-wider
                                 text-green-700
                                 bg-green-100
                                 px-3 py-1 rounded-full">

                        Agenda Ruangan

                    </span>


                    <h3 class="text-xl font-bold text-slate-900 mt-4">
                        Kelola Pengajuan Agenda
                    </h3>

                    <p class="text-sm text-slate-500 mt-2 max-w-md">
                        Periksa agenda yang diajukan pada ruangan Anda,
                        lalu tentukan status dan berikan catatan.
                    </p>

                    <a href="{{ route('pic.events.index') }}"
                       class="inline-flex mt-6
                              bg-green-600 hover:bg-green-700
                              text-white
                              px-5 py-2.5 rounded-lg
                              text-sm font-semibold transition">

                        Buka Agenda

                    </a>

                </div>


                {{-- PENGADUAN --}}
                <div class="bg-gradient-to-br
                            from-teal-50 to-white
                            border border-teal-100
                            rounded-2xl p-6">

                    <span class="inline-block
                                 text-xs font-bold uppercase
                                 tracking-wider
                                 text-teal-700
                                 bg-teal-100
                                 px-3 py-1 rounded-full">

                        Pengaduan Ruangan

                    </span>


                    <h3 class="text-xl font-bold text-slate-900 mt-4">
                        Kelola Penanganan Kerusakan
                    </h3>

                    <p class="text-sm text-slate-500 mt-2 max-w-md">
                        Perbarui proses penanganan laporan kerusakan
                        dan berikan catatan kepada pelapor.
                    </p>

                    <a href="{{ route('pic.complaints.index') }}"
                       class="inline-flex mt-6
                              bg-teal-600 hover:bg-teal-700
                              text-white
                              px-5 py-2.5 rounded-lg
                              text-sm font-semibold transition">

                        Buka Pengaduan

                    </a>

                </div>

            </div>

        </section>


        {{-- ========================= --}}
        {{-- RUANGAN TANGGUNG JAWAB --}}
        {{-- ========================= --}}
        <section>

            <div class="bg-white rounded-2xl
                        border border-slate-200
                        shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b border-slate-100">

                    <h3 class="text-lg font-bold text-slate-900">
                        Ruangan Tanggung Jawab
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Daftar ruangan yang ditugaskan kepada Anda.
                    </p>

                </div>


                <div class="p-6">

                    @forelse ($rooms as $room)

                        <div class="border border-slate-200
                                    rounded-xl p-5
                                    mb-4 last:mb-0
                                    hover:border-green-300
                                    hover:shadow-sm transition">

                            <div class="flex flex-col md:flex-row
                                        md:items-center md:justify-between
                                        gap-4">

                                <div>

                                    <h4 class="font-bold text-slate-900">
                                        {{ $room->name }}
                                    </h4>

                                    <p class="text-sm text-slate-500 mt-1">
                                        {{ $room->location }}
                                    </p>

                                </div>


                                <div class="flex flex-wrap gap-3">

                                    <div class="bg-slate-50
                                                border border-slate-100
                                                rounded-lg px-4 py-2">

                                        <p class="text-xs text-slate-400">
                                            Kapasitas
                                        </p>

                                        <p class="font-semibold text-slate-800 mt-0.5">
                                            {{ $room->capacity }} orang
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="py-10 text-center">

                            <p class="font-semibold text-slate-700">
                                Belum ada ruangan
                            </p>

                            <p class="text-sm text-slate-500 mt-1">
                                Belum ada ruangan yang ditugaskan kepada Anda.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

        </section>

    </main>

</body>

</html>
@endsection