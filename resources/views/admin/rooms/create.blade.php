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

    <title>Tambah Ruangan - RAPI-Sekolah</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 min-h-screen">

    


    {{-- CONTENT --}}
    <main class="max-w-5xl mx-auto px-6 py-8">


       

        {{-- FORM CARD --}}
        <section class="bg-white
                        border border-slate-200
                        rounded-2xl
                        shadow-sm
                        overflow-hidden">

            {{-- CARD HEADER --}}
            <div class="px-6 py-5
                        border-b border-slate-100">

                <h3 class="text-lg font-bold text-slate-900">
                    Form Data Ruangan
                </h3>

                <p class="text-sm text-slate-500 mt-1">
                    Lengkapi data ruangan dengan benar.
                </p>

            </div>


            {{-- FORM --}}
            <form action="{{ route('admin.rooms.store') }}"
                  method="POST"
                  class="p-6 md:p-8">

                @csrf


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
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Contoh: Laboratorium RPL"
                            required
                            class="w-full
                                   border border-slate-300
                                   bg-white
                                   text-slate-800
                                   placeholder-slate-400
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
                            id="location"
                            type="text"
                            name="location"
                            value="{{ old('location') }}"
                            placeholder="Contoh: Lantai 2"
                            required
                            class="w-full
                                   border border-slate-300
                                   bg-white
                                   text-slate-800
                                   placeholder-slate-400
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
                                id="capacity"
                                type="number"
                                name="capacity"
                                value="{{ old('capacity') }}"
                                placeholder="Contoh: 36"
                                min="1"
                                required
                                class="w-full
                                       border border-slate-300
                                       bg-white
                                       text-slate-800
                                       placeholder-slate-400
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


                    {{-- INFORMASI --}}
                    <div class="bg-blue-50
                                border border-blue-100
                                rounded-xl
                                px-5 py-4">

                        <p class="text-sm font-semibold text-blue-700">
                            Informasi
                        </p>

                        <p class="text-sm text-blue-600 mt-1 leading-6">
                            PIC ruangan dapat ditentukan melalui menu edit
                            setelah data ruangan berhasil ditambahkan.
                        </p>

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
                        placeholder="Contoh: Laboratorium komputer untuk kegiatan pembelajaran RPL..."
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
                               transition">{{ old('description') }}</textarea>

                    <div class="flex justify-between gap-4 mt-2">

                        <p class="text-xs text-slate-400">
                            Deskripsi bersifat opsional.
                        </p>

                    </div>

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
                            sm:justify-end
                            gap-3
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

                        Simpan Ruangan

                    </button>

                </div>

            </form>

        </section>


        {{-- BOTTOM INFO --}}
        <div class="mt-5
                    bg-white
                    border border-slate-200
                    rounded-xl
                    px-5 py-4">

            <p class="text-sm text-slate-500">
                Setelah data disimpan, ruangan akan langsung muncul
                pada daftar ruangan dan dapat digunakan dalam pengelolaan agenda.
            </p>

        </div>

    </main>

</body>

</html>

@endsection