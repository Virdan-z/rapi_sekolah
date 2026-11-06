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

    <title>Edit Ruangan - RAPI-Sekolah</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen">
    {{-- CONTENT --}}
    <main class="max-w-5xl mx-auto px-6 py-8">


        

        {{-- ERROR GLOBAL --}}
        @if ($errors->any())

            <div class="bg-red-50
                        border border-red-200
                        text-red-700
                        rounded-xl
                        px-5 py-4
                        mb-6">

                <p class="font-semibold">
                    Data belum dapat disimpan
                </p>

                <ul class="list-disc list-inside text-sm mt-2 space-y-1">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif


        {{-- FORM CARD --}}
        <section class="bg-white
                        border border-slate-200
                        rounded-2xl
                        shadow-sm
                        overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-100">

                <h3 class="text-lg font-bold text-slate-900">
                    Form Edit Ruangan
                </h3>

                <p class="text-sm text-slate-500 mt-1">
                    Ubah data yang diperlukan kemudian simpan perubahan.
                </p>

            </div>


            <form
                action="{{ route('admin.rooms.update', $room) }}"
                method="POST"
                class="p-6 md:p-8">

                @csrf
                @method('PUT')


                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- NAMA --}}
                    <div>

                        <label for="name"
                               class="block text-sm
                                      font-semibold
                                      text-slate-700
                                      mb-2">

                            Nama Ruangan

                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $room->name) }}"
                            required
                            class="w-full
                                   border border-slate-300
                                   bg-white
                                   text-slate-800
                                   rounded-xl
                                   px-4 py-3
                                   outline-none
                                   focus:ring-2
                                   focus:ring-blue-500
                                   focus:border-blue-500
                                   transition">

                        @error('name')
                            <p class="text-red-600 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- LOKASI --}}
                    <div>

                        <label for="location"
                               class="block text-sm
                                      font-semibold
                                      text-slate-700
                                      mb-2">

                            Lokasi

                        </label>

                        <input
                            type="text"
                            id="location"
                            name="location"
                            value="{{ old('location', $room->location) }}"
                            required
                            class="w-full
                                   border border-slate-300
                                   bg-white
                                   text-slate-800
                                   rounded-xl
                                   px-4 py-3
                                   outline-none
                                   focus:ring-2
                                   focus:ring-blue-500
                                   focus:border-blue-500
                                   transition">

                        @error('location')
                            <p class="text-red-600 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- KAPASITAS --}}
                    <div>

                        <label for="capacity"
                               class="block text-sm
                                      font-semibold
                                      text-slate-700
                                      mb-2">

                            Kapasitas

                        </label>

                        <div class="relative">

                            <input
                                type="number"
                                id="capacity"
                                name="capacity"
                                value="{{ old('capacity', $room->capacity) }}"
                                min="1"
                                required
                                class="w-full
                                       border border-slate-300
                                       bg-white
                                       text-slate-800
                                       rounded-xl
                                       px-4 py-3
                                       pr-20
                                       outline-none
                                       focus:ring-2
                                       focus:ring-blue-500
                                       focus:border-blue-500
                                       transition">

                            <span class="absolute
                                         right-4 top-1/2
                                         -translate-y-1/2
                                         text-sm
                                         text-slate-400">

                                orang

                            </span>

                        </div>

                        @error('capacity')
                            <p class="text-red-600 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- PIC --}}
                    <div>

                        <label for="pic_id"
                               class="block text-sm
                                      font-semibold
                                      text-slate-700
                                      mb-2">

                            PIC Ruangan

                        </label>

                        <select
                            id="pic_id"
                            name="pic_id"
                            class="w-full
                                   border border-slate-300
                                   bg-white
                                   text-slate-800
                                   rounded-xl
                                   px-4 py-3
                                   outline-none
                                   focus:ring-2
                                   focus:ring-blue-500
                                   focus:border-blue-500
                                   transition">

                            <option value="">
                                -- Belum Ditentukan --
                            </option>

                            @foreach ($pics as $pic)

                                <option
                                    value="{{ $pic->id }}"
                                    {{ old('pic_id', $room->pic_id) == $pic->id ? 'selected' : '' }}>

                                    {{ $pic->name }} - {{ $pic->email }}

                                </option>

                            @endforeach

                        </select>

                        @if ($pics->count() == 0)

                            <p class="text-orange-600 text-sm mt-2">
                                Belum ada pengguna dengan role PIC.
                            </p>

                        @endif

                        @error('pic_id')
                            <p class="text-red-600 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>


                {{-- INFO PIC --}}
                <div class="mt-6
                            bg-blue-50
                            border border-blue-100
                            rounded-xl
                            px-5 py-4">

                    <div class="flex flex-col sm:flex-row
                                sm:items-center
                                sm:justify-between
                                gap-3">

                        <div>

                            <p class="text-sm font-semibold text-blue-700">
                                PIC Saat Ini
                            </p>

                            <p class="text-sm text-blue-600 mt-1">

                                @if($room->pic)

                                    {{ $room->pic->name }}
                                    — {{ $room->pic->email }}

                                @else

                                    Belum ada PIC yang ditentukan.

                                @endif

                            </p>

                        </div>


                        @if($room->pic)

                            <span class="inline-flex
                                         bg-green-100
                                         text-green-700
                                         px-3 py-1
                                         rounded-full
                                         text-xs font-semibold">

                                PIC Aktif

                            </span>

                        @else

                            <span class="inline-flex
                                         bg-orange-100
                                         text-orange-700
                                         px-3 py-1
                                         rounded-full
                                         text-xs font-semibold">

                                Belum Ditentukan

                            </span>

                        @endif

                    </div>

                </div>


                {{-- DESKRIPSI --}}
                <div class="mt-6">

                    <label for="description"
                           class="block text-sm
                                  font-semibold
                                  text-slate-700
                                  mb-2">

                        Deskripsi

                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="5"
                        placeholder="Masukkan deskripsi ruangan..."
                        class="w-full
                               border border-slate-300
                               bg-white
                               text-slate-800
                               placeholder-slate-400
                               rounded-xl
                               px-4 py-3
                               outline-none
                               resize-none
                               focus:ring-2
                               focus:ring-blue-500
                               focus:border-blue-500
                               transition">{{ old('description', $room->description) }}</textarea>

                    <p class="text-xs text-slate-400 mt-2">
                        Deskripsi ruangan bersifat opsional.
                    </p>

                    @error('description')
                        <p class="text-red-600 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- ACTION --}}
                <div class="flex flex-col-reverse
                            sm:flex-row
                            sm:items-center
                            sm:justify-between
                            gap-4
                            mt-8 pt-6
                            border-t border-slate-100">

                    <a href="{{ route('admin.rooms.show', $room) }}"
                       class="text-sm
                              font-semibold
                              text-blue-600
                              hover:text-blue-700">

                        Lihat Detail Ruangan

                    </a>


                    <div class="flex flex-col-reverse
                                sm:flex-row
                                gap-3">

                        <a href="{{ route('admin.rooms.index') }}"
                           class="inline-flex justify-center
                                  bg-slate-100
                                  hover:bg-slate-200
                                  text-slate-700
                                  px-5 py-2.5
                                  rounded-lg
                                  text-sm font-semibold
                                  transition">

                            Batal

                        </a>

                        <button
                            type="submit"
                            class="inline-flex justify-center
                                   bg-blue-600
                                   hover:bg-blue-700
                                   text-white
                                   px-6 py-2.5
                                   rounded-lg
                                   text-sm font-semibold
                                   shadow-sm
                                   transition">

                            Simpan Perubahan

                        </button>

                    </div>

                </div>

            </form>

        </section>

    </main>

</body>

</html>
@endsection