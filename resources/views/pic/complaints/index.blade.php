@extends('layouts.rapi')

@section('title', 'Pengaduan')

@section('page-title', 'Daftar Pengaduan')

@section('breadcrumb', 'PIC / Pengaduan / Daftar')

@section('content')



<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pengaduan PIC - RAPI-Sekolah</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 min-h-screen">

    
    {{-- CONTENT --}}
    <main class="max-w-7xl mx-auto px-6 py-8">


        
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


        {{-- STATISTIK --}}
        <section class="grid grid-cols-1
                        sm:grid-cols-2
                        lg:grid-cols-4
                        gap-4
                        mb-6">


            {{-- TOTAL --}}
            <div class="bg-white
                        border border-slate-200
                        border-l-4 border-l-green-500
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs
                          font-bold
                          uppercase
                          tracking-wider
                          text-green-600">

                    Total Pengaduan

                </p>

                <p class="text-3xl font-bold text-slate-900 mt-2">
                    {{ $complaints->count() }}
                </p>

                <p class="text-sm text-slate-500 mt-1">
                    Semua laporan ruangan
                </p>

            </div>


            {{-- DILAPORKAN --}}
            <div class="bg-white
                        border border-slate-200
                        border-l-4 border-l-red-500
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs
                          font-bold
                          uppercase
                          tracking-wider
                          text-red-600">

                    Dilaporkan

                </p>

                <p class="text-3xl font-bold text-slate-900 mt-2">
                    {{ $complaints->where('status', 'dilaporkan')->count() }}
                </p>

                <p class="text-sm text-slate-500 mt-1">
                    Belum mulai ditangani
                </p>

            </div>


            {{-- DIPROSES --}}
            <div class="bg-white
                        border border-slate-200
                        border-l-4 border-l-yellow-500
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs
                          font-bold
                          uppercase
                          tracking-wider
                          text-yellow-600">

                    Diproses

                </p>

                <p class="text-3xl font-bold text-slate-900 mt-2">
                    {{ $complaints->where('status', 'diproses')->count() }}
                </p>

                <p class="text-sm text-slate-500 mt-1">
                    Sedang dalam penanganan
                </p>

            </div>


            {{-- SELESAI --}}
            <div class="bg-white
                        border border-slate-200
                        border-l-4 border-l-emerald-500
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs
                          font-bold
                          uppercase
                          tracking-wider
                          text-emerald-600">

                    Selesai

                </p>

                <p class="text-3xl font-bold text-slate-900 mt-2">
                    {{ $complaints->where('status', 'selesai')->count() }}
                </p>

                <p class="text-sm text-slate-500 mt-1">
                    Penanganan telah selesai
                </p>

            </div>

        </section>


        {{-- TABLE CARD --}}
        <section class="bg-white
                        border border-slate-200
                        rounded-2xl
                        shadow-sm
                        overflow-hidden">


            {{-- TABLE HEADER --}}
            <div class="px-6 py-5
                        border-b border-slate-100
                        flex flex-col
                        sm:flex-row
                        sm:items-center
                        sm:justify-between
                        gap-4">

                <div>

                    <h3 class="text-lg font-bold text-slate-900">
                        Daftar Pengaduan
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Total {{ $complaints->count() }} laporan
                        pada ruangan yang Anda kelola.
                    </p>

                </div>


                <div class="inline-flex
                            self-start
                            sm:self-auto
                            bg-green-50
                            border border-green-100
                            text-green-700
                            px-4 py-2
                            rounded-lg
                            text-sm font-semibold">

                    {{ $complaints->where('status', 'dilaporkan')->count() }}
                    Perlu Ditangani

                </div>

            </div>


            {{-- TABLE --}}
            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-slate-50
                                  border-b border-slate-200">

                        <tr>

                            <th class="px-5 py-4
                                       text-left
                                       text-xs font-bold
                                       uppercase tracking-wider
                                       text-slate-500">
                                No
                            </th>

                            <th class="px-5 py-4
                                       text-left
                                       text-xs font-bold
                                       uppercase tracking-wider
                                       text-slate-500">
                                Pengaduan
                            </th>

                            <th class="px-5 py-4
                                       text-left
                                       text-xs font-bold
                                       uppercase tracking-wider
                                       text-slate-500">
                                Ruangan
                            </th>

                            <th class="px-5 py-4
                                       text-left
                                       text-xs font-bold
                                       uppercase tracking-wider
                                       text-slate-500">
                                Pelapor
                            </th>

                            <th class="px-5 py-4
                                       text-left
                                       text-xs font-bold
                                       uppercase tracking-wider
                                       text-slate-500">
                                Status
                            </th>

                            <th class="px-5 py-4
                                       text-center
                                       text-xs font-bold
                                       uppercase tracking-wider
                                       text-slate-500">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse($complaints as $complaint)

                            <tr class="hover:bg-slate-50 transition">


                                {{-- NO --}}
                                <td class="px-5 py-5">

                                    <span class="inline-flex
                                                 items-center
                                                 justify-center
                                                 w-8 h-8
                                                 bg-slate-100
                                                 text-slate-600
                                                 rounded-lg
                                                 text-sm font-semibold">

                                        {{ $loop->iteration }}

                                    </span>

                                </td>


                                {{-- PENGADUAN --}}
                                <td class="px-5 py-5 min-w-[260px]">

                                    <p class="font-semibold text-slate-900">
                                        {{ $complaint->title }}
                                    </p>

                                    <p class="text-xs
                                              text-slate-500
                                              mt-1
                                              leading-5
                                              max-w-xs">

                                        {{ \Illuminate\Support\Str::limit(
                                            $complaint->description,
                                            55
                                        ) }}

                                    </p>


                                    @if($complaint->photo)

                                        <span class="inline-flex
                                                     mt-2
                                                     bg-slate-100
                                                     text-slate-600
                                                     px-2.5 py-1
                                                     rounded-md
                                                     text-xs font-medium">

                                            Foto tersedia

                                        </span>

                                    @endif

                                </td>


                                {{-- RUANGAN --}}
                                <td class="px-5 py-5 min-w-[160px]">

                                    <span class="inline-flex
                                                 bg-green-50
                                                 border border-green-100
                                                 text-green-700
                                                 px-3 py-1
                                                 rounded-full
                                                 text-xs font-semibold">

                                        {{ $complaint->room->name ?? '-' }}

                                    </span>


                                    @if($complaint->room?->location)

                                        <p class="text-xs text-slate-400 mt-2">
                                            {{ $complaint->room->location }}
                                        </p>

                                    @endif

                                </td>


                                {{-- PELAPOR --}}
                                <td class="px-5 py-5 min-w-[150px]">

                                    <p class="text-sm
                                              font-semibold
                                              text-slate-700">

                                        {{ $complaint->user->name ?? '-' }}

                                    </p>


                                    @if($complaint->user?->role)

                                        <p class="text-xs
                                                  text-slate-400
                                                  mt-1">

                                            {{ ucfirst($complaint->user->role) }}

                                        </p>

                                    @endif

                                </td>


                                {{-- STATUS --}}
                                <td class="px-5 py-5">

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

                                </td>


                                {{-- AKSI --}}
                                <td class="px-5 py-5">

                                    <div class="flex
                                                flex-col
                                                sm:flex-row
                                                justify-center
                                                gap-2">

                                        <a href="{{ route('pic.complaints.show', $complaint) }}"
                                           class="inline-flex
                                                  justify-center
                                                  bg-slate-100
                                                  hover:bg-slate-200
                                                  text-slate-700
                                                  px-3 py-2
                                                  rounded-lg
                                                  text-xs font-semibold
                                                  transition">

                                            Lihat Detail

                                        </a>


                                        <a href="{{ route('pic.complaints.edit', $complaint) }}"
                                           class="inline-flex
                                                  justify-center
                                                  bg-green-600
                                                  hover:bg-green-700
                                                  text-white
                                                  px-3 py-2
                                                  rounded-lg
                                                  text-xs font-semibold
                                                  transition">

                                            Update Status

                                        </a>

                                    </div>

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td colspan="6"
                                    class="px-6 py-16 text-center">

                                    <p class="text-lg
                                              font-semibold
                                              text-slate-700">

                                        Belum Ada Pengaduan

                                    </p>

                                    <p class="text-sm
                                              text-slate-500
                                              mt-1">

                                        Belum ada pengaduan untuk
                                        ruangan yang menjadi tanggung
                                        jawab Anda.

                                    </p>

                                    <a href="{{ route('pic.dashboard') }}"
                                       class="inline-flex
                                              mt-5
                                              bg-green-600
                                              hover:bg-green-700
                                              text-white
                                              px-5 py-2.5
                                              rounded-lg
                                              text-sm font-semibold
                                              transition">

                                        Kembali ke Dashboard

                                    </a>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </section>


        {{-- INFO --}}
        <section class="mt-5
                        bg-white
                        border border-slate-200
                        rounded-xl
                        px-5 py-4">

            <p class="text-sm text-slate-500 leading-6">
                Pengaduan yang ditampilkan hanya berasal dari ruangan
                yang menjadi tanggung jawab Anda. Gunakan
                <span class="font-semibold text-slate-700">
                    Update Status
                </span>
                untuk memperbarui proses penanganan dan memberikan
                catatan kepada pelapor.
            </p>

        </section>

    </main>

</body>

</html>
@endsection