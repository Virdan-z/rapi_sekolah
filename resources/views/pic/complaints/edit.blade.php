@extends('layouts.rapi')

@section('title', 'Pengaduan')

@section('page-title', 'Perbarui Penanganan Pengaduan')

@section('breadcrumb', 'PIC / Pengaduan / Perbarui')

@section('content')



<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Pengaduan PIC - RAPI-Sekolah</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 min-h-screen">

    

    {{-- CONTENT --}}
    <main class="max-w-6xl mx-auto px-6 py-8">


      

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

                <ul class="list-disc
                           list-inside
                           text-sm
                           mt-2
                           space-y-1">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif


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
                            Detail laporan kerusakan yang perlu ditangani.
                        </p>

                    </div>


                    <div class="p-6">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                            {{-- RUANGAN --}}
                            <div class="bg-slate-50
                                        border border-slate-200
                                        rounded-xl
                                        p-5">

                                <p class="text-xs font-bold
                                          uppercase tracking-wider
                                          text-green-600">

                                    Ruangan

                                </p>

                                <p class="font-bold text-slate-900 mt-2">
                                    {{ $complaint->room->name ?? '-' }}
                                </p>

                                <p class="text-sm text-slate-500 mt-1">
                                    {{ $complaint->room->location ?? '-' }}
                                </p>

                            </div>


                            {{-- PELAPOR --}}
                            <div class="bg-slate-50
                                        border border-slate-200
                                        rounded-xl
                                        p-5">

                                <p class="text-xs font-bold
                                          uppercase tracking-wider
                                          text-emerald-600">

                                    Pelapor

                                </p>

                                <p class="font-bold text-slate-900 mt-2">
                                    {{ $complaint->user->name ?? '-' }}
                                </p>

                                <p class="text-sm text-slate-500 mt-1">
                                    {{ $complaint->user->email ?? '-' }}
                                </p>

                            </div>

                        </div>


                        {{-- DESKRIPSI --}}
                        <div class="mt-6">

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
                            Dokumentasi kondisi fasilitas yang dilaporkan.
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
                                        p-7
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


                {{-- FORM PENANGANAN --}}
                <section class="bg-white
                                border border-slate-200
                                rounded-2xl
                                shadow-sm
                                overflow-hidden">

                    <div class="px-6 py-5
                                border-b border-slate-100">

                        <h3 class="text-lg font-bold text-slate-900">
                            Form Penanganan
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">
                            Perbarui status dan tuliskan hasil penanganan.
                        </p>

                    </div>


                    <form
                        action="{{ route('pic.complaints.update', $complaint) }}"
                        method="POST"
                        class="p-6">

                        @csrf
                        @method('PUT')


                        {{-- STATUS --}}
                        <div class="mb-6">

                            <label
                                for="status"
                                class="block
                                       text-sm font-semibold
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
                                       focus:ring-green-500
                                       focus:border-green-500
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


                        {{-- STATUS GUIDE --}}
                        <div class="grid grid-cols-1
                                    md:grid-cols-3
                                    gap-3
                                    mb-6">

                            <div class="bg-red-50
                                        border border-red-100
                                        rounded-xl
                                        p-4">

                                <p class="text-sm font-semibold text-red-700">
                                    Dilaporkan
                                </p>

                                <p class="text-xs text-red-600 mt-1 leading-5">
                                    Laporan baru dan belum mulai ditangani.
                                </p>

                            </div>

                            <div class="bg-yellow-50
                                        border border-yellow-100
                                        rounded-xl
                                        p-4">

                                <p class="text-sm font-semibold text-yellow-700">
                                    Diproses
                                </p>

                                <p class="text-xs text-yellow-600 mt-1 leading-5">
                                    Kerusakan sedang dalam proses penanganan.
                                </p>

                            </div>

                            <div class="bg-green-50
                                        border border-green-100
                                        rounded-xl
                                        p-4">

                                <p class="text-sm font-semibold text-green-700">
                                    Selesai
                                </p>

                                <p class="text-xs text-green-600 mt-1 leading-5">
                                    Penanganan kerusakan telah selesai.
                                </p>

                            </div>

                        </div>


                        {{-- CATATAN PIC --}}
                        <div>

                            <label
                                for="pic_note"
                                class="block
                                       text-sm font-semibold
                                       text-slate-700
                                       mb-2">

                                Catatan Penanganan PIC

                            </label>

                            <textarea
                                id="pic_note"
                                name="pic_note"
                                rows="6"
                                maxlength="2000"
                                placeholder="Contoh: Proyektor sudah diperiksa dan kabel HDMI diganti."
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
                                       focus:ring-green-500
                                       focus:border-green-500
                                       transition">{{ old('pic_note', $complaint->pic_note) }}</textarea>

                            <div class="flex flex-col
                                        sm:flex-row
                                        sm:items-center
                                        sm:justify-between
                                        gap-2
                                        mt-2">

                                <p class="text-xs text-slate-400">
                                    Tuliskan tindakan atau hasil penanganan kerusakan.
                                </p>

                                <p class="text-xs text-slate-400">
                                    Maksimal 2000 karakter
                                </p>

                            </div>

                            @error('pic_note')

                                <p class="text-red-600 text-sm mt-2">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- BUTTON --}}
                        <div class="flex flex-col-reverse
                                    sm:flex-row
                                    sm:items-center
                                    sm:justify-end
                                    gap-3
                                    mt-8
                                    pt-6
                                    border-t border-slate-100">

                            <a href="{{ route('pic.complaints.show', $complaint) }}"
                               class="inline-flex
                                      justify-center
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
                                class="inline-flex
                                       justify-center
                                       bg-green-600
                                       hover:bg-green-700
                                       text-white
                                       px-6 py-2.5
                                       rounded-lg
                                       text-sm font-semibold
                                       shadow-sm
                                       transition">

                                Simpan Penanganan

                            </button>

                        </div>

                    </form>

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
                            Proses Pengaduan
                        </h3>

                        <p class="text-xs text-slate-500 mt-1">
                            Tahapan penanganan laporan.
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
                                        Proses penanganan dimulai.
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


                {{-- RUANGAN --}}
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

                            <p class="text-sm font-semibold text-slate-700 mt-1">
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

            </div>

        </div>

    </main>

</body>

</html>
@endsection