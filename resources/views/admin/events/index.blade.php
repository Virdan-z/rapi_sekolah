@extends('layouts.rapi')

@section('title', 'Kelola Agenda')

@section('page-title', 'Kelola Agenda')

@section('breadcrumb', 'Admin / Kelola Agenda / Tambah')

@section('content')



<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Agenda - RAPI-Sekolah</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 min-h-screen">

   


    {{-- CONTENT --}}
    <main class="max-w-7xl mx-auto px-6 py-8">


        

        {{-- SUCCESS --}}
        @if (session('success'))

            <div class="bg-green-50
                        border border-green-200
                        text-green-700
                        px-5 py-4
                        rounded-xl
                        mb-6">

                <p class="font-semibold">
                    Berhasil
                </p>

                <p class="text-sm mt-1">
                    {{ session('success') }}
                </p>

            </div>

        @endif


        {{-- ERROR --}}
        @if ($errors->any())

            <div class="bg-red-50
                        border border-red-200
                        text-red-700
                        px-5 py-4
                        rounded-xl
                        mb-6">

                <p class="font-semibold">
                    Terjadi kesalahan
                </p>

                <ul class="list-disc list-inside text-sm mt-2 space-y-1">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

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
                        border-l-4 border-l-blue-500
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs font-bold
                          uppercase tracking-wider
                          text-blue-600">

                    Total Agenda

                </p>

                <p class="text-3xl font-bold text-slate-900 mt-2">
                    {{ $events->count() }}
                </p>

                <p class="text-sm text-slate-500 mt-1">
                    Semua agenda
                </p>

            </div>


            {{-- DIAJUKAN --}}
            <div class="bg-white
                        border border-slate-200
                        border-l-4 border-l-yellow-500
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs font-bold
                          uppercase tracking-wider
                          text-yellow-600">

                    Diajukan

                </p>

                <p class="text-3xl font-bold text-slate-900 mt-2">
                    {{ $events->where('status', 'diajukan')->count() }}
                </p>

                <p class="text-sm text-slate-500 mt-1">
                    Menunggu persetujuan
                </p>

            </div>


            {{-- DISETUJUI --}}
            <div class="bg-white
                        border border-slate-200
                        border-l-4 border-l-green-500
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs font-bold
                          uppercase tracking-wider
                          text-green-600">

                    Disetujui

                </p>

                <p class="text-3xl font-bold text-slate-900 mt-2">
                    {{ $events->where('status', 'disetujui')->count() }}
                </p>

                <p class="text-sm text-slate-500 mt-1">
                    Agenda disetujui
                </p>

            </div>


            {{-- DITOLAK --}}
            <div class="bg-white
                        border border-slate-200
                        border-l-4 border-l-red-500
                        rounded-xl
                        p-5
                        shadow-sm">

                <p class="text-xs font-bold
                          uppercase tracking-wider
                          text-red-600">

                    Ditolak

                </p>

                <p class="text-3xl font-bold text-slate-900 mt-2">
                    {{ $events->where('status', 'ditolak')->count() }}
                </p>

                <p class="text-sm text-slate-500 mt-1">
                    Agenda tidak disetujui
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
                        flex flex-col sm:flex-row
                        sm:items-center
                        sm:justify-between
                        gap-4">

                <div>

                    <h3 class="text-lg font-bold text-slate-900">
                        Daftar Agenda
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Total {{ $events->count() }} agenda terdaftar dalam sistem.
                    </p>

                </div>


                <a href="{{ route('admin.events.create') }}"
                   class="inline-flex justify-center
                          bg-blue-600
                          hover:bg-blue-700
                          text-white
                          px-4 py-2.5
                          rounded-lg
                          text-sm font-semibold
                          transition">

                    Tambah Agenda

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

                                Agenda

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

                                Tanggal

                            </th>

                            <th class="px-5 py-4
                                       text-left
                                       text-xs font-bold
                                       uppercase tracking-wider
                                       text-slate-500">

                                Waktu

                            </th>

                            <th class="px-5 py-4
                                       text-left
                                       text-xs font-bold
                                       uppercase tracking-wider
                                       text-slate-500">

                                Pengaju

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

                        @forelse ($events as $event)

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


                                {{-- AGENDA --}}
                                <td class="px-5 py-5 min-w-[200px]">

                                    <p class="font-semibold text-slate-900">
                                        {{ $event->title }}
                                    </p>

                                    @if ($event->description)

                                        <p class="text-xs text-slate-500 mt-1">
                                            {{ \Illuminate\Support\Str::limit($event->description, 45) }}
                                        </p>

                                    @endif


                                    {{-- DIPINDAHKAN --}}
                                    @if ($event->move_reason)

                                        <div class="mt-2">

                                            <span class="inline-flex
                                                         bg-violet-50
                                                         border border-violet-100
                                                         text-violet-700
                                                         px-2.5 py-1
                                                         rounded-full
                                                         text-xs font-semibold">

                                                Dipindahkan

                                            </span>

                                            <p class="text-xs text-violet-600 mt-1">
                                                {{ \Illuminate\Support\Str::limit($event->move_reason, 40) }}
                                            </p>

                                        </div>

                                    @endif

                                </td>


                                {{-- RUANGAN --}}
                                <td class="px-5 py-5">

                                    <span class="inline-flex
                                                 bg-blue-50
                                                 border border-blue-100
                                                 text-blue-700
                                                 px-3 py-1
                                                 rounded-full
                                                 text-xs font-semibold">

                                        {{ $event->room->name ?? '-' }}

                                    </span>

                                </td>


                                {{-- TANGGAL --}}
                                <td class="px-5 py-5 text-sm text-slate-600 whitespace-nowrap">

                                    {{ \Carbon\Carbon::parse($event->event_date)->format('d-m-Y') }}

                                </td>


                                {{-- WAKTU --}}
                                <td class="px-5 py-5 whitespace-nowrap">

                                    <p class="text-sm font-semibold text-slate-700">

                                        {{ substr($event->start_time, 0, 5) }}
                                        -
                                        {{ substr($event->end_time, 0, 5) }}

                                    </p>

                                </td>


                                {{-- PENGAJU --}}
                                <td class="px-5 py-5 min-w-[150px]">

                                    <p class="text-sm font-semibold text-slate-700">
                                        {{ $event->user->name ?? '-' }}
                                    </p>

                                    @if($event->user)

                                        <p class="text-xs text-slate-400 mt-1">
                                            {{ ucfirst($event->user->role ?? '') }}
                                        </p>

                                    @endif

                                </td>


                                {{-- STATUS --}}
                                <td class="px-5 py-5">

                                    @if ($event->status === 'disetujui')

                                        <span class="inline-flex
                                                     bg-green-50
                                                     border border-green-100
                                                     text-green-700
                                                     px-3 py-1
                                                     rounded-full
                                                     text-xs font-semibold">

                                            Disetujui

                                        </span>

                                    @elseif ($event->status === 'ditolak')

                                        <span class="inline-flex
                                                     bg-red-50
                                                     border border-red-100
                                                     text-red-700
                                                     px-3 py-1
                                                     rounded-full
                                                     text-xs font-semibold">

                                            Ditolak

                                        </span>

                                    @else

                                        <span class="inline-flex
                                                     bg-yellow-50
                                                     border border-yellow-100
                                                     text-yellow-700
                                                     px-3 py-1
                                                     rounded-full
                                                     text-xs font-semibold">

                                            Diajukan

                                        </span>

                                    @endif

                                </td>


                                {{-- AKSI --}}
                                <td class="px-5 py-5">

                                    <div class="flex
                                                justify-center
                                                flex-wrap
                                                gap-2">

                                        <a href="{{ route('admin.events.show', $event) }}"
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


                                        <a href="{{ route('admin.events.edit', $event) }}"
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
                                            action="{{ route('admin.events.destroy', $event) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus agenda {{ $event->title }}?')">

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

                                <td colspan="8"
                                    class="px-6 py-16 text-center">

                                    <p class="text-lg font-semibold text-slate-700">
                                        Belum ada agenda
                                    </p>

                                    <p class="text-sm text-slate-500 mt-1">
                                        Belum ada agenda atau peminjaman ruangan yang terdaftar.
                                    </p>

                                    <a href="{{ route('admin.events.create') }}"
                                       class="inline-flex
                                              mt-5
                                              bg-blue-600
                                              hover:bg-blue-700
                                              text-white
                                              px-5 py-2.5
                                              rounded-lg
                                              text-sm font-semibold
                                              transition">

                                        Tambah Agenda

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