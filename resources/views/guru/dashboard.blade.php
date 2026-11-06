@extends('layouts.rapi')

@section('title', 'Tambah Ruangan')

@section('page-title', 'Tambah Ruangan')

@section('breadcrumb', 'Admin / Kelola Ruangan / Tambah')

@section('content')



<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Guru - RAPI-Sekolah</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 min-h-screen">

    <main class="max-w-7xl mx-auto px-6 py-8">
        <section class="relative overflow-hidden
                        bg-gradient-to-r from-indigo-600 via-indigo-600 to-violet-600
                        rounded-2xl shadow-sm
                        mb-8">

            {{-- Dekorasi --}}
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


                    {{-- KIRI --}}
                    <div>

                        <span class="inline-block
                                     px-3 py-1
                                     bg-white/15
                                     border border-white/20
                                     rounded-full
                                     text-xs font-semibold
                                     text-indigo-50
                                     uppercase tracking-wider">

                            Dashboard Guru

                        </span>


                        <h2 class="text-2xl md:text-3xl
                                   font-bold text-white mt-4">

                            Selamat datang, {{ auth()->user()->name }}

                        </h2>


                        <p class="text-indigo-100 mt-2
                                  max-w-2xl text-sm md:text-base">

                            Pantau pengajuan agenda, perubahan jadwal,
                            catatan PIC, dan laporan kerusakan ruangan
                            dari satu halaman.

                        </p>

                    </div>


                    {{-- KANAN --}}
                    <div class="flex flex-wrap gap-3">

                        <a href="{{ route('guru.events.create') }}"
                           class="bg-white
                                  text-indigo-700
                                  hover:bg-indigo-50
                                  px-5 py-2.5
                                  rounded-xl
                                  text-sm font-semibold
                                  shadow-sm transition">

                            Ajukan Agenda

                        </a>


                        <a href="{{ route('guru.complaints.create') }}"
                           class="bg-indigo-500/50
                                  border border-white/30
                                  text-white
                                  hover:bg-indigo-500
                                  px-5 py-2.5
                                  rounded-xl
                                  text-sm font-semibold
                                  transition">

                            Buat Pengaduan

                        </a>

                    </div>

                </div>


                {{-- STATISTIK MINI --}}
                <div class="grid grid-cols-2 md:grid-cols-4
                            gap-3 mt-8">

                    <div class="bg-white/10
                                border border-white/15
                                backdrop-blur-sm
                                rounded-xl px-4 py-3">

                        <p class="text-xs text-indigo-100">
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

                        <p class="text-xs text-indigo-100">
                            Agenda Disetujui
                        </p>

                        <p class="text-xl font-bold text-white mt-1">
                            {{ $approvedEvents }}
                        </p>

                    </div>


                    <div class="bg-white/10
                                border border-white/15
                                backdrop-blur-sm
                                rounded-xl px-4 py-3">

                        <p class="text-xs text-indigo-100">
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

                        <p class="text-xs text-indigo-100">
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
        {{-- INFORMASI TERBARU --}}
        {{-- ========================= --}}
        <section class="mb-8">

            <div class="bg-white rounded-2xl
                        border border-slate-200
                        shadow-sm overflow-hidden">

                <div class="px-6 py-5
                            border-b border-slate-100
                            flex flex-col sm:flex-row
                            sm:items-center sm:justify-between
                            gap-3">

                    <div>

                        <h3 class="text-lg font-bold text-slate-900">
                            Informasi Terbaru
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            Perubahan terbaru pada agenda Anda.
                        </p>

                    </div>


                    <a href="{{ route('guru.events.index') }}"
                       class="text-sm font-semibold
                              text-indigo-600
                              hover:text-indigo-700">

                        Lihat Semua Agenda

                    </a>

                </div>


                <div class="divide-y divide-slate-100">

                    @forelse ($importantEvents as $event)

                        <a href="{{ route('guru.events.show', $event) }}"
                           class="block px-6 py-5
                                  hover:bg-slate-50
                                  transition">

                            <div class="flex flex-col sm:flex-row
                                        sm:items-start
                                        sm:justify-between
                                        gap-4">

                                <div class="flex-1">

                                    <p class="font-semibold text-slate-900">
                                        {{ $event->title }}
                                    </p>


                                    <p class="text-sm text-slate-500 mt-1">

                                        {{ $event->room->name ?? '-' }}

                                        <span class="mx-1">·</span>

                                        {{ \Carbon\Carbon::parse($event->event_date)->format('d-m-Y') }}

                                        <span class="mx-1">·</span>

                                        {{ substr($event->start_time, 0, 5) }}
                                        -
                                        {{ substr($event->end_time, 0, 5) }}

                                    </p>


                                    <div class="flex flex-wrap gap-2 mt-3">

                                        @if ($event->status === 'disetujui')

                                            <span class="px-3 py-1 rounded-full
                                                         bg-green-100 text-green-700
                                                         text-xs font-semibold">

                                                Disetujui

                                            </span>

                                        @elseif ($event->status === 'ditolak')

                                            <span class="px-3 py-1 rounded-full
                                                         bg-red-100 text-red-700
                                                         text-xs font-semibold">

                                                Ditolak

                                            </span>

                                        @else

                                            <span class="px-3 py-1 rounded-full
                                                         bg-yellow-100 text-yellow-700
                                                         text-xs font-semibold">

                                                Diajukan

                                            </span>

                                        @endif


                                        @if ($event->move_reason)

                                            <span class="px-3 py-1 rounded-full
                                                         bg-orange-100 text-orange-700
                                                         text-xs font-semibold">

                                                Dipindahkan

                                            </span>

                                        @endif


                                        @if ($event->pic_note)

                                            <span class="px-3 py-1 rounded-full
                                                         bg-blue-100 text-blue-700
                                                         text-xs font-semibold">

                                                Catatan PIC

                                            </span>

                                        @endif

                                    </div>


                                    @if ($event->move_reason || $event->pic_note)

                                        <div class="mt-3 space-y-1">

                                            @if ($event->move_reason)

                                                <p class="text-sm text-orange-600">
                                                    Ruangan atau jadwal agenda telah diubah.
                                                </p>

                                            @endif


                                            @if ($event->pic_note)

                                                <p class="text-sm text-blue-600">
                                                    PIC telah memberikan catatan pada agenda.
                                                </p>

                                            @endif

                                        </div>

                                    @endif

                                </div>


                                <span class="text-xs text-slate-400 whitespace-nowrap">

                                    {{ $event->updated_at->diffForHumans() }}

                                </span>

                            </div>

                        </a>

                    @empty

                        <div class="px-6 py-10 text-center">

                            <p class="font-semibold text-slate-700">
                                Belum ada informasi terbaru
                            </p>

                            <p class="text-sm text-slate-500 mt-1">
                                Perubahan agenda akan muncul di bagian ini.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

        </section>


        {{-- ========================= --}}
        {{-- RINGKASAN AGENDA --}}
        {{-- ========================= --}}
        <section class="mb-8">

            <div class="mb-4">

                <h3 class="text-xl font-bold text-slate-900">
                    Ringkasan Agenda
                </h3>

                <p class="text-sm text-slate-500 mt-1">
                    Status seluruh pengajuan agenda Anda.
                </p>

            </div>


            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">


                {{-- TOTAL --}}
                <a href="{{ route('guru.events.index') }}"
                   class="bg-white rounded-xl
                          border border-slate-200
                          border-l-4 border-l-indigo-500
                          p-6 shadow-sm
                          hover:shadow-md
                          hover:-translate-y-0.5
                          transition">

                    <p class="text-xs font-bold
                              text-indigo-600
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
                            Lihat seluruh pengajuan agenda
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
                            Menunggu keputusan PIC atau Admin
                        </p>

                    </div>

                </div>


                {{-- DISETUJUI --}}
                <div class="bg-white rounded-xl
                            border border-slate-200
                            border-l-4 border-l-green-500
                            p-6 shadow-sm">

                    <p class="text-xs font-bold
                              text-green-600
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


                {{-- DITOLAK --}}
                <div class="bg-white rounded-xl
                            border border-slate-200
                            border-l-4 border-l-red-500
                            p-6 shadow-sm">

                    <p class="text-xs font-bold
                              text-red-600
                              uppercase tracking-wider">
                        Ditolak
                    </p>

                    <div class="flex items-end justify-between gap-4 mt-4">

                        <p class="text-4xl font-bold text-slate-900">
                            {{ $rejectedEvents }}
                        </p>

                        <p class="text-sm text-slate-400">
                            Tidak diterima
                        </p>

                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-100">

                        <p class="text-sm text-slate-500">
                            Pengajuan yang tidak disetujui
                        </p>

                    </div>

                </div>


                {{-- DIPINDAHKAN --}}
                <div class="bg-white rounded-xl
                            border border-slate-200
                            border-l-4 border-l-orange-500
                            p-6 shadow-sm">

                    <p class="text-xs font-bold
                              text-orange-600
                              uppercase tracking-wider">
                        Dipindahkan
                    </p>

                    <div class="flex items-end justify-between gap-4 mt-4">

                        <p class="text-4xl font-bold text-slate-900">
                            {{ $movedEvents }}
                        </p>

                        <p class="text-sm text-slate-400">
                            Jadwal berubah
                        </p>

                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-100">

                        <p class="text-sm text-slate-500">
                            Ruangan atau waktu yang telah diubah
                        </p>

                    </div>

                </div>


                {{-- CATATAN PIC --}}
                <div class="bg-white rounded-xl
                            border border-slate-200
                            border-l-4 border-l-blue-500
                            p-6 shadow-sm">

                    <p class="text-xs font-bold
                              text-blue-600
                              uppercase tracking-wider">
                        Catatan PIC
                    </p>

                    <div class="flex items-end justify-between gap-4 mt-4">

                        <p class="text-4xl font-bold text-slate-900">
                            {{ $notedEvents }}
                        </p>

                        <p class="text-sm text-slate-400">
                            Ada catatan
                        </p>

                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-100">

                        <p class="text-sm text-slate-500">
                            Agenda yang memiliki catatan PIC
                        </p>

                    </div>

                </div>

            </div>

        </section>


        {{-- ========================= --}}
        {{-- RINGKASAN PENGADUAN --}}
        {{-- ========================= --}}
        <section class="mb-8">

            <div class="mb-4">

                <h3 class="text-xl font-bold text-slate-900">
                    Ringkasan Pengaduan
                </h3>

                <p class="text-sm text-slate-500 mt-1">
                    Status laporan kerusakan yang Anda kirim.
                </p>

            </div>


            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">


                <a href="{{ route('guru.complaints.index') }}"
                   class="bg-white rounded-xl
                          border border-slate-200
                          border-t-4 border-t-indigo-500
                          p-6 shadow-sm
                          hover:shadow-md
                          transition">

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
                        Sedang ditangani PIC
                    </p>

                </div>


                <div class="bg-white rounded-xl
                            border border-slate-200
                            border-t-4 border-t-green-500
                            p-6 shadow-sm">

                    <p class="text-sm font-semibold text-slate-500">
                        Selesai
                    </p>

                    <p class="text-4xl font-bold text-green-600 mt-4">
                        {{ $completedComplaints }}
                    </p>

                    <p class="text-sm text-slate-400 mt-3">
                        Penanganan selesai
                    </p>

                </div>

            </div>

        </section>


        {{-- ========================= --}}
        {{-- AKSI CEPAT --}}
        {{-- ========================= --}}
        <section class="mb-8">

            <div class="mb-4">

                <h3 class="text-xl font-bold text-slate-900">
                    Aksi Cepat
                </h3>

                <p class="text-sm text-slate-500 mt-1">
                    Buat pengajuan baru atau laporkan kerusakan fasilitas.
                </p>

            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                <div class="bg-gradient-to-br
                            from-indigo-50 to-white
                            border border-indigo-100
                            rounded-2xl p-6">

                    <span class="inline-block
                                 text-xs font-bold uppercase
                                 tracking-wider
                                 text-indigo-600
                                 bg-indigo-100
                                 px-3 py-1 rounded-full">
                        Agenda
                    </span>

                    <h3 class="text-xl font-bold text-slate-900 mt-4">
                        Pengajuan Penggunaan Ruangan
                    </h3>

                    <p class="text-sm text-slate-500 mt-2 max-w-md">
                        Ajukan penggunaan ruangan sekolah untuk rapat,
                        kegiatan, pembelajaran, atau agenda lainnya.
                    </p>

                    <a href="{{ route('guru.events.create') }}"
                       class="inline-flex mt-6
                              bg-indigo-600 hover:bg-indigo-700
                              text-white
                              px-5 py-2.5 rounded-lg
                              text-sm font-semibold
                              transition">

                        Ajukan Agenda

                    </a>

                </div>


                <div class="bg-gradient-to-br
                            from-orange-50 to-white
                            border border-orange-100
                            rounded-2xl p-6">

                    <span class="inline-block
                                 text-xs font-bold uppercase
                                 tracking-wider
                                 text-orange-600
                                 bg-orange-100
                                 px-3 py-1 rounded-full">
                        Pengaduan
                    </span>

                    <h3 class="text-xl font-bold text-slate-900 mt-4">
                        Laporkan Kerusakan Fasilitas
                    </h3>

                    <p class="text-sm text-slate-500 mt-2 max-w-md">
                        Laporkan kerusakan fasilitas atau kondisi ruangan
                        agar dapat segera ditangani oleh PIC.
                    </p>

                    <a href="{{ route('guru.complaints.create') }}"
                       class="inline-flex mt-6
                              bg-orange-500 hover:bg-orange-600
                              text-white
                              px-5 py-2.5 rounded-lg
                              text-sm font-semibold
                              transition">

                        Buat Pengaduan

                    </a>

                </div>

            </div>

        </section>


        {{-- ========================= --}}
        {{-- AGENDA TERBARU --}}
        {{-- ========================= --}}
        <section class="mb-8">

            <div class="bg-white rounded-2xl
                        border border-slate-200
                        shadow-sm overflow-hidden">

                <div class="px-6 py-5
                            border-b border-slate-100
                            flex flex-col sm:flex-row
                            sm:items-center sm:justify-between
                            gap-3">

                    <div>

                        <h3 class="text-lg font-bold text-slate-900">
                            Agenda Terbaru
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            Lima pengajuan agenda terakhir Anda.
                        </p>

                    </div>


                    <a href="{{ route('guru.events.index') }}"
                       class="text-sm font-semibold
                              text-indigo-600
                              hover:text-indigo-700">

                        Lihat Semua

                    </a>

                </div>


                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-slate-50
                                      border-b border-slate-200">

                            <tr>

                                <th class="px-6 py-4 text-left
                                           text-xs font-bold
                                           text-slate-500 uppercase
                                           tracking-wider">
                                    Agenda
                                </th>

                                <th class="px-6 py-4 text-left
                                           text-xs font-bold
                                           text-slate-500 uppercase
                                           tracking-wider">
                                    Ruangan
                                </th>

                                <th class="px-6 py-4 text-left
                                           text-xs font-bold
                                           text-slate-500 uppercase
                                           tracking-wider">
                                    Tanggal
                                </th>

                                <th class="px-6 py-4 text-left
                                           text-xs font-bold
                                           text-slate-500 uppercase
                                           tracking-wider">
                                    Status
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-100">

                            @forelse ($latestEvents as $event)

                                <tr class="hover:bg-slate-50 transition">

                                    <td class="px-6 py-4">

                                        <a href="{{ route('guru.events.show', $event) }}"
                                           class="font-semibold
                                                  text-slate-900
                                                  hover:text-indigo-600">

                                            {{ $event->title }}

                                        </a>


                                        @if ($event->move_reason || $event->pic_note)

                                            <div class="flex flex-wrap gap-2 mt-2">

                                                @if ($event->move_reason)

                                                    <span class="px-2.5 py-1
                                                                 rounded-full
                                                                 bg-orange-100
                                                                 text-orange-700
                                                                 text-xs font-semibold">
                                                        Dipindahkan
                                                    </span>

                                                @endif


                                                @if ($event->pic_note)

                                                    <span class="px-2.5 py-1
                                                                 rounded-full
                                                                 bg-blue-100
                                                                 text-blue-700
                                                                 text-xs font-semibold">
                                                        Catatan PIC
                                                    </span>

                                                @endif

                                            </div>

                                        @endif

                                    </td>


                                    <td class="px-6 py-4 text-slate-600">
                                        {{ $event->room->name ?? '-' }}
                                    </td>


                                    <td class="px-6 py-4 text-slate-600">
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('d-m-Y') }}
                                    </td>


                                    <td class="px-6 py-4">

                                        @if ($event->status === 'disetujui')

                                            <span class="px-3 py-1 rounded-full
                                                         bg-green-100 text-green-700
                                                         text-xs font-semibold">
                                                Disetujui
                                            </span>

                                        @elseif ($event->status === 'ditolak')

                                            <span class="px-3 py-1 rounded-full
                                                         bg-red-100 text-red-700
                                                         text-xs font-semibold">
                                                Ditolak
                                            </span>

                                        @else

                                            <span class="px-3 py-1 rounded-full
                                                         bg-yellow-100 text-yellow-700
                                                         text-xs font-semibold">
                                                Diajukan
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="4"
                                        class="px-6 py-12 text-center text-slate-500">

                                        Belum ada agenda.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </section>


        {{-- ========================= --}}
        {{-- PENGADUAN TERBARU --}}
        {{-- ========================= --}}
        <section>

            <div class="bg-white rounded-2xl
                        border border-slate-200
                        shadow-sm overflow-hidden">

                <div class="px-6 py-5
                            border-b border-slate-100
                            flex flex-col sm:flex-row
                            sm:items-center sm:justify-between
                            gap-3">

                    <div>

                        <h3 class="text-lg font-bold text-slate-900">
                            Pengaduan Terbaru
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            Lima laporan kerusakan terakhir Anda.
                        </p>

                    </div>


                    <a href="{{ route('guru.complaints.index') }}"
                       class="text-sm font-semibold
                              text-indigo-600
                              hover:text-indigo-700">

                        Lihat Semua

                    </a>

                </div>


                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-slate-50
                                      border-b border-slate-200">

                            <tr>

                                <th class="px-6 py-4 text-left
                                           text-xs font-bold
                                           text-slate-500 uppercase
                                           tracking-wider">
                                    Pengaduan
                                </th>

                                <th class="px-6 py-4 text-left
                                           text-xs font-bold
                                           text-slate-500 uppercase
                                           tracking-wider">
                                    Ruangan
                                </th>

                                <th class="px-6 py-4 text-left
                                           text-xs font-bold
                                           text-slate-500 uppercase
                                           tracking-wider">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-center
                                           text-xs font-bold
                                           text-slate-500 uppercase
                                           tracking-wider">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-100">

                            @forelse ($latestComplaints as $complaint)

                                <tr class="hover:bg-slate-50 transition">

                                    <td class="px-6 py-4">

                                        <p class="font-semibold text-slate-900">
                                            {{ $complaint->title }}
                                        </p>

                                    </td>


                                    <td class="px-6 py-4 text-slate-600">
                                        {{ $complaint->room->name ?? '-' }}
                                    </td>


                                    <td class="px-6 py-4">

                                        @if ($complaint->status === 'selesai')

                                            <span class="px-3 py-1 rounded-full
                                                         bg-green-100 text-green-700
                                                         text-xs font-semibold">
                                                Selesai
                                            </span>

                                        @elseif ($complaint->status === 'diproses')

                                            <span class="px-3 py-1 rounded-full
                                                         bg-yellow-100 text-yellow-700
                                                         text-xs font-semibold">
                                                Diproses
                                            </span>

                                        @else

                                            <span class="px-3 py-1 rounded-full
                                                         bg-red-100 text-red-700
                                                         text-xs font-semibold">
                                                Dilaporkan
                                            </span>

                                        @endif

                                    </td>


                                    <td class="px-6 py-4 text-center">

                                        <a href="{{ route('guru.complaints.show', $complaint) }}"
                                           class="inline-flex
                                                  border border-slate-300
                                                  bg-white
                                                  hover:bg-slate-50
                                                  text-slate-700
                                                  px-4 py-2
                                                  rounded-lg
                                                  text-sm font-semibold
                                                  transition">

                                            Lihat

                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="4"
                                        class="px-6 py-12 text-center text-slate-500">

                                        Belum ada pengaduan.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </section>

    </main>

</body>

</html>
@endsection