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

    <title>Edit Pengaduan - RAPI-Sekolah</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 min-h-screen">

    


    {{-- CONTENT --}}
    <main class="max-w-5xl mx-auto px-6 py-8">


       


        {{-- ERROR --}}
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

            <div class="px-6 py-5
                        border-b border-slate-100">

                <h3 class="text-lg font-bold text-slate-900">
                    Form Edit Pengaduan
                </h3>

                <p class="text-sm text-slate-500 mt-1">
                    Ubah data pengaduan kemudian simpan perubahan.
                </p>

            </div>


            <form
                action="{{ route('admin.complaints.update', $complaint) }}"
                method="POST"
                enctype="multipart/form-data"
                class="p-6 md:p-8">

                @csrf
                @method('PUT')


                {{-- JUDUL --}}
                <div class="mb-6">

                    <label for="title"
                           class="block text-sm
                                  font-semibold
                                  text-slate-700
                                  mb-2">

                        Judul Pengaduan

                    </label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title', $complaint->title) }}"
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

                    @error('title')
                        <p class="text-red-600 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- RUANGAN --}}
                <div class="mb-6">

                    <label for="room_id"
                           class="block text-sm
                                  font-semibold
                                  text-slate-700
                                  mb-2">

                        Ruangan

                    </label>

                    <select
                        id="room_id"
                        name="room_id"
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

                        @foreach ($rooms as $room)

                            <option
                                value="{{ $room->id }}"
                                {{ old('room_id', $complaint->room_id) == $room->id ? 'selected' : '' }}>

                                {{ $room->name }} - {{ $room->location }}

                            </option>

                        @endforeach

                    </select>

                    @error('room_id')
                        <p class="text-red-600 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- DESKRIPSI --}}
                <div class="mb-6">

                    <label for="description"
                           class="block text-sm
                                  font-semibold
                                  text-slate-700
                                  mb-2">

                        Deskripsi Kerusakan

                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="6"
                        required
                        class="w-full
                               border border-slate-300
                               bg-white
                               text-slate-800
                               rounded-xl
                               px-4 py-3
                               outline-none
                               resize-none
                               focus:ring-2
                               focus:ring-blue-500
                               focus:border-blue-500
                               transition">{{ old('description', $complaint->description) }}</textarea>

                    @error('description')
                        <p class="text-red-600 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- STATUS --}}
                <div class="mb-6">

                    <label for="status"
                           class="block text-sm
                                  font-semibold
                                  text-slate-700
                                  mb-2">

                        Status Pengaduan

                    </label>

                    <select
                        id="status"
                        name="status"
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

                        <option
                            value="dilaporkan"
                            {{ old('status', $complaint->status) === 'dilaporkan' ? 'selected' : '' }}>

                            Dilaporkan

                        </option>

                        <option
                            value="diproses"
                            {{ old('status', $complaint->status) === 'diproses' ? 'selected' : '' }}>

                            Diproses

                        </option>

                        <option
                            value="selesai"
                            {{ old('status', $complaint->status) === 'selesai' ? 'selected' : '' }}>

                            Selesai

                        </option>

                    </select>

                    @error('status')
                        <p class="text-red-600 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- INFO STATUS --}}
                <div class="grid grid-cols-1
                            sm:grid-cols-3
                            gap-3
                            mb-6">

                    <div class="bg-yellow-50
                                border border-yellow-100
                                rounded-xl
                                p-4">

                        <p class="text-xs font-bold
                                  uppercase tracking-wider
                                  text-yellow-700">

                            Dilaporkan

                        </p>

                        <p class="text-xs text-yellow-600 mt-2 leading-5">
                            Laporan baru diterima dan belum mulai ditangani.
                        </p>

                    </div>


                    <div class="bg-blue-50
                                border border-blue-100
                                rounded-xl
                                p-4">

                        <p class="text-xs font-bold
                                  uppercase tracking-wider
                                  text-blue-700">

                            Diproses

                        </p>

                        <p class="text-xs text-blue-600 mt-2 leading-5">
                            Kerusakan sedang dalam proses penanganan.
                        </p>

                    </div>


                    <div class="bg-green-50
                                border border-green-100
                                rounded-xl
                                p-4">

                        <p class="text-xs font-bold
                                  uppercase tracking-wider
                                  text-green-700">

                            Selesai

                        </p>

                        <p class="text-xs text-green-600 mt-2 leading-5">
                            Kerusakan telah selesai ditangani.
                        </p>

                    </div>

                </div>


                {{-- FOTO --}}
                <div class="mb-6">

                    <label for="photo"
                           class="block text-sm
                                  font-semibold
                                  text-slate-700
                                  mb-2">

                        Foto Kerusakan

                    </label>


                    @if ($complaint->photo)

                        <div class="bg-slate-50
                                    border border-slate-200
                                    rounded-xl
                                    p-5
                                    mb-4">

                            <p class="text-xs font-semibold
                                      uppercase tracking-wider
                                      text-slate-400
                                      mb-3">

                                Foto Saat Ini

                            </p>

                            <img
                                src="{{ asset('storage/' . $complaint->photo) }}"
                                alt="Foto kerusakan {{ $complaint->title }}"
                                class="w-full
                                       max-w-md
                                       h-56
                                       object-cover
                                       rounded-xl
                                       border border-slate-200">

                        </div>

                    @else

                        <div class="bg-slate-50
                                    border border-slate-200
                                    rounded-xl
                                    p-5
                                    mb-4">

                            <p class="text-sm text-slate-500">
                                Belum ada foto untuk pengaduan ini.
                            </p>

                        </div>

                    @endif


                    <div class="border
                                border-dashed
                                border-slate-300
                                bg-slate-50
                                rounded-xl
                                p-5">

                        <input
                            type="file"
                            id="photo"
                            name="photo"
                            accept="image/*"
                            class="block
                                   w-full
                                   text-sm
                                   text-slate-600
                                   file:mr-4
                                   file:py-2.5
                                   file:px-4
                                   file:rounded-lg
                                   file:border-0
                                   file:text-sm
                                   file:font-semibold
                                   file:bg-blue-600
                                   file:text-white
                                   hover:file:bg-blue-700
                                   file:cursor-pointer">

                        <p class="text-xs text-slate-500 mt-3">
                            Kosongkan jika tidak ingin mengganti foto.
                            Jika diganti, gunakan JPG, JPEG, PNG, atau WEBP dengan ukuran maksimal 2 MB.
                        </p>

                    </div>

                    @error('photo')
                        <p class="text-red-600 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- INFO --}}
                <div class="bg-blue-50
                            border border-blue-100
                            rounded-xl
                            px-5 py-4">

                    <p class="text-sm font-semibold text-blue-700">
                        Informasi Perubahan
                    </p>

                    <p class="text-sm text-blue-600 mt-1 leading-6">
                        Perubahan status akan menunjukkan perkembangan penanganan
                        pengaduan kepada pengguna yang berkaitan dengan laporan ini.
                    </p>

                </div>


                {{-- ACTION --}}
                <div class="flex flex-col
                            lg:flex-row
                            lg:items-center
                            lg:justify-between
                            gap-4
                            mt-8 pt-6
                            border-t border-slate-100">

                    <a href="{{ route('admin.complaints.show', $complaint) }}"
                       class="text-sm
                              font-semibold
                              text-blue-600
                              hover:text-blue-700">

                        Lihat Detail Pengaduan

                    </a>


                    <div class="flex flex-col-reverse sm:flex-row gap-3">

                        <a href="{{ route('admin.complaints.index') }}"
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


        {{-- BOTTOM INFO --}}
        <div class="mt-5
                    bg-white
                    border border-slate-200
                    rounded-xl
                    px-5 py-4">

            <p class="text-sm text-slate-500">
                Pastikan status pengaduan sesuai dengan kondisi penanganan kerusakan saat ini.
            </p>

        </div>

    </main>

</body>

</html>
@endsection