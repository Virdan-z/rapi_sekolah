@extends('layouts.rapi')

@section('title', 'Kelola Agenda')

@section('page-title', 'Kelola Agenda')

@section('breadcrumb', 'Admin / Kelola Agenda / Edit')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | MENENTUKAN SESI DARI DATA AGENDA LAMA
    |--------------------------------------------------------------------------
    */

    $eventStartTime = substr((string) $event->start_time, 0, 5);
    $eventEndTime = substr((string) $event->end_time, 0, 5);

    $currentSession = '';

    if ($eventStartTime === '08:00' && $eventEndTime === '10:00') {
        $currentSession = '1';
    } elseif ($eventStartTime === '10:00' && $eventEndTime === '12:00') {
        $currentSession = '2';
    } elseif ($eventStartTime === '13:00' && $eventEndTime === '15:00') {
        $currentSession = '3';
    }

    $selectedSession = old('session', $currentSession);

    $sessionTimes = [
        '1' => [
            'start' => '08:00',
            'end' => '10:00',
        ],
        '2' => [
            'start' => '10:00',
            'end' => '12:00',
        ],
        '3' => [
            'start' => '13:00',
            'end' => '15:00',
        ],
    ];

    $selectedStartTime = $sessionTimes[$selectedSession]['start'] ?? '';
    $selectedEndTime = $sessionTimes[$selectedSession]['end'] ?? '';

    $eventDateValue = old(
        'event_date',
        substr((string) $event->event_date, 0, 10)
    );
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Agenda - RAPI-Sekolah</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 min-h-screen">

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

            {{-- HEADER CARD --}}
            <div class="px-6 py-5 border-b border-slate-100">

                <h3 class="text-lg font-bold text-slate-900">
                    Form Edit Agenda
                </h3>

                <p class="text-sm text-slate-500 mt-1">
                    Ubah data yang diperlukan kemudian simpan perubahan.
                </p>

            </div>

            {{-- FORM --}}
            <form
                action="{{ route('admin.events.update', $event) }}"
                method="POST"
                class="p-6 md:p-8">

                @csrf
                @method('PUT')

                {{-- NAMA AGENDA --}}
                <div class="mb-6">

                    <label for="title"
                           class="block text-sm font-semibold text-slate-700 mb-2">

                        Nama Agenda

                    </label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title', $event->title) }}"
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
                           class="block text-sm font-semibold text-slate-700 mb-2">

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
                                {{ old('room_id', $event->room_id) == $room->id ? 'selected' : '' }}>

                                {{ $room->name }}
                                - {{ $room->location }}
                                ({{ $room->capacity }} orang)

                            </option>

                        @endforeach

                    </select>

                    @error('room_id')
                        <p class="text-red-600 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- TANGGAL DAN SESI --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                    {{-- TANGGAL --}}
                    <div>

                        <label for="event_date"
                               class="block text-sm font-semibold text-slate-700 mb-2">

                            Tanggal

                        </label>

                        <input
                            type="date"
                            id="event_date"
                            name="event_date"
                            value="{{ $eventDateValue }}"
                            min="{{ now('Asia/Jakarta')->toDateString() }}"
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

                        <p class="text-xs text-slate-400 mt-2">
                            Tanggal tidak boleh sebelum hari ini.
                        </p>

                        @error('event_date')
                            <p class="text-red-600 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- PILIH SESI --}}
                    <div>

                        <label for="session"
                               class="block text-sm font-semibold text-slate-700 mb-2">

                            Sesi Agenda

                        </label>

                        <select
                            id="session"
                            name="session"
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
                                value=""
                                disabled
                                {{ $selectedSession === '' ? 'selected' : '' }}>

                                Pilih Sesi

                            </option>

                            <option
                                value="1"
                                {{ $selectedSession == '1' ? 'selected' : '' }}>

                                Sesi 1 (08:00 - 10:00)

                            </option>

                            <option
                                value="2"
                                {{ $selectedSession == '2' ? 'selected' : '' }}>

                                Sesi 2 (10:00 - 12:00)

                            </option>

                            <option
                                value="3"
                                {{ $selectedSession == '3' ? 'selected' : '' }}>

                                Sesi 3 (13:00 - 15:00)

                            </option>

                        </select>

                        @error('session')
                            <p class="text-red-600 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- JAM MULAI --}}
                    <div>

                        <label for="start_time"
                               class="block text-sm font-semibold text-slate-700 mb-2">

                            Jam Mulai

                        </label>

                        <input
                            type="time"
                            id="start_time"
                            value="{{ $selectedStartTime }}"
                            readonly
                            class="w-full
                                   border border-slate-300
                                   bg-slate-100
                                   text-slate-600
                                   rounded-xl
                                   px-4 py-3
                                   outline-none
                                   cursor-not-allowed">

                    </div>

                </div>

                {{-- JAM SELESAI --}}
                <div class="mb-6">

                    <label for="end_time"
                           class="block text-sm font-semibold text-slate-700 mb-2">

                        Jam Selesai

                    </label>

                    <input
                        type="time"
                        id="end_time"
                        value="{{ $selectedEndTime }}"
                        readonly
                        class="w-full md:w-1/3
                               border border-slate-300
                               bg-slate-100
                               text-slate-600
                               rounded-xl
                               px-4 py-3
                               outline-none
                               cursor-not-allowed">

                    <p class="text-xs text-slate-400 mt-2">
                        Jam mulai dan selesai otomatis mengikuti sesi yang dipilih.
                    </p>

                </div>

                {{-- INFO PEMINDAHAN --}}
                <div class="bg-violet-50
                            border border-violet-200
                            rounded-xl
                            px-5 py-4
                            mb-6">

                    <p class="text-sm font-semibold text-violet-700">
                        Perubahan Ruangan atau Jadwal
                    </p>

                    <p class="text-sm text-violet-600 mt-1 leading-6">
                        Jika Admin mengubah ruangan, tanggal, atau sesi,
                        alasan pemindahan wajib diisi.
                        Informasi ini akan dapat dilihat oleh pengguna terkait.
                    </p>

                </div>

                {{-- ALASAN PEMINDAHAN --}}
                <div class="mb-6">

                    <label for="move_reason"
                           class="block text-sm font-semibold text-slate-700 mb-2">

                        Alasan Pemindahan Ruangan / Jadwal

                    </label>

                    <textarea
                        id="move_reason"
                        name="move_reason"
                        rows="4"
                        placeholder="Contoh: Ruangan digunakan untuk kegiatan sekolah sehingga agenda dipindahkan..."
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
                               focus:ring-violet-500
                               focus:border-violet-500
                               transition">{{ old('move_reason', $event->move_reason) }}</textarea>

                    <div class="flex flex-col sm:flex-row
                                sm:items-center
                                sm:justify-between
                                gap-2
                                mt-2">

                        <p class="text-xs text-slate-500">
                            Wajib jika ruangan, tanggal, atau sesi agenda diubah.
                        </p>

                        @if ($event->move_reason)

                            <span class="inline-flex
                                         bg-violet-50
                                         border border-violet-100
                                         text-violet-700
                                         px-3 py-1
                                         rounded-full
                                         text-xs font-semibold">

                                Agenda pernah dipindahkan

                            </span>

                        @endif

                    </div>

                    @error('move_reason')
                        <p class="text-red-600 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- STATUS --}}
                <div class="mb-6">

                    <label for="status"
                           class="block text-sm font-semibold text-slate-700 mb-2">

                        Status Agenda

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
                            value="diajukan"
                            {{ old('status', $event->status) === 'diajukan' ? 'selected' : '' }}>

                            Diajukan

                        </option>

                        <option
                            value="disetujui"
                            {{ old('status', $event->status) === 'disetujui' ? 'selected' : '' }}>

                            Disetujui

                        </option>

                        <option
                            value="ditolak"
                            {{ old('status', $event->status) === 'ditolak' ? 'selected' : '' }}>

                            Ditolak

                        </option>

                    </select>

                    @error('status')
                        <p class="text-red-600 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- CATATAN PIC --}}
                <div class="mb-6">

                    <div class="flex items-center justify-between gap-4 mb-2">

                        <label class="block text-sm font-semibold text-slate-700">

                            Catatan PIC

                        </label>

                        <span class="bg-slate-100
                                     text-slate-500
                                     px-3 py-1
                                     rounded-full
                                     text-xs font-semibold">

                            Hanya PIC

                        </span>

                    </div>

                    @if ($event->pic_note)

                        <div class="bg-blue-50
                                    border border-blue-200
                                    rounded-xl
                                    p-5">

                            <p class="text-sm font-semibold text-blue-700">
                                Catatan dari PIC Ruangan
                            </p>

                            <p class="text-blue-700
                                      whitespace-pre-line
                                      leading-6
                                      mt-2">

                                {{ $event->pic_note }}

                            </p>

                        </div>

                    @else

                        <div class="bg-slate-50
                                    border border-slate-200
                                    rounded-xl
                                    p-5">

                            <p class="text-slate-500 text-sm">
                                PIC belum memberikan catatan untuk agenda ini.
                            </p>

                        </div>

                    @endif

                    <p class="text-xs text-slate-400 mt-2">
                        Catatan PIC hanya dapat diubah oleh PIC ruangan.
                    </p>

                </div>

                {{-- DESKRIPSI --}}
                <div>

                    <label for="description"
                           class="block text-sm font-semibold text-slate-700 mb-2">

                        Deskripsi Agenda

                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="5"
                        placeholder="Masukkan deskripsi agenda..."
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
                               transition">{{ old('description', $event->description) }}</textarea>

                    <p class="text-xs text-slate-400 mt-2">
                        Deskripsi agenda bersifat opsional.
                    </p>

                    @error('description')
                        <p class="text-red-600 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- ACTION --}}
                <div class="flex flex-col
                            lg:flex-row
                            lg:items-center
                            lg:justify-between
                            gap-4
                            mt-8 pt-6
                            border-t border-slate-100">

                    <a href="{{ route('admin.events.show', $event) }}"
                       class="text-sm
                              font-semibold
                              text-blue-600
                              hover:text-blue-700">

                        Lihat Detail Agenda

                    </a>

                    <div class="flex flex-col-reverse sm:flex-row gap-3">

                        <a href="{{ route('admin.events.index') }}"
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

        {{-- INFO BOTTOM --}}
        <div class="mt-5
                    bg-white
                    border border-slate-200
                    rounded-xl
                    px-5 py-4">

            <p class="text-sm text-slate-500">
                Perubahan ruangan atau sesi tetap akan diperiksa terhadap
                agenda lain untuk mencegah bentrok jadwal.
            </p>

        </div>

    </main>

    {{-- JAVASCRIPT SESI --}}
    <script>
        const sessionSelect = document.getElementById('session');

        const startTimeInput = document.getElementById('start_time');

        const endTimeInput = document.getElementById('end_time');

        const sessionSchedules = {
            '1': {
                start: '08:00',
                end: '10:00'
            },
            '2': {
                start: '10:00',
                end: '12:00'
            },
            '3': {
                start: '13:00',
                end: '15:00'
            }
        };

        function updateSessionTime() {
            const selectedSession = sessionSelect.value;

            if (sessionSchedules[selectedSession]) {
                startTimeInput.value =
                    sessionSchedules[selectedSession].start;

                endTimeInput.value =
                    sessionSchedules[selectedSession].end;
            } else {
                startTimeInput.value = '';
                endTimeInput.value = '';
            }
        }

        sessionSelect.addEventListener(
            'change',
            updateSessionTime
        );

        updateSessionTime();
    </script>

</body>

</html>

@endsection