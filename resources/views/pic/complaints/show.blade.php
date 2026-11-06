@extends('layouts.rapi')

@section('title', 'Pengaduan')

@section('page-title', 'Detail Pengaduan')

@section('breadcrumb', 'PIC / Pengaduan / Detail')

@section('content')



<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Pengaduan PIC - RAPI-Sekolah</title>

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

                <p class="text-xs font-bold
                          uppercase tracking-wider
                          text-green-600">

                    Ruangan

                </p>

                <p class="text-lg font-bold text-slate-900 mt-2">
                    {{ $complaint->room->name ?? '-' }}
                </p>

                <p class="text-sm text-slate-500 mt-1">
                    {{ $complaint->room->location ?? '-' }}
                </p>

            </div>


            {{-- PELAPOR --}}
            <div class="bg-white
                        border border-slate-200
                        border-l-4 border-l-emerald-500
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs font-bold
                          uppercase tracking-wider
                          text-emerald-600">

                    Pelapor

                </p>

                <p class="text-lg font-bold text-slate-900 mt-2">
                    {{ $complaint->user->name ?? '-' }}
                </p>

                <p class="text-sm text-slate-500 mt-1">
                    {{ $complaint->user->email ?? '-' }}
                </p>

            </div>


            {{-- TANGGAL --}}
            <div class="bg-white
                        border border-slate-200
                        border-l-4 border-l-teal-500
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs font-bold
                          uppercase tracking-wider
                          text-teal-600">

                    Tanggal Laporan

                </p>

                <p class="text-lg font-bold text-slate-900 mt-2">
                    {{ $complaint->created_at?->format('d-m-Y') ?? '-' }}
                </p>

                <p class="text-sm text-slate-500 mt-1">
                    {{ $complaint->created_at?->format('H:i') ?? '-' }}
                </p>

            </div>


            {{-- STATUS --}}
            <div class="bg-white
                        border border-slate-200
                        border-l-4
                        {{ $complaint->status === 'selesai'
                            ? 'border-l-green-500'
                            : ($complaint->status === 'diproses'
                                ? 'border-l-yellow-500'
                                : 'border-l-red-500') }}
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs font-bold
                          uppercase tracking-wider
                          text-slate-500">

                    Status

                </p>

                <div class="mt-3">

                    @if($complaint->status === 'selesai')

                        <span class="inline-flex
                                     bg-green-50
                                     border border-green-100
                                     text-green-700
                                     px-3 py-1
                                     rounded-full
                                     text-xs font-semibold">

                            Selesai

                        </span>

                    @elseif($complaint->status === 'diproses')

                        <span class="inline-flex
                                     bg-yellow-50
                                     border border-yellow-100
                                     text-yellow-700
                                     px-3 py-1
                                     rounded-full
                                     text-xs font-semibold">

                            Diproses

                        </span>

                    @else

                        <span class="inline-flex
                                     bg-red-50
                                     border border-red-100
                                     text-red-700
                                     px-3 py-1
                                     rounded-full
                                     text-xs font-semibold">

                            Dilaporkan

                        </span>

                    @endif

                </div>

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
                            Informasi Pengaduan
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            Detail laporan kerusakan pada ruangan.
                        </p>

                    </div>


                    <div class="p-6">

                        <div class="border border-slate-200
                                    rounded-xl
                                    p-5">

                            <p class="text-xs
                                      font-semibold
                                      uppercase tracking-wider
                                      text-slate-400">

                                Judul Pengaduan

                            </p>

                            <p class="font-bold text-slate-900 mt-2">
                                {{ $complaint->title }}
                            </p>

                        </div>


                        <div class="mt-5">

                            <p class="text-sm
                                      font-semibold
                                      text-slate-700
                                      mb-2">

                                Deskripsi Kerusakan

                            </p>

                            <div class="bg-slate-50
                                        border border-slate-200
                                        rounded-xl
                                        p-5">

                                <p class="text-slate-700
                                          leading-7
                                          whitespace-pre-line">{{ $complaint->description }}</p>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- FOTO --}}
                <section class="bg-white
                                border border-slate-200
                                rounded-2xl
                                shadow-sm
                                overflow-hidden">

                    <div class="px-6 py-5
                                border-b border-slate-100">

                        <h3 class="text-lg font-bold text-slate-900">
                            Foto Kerusakan
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            Dokumentasi fasilitas yang dilaporkan.
                        </p>

                    </div>


                    <div class="p-6">

                        @if($complaint->photo)

                            <div class="bg-slate-50
                                        border border-slate-200
                                        rounded-xl
                                        p-4">

                                <a href="{{ asset('storage/' . $complaint->photo) }}"
                                   target="_blank"
                                   class="block">

                                    <img
                                        src="{{ asset('storage/' . $complaint->photo) }}"
                                        alt="Foto kerusakan {{ $complaint->title }}"
                                        class="w-full
                                               max-h-[520px]
                                               object-contain
                                               rounded-xl
                                               border border-slate-200">

                                </a>

                            </div>

                            <p class="text-xs text-slate-400 mt-3">
                                Klik foto untuk membuka ukuran penuh.
                            </p>

                        @else

                            <div class="bg-slate-50
                                        border border-slate-200
                                        rounded-xl
                                        p-8
                                        text-center">

                                <p class="font-semibold text-slate-700">
                                    Tidak Ada Foto
                                </p>

                                <p class="text-sm text-slate-500 mt-1">
                                    Pelapor tidak melampirkan foto kerusakan.
                                </p>

                            </div>

                        @endif

                    </div>

                </section>


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
                                    Catatan Penanganan
                                </h3>

                                <p class="text-sm text-slate-500 mt-1">
                                    Catatan tindakan yang telah dilakukan PIC.
                                </p>

                            </div>


                            @if($complaint->pic_note)

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

                        @if($complaint->pic_note)

                            <div class="bg-green-50
                                        border border-green-200
                                        rounded-xl
                                        p-5">

                                <p class="font-semibold text-green-800">
                                    Catatan PIC
                                </p>

                                <p class="text-green-700
                                          leading-7
                                          mt-2
                                          whitespace-pre-line">{{ $complaint->pic_note }}</p>

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
                                    Belum ada catatan penanganan untuk
                                    pengaduan ini.
                                </p>

                            </div>

                        @endif

                    </div>

                </section>

            </div>


            {{-- RIGHT --}}
            <div class="space-y-6">


                {{-- PROSES --}}
                <section class="bg-white
                                border border-slate-200
                                rounded-2xl
                                shadow-sm
                                overflow-hidden">

                    <div class="px-5 py-4
                                border-b border-slate-100">

                        <h3 class="font-bold text-slate-900">
                            Proses Penanganan
                        </h3>

                        <p class="text-xs text-slate-500 mt-1">
                            Tahapan status pengaduan.
                        </p>

                    </div>


                    <div class="p-5 space-y-3">


                        {{-- STEP 1 --}}
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

                                    1

                                </span>

                                <div>

                                    <p class="font-semibold text-red-700">
                                        Dilaporkan
                                    </p>

                                    <p class="text-xs text-slate-500 mt-1">
                                        Pengaduan masuk ke sistem.
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="h-5 w-px bg-slate-200 ml-4"></div>


                        {{-- STEP 2 --}}
                        <div class="rounded-xl
                                    border
                                    p-4
                                    {{ in_array($complaint->status, ['diproses', 'selesai'])
                                        ? 'bg-yellow-50 border-yellow-200'
                                        : 'bg-slate-50 border-slate-200' }}">

                            <div class="flex items-center gap-3">

                                <span class="flex
                                             items-center
                                             justify-center
                                             w-8 h-8
                                             rounded-full
                                             text-xs font-bold
                                             {{ in_array($complaint->status, ['diproses', 'selesai'])
                                                 ? 'bg-yellow-100 text-yellow-700'
                                                 : 'bg-slate-200 text-slate-500' }}">

                                    2

                                </span>

                                <div>

                                    <p class="font-semibold
                                              {{ in_array($complaint->status, ['diproses', 'selesai'])
                                                  ? 'text-yellow-700'
                                                  : 'text-slate-500' }}">

                                        Diproses

                                    </p>

                                    <p class="text-xs text-slate-500 mt-1">
                                        Kerusakan sedang ditangani.
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="h-5 w-px bg-slate-200 ml-4"></div>


                        {{-- STEP 3 --}}
                        <div class="rounded-xl
                                    border
                                    p-4
                                    {{ $complaint->status === 'selesai'
                                        ? 'bg-green-50 border-green-200'
                                        : 'bg-slate-50 border-slate-200' }}">

                            <div class="flex items-center gap-3">

                                <span class="flex
                                             items-center
                                             justify-center
                                             w-8 h-8
                                             rounded-full
                                             text-xs font-bold
                                             {{ $complaint->status === 'selesai'
                                                 ? 'bg-green-100 text-green-700'
                                                 : 'bg-slate-200 text-slate-500' }}">

                                    3

                                </span>

                                <div>

                                    <p class="font-semibold
                                              {{ $complaint->status === 'selesai'
                                                  ? 'text-green-700'
                                                  : 'text-slate-500' }}">

                                        Selesai

                                    </p>

                                    <p class="text-xs text-slate-500 mt-1">
                                        Penanganan telah selesai.
                                    </p>

                                </div>

                            </div>

                        </div>

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

                        <p class="text-xs
                                  font-semibold
                                  uppercase tracking-wider
                                  text-slate-400">

                            Nama Ruangan

                        </p>

                        <p class="font-bold text-slate-900 mt-1">
                            {{ $complaint->room->name ?? '-' }}
                        </p>


                        <div class="border-t border-slate-100 my-4"></div>


                        <p class="text-xs
                                  font-semibold
                                  uppercase tracking-wider
                                  text-slate-400">

                            Lokasi

                        </p>

                        <p class="text-sm text-slate-700 mt-1">
                            {{ $complaint->room->location ?? '-' }}
                        </p>


                        @if($complaint->room?->capacity)

                            <div class="border-t border-slate-100 my-4"></div>

                            <p class="text-xs
                                      font-semibold
                                      uppercase tracking-wider
                                      text-slate-400">

                                Kapasitas

                            </p>

                            <p class="text-sm font-semibold
                                      text-slate-700 mt-1">

                                {{ $complaint->room->capacity }} orang

                            </p>

                        @endif

                    </div>

                </section>


                {{-- PELAPOR --}}
                <section class="bg-white
                                border border-slate-200
                                rounded-2xl
                                shadow-sm
                                overflow-hidden">

                    <div class="px-5 py-4
                                border-b border-slate-100">

                        <h3 class="font-bold text-slate-900">
                            Informasi Pelapor
                        </h3>

                    </div>


                    <div class="p-5">

                        <p class="font-semibold text-slate-900">
                            {{ $complaint->user->name ?? '-' }}
                        </p>

                        <p class="text-sm text-slate-500 mt-1">
                            {{ $complaint->user->email ?? '-' }}
                        </p>


                        @if($complaint->user?->role)

                            <span class="inline-flex
                                         mt-3
                                         bg-green-50
                                         border border-green-100
                                         text-green-700
                                         px-3 py-1
                                         rounded-full
                                         text-xs font-semibold">

                                {{ ucfirst($complaint->user->role) }}

                            </span>

                        @endif

                    </div>

                </section>


                {{-- AKSI --}}
                <section class="bg-white
                                border border-slate-200
                                rounded-2xl
                                shadow-sm
                                p-5">

                    <p class="font-bold text-slate-900">
                        Penanganan Pengaduan
                    </p>

                    <p class="text-sm text-slate-500 mt-1 leading-6">
                        Perbarui status dan catatan setelah melakukan
                        pemeriksaan atau perbaikan.
                    </p>


                    <a href="{{ route('pic.complaints.edit', $complaint) }}"
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

                        Update Penanganan

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

                <a href="{{ route('pic.complaints.index') }}"
                   class="inline-flex
                          justify-center
                          bg-slate-100
                          hover:bg-slate-200
                          text-slate-700
                          px-5 py-2.5
                          rounded-lg
                          text-sm font-semibold
                          transition">

                    Kembali ke Pengaduan

                </a>


                <a href="{{ route('pic.complaints.edit', $complaint) }}"
                   class="inline-flex
                          justify-center
                          bg-green-600
                          hover:bg-green-700
                          text-white
                          px-5 py-2.5
                          rounded-lg
                          text-sm font-semibold
                          transition">

                    Update Penanganan

                </a>

            </div>

        </section>

    </main>

</body>

</html>
@endsection