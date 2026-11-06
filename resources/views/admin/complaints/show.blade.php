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

    <title>Detail Pengaduan - RAPI-Sekolah</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 min-h-screen">

    
    {{-- CONTENT --}}
    <main class="max-w-6xl mx-auto px-6 py-8">


        


        {{-- RINGKASAN --}}
        <section class="grid grid-cols-1
                        sm:grid-cols-2
                        lg:grid-cols-4
                        gap-4
                        mb-6">


            {{-- RUANGAN --}}
            <div class="bg-white
                        border border-slate-200
                        border-l-4 border-l-blue-500
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs font-bold
                          uppercase tracking-wider
                          text-blue-600">
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
                        border-l-4 border-l-indigo-500
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs font-bold
                          uppercase tracking-wider
                          text-indigo-600">
                    Pelapor
                </p>

                <p class="text-lg font-bold text-slate-900 mt-2">
                    {{ $complaint->user->name ?? '-' }}
                </p>

                <p class="text-sm text-slate-500 mt-1 truncate">
                    {{ $complaint->user->email ?? '-' }}
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

                    @if ($complaint->status === 'selesai')

                        <span class="inline-flex
                                     bg-green-50
                                     border border-green-100
                                     text-green-700
                                     px-3 py-1
                                     rounded-full
                                     text-xs font-semibold">
                            Selesai
                        </span>

                    @elseif ($complaint->status === 'diproses')

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


            {{-- KIRI --}}
            <div class="lg:col-span-2 space-y-6">


                {{-- DETAIL --}}
                <section class="bg-white
                                border border-slate-200
                                rounded-2xl
                                shadow-sm
                                overflow-hidden">

                    <div class="px-6 py-5 border-b border-slate-100">

                        <h3 class="text-lg font-bold text-slate-900">
                            Informasi Pengaduan
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            Informasi lengkap laporan kerusakan fasilitas.
                        </p>

                    </div>


                    <div class="p-6">


                        {{-- JUDUL --}}
                        <div class="border border-slate-200
                                    rounded-xl
                                    p-5">

                            <p class="text-xs font-semibold
                                      uppercase tracking-wider
                                      text-slate-400">

                                Judul Pengaduan

                            </p>

                            <p class="font-bold text-slate-900 mt-2">
                                {{ $complaint->title }}
                            </p>

                        </div>


                        {{-- DESKRIPSI --}}
                        <div class="mt-5">

                            <p class="text-sm font-semibold text-slate-700 mb-2">
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

                    <div class="px-6 py-5 border-b border-slate-100">

                        <h3 class="text-lg font-bold text-slate-900">
                            Foto Kerusakan
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            Dokumentasi kondisi fasilitas yang dilaporkan.
                        </p>

                    </div>


                    <div class="p-6">

                        @if ($complaint->photo)

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
                                               max-h-[500px]
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
                                    Pengaduan ini tidak memiliki dokumentasi foto.
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

                    <div class="px-6 py-5 border-b border-slate-100">

                        <div class="flex items-center justify-between gap-4">

                            <div>

                                <h3 class="text-lg font-bold text-slate-900">
                                    Catatan Penanganan PIC
                                </h3>

                                <p class="text-sm text-slate-500 mt-1">
                                    Informasi penanganan dari PIC ruangan.
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

                        @if ($complaint->pic_note)

                            <div class="bg-blue-50
                                        border border-blue-200
                                        rounded-xl
                                        p-5">

                                <p class="font-semibold text-blue-800">
                                    Catatan dari PIC
                                </p>

                                <p class="text-blue-700
                                          mt-2
                                          leading-7
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
                                    PIC belum memberikan catatan penanganan untuk pengaduan ini.
                                </p>

                            </div>

                        @endif

                    </div>

                </section>

            </div>


            {{-- KANAN --}}
            <div class="space-y-6">


                {{-- PROSES PENANGANAN --}}
                <section class="bg-white
                                border border-slate-200
                                rounded-2xl
                                shadow-sm
                                overflow-hidden">

                    <div class="px-5 py-4 border-b border-slate-100">

                        <h3 class="font-bold text-slate-900">
                            Proses Penanganan
                        </h3>

                        <p class="text-xs text-slate-500 mt-1">
                            Perkembangan laporan kerusakan.
                        </p>

                    </div>


                    <div class="p-5 space-y-3">


                        {{-- STEP 1 --}}
                        <div class="rounded-xl
                                    border
                                    p-4
                                    {{ in_array($complaint->status, ['dilaporkan', 'diproses', 'selesai'])
                                        ? 'bg-red-50 border-red-200'
                                        : 'bg-slate-50 border-slate-200' }}">

                            <div class="flex items-center gap-3">

                                <span class="flex items-center
                                             justify-center
                                             w-8 h-8
                                             rounded-full
                                             text-xs font-bold
                                             {{ in_array($complaint->status, ['dilaporkan', 'diproses', 'selesai'])
                                                 ? 'bg-red-100 text-red-700'
                                                 : 'bg-slate-200 text-slate-500' }}">

                                    1

                                </span>

                                <div>

                                    <p class="font-semibold
                                              {{ in_array($complaint->status, ['dilaporkan', 'diproses', 'selesai'])
                                                  ? 'text-red-700'
                                                  : 'text-slate-500' }}">

                                        Dilaporkan

                                    </p>

                                    <p class="text-xs text-slate-500 mt-1">
                                        Laporan telah diterima.
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- GARIS --}}
                        <div class="h-5 w-px bg-slate-200 ml-4"></div>


                        {{-- STEP 2 --}}
                        <div class="rounded-xl
                                    border
                                    p-4
                                    {{ in_array($complaint->status, ['diproses', 'selesai'])
                                        ? 'bg-yellow-50 border-yellow-200'
                                        : 'bg-slate-50 border-slate-200' }}">

                            <div class="flex items-center gap-3">

                                <span class="flex items-center
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


                        {{-- GARIS --}}
                        <div class="h-5 w-px bg-slate-200 ml-4"></div>


                        {{-- STEP 3 --}}
                        <div class="rounded-xl
                                    border
                                    p-4
                                    {{ $complaint->status === 'selesai'
                                        ? 'bg-green-50 border-green-200'
                                        : 'bg-slate-50 border-slate-200' }}">

                            <div class="flex items-center gap-3">

                                <span class="flex items-center
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


                {{-- INFORMASI PELAPOR --}}
                <section class="bg-white
                                border border-slate-200
                                rounded-2xl
                                shadow-sm
                                overflow-hidden">

                    <div class="px-5 py-4 border-b border-slate-100">

                        <h3 class="font-bold text-slate-900">
                            Informasi Pelapor
                        </h3>

                    </div>


                    <div class="p-5">

                        <p class="text-xs font-semibold
                                  uppercase tracking-wider
                                  text-slate-400">
                            Nama
                        </p>

                        <p class="font-bold text-slate-900 mt-1">
                            {{ $complaint->user->name ?? '-' }}
                        </p>


                        <div class="border-t border-slate-100 my-4"></div>


                        <p class="text-xs font-semibold
                                  uppercase tracking-wider
                                  text-slate-400">
                            Email
                        </p>

                        <p class="text-sm text-slate-700
                                  mt-1 break-all">
                            {{ $complaint->user->email ?? '-' }}
                        </p>


                        @if($complaint->user?->role)

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

                                {{ ucfirst($complaint->user->role) }}

                            </span>

                        @endif

                    </div>

                </section>


                {{-- RUANGAN --}}
                <section class="bg-white
                                border border-slate-200
                                rounded-2xl
                                shadow-sm
                                overflow-hidden">

                    <div class="px-5 py-4 border-b border-slate-100">

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
                            {{ $complaint->room->name ?? '-' }}
                        </p>


                        <div class="border-t border-slate-100 my-4"></div>


                        <p class="text-xs font-semibold
                                  uppercase tracking-wider
                                  text-slate-400">
                            Lokasi
                        </p>

                        <p class="text-sm text-slate-700 mt-1">
                            {{ $complaint->room->location ?? '-' }}
                        </p>


                        @if($complaint->room?->pic)

                            <div class="border-t border-slate-100 my-4"></div>

                            <p class="text-xs font-semibold
                                      uppercase tracking-wider
                                      text-slate-400">
                                PIC Ruangan
                            </p>

                            <p class="text-sm font-semibold
                                      text-slate-700 mt-1">
                                {{ $complaint->room->pic->name }}
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
                        md:flex-row
                        md:items-center
                        md:justify-between
                        gap-4">

                <a href="{{ route('admin.complaints.index') }}"
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

                    <a href="{{ route('admin.complaints.edit', $complaint) }}"
                       class="inline-flex justify-center
                              bg-yellow-50
                              hover:bg-yellow-100
                              border border-yellow-200
                              text-yellow-700
                              px-5 py-2.5
                              rounded-lg
                              text-sm font-semibold
                              transition">

                        Edit Pengaduan

                    </a>


                    <form
                        action="{{ route('admin.complaints.destroy', $complaint) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus pengaduan {{ $complaint->title }}?')">

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

                            Hapus Pengaduan

                        </button>

                    </form>

                </div>

            </div>

        </section>

    </main>

</body>

</html>
@endsection