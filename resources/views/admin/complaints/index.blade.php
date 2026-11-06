@extends('layouts.rapi')

@section('title', 'Pengaduan')

@section('page-title', 'Pengaduan')

@section('breadcrumb', 'Admin / Pengaduan / Tambah')

@section('content')



<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Pengaduan - RAPI-Sekolah</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 min-h-screen">

  
    

        {{-- SUCCESS --}}
        @if (session('success'))

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
                        Total {{ $complaints->count() }} laporan kerusakan terdaftar.
                    </p>

                </div>


                <a href="{{ route('admin.complaints.create') }}"
                   class="inline-flex justify-center
                          bg-blue-600
                          hover:bg-blue-700
                          text-white
                          px-4 py-2.5
                          rounded-lg
                          text-sm font-semibold
                          transition">

                    Tambah Pengaduan

                </a>

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
                                       text-left
                                       text-xs font-bold
                                       uppercase tracking-wider
                                       text-slate-500">
                                Foto
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

                        @forelse ($complaints as $complaint)

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
                                <td class="px-5 py-5 min-w-[220px]">

                                    <p class="font-semibold text-slate-900">
                                        {{ $complaint->title }}
                                    </p>

                                    <p class="text-xs text-slate-500 mt-1 leading-5">
                                        {{ \Illuminate\Support\Str::limit($complaint->description, 50) }}
                                    </p>

                                </td>


                                {{-- RUANGAN --}}
                                <td class="px-5 py-5 min-w-[140px]">

                                    <span class="inline-flex
                                                 bg-blue-50
                                                 border border-blue-100
                                                 text-blue-700
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

                                    <p class="text-sm font-semibold text-slate-700">
                                        {{ $complaint->user->name ?? '-' }}
                                    </p>

                                    @if($complaint->user?->role)

                                        <p class="text-xs text-slate-400 mt-1">
                                            {{ ucfirst($complaint->user->role) }}
                                        </p>

                                    @endif

                                </td>


                                {{-- STATUS --}}
                                <td class="px-5 py-5">

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

                                </td>


                                {{-- FOTO --}}
                                <td class="px-5 py-5">

                                    @if ($complaint->photo)

                                        <a href="{{ asset('storage/' . $complaint->photo) }}"
                                           target="_blank"
                                           class="block w-fit">

                                            <img
                                                src="{{ asset('storage/' . $complaint->photo) }}"
                                                alt="Foto kerusakan {{ $complaint->title }}"
                                                class="w-20 h-16
                                                       object-cover
                                                       rounded-lg
                                                       border border-slate-200
                                                       hover:opacity-80
                                                       transition">

                                        </a>

                                    @else

                                        <span class="inline-flex
                                                     bg-slate-100
                                                     text-slate-500
                                                     px-3 py-1
                                                     rounded-full
                                                     text-xs font-semibold">

                                            Tidak ada foto

                                        </span>

                                    @endif

                                </td>


                                {{-- AKSI --}}
                                <td class="px-5 py-5">

                                    <div class="flex
                                                justify-center
                                                flex-wrap
                                                gap-2">

                                        <a href="{{ route('admin.complaints.show', $complaint) }}"
                                           class="bg-blue-50
                                                  hover:bg-blue-100
                                                  border border-blue-100
                                                  text-blue-700
                                                  px-3 py-2
                                                  rounded-lg
                                                  text-xs font-semibold
                                                  transition">

                                            Lihat

                                        </a>


                                        <a href="{{ route('admin.complaints.edit', $complaint) }}"
                                           class="bg-yellow-50
                                                  hover:bg-yellow-100
                                                  border border-yellow-200
                                                  text-yellow-700
                                                  px-3 py-2
                                                  rounded-lg
                                                  text-xs font-semibold
                                                  transition">

                                            Edit

                                        </a>


                                        <form
                                            action="{{ route('admin.complaints.destroy', $complaint) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus pengaduan {{ $complaint->title }}?')">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="bg-red-50
                                                       hover:bg-red-100
                                                       border border-red-200
                                                       text-red-700
                                                       px-3 py-2
                                                       rounded-lg
                                                       text-xs font-semibold
                                                       transition">

                                                Hapus

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td colspan="7"
                                    class="px-6 py-16 text-center">

                                    <p class="text-lg font-semibold text-slate-700">
                                        Belum ada pengaduan
                                    </p>

                                    <p class="text-sm text-slate-500 mt-1">
                                        Belum ada laporan kerusakan fasilitas yang terdaftar.
                                    </p>

                                    <a href="{{ route('admin.complaints.create') }}"
                                       class="inline-flex
                                              mt-5
                                              bg-blue-600
                                              hover:bg-blue-700
                                              text-white
                                              px-5 py-2.5
                                              rounded-lg
                                              text-sm font-semibold
                                              transition">

                                        Tambah Pengaduan

                                    </a>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </section>

    </main>

</body>

</html>
@endsection