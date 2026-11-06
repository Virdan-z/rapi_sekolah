@extends('layouts.rapi')

@section('title', 'Kelola Agenda')

@section('page-title', 'Kelola Agenda')

@section('breadcrumb', 'Admin / Kelola Agenda / Tambah')

@section('content')




<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Agenda - RAPI-Sekolah</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 min-h-screen">

    

    {{-- CONTENT --}}
    <main class="max-w-6xl mx-auto px-6 py-8">


       


        {{-- INFORMASI UTAMA --}}
        <section class="grid grid-cols-1
                        sm:grid-cols-2
                        lg:grid-cols-4
                        gap-4
                        mb-6">


            {{-- TANGGAL --}}
            <div class="bg-white
                        border border-slate-200
                        border-l-4 border-l-blue-500
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs font-bold
                          uppercase tracking-wider
                          text-blue-600">

                    Tanggal

                </p>

                <p class="text-lg font-bold text-slate-900 mt-2">

                    {{ \Carbon\Carbon::parse($event->event_date)->format('d-m-Y') }}

                </p>

                <p class="text-sm text-slate-500 mt-1">
                    Tanggal pelaksanaan
                </p>

            </div>


            {{-- WAKTU --}}
            <div class="bg-white
                        border border-slate-200
                        border-l-4 border-l-indigo-500
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs font-bold
                          uppercase tracking-wider
                          text-indigo-600">

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


            {{-- RUANGAN --}}
            <div class="bg-white
                        border border-slate-200
                        border-l-4 border-l-violet-500
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs font-bold
                          uppercase tracking-wider
                          text-violet-600">

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
                        border-l-4 border-l-green-500
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs font-bold
                          uppercase tracking-wider
                          text-green-600">

                    Pengaju

                </p>

                <p class="text-lg font-bold text-slate-900 mt-2">
                    {{ $event->user->name ?? '-' }}
                </p>

                <p class="text-sm text-slate-500 mt-1">
                    {{ $event->user->email ?? '-' }}
                </p>

            </div>

        </section>


        {{-- DETAIL --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


            {{-- KOLOM KIRI --}}
            <div class="lg:col-span-2 space-y-6">


                {{-- DETAIL AGENDA --}}
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
                            Informasi lengkap mengenai agenda dan penggunaan ruangan.
                        </p>

                    </div>


                    <div class="p-6">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                            {{-- NAMA --}}
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


                            {{-- STATUS --}}
                            <div class="border border-slate-200
                                        rounded-xl
                                        p-5">

                                <p class="text-xs font-semibold
                                          uppercase tracking-wider
                                          text-slate-400">

                                    Status

                                </p>

                                <div class="mt-2">

                                    @if ($event->status === 'disetujui')

                                        <span class="inline-flex
                                                     bg-green-50
                                                     border border-green-100
                                                     text-green-700
                                                     px-3 py-1
                                                     rounded-full
                                                     text-xs font-semibold">

                                            Disetujui

                                        </span>

                                    @elseif ($event->status === 'ditolak')

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


                            {{-- RUANGAN --}}
                            <div class="border border-slate-200
                                        rounded-xl
                                        p-5">

                                <p class="text-xs font-semibold
                                          uppercase tracking-wider
                                          text-slate-400">

                                    Ruangan

                                </p>

                                <p class="font-bold text-slate-900 mt-2">
                                    {{ $event->room->name ?? '-' }}
                                </p>

                                <p class="text-sm text-slate-500 mt-1">
                                    {{ $event->room->location ?? '-' }}
                                </p>

                                @if($event->room)

                                    <p class="text-xs text-slate-400 mt-2">
                                        Kapasitas {{ $event->room->capacity }} orang
                                    </p>

                                @endif

                            </div>


                            {{-- PIC --}}
                            <div class="border border-slate-200
                                        rounded-xl
                                        p-5">

                                <p class="text-xs font-semibold
                                          uppercase tracking-wider
                                          text-slate-400">

                                    PIC Ruangan

                                </p>

                                @if ($event->room?->pic)

                                    <p class="font-bold text-slate-900 mt-2">
                                        {{ $event->room->pic->name }}
                                    </p>

                                    <p class="text-sm text-slate-500 mt-1">
                                        {{ $event->room->pic->email }}
                                    </p>

                                    <span class="inline-flex
                                                 mt-3
                                                 bg-green-50
                                                 border border-green-100
                                                 text-green-700
                                                 px-3 py-1
                                                 rounded-full
                                                 text-xs font-semibold">

                                        PIC Aktif

                                    </span>

                                @else

                                    <p class="font-semibold text-orange-600 mt-2">
                                        Belum ditentukan
                                    </p>

                                @endif

                            </div>

                        </div>


                        {{-- DESKRIPSI --}}
                        <div class="mt-6">

                            <p class="text-sm font-semibold text-slate-700 mb-2">
                                Deskripsi Agenda
                            </p>

                            <div class="bg-slate-50
                                        border border-slate-200
                                        rounded-xl
                                        p-5">

                                <p class="text-slate-700
                                          leading-7
                                          whitespace-pre-line">{{ $event->description ?: 'Tidak ada deskripsi untuk agenda ini.' }}</p>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- ALASAN PEMINDAHAN --}}
                @if ($event->move_reason)

                    <section class="bg-white
                                    border border-violet-200
                                    rounded-2xl
                                    shadow-sm
                                    overflow-hidden">

                        <div class="px-6 py-5
                                    bg-violet-50
                                    border-b border-violet-100">

                            <div class="flex flex-col sm:flex-row
                                        sm:items-center
                                        sm:justify-between
                                        gap-3">

                                <div>

                                    <h3 class="text-lg font-bold text-violet-800">
                                        Informasi Pemindahan
                                    </h3>

                                    <p class="text-sm text-violet-600 mt-1">
                                        Agenda ini pernah mengalami perubahan ruangan atau jadwal.
                                    </p>

                                </div>


                                <span class="inline-flex
                                             bg-violet-100
                                             text-violet-700
                                             px-3 py-1
                                             rounded-full
                                             text-xs font-semibold">

                                    Dipindahkan

                                </span>

                            </div>

                        </div>


                        <div class="p-6">

                            <p class="text-sm font-semibold text-slate-700">
                                Alasan Pemindahan Ruangan / Jadwal
                            </p>

                            <div class="mt-3
                                        bg-violet-50
                                        border border-violet-100
                                        rounded-xl
                                        p-5">

                                <p class="text-violet-700
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

                        <div class="flex items-center justify-between gap-4">

                            <div>

                                <h3 class="text-lg font-bold text-slate-900">
                                    Catatan PIC
                                </h3>

                                <p class="text-sm text-slate-500 mt-1">
                                    Catatan atau keterangan dari PIC ruangan.
                                </p>

                            </div>


                            <span class="bg-slate-100
                                         text-slate-500
                                         px-3 py-1
                                         rounded-full
                                         text-xs font-semibold">

                                PIC Ruangan

                            </span>

                        </div>

                    </div>


                    <div class="p-6">

                        @if ($event->pic_note)

                            <div class="bg-blue-50
                                        border border-blue-200
                                        rounded-xl
                                        p-5">

                                <p class="text-sm font-semibold text-blue-800">
                                    Catatan Keputusan PIC
                                </p>

                                <p class="text-blue-700
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
                                    PIC belum memberikan catatan untuk agenda ini.
                                </p>

                            </div>

                        @endif

                    </div>

                </section>

            </div>


            {{-- KOLOM KANAN --}}
            <div class="space-y-6">


                {{-- STATUS KEPUTUSAN --}}
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

                    </div>


                    <div class="p-5">

                        @if ($event->status === 'diajukan')

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

                                <h4 class="font-bold text-yellow-800 mt-4">
                                    Menunggu Keputusan
                                </h4>

                                <p class="text-sm text-yellow-700 mt-2 leading-6">
                                    Agenda masih menunggu persetujuan dari PIC ruangan.
                                </p>

                            </div>


                        @elseif ($event->status === 'disetujui')

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

                                <h4 class="font-bold text-green-800 mt-4">
                                    Agenda Disetujui
                                </h4>

                                <p class="text-sm text-green-700 mt-2 leading-6">
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

                                <h4 class="font-bold text-red-800 mt-4">
                                    Agenda Ditolak
                                </h4>

                                <p class="text-sm text-red-700 mt-2 leading-6">
                                    Pengajuan agenda tidak disetujui.
                                </p>

                            </div>

                        @endif

                    </div>

                </section>


                {{-- PENGAJU --}}
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

                        <p class="text-xs font-semibold
                                  uppercase tracking-wider
                                  text-slate-400">

                            Nama

                        </p>

                        <p class="font-bold text-slate-900 mt-1">
                            {{ $event->user->name ?? '-' }}
                        </p>


                        <div class="border-t border-slate-100 my-4"></div>


                        <p class="text-xs font-semibold
                                  uppercase tracking-wider
                                  text-slate-400">

                            Email

                        </p>

                        <p class="text-sm text-slate-700 mt-1 break-all">
                            {{ $event->user->email ?? '-' }}
                        </p>


                        @if($event->user?->role)

                            <div class="border-t border-slate-100 my-4"></div>

                            <p class="text-xs font-semibold
                                      uppercase tracking-wider
                                      text-slate-400">

                                Role

                            </p>

                            <span class="inline-flex
                                         mt-2
                                         bg-blue-50
                                         border border-blue-100
                                         text-blue-700
                                         px-3 py-1
                                         rounded-full
                                         text-xs font-semibold">

                                {{ ucfirst($event->user->role) }}

                            </span>

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
                        md:flex-row
                        md:items-center
                        md:justify-between
                        gap-4">

                <a href="{{ route('admin.events.index') }}"
                   class="inline-flex justify-center
                          bg-slate-100
                          hover:bg-slate-200
                          text-slate-700
                          px-5 py-2.5
                          rounded-lg
                          text-sm font-semibold
                          transition">

                    Kembali ke Daftar

                </a>


                <div class="flex flex-col sm:flex-row gap-3">

                    <a href="{{ route('admin.events.edit', $event) }}"
                       class="inline-flex justify-center
                              bg-yellow-50
                              hover:bg-yellow-100
                              border border-yellow-200
                              text-yellow-700
                              px-5 py-2.5
                              rounded-lg
                              text-sm font-semibold
                              transition">

                        Edit Agenda

                    </a>


                    <form
                        action="{{ route('admin.events.destroy', $event) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus agenda {{ $event->title }}?')">

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="w-full
                                   bg-red-50
                                   hover:bg-red-100
                                   border border-red-200
                                   text-red-700
                                   px-5 py-2.5
                                   rounded-lg
                                   text-sm font-semibold
                                   transition">

                            Hapus Agenda

                        </button>

                    </form>

                </div>

            </div>

        </section>

    </main>

</body>

</html>
@endsection