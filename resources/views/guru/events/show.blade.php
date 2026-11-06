@extends('layouts.rapi')

@section('title', 'Agenda')

@section('page-title', 'Agenda')

@section('breadcrumb', 'Admin / Agenda / Tambah')

@section('content')



<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Agenda Guru - RAPI-Sekolah</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 min-h-screen">

   
    <main class="max-w-6xl mx-auto px-6 py-8">


       
        {{-- SUMMARY --}}
        <section class="grid grid-cols-1
                        sm:grid-cols-2
                        lg:grid-cols-4
                        gap-4
                        mb-6">


            {{-- RUANGAN --}}
            <div class="bg-white
                        border border-slate-200
                        border-l-4 border-l-indigo-500
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs font-bold
                          uppercase tracking-wider
                          text-indigo-600">
                    Ruangan
                </p>

                <p class="text-lg font-bold text-slate-900 mt-2">
                    {{ $event->room->name ?? '-' }}
                </p>

                <p class="text-sm text-slate-500 mt-1">
                    {{ $event->room->location ?? '-' }}
                </p>

            </div>


            {{-- TANGGAL --}}
            <div class="bg-white
                        border border-slate-200
                        border-l-4 border-l-violet-500
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs font-bold
                          uppercase tracking-wider
                          text-violet-600">
                    Tanggal
                </p>

                <p class="text-lg font-bold text-slate-900 mt-2">
                    {{ \Carbon\Carbon::parse($event->event_date)->format('d-m-Y') }}
                </p>

                <p class="text-sm text-slate-500 mt-1">
                    Jadwal kegiatan
                </p>

            </div>


            {{-- WAKTU --}}
            <div class="bg-white
                        border border-slate-200
                        border-l-4 border-l-purple-500
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs font-bold
                          uppercase tracking-wider
                          text-purple-600">
                    Waktu
                </p>

                <p class="text-lg font-bold text-slate-900 mt-2">

                    {{ substr($event->start_time, 0, 5) }}
                    -
                    {{ substr($event->end_time, 0, 5) }}

                </p>

                <p class="text-sm text-slate-500 mt-1">
                    Waktu penggunaan
                </p>

            </div>


            {{-- STATUS --}}
            <div class="bg-white
                        border border-slate-200
                        border-l-4
                        {{ $event->status === 'disetujui'
                            ? 'border-l-green-500'
                            : ($event->status === 'ditolak'
                                ? 'border-l-red-500'
                                : 'border-l-yellow-500') }}
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs font-bold
                          uppercase tracking-wider
                          text-slate-500">
                    Status
                </p>

                <div class="mt-3">

                    @if($event->status === 'disetujui')

                        <span class="inline-flex
                                     bg-green-50
                                     border border-green-100
                                     text-green-700
                                     px-3 py-1
                                     rounded-full
                                     text-xs font-semibold">

                            Disetujui

                        </span>

                    @elseif($event->status === 'ditolak')

                        <span class="inline-flex
                                     bg-red-50
                                     border border-red-100
                                     text-red-700
                                     px-3 py-1
                                     rounded-full
                                     text-xs font-semibold">

                            Ditolak

                        </span>

                    @else

                        <span class="inline-flex
                                     bg-yellow-50
                                     border border-yellow-100
                                     text-yellow-700
                                     px-3 py-1
                                     rounded-full
                                     text-xs font-semibold">

                            Diajukan

                        </span>

                    @endif

                </div>

            </div>

        </section>


        {{-- MAIN GRID --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


            {{-- LEFT --}}
            <div class="lg:col-span-2 space-y-6">


                {{-- INFORMASI AGENDA --}}
                <section class="bg-white
                                border border-slate-200
                                rounded-2xl
                                shadow-sm
                                overflow-hidden">

                    <div class="px-6 py-5
                                border-b border-slate-100">

                        <h3 class="text-lg font-bold text-slate-900">
                            Informasi Agenda
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            Informasi lengkap pengajuan penggunaan ruangan.
                        </p>

                    </div>


                    <div class="p-6">

                        <div class="border border-slate-200
                                    rounded-xl
                                    p-5">

                            <p class="text-xs font-semibold
                                      uppercase tracking-wider
                                      text-slate-400">
                                Nama Agenda
                            </p>

                            <p class="font-bold text-slate-900 mt-2">
                                {{ $event->title }}
                            </p>

                        </div>


                        <div class="mt-5">

                            <p class="text-sm
                                      font-semibold
                                      text-slate-700
                                      mb-2">
                                Deskripsi Agenda
                            </p>

                            <div class="bg-slate-50
                                        border border-slate-200
                                        rounded-xl
                                        p-5">

                                <p class="text-slate-700
                                          leading-7
                                          whitespace-pre-line">{{ $event->description ?: 'Tidak ada deskripsi.' }}</p>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- ALASAN PEMINDAHAN --}}
                @if($event->move_reason)

                    <section class="bg-white
                                    border border-violet-200
                                    rounded-2xl
                                    shadow-sm
                                    overflow-hidden">

                        <div class="px-6 py-5
                                    bg-violet-50
                                    border-b border-violet-100">

                            <div class="flex flex-col
                                        sm:flex-row
                                        sm:items-center
                                        sm:justify-between
                                        gap-3">

                                <div>

                                    <h3 class="text-lg font-bold text-violet-900">
                                        Informasi Pemindahan Agenda
                                    </h3>

                                    <p class="text-sm text-violet-700 mt-1">
                                        Admin telah melakukan perubahan
                                        ruangan atau jadwal.
                                    </p>

                                </div>


                                <span class="inline-flex
                                             self-start
                                             sm:self-auto
                                             bg-violet-100
                                             border border-violet-200
                                             text-violet-700
                                             px-3 py-1
                                             rounded-full
                                             text-xs font-semibold">

                                    Dipindahkan

                                </span>

                            </div>

                        </div>


                        <div class="p-6">

                            <p class="text-xs
                                      font-bold
                                      uppercase tracking-wider
                                      text-violet-500">

                                Alasan Pemindahan

                            </p>

                            <div class="mt-3
                                        bg-violet-50
                                        border border-violet-100
                                        rounded-xl
                                        p-5">

                                <p class="text-violet-800
                                          leading-7
                                          whitespace-pre-line">{{ $event->move_reason }}</p>

                            </div>

                            <p class="text-xs text-slate-400 mt-3">
                                Jadwal dan ruangan yang ditampilkan pada
                                halaman ini merupakan data agenda terbaru.
                            </p>

                        </div>

                    </section>

                @endif


                {{-- CATATAN PIC --}}
                <section class="bg-white
                                border border-slate-200
                                rounded-2xl
                                shadow-sm
                                overflow-hidden">

                    <div class="px-6 py-5
                                border-b border-slate-100">

                        <div class="flex items-center
                                    justify-between
                                    gap-4">

                            <div>

                                <h3 class="text-lg font-bold text-slate-900">
                                    Catatan PIC
                                </h3>

                                <p class="text-sm text-slate-500 mt-1">
                                    Informasi atau keputusan dari PIC ruangan.
                                </p>

                            </div>


                            <span class="bg-indigo-50
                                         border border-indigo-100
                                         text-indigo-700
                                         px-3 py-1
                                         rounded-full
                                         text-xs font-semibold">

                                PIC Ruangan

                            </span>

                        </div>

                    </div>


                    <div class="p-6">

                        @if($event->pic_note)

                            <div class="bg-indigo-50
                                        border border-indigo-200
                                        rounded-xl
                                        p-5">

                                <p class="font-semibold text-indigo-800">
                                    Catatan Keputusan PIC
                                </p>

                                <p class="text-indigo-700
                                          mt-2
                                          leading-7
                                          whitespace-pre-line">{{ $event->pic_note }}</p>

                            </div>

                        @else

                            <div class="bg-slate-50
                                        border border-slate-200
                                        rounded-xl
                                        p-5">

                                <p class="font-semibold text-slate-700">
                                    Belum Ada Catatan
                                </p>

                                <p class="text-sm text-slate-500 mt-1">
                                    PIC belum memberikan catatan untuk
                                    agenda ini.
                                </p>

                            </div>

                        @endif

                    </div>

                </section>

            </div>


            {{-- RIGHT --}}
            <div class="space-y-6">


                {{-- KETERANGAN STATUS --}}
                <section class="bg-white
                                border border-slate-200
                                rounded-2xl
                                shadow-sm
                                overflow-hidden">

                    <div class="px-5 py-4
                                border-b border-slate-100">

                        <h3 class="font-bold text-slate-900">
                            Keterangan Status
                        </h3>

                        <p class="text-xs text-slate-500 mt-1">
                            Kondisi pengajuan saat ini.
                        </p>

                    </div>


                    <div class="p-5">

                        @if($event->status === 'diajukan')

                            <div class="bg-yellow-50
                                        border border-yellow-200
                                        rounded-xl
                                        p-5">

                                <span class="inline-flex
                                             bg-yellow-100
                                             text-yellow-700
                                             px-3 py-1
                                             rounded-full
                                             text-xs font-semibold">

                                    Diajukan

                                </span>

                                <p class="font-semibold
                                          text-yellow-800
                                          mt-3">
                                    Menunggu Keputusan
                                </p>

                                <p class="text-sm
                                          text-yellow-700
                                          mt-1
                                          leading-6">

                                    Agenda masih menunggu keputusan
                                    PIC atau Admin.

                                </p>

                            </div>


                        @elseif($event->status === 'disetujui')

                            <div class="bg-green-50
                                        border border-green-200
                                        rounded-xl
                                        p-5">

                                <span class="inline-flex
                                             bg-green-100
                                             text-green-700
                                             px-3 py-1
                                             rounded-full
                                             text-xs font-semibold">

                                    Disetujui

                                </span>

                                <p class="font-semibold
                                          text-green-800
                                          mt-3">
                                    Agenda Disetujui
                                </p>

                                <p class="text-sm
                                          text-green-700
                                          mt-1
                                          leading-6">

                                    Ruangan dapat digunakan sesuai
                                    tanggal dan waktu yang telah ditentukan.

                                </p>

                            </div>


                        @else

                            <div class="bg-red-50
                                        border border-red-200
                                        rounded-xl
                                        p-5">

                                <span class="inline-flex
                                             bg-red-100
                                             text-red-700
                                             px-3 py-1
                                             rounded-full
                                             text-xs font-semibold">

                                    Ditolak

                                </span>

                                <p class="font-semibold
                                          text-red-800
                                          mt-3">
                                    Agenda Ditolak
                                </p>

                                <p class="text-sm
                                          text-red-700
                                          mt-1
                                          leading-6">

                                    Pengajuan tidak disetujui.
                                    Lihat catatan PIC untuk keterangannya.

                                </p>

                            </div>

                        @endif

                    </div>

                </section>


                {{-- PROSES PENGAJUAN --}}
                <section class="bg-white
                                border border-slate-200
                                rounded-2xl
                                shadow-sm
                                overflow-hidden">

                    <div class="px-5 py-4
                                border-b border-slate-100">

                        <h3 class="font-bold text-slate-900">
                            Proses Pengajuan
                        </h3>

                        <p class="text-xs text-slate-500 mt-1">
                            Tahapan pengajuan agenda.
                        </p>

                    </div>


                    <div class="p-5 space-y-3">


                        {{-- STEP 1 --}}
                        <div class="bg-yellow-50
                                    border border-yellow-200
                                    rounded-xl
                                    p-4">

                            <div class="flex items-center gap-3">

                                <span class="flex
                                             items-center
                                             justify-center
                                             w-8 h-8
                                             rounded-full
                                             bg-yellow-100
                                             text-yellow-700
                                             text-xs font-bold">

                                    1

                                </span>

                                <div>

                                    <p class="font-semibold text-yellow-700">
                                        Diajukan
                                    </p>

                                    <p class="text-xs text-slate-500 mt-1">
                                        Pengajuan telah dikirim.
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="h-5 w-px bg-slate-200 ml-4"></div>


                        {{-- STEP 2 --}}
                        @if($event->status === 'disetujui')

                            <div class="bg-green-50
                                        border border-green-200
                                        rounded-xl
                                        p-4">

                                <div class="flex items-center gap-3">

                                    <span class="flex
                                                 items-center
                                                 justify-center
                                                 w-8 h-8
                                                 rounded-full
                                                 bg-green-100
                                                 text-green-700
                                                 text-xs font-bold">

                                        2

                                    </span>

                                    <div>

                                        <p class="font-semibold text-green-700">
                                            Disetujui
                                        </p>

                                        <p class="text-xs text-slate-500 mt-1">
                                            Pengajuan telah disetujui.
                                        </p>

                                    </div>

                                </div>

                            </div>


                        @elseif($event->status === 'ditolak')

                            <div class="bg-red-50
                                        border border-red-200
                                        rounded-xl
                                        p-4">

                                <div class="flex items-center gap-3">

                                    <span class="flex
                                                 items-center
                                                 justify-center
                                                 w-8 h-8
                                                 rounded-full
                                                 bg-red-100
                                                 text-red-700
                                                 text-xs font-bold">

                                        2

                                    </span>

                                    <div>

                                        <p class="font-semibold text-red-700">
                                            Ditolak
                                        </p>

                                        <p class="text-xs text-slate-500 mt-1">
                                            Pengajuan tidak disetujui.
                                        </p>

                                    </div>

                                </div>

                            </div>


                        @else

                            <div class="bg-slate-50
                                        border border-slate-200
                                        rounded-xl
                                        p-4">

                                <div class="flex items-center gap-3">

                                    <span class="flex
                                                 items-center
                                                 justify-center
                                                 w-8 h-8
                                                 rounded-full
                                                 bg-slate-200
                                                 text-slate-500
                                                 text-xs font-bold">

                                        2

                                    </span>

                                    <div>

                                        <p class="font-semibold text-slate-500">
                                            Menunggu Keputusan
                                        </p>

                                        <p class="text-xs text-slate-400 mt-1">
                                            Belum ada keputusan.
                                        </p>

                                    </div>

                                </div>

                            </div>

                        @endif


                        {{-- PEMINDAHAN --}}
                        @if($event->move_reason)

                            <div class="h-5 w-px bg-slate-200 ml-4"></div>

                            <div class="bg-violet-50
                                        border border-violet-200
                                        rounded-xl
                                        p-4">

                                <div class="flex items-center gap-3">

                                    <span class="flex
                                                 items-center
                                                 justify-center
                                                 w-8 h-8
                                                 rounded-full
                                                 bg-violet-100
                                                 text-violet-700
                                                 text-xs font-bold">

                                        3

                                    </span>

                                    <div>

                                        <p class="font-semibold text-violet-700">
                                            Jadwal Dipindahkan
                                        </p>

                                        <p class="text-xs text-slate-500 mt-1">
                                            Admin mengubah ruangan atau jadwal.
                                        </p>

                                    </div>

                                </div>

                            </div>

                        @endif

                    </div>

                </section>


                {{-- INFORMASI RUANGAN --}}
                <section class="bg-white
                                border border-slate-200
                                rounded-2xl
                                shadow-sm
                                overflow-hidden">

                    <div class="px-5 py-4
                                border-b border-slate-100">

                        <h3 class="font-bold text-slate-900">
                            Informasi Ruangan
                        </h3>

                    </div>


                    <div class="p-5">

                        <p class="text-xs font-semibold
                                  uppercase tracking-wider
                                  text-slate-400">
                            Nama Ruangan
                        </p>

                        <p class="font-bold text-slate-900 mt-1">
                            {{ $event->room->name ?? '-' }}
                        </p>


                        <div class="border-t border-slate-100 my-4"></div>


                        <p class="text-xs font-semibold
                                  uppercase tracking-wider
                                  text-slate-400">
                            Lokasi
                        </p>

                        <p class="text-sm text-slate-700 mt-1">
                            {{ $event->room->location ?? '-' }}
                        </p>


                        @if($event->room?->capacity)

                            <div class="border-t border-slate-100 my-4"></div>

                            <p class="text-xs font-semibold
                                      uppercase tracking-wider
                                      text-slate-400">
                                Kapasitas
                            </p>

                            <p class="text-sm font-semibold text-slate-700 mt-1">
                                {{ $event->room->capacity }} orang
                            </p>

                        @endif


                        @if($event->room?->pic)

                            <div class="border-t border-slate-100 my-4"></div>

                            <p class="text-xs font-semibold
                                      uppercase tracking-wider
                                      text-slate-400">
                                PIC Ruangan
                            </p>

                            <p class="text-sm font-semibold text-slate-700 mt-1">
                                {{ $event->room->pic->name }}
                            </p>

                        @endif

                    </div>

                </section>

            </div>

        </div>


        {{-- ACTION --}}
        <section class="bg-white
                        border border-slate-200
                        rounded-2xl
                        shadow-sm
                        p-5
                        mt-6">

            <div class="flex flex-col
                        sm:flex-row
                        sm:items-center
                        sm:justify-between
                        gap-3">

                <a href="{{ route('guru.events.index') }}"
                   class="inline-flex
                          justify-center
                          bg-slate-100
                          hover:bg-slate-200
                          text-slate-700
                          px-5 py-2.5
                          rounded-lg
                          text-sm font-semibold
                          transition">

                    Kembali ke Agenda

                </a>


                <a href="{{ route('guru.dashboard') }}"
                   class="inline-flex
                          justify-center
                          bg-indigo-600
                          hover:bg-indigo-700
                          text-white
                          px-5 py-2.5
                          rounded-lg
                          text-sm font-semibold
                          transition">

                    Dashboard

                </a>

            </div>

        </section>

    </main>

</body>

</html>
@endsection