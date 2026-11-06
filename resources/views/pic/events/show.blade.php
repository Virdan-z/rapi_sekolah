@extends('layouts.rapi')

@section('title', 'Agenda')

@section('page-title', 'Detail Agenda')

@section('breadcrumb', 'PIC / Agenda / Detail')

@section('content')



<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Agenda PIC - RAPI-Sekolah</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 min-h-screen">

    
    <main class="max-w-6xl mx-auto px-6 py-8">


       
        {{-- SUCCESS --}}
        @if(session('success'))

            <div class="bg-green-50
                        border border-green-200
                        text-green-700
                        rounded-xl
                        px-5 py-4
                        mb-6">

                <p class="font-semibold">
                    Berhasil
                </p>

                <p class="text-sm mt-1">
                    {{ session('success') }}
                </p>

            </div>

        @endif


        {{-- SUMMARY --}}
        <section class="grid grid-cols-1
                        sm:grid-cols-2
                        lg:grid-cols-4
                        gap-4
                        mb-6">


            {{-- RUANGAN --}}
            <div class="bg-white
                        border border-slate-200
                        border-l-4 border-l-green-500
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs
                          font-bold
                          uppercase tracking-wider
                          text-green-600">

                    Ruangan

                </p>

                <p class="text-lg font-bold text-slate-900 mt-2">
                    {{ $event->room->name ?? '-' }}
                </p>

                <p class="text-sm text-slate-500 mt-1">
                    {{ $event->room->location ?? '-' }}
                </p>

            </div>


            {{-- PENGAJU --}}
            <div class="bg-white
                        border border-slate-200
                        border-l-4 border-l-emerald-500
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs
                          font-bold
                          uppercase tracking-wider
                          text-emerald-600">

                    Pengaju

                </p>

                <p class="text-lg font-bold text-slate-900 mt-2">
                    {{ $event->user->name ?? '-' }}
                </p>

                <p class="text-sm text-slate-500 mt-1">
                    {{ $event->user->email ?? '-' }}
                </p>

            </div>


            {{-- TANGGAL --}}
            <div class="bg-white
                        border border-slate-200
                        border-l-4 border-l-teal-500
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs
                          font-bold
                          uppercase tracking-wider
                          text-teal-600">

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
                        border-l-4 border-l-cyan-500
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs
                          font-bold
                          uppercase tracking-wider
                          text-cyan-600">

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

        </section>


        {{-- MAIN GRID --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


            {{-- LEFT --}}
            <div class="lg:col-span-2 space-y-6">


                {{-- DETAIL --}}
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

                        <div class="border
                                    border-slate-200
                                    rounded-xl
                                    p-5">

                            <p class="text-xs
                                      font-semibold
                                      uppercase tracking-wider
                                      text-slate-400">

                                Judul Agenda

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


                {{-- MOVE REASON --}}
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
                                        Jadwal atau ruangan agenda telah diubah oleh Admin.
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

                            <div class="bg-violet-50
                                        border border-violet-100
                                        rounded-xl
                                        p-5
                                        mt-3">

                                <p class="text-violet-800
                                          leading-7
                                          whitespace-pre-line">{{ $event->move_reason }}</p>

                            </div>

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

                        <div class="flex flex-col
                                    sm:flex-row
                                    sm:items-center
                                    sm:justify-between
                                    gap-3">

                            <div>

                                <h3 class="text-lg font-bold text-slate-900">
                                    Catatan PIC
                                </h3>

                                <p class="text-sm text-slate-500 mt-1">
                                    Informasi atau alasan keputusan dari PIC.
                                </p>

                            </div>


                            @if($event->pic_note)

                                <span class="inline-flex
                                             self-start
                                             sm:self-auto
                                             bg-green-50
                                             border border-green-100
                                             text-green-700
                                             px-3 py-1
                                             rounded-full
                                             text-xs font-semibold">

                                    Catatan Tersedia

                                </span>

                            @endif

                        </div>

                    </div>


                    <div class="p-6">

                        @if($event->pic_note)

                            <div class="bg-green-50
                                        border border-green-200
                                        rounded-xl
                                        p-5">

                                <p class="font-semibold text-green-800">
                                    Catatan Keputusan
                                </p>

                                <p class="text-green-700
                                          leading-7
                                          mt-2
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
                                    Belum ada catatan PIC untuk agenda ini.
                                </p>

                            </div>

                        @endif

                    </div>

                </section>

            </div>


            {{-- RIGHT --}}
            <div class="space-y-6">


                {{-- STATUS --}}
                <section class="bg-white
                                border border-slate-200
                                rounded-2xl
                                shadow-sm
                                overflow-hidden">

                    <div class="px-5 py-4
                                border-b border-slate-100">

                        <h3 class="font-bold text-slate-900">
                            Status Pengajuan
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
                                          leading-6
                                          mt-1">

                                    Agenda masih menunggu keputusan dari PIC.

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
                                          leading-6
                                          mt-1">

                                    Ruangan dapat digunakan sesuai jadwal yang telah ditentukan.

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
                                          leading-6
                                          mt-1">

                                    Pengajuan penggunaan ruangan tidak disetujui.

                                </p>

                            </div>

                        @endif

                    </div>

                </section>


                {{-- PROCESS --}}
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
                                        Agenda diajukan ke PIC.
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="h-5 w-px bg-slate-200 ml-4"></div>


                        {{-- STEP 2 --}}
                        <div class="rounded-xl
                                    border
                                    p-4
                                    {{ $event->status === 'disetujui'
                                        ? 'bg-green-50 border-green-200'
                                        : ($event->status === 'ditolak'
                                            ? 'bg-red-50 border-red-200'
                                            : 'bg-slate-50 border-slate-200') }}">

                            <div class="flex items-center gap-3">

                                <span class="flex
                                             items-center
                                             justify-center
                                             w-8 h-8
                                             rounded-full
                                             text-xs font-bold
                                             {{ $event->status === 'disetujui'
                                                 ? 'bg-green-100 text-green-700'
                                                 : ($event->status === 'ditolak'
                                                     ? 'bg-red-100 text-red-700'
                                                     : 'bg-slate-200 text-slate-500') }}">

                                    2

                                </span>

                                <div>

                                    @if($event->status === 'disetujui')

                                        <p class="font-semibold text-green-700">
                                            Disetujui
                                        </p>

                                        <p class="text-xs text-slate-500 mt-1">
                                            Agenda telah disetujui PIC.
                                        </p>

                                    @elseif($event->status === 'ditolak')

                                        <p class="font-semibold text-red-700">
                                            Ditolak
                                        </p>

                                        <p class="text-xs text-slate-500 mt-1">
                                            Agenda tidak disetujui PIC.
                                        </p>

                                    @else

                                        <p class="font-semibold text-slate-500">
                                            Menunggu Keputusan
                                        </p>

                                        <p class="text-xs text-slate-500 mt-1">
                                            PIC belum memberikan keputusan.
                                        </p>

                                    @endif

                                </div>

                            </div>

                        </div>


                        {{-- MOVED --}}
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
                                            Admin mengubah ruangan atau jadwal agenda.
                                        </p>

                                    </div>

                                </div>

                            </div>

                        @endif

                    </div>

                </section>


                {{-- ROOM INFO --}}
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

                        <p class="text-xs
                                  font-semibold
                                  uppercase tracking-wider
                                  text-slate-400">

                            Nama Ruangan

                        </p>

                        <p class="font-bold text-slate-900 mt-1">
                            {{ $event->room->name ?? '-' }}
                        </p>


                        <div class="border-t border-slate-100 my-4"></div>


                        <p class="text-xs
                                  font-semibold
                                  uppercase tracking-wider
                                  text-slate-400">

                            Lokasi

                        </p>

                        <p class="text-sm text-slate-700 mt-1">
                            {{ $event->room->location ?? '-' }}
                        </p>


                        @if($event->room?->capacity)

                            <div class="border-t border-slate-100 my-4"></div>

                            <p class="text-xs
                                      font-semibold
                                      uppercase tracking-wider
                                      text-slate-400">

                                Kapasitas

                            </p>

                            <p class="text-sm font-semibold
                                      text-slate-700 mt-1">

                                {{ $event->room->capacity }} orang

                            </p>

                        @endif

                    </div>

                </section>


                {{-- APPLICANT --}}
                <section class="bg-white
                                border border-slate-200
                                rounded-2xl
                                shadow-sm
                                overflow-hidden">

                    <div class="px-5 py-4
                                border-b border-slate-100">

                        <h3 class="font-bold text-slate-900">
                            Informasi Pengaju
                        </h3>

                    </div>


                    <div class="p-5">

                        <p class="font-semibold text-slate-900">
                            {{ $event->user->name ?? '-' }}
                        </p>

                        <p class="text-sm text-slate-500 mt-1">
                            {{ $event->user->email ?? '-' }}
                        </p>


                        @if($event->user?->role)

                            <span class="inline-flex
                                         mt-3
                                         bg-green-50
                                         border border-green-100
                                         text-green-700
                                         px-3 py-1
                                         rounded-full
                                         text-xs font-semibold">

                                {{ ucfirst($event->user->role) }}

                            </span>

                        @endif

                    </div>

                </section>


                {{-- ACTION --}}
                <section class="bg-white
                                border border-slate-200
                                rounded-2xl
                                shadow-sm
                                p-5">

                    <p class="font-bold text-slate-900">
                        Keputusan Agenda
                    </p>

                    <p class="text-sm
                              text-slate-500
                              mt-1
                              leading-6">

                        Gunakan halaman update untuk menyetujui,
                        menolak, atau memberikan catatan pada agenda.

                    </p>


                    <a href="{{ route('pic.events.edit', $event) }}"
                       class="inline-flex
                              w-full
                              justify-center
                              mt-5
                              bg-green-600
                              hover:bg-green-700
                              text-white
                              px-5 py-2.5
                              rounded-lg
                              text-sm font-semibold
                              transition">

                        Update Status

                    </a>

                </section>

            </div>

        </div>


        {{-- BOTTOM ACTION --}}
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

                <a href="{{ route('pic.events.index') }}"
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


                <a href="{{ route('pic.events.edit', $event) }}"
                   class="inline-flex
                          justify-center
                          bg-green-600
                          hover:bg-green-700
                          text-white
                          px-5 py-2.5
                          rounded-lg
                          text-sm font-semibold
                          transition">

                    Update Status

                </a>

            </div>

        </section>

    </main>

</body>

</html>
@endsection