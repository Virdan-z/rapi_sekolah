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

    <title>Data Ruangan - RAPI-Sekolah</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <main class="p-6">

        <div class="flex justify-between items-center mb-6">

            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Data Ruangan
                </h2>

                <p class="text-gray-500">
                    Kelola ruangan dan PIC ruangan.
                </p>
            </div>

            <a href="{{ route('admin.rooms.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                + Tambah Ruangan
            </a>

        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-5">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow overflow-hidden">

            <table class="w-full">

                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left">No</th>
                        <th class="px-6 py-3 text-left">Nama Ruangan</th>
                        <th class="px-6 py-3 text-left">Lokasi</th>
                        <th class="px-6 py-3 text-left">Kapasitas</th>
                        <th class="px-6 py-3 text-left">PIC</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($rooms as $room)

                        <tr class="border-t">

                            <td class="px-6 py-4">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-6 py-4 font-semibold">
                                {{ $room->name }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $room->location }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $room->capacity }} orang
                            </td>

                            <td class="px-6 py-4">
                                @if($room->pics->isNotEmpty())
                                    {{ $room->pics->pluck('name')->implode(', ') }}
                                @else
                                    Belum ditentukan
                                @endif
                            </td>

                            <td class="px-6 py-4">

                                <div class="flex gap-2">

                                    <a href="{{ route('admin.rooms.show', $room) }}"
                                        class="bg-gray-500 text-white px-3 py-1 rounded">
                                        Lihat
                                    </a>

                                    <a href="{{ route('admin.rooms.edit', $room) }}"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.rooms.destroy', $room) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus ruangan ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="bg-red-500 text-white px-3 py-1 rounded">
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6"
                                class="px-6 py-8 text-center text-gray-500">
                                Belum ada data ruangan.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </main>

</body>

</html>
@endsection