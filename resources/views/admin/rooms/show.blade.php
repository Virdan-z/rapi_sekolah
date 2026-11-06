@extends('layouts.rapi')

@section('title', 'Kelola Ruangan')

@section('page-title', 'Kelola Ruangan')

@section('breadcrumb', 'Admin / Kelola Ruangan / Tambah')

@section('content')



<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Ruangan - RAPI-Sekolah</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 min-h-screen">

    {{-- CONTENT --}}
    <main class="max-w-5xl mx-auto px-6 py-8">


        


        {{-- SUMMARY --}}
        <section class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

            <div class="bg-white
                        border border-slate-200
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs font-bold
                          uppercase tracking-wider
                          text-blue-600">

                    Lokasi

                </p>

                <p class="text-lg font-bold text-slate-900 mt-2">
                    {{ $room->location }}
                </p>

                <p class="text-sm text-slate-500 mt-1">
                    Lokasi ruangan
                </p>

            </div>


            <div class="bg-white
                        border border-slate-200
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs font-bold
                          uppercase tracking-wider
                          text-green-600">

                    Kapasitas

                </p>

                <p class="text-lg font-bold text-slate-900 mt-2">
                    {{ $room->capacity }} orang
                </p>

                <p class="text-sm text-slate-500 mt-1">
                    Kapasitas maksimal
                </p>

            </div>


            <div class="bg-white
                        border border-slate-200
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs font-bold
                          uppercase tracking-wider
                          text-violet-600">

                    PIC

                </p>

                @if($room->pic)

                    <p class="text-lg font-bold text-slate-900 mt-2">
                        {{ $room->pic->name }}
                    </p>

                    <p class="text-sm text-slate-500 mt-1">
                        Penanggung jawab aktif
                    </p>

                @else

                    <p class="text-lg font-bold text-orange-600 mt-2">
                        Belum ditentukan
                    </p>

                    <p class="text-sm text-slate-500 mt-1">
                        Belum memiliki PIC
                    </p>

                @endif

            </div>

        </section>


        {{-- DETAIL CARD --}}
        <section class="bg-white
                        border border-slate-200
                        rounded-2xl
                        shadow-sm
                        overflow-hidden">

            <div class="px-6 py-5
                        border-b border-slate-100">

                <h3 class="text-lg font-bold text-slate-900">
                    Informasi Ruangan
                </h3>

                <p class="text-sm text-slate-500 mt-1">
                    Detail data ruangan dan PIC yang bertanggung jawab.
                </p>

            </div>


            <div class="p-6 md:p-8">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                    {{-- NAMA --}}
                    <div class="border border-slate-200
                                rounded-xl
                                p-5">

                        <p class="text-xs font-semibold
                                  uppercase tracking-wider
                                  text-slate-400">

                            Nama Ruangan

                        </p>

                        <p class="text-lg font-bold
                                  text-slate-900 mt-2">

                            {{ $room->name }}

                        </p>

                    </div>


                    {{-- LOKASI --}}
                    <div class="border border-slate-200
                                rounded-xl
                                p-5">

                        <p class="text-xs font-semibold
                                  uppercase tracking-wider
                                  text-slate-400">

                            Lokasi

                        </p>

                        <p class="text-lg font-bold
                                  text-slate-900 mt-2">

                            {{ $room->location }}

                        </p>

                    </div>


                    {{-- KAPASITAS --}}
                    <div class="border border-slate-200
                                rounded-xl
                                p-5">

                        <p class="text-xs font-semibold
                                  uppercase tracking-wider
                                  text-slate-400">

                            Kapasitas

                        </p>

                        <div class="mt-2">

                            <span class="inline-flex
                                         bg-blue-50
                                         border border-blue-100
                                         text-blue-700
                                         px-3 py-1.5
                                         rounded-full
                                         text-sm font-semibold">

                                {{ $room->capacity }} orang

                            </span>

                        </div>

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

                        @if ($room->pic)

                            <p class="text-lg font-bold
                                      text-slate-900 mt-2">

                                {{ $room->pic->name }}

                            </p>

                            <p class="text-sm text-slate-500 mt-1">
                                {{ $room->pic->email }}
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

                            <p class="text-orange-600
                                      font-semibold mt-2">

                                Belum ditentukan

                            </p>

                            <p class="text-sm text-slate-500 mt-1">
                                Edit ruangan untuk menentukan PIC.
                            </p>

                        @endif

                    </div>

                </div>


                {{-- DESKRIPSI --}}
                <div class="mt-6">

                    <p class="text-sm font-semibold text-slate-700 mb-2">
                        Deskripsi Ruangan
                    </p>

                    <div class="bg-slate-50
                                border border-slate-200
                                rounded-xl
                                p-5">

                        <p class="text-slate-700 leading-7 whitespace-pre-line">
                            {{ $room->description ?: 'Tidak ada deskripsi untuk ruangan ini.' }}
                        </p>

                    </div>

                </div>


                {{-- ACTIONS --}}
                <div class="flex flex-col
                            md:flex-row
                            md:items-center
                            md:justify-between
                            gap-4
                            mt-8 pt-6
                            border-t border-slate-100">

                    <a href="{{ route('admin.rooms.index') }}"
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

                        <a href="{{ route('admin.rooms.edit', $room) }}"
                           class="inline-flex justify-center
                                  bg-yellow-50
                                  hover:bg-yellow-100
                                  border border-yellow-200
                                  text-yellow-700
                                  px-5 py-2.5
                                  rounded-lg
                                  text-sm font-semibold
                                  transition">

                            Edit Ruangan

                        </a>


                        <form
                            action="{{ route('admin.rooms.destroy', $room) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus ruangan {{ $room->name }}?')">

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

                                Hapus Ruangan

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </section>

    </main>

</body>

</html>
@endsection