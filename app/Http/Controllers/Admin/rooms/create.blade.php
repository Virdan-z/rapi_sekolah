<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Ruangan - RAPI-Sekolah</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-blue-600 text-white px-6 py-4 shadow">
        <div class="max-w-6xl mx-auto flex justify-between items-center">

            <h1 class="text-xl font-bold">
                RAPI-Sekolah
            </h1>

            <a href="{{ route('admin.rooms.index') }}"
                class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-gray-100">
                Kembali
            </a>

        </div>
    </nav>


    {{-- Content --}}
    <main class="max-w-3xl mx-auto p-6">

        <div class="bg-white rounded-xl shadow p-6">

            {{-- Header --}}
            <div class="mb-6">

                <h2 class="text-2xl font-bold text-gray-800">
                    Tambah Ruangan
                </h2>

                <p class="text-gray-500 mt-1">
                    Tambahkan data ruangan baru ke sistem.
                </p>

            </div>


            {{-- Error --}}
            @if ($errors->any())

                <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-6">

                    <p class="font-semibold mb-2">
                        Terjadi kesalahan:
                    </p>

                    <ul class="list-disc list-inside">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- Form --}}
            <form action="{{ route('admin.rooms.store') }}" method="POST">

                @csrf


                {{-- Nama Ruangan --}}
                <div class="mb-5">

                    <label for="name"
                        class="block font-semibold text-gray-700 mb-2">

                        Nama Ruangan

                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Contoh: Laboratorium RPL"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >

                    @error('name')

                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Lokasi --}}
                <div class="mb-5">

                    <label for="location"
                        class="block font-semibold text-gray-700 mb-2">

                        Lokasi

                    </label>

                    <input
                        type="text"
                        id="location"
                        name="location"
                        value="{{ old('location') }}"
                        placeholder="Contoh: Gedung A Lantai 2"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >

                    @error('location')

                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Kapasitas --}}
                <div class="mb-5">

                    <label for="capacity"
                        class="block font-semibold text-gray-700 mb-2">

                        Kapasitas

                    </label>

                    <input
                        type="number"
                        id="capacity"
                        name="capacity"
                        value="{{ old('capacity') }}"
                        placeholder="Contoh: 36"
                        min="1"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >

                    @error('capacity')

                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- PIC --}}
                <div class="mb-5">

                    <label for="pic_id"
                        class="block font-semibold text-gray-700 mb-2">

                        PIC Ruangan

                    </label>

                    <select
                        id="pic_id"
                        name="pic_id"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >

                        <option value="">
                            -- Pilih PIC Ruangan --
                        </option>

                        @foreach ($pics as $pic)

                            <option
                                value="{{ $pic->id }}"
                                {{ old('pic_id') == $pic->id ? 'selected' : '' }}
                            >
                                {{ $pic->name }} - {{ $pic->email }}
                            </option>

                        @endforeach

                    </select>

                    @if ($pics->count() == 0)

                        <p class="text-yellow-600 text-sm mt-2">
                            Belum ada pengguna dengan role PIC.
                        </p>

                    @endif

                    @error('pic_id')

                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Deskripsi --}}
                <div class="mb-6">

                    <label for="description"
                        class="block font-semibold text-gray-700 mb-2">

                        Deskripsi

                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        placeholder="Masukkan deskripsi ruangan..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >{{ old('description') }}</textarea>

                    @error('description')

                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Tombol --}}
                <div class="flex justify-end gap-3">

                    <a
                        href="{{ route('admin.rooms.index') }}"
                        class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                    >
                        Simpan Ruangan
                    </button>

                </div>

            </form>

        </div>

    </main>

</body>

</html>