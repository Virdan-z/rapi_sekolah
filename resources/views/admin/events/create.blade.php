@extends('layouts.rapi')

@section('title', 'Kelola Agenda')

@section('page-title', 'Kelola Agenda')

@section('breadcrumb', 'Admin / Kelola Agenda / Tambah')

@section('content')

<main class="max-w-5xl mx-auto px-6 py-8">

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-5 py-4 mb-6">

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
    <section class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

        <div class="px-6 py-5 border-b border-slate-100">

            <h3 class="text-lg font-bold text-slate-900">
                Form Tambah Agenda
            </h3>

            <p class="text-sm text-slate-500 mt-1">
                Lengkapi informasi agenda sebelum menyimpan data.
            </p>

        </div>


        <form action="{{ route('admin.events.store') }}"
              method="POST"
              class="p-6 md:p-8">

            @csrf


            {{-- NAMA AGENDA --}}
            <div class="mb-6">

                <label for="title"
                       class="block text-sm font-semibold text-slate-700 mb-2">
                    Nama Agenda
                </label>

                <input
                    id="title"
                    type="text"
                    name="title"
                    value="{{ old('title') }}"
                    placeholder="Contoh: Rapat OSIS"
                    required
                    class="w-full border border-slate-300 bg-white text-slate-800
                           placeholder-slate-400 rounded-xl px-4 py-3 outline-none
                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">

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
                    class="w-full border border-slate-300 bg-white text-slate-800
                           rounded-xl px-4 py-3 outline-none focus:ring-2
                           focus:ring-blue-500 focus:border-blue-500 transition">

                    <option value="">
                        -- Pilih Ruangan --
                    </option>

                    @foreach ($rooms as $room)
                        <option
                            value="{{ $room->id }}"
                            {{ old('room_id') == $room->id ? 'selected' : '' }}>

                            {{ $room->name }} 
                            - {{ $room->location }} 
                            ({{ $room->capacity }} orang)
                            @if($room->pics->isNotEmpty())
                                [PIC: {{ $room->pics->pluck('name')->implode(', ') }}]
                            @else
                                [Tanpa PIC]
                            @endif

                        </option>
                    @endforeach

                </select>

                @error('room_id')
                    <p class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- TANGGAL MULAI, TANGGAL SELESAI, DAN SESI --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                {{-- TANGGAL MULAI --}}
                <div>

                    <label for="event_date"
                           class="block text-sm font-semibold text-slate-700 mb-2">
                        Tanggal Mulai
                    </label>

                    <input
                        id="event_date"
                        type="date"
                        name="event_date"
                        value="{{ old('event_date') }}"
                        min="{{ now()->toDateString() }}"
                        required
                        class="w-full border border-slate-300 bg-white text-slate-800
                               rounded-xl px-4 py-3 outline-none focus:ring-2
                               focus:ring-blue-500 focus:border-blue-500 transition">

                    @error('event_date')
                        <p class="text-red-600 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- TANGGAL SELESAI (MULTI-DAY) --}}
                <div>

                    <label for="end_date"
                           class="block text-sm font-semibold text-slate-700 mb-2">
                        Tanggal Selesai <span class="text-xs font-normal text-slate-400">(Opsional)</span>
                    </label>

                    <input
                        id="end_date"
                        type="date"
                        name="end_date"
                        value="{{ old('end_date') }}"
                        min="{{ now()->toDateString() }}"
                        class="w-full border border-slate-300 bg-white text-slate-800
                               rounded-xl px-4 py-3 outline-none focus:ring-2
                               focus:ring-blue-500 focus:border-blue-500 transition">

                    <p class="text-xs text-slate-400 mt-1">Kosongkan jika hanya 1 hari.</p>

                    @error('end_date')
                        <p class="text-red-600 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- PILIH SESI --}}
                <div>

                    <label for="session"
                           class="block text-sm font-semibold text-slate-700 mb-2">
                        Pilih Sesi Agenda
                    </label>

                    <select
                        id="session"
                        name="session"
                        required
                        class="w-full border border-slate-300 bg-white text-slate-800
                               rounded-xl px-4 py-3 outline-none focus:ring-2
                               focus:ring-blue-500 focus:border-blue-500 transition">

                        <option value="">
                            -- Pilih Sesi --
                        </option>

                        <option value="1" {{ old('session') == '1' ? 'selected' : '' }}>
                            Sesi 1 (08:00 - 10:00)
                        </option>

                        <option value="2" {{ old('session') == '2' ? 'selected' : '' }}>
                            Sesi 2 (10:00 - 12:00)
                        </option>

                        <option value="3" {{ old('session') == '3' ? 'selected' : '' }}>
                            Sesi 3 (13:00 - 15:00)
                        </option>

                    </select>

                    @error('session')
                        <p class="text-red-600 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>


            {{-- JAM MULAI DAN SELESAI OTOMATIS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                {{-- JAM MULAI --}}
                <div>

                    <label for="start_time_display"
                           class="block text-sm font-semibold text-slate-700 mb-2">
                        Jam Mulai
                    </label>

                    <input
                        id="start_time_display"
                        type="time"
                        value="{{ old('start_time') }}"
                        readonly
                        class="w-full border border-slate-300 bg-slate-100 text-slate-700
                               rounded-xl px-4 py-3 cursor-not-allowed">

                    <input
                        type="hidden"
                        name="start_time"
                        id="start_time"
                        value="{{ old('start_time') }}">

                </div>


                {{-- JAM SELESAI --}}
                <div>

                    <label for="end_time_display"
                           class="block text-sm font-semibold text-slate-700 mb-2">
                        Jam Selesai
                    </label>

                    <input
                        id="end_time_display"
                        type="time"
                        value="{{ old('end_time') }}"
                        readonly
                        class="w-full border border-slate-300 bg-slate-100 text-slate-700
                               rounded-xl px-4 py-3 cursor-not-allowed">

                    <input
                        type="hidden"
                        name="end_time"
                        id="end_time"
                        value="{{ old('end_time') }}">

                </div>

            </div>

            <p class="text-xs text-slate-500 mb-6">
                Jam mulai dan selesai akan terisi otomatis berdasarkan sesi yang dipilih.
            </p>


            {{-- INFO JADWAL --}}
            <div class="bg-blue-50 border border-blue-100 rounded-xl px-5 py-4 mb-6">

                <p class="text-sm font-semibold text-blue-700">
                    Pemeriksaan Jadwal
                </p>

                <p class="text-sm text-blue-600 mt-1 leading-6">
                    Sistem akan memeriksa apakah ruangan yang dipilih
                    memiliki agenda lain pada rentang tanggal dan waktu yang sama.
                    Jadwal yang bertabrakan akan ditolak oleh sistem.
                </p>

            </div>


            {{-- DESKRIPSI --}}
            <div>

                <label for="description"
                       class="block text-sm font-semibold text-slate-700 mb-2">
                    Deskripsi
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    placeholder="Masukkan keterangan agenda..."
                    class="w-full border border-slate-300 bg-white text-slate-800
                           placeholder-slate-400 rounded-xl px-4 py-3 outline-none
                           resize-none focus:ring-2 focus:ring-blue-500
                           focus:border-blue-500 transition">{{ old('description') }}</textarea>

                <p class="text-xs text-slate-400 mt-2">
                    Deskripsi agenda bersifat opsional.
                </p>

                @error('description')
                    <p class="text-red-600 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- TOMBOL --}}
            <div class="flex flex-col-reverse sm:flex-row sm:items-center
                        sm:justify-end gap-3 mt-8 pt-6 border-t border-slate-100">

                <a href="{{ route('admin.events.index') }}"
                   class="inline-flex justify-center bg-slate-100 hover:bg-slate-200
                          text-slate-700 px-5 py-2.5 rounded-lg text-sm font-semibold transition">

                    Batal

                </a>

                <button
                    type="submit"
                    class="inline-flex justify-center bg-blue-600 hover:bg-blue-700
                           text-white px-6 py-2.5 rounded-lg text-sm font-semibold
                           shadow-sm transition">

                    Simpan Agenda

                </button>

            </div>

        </form>

    </section>


    {{-- INFORMASI BAWAH --}}
    <div class="mt-5 bg-white border border-slate-200 rounded-xl px-5 py-4">

        <p class="text-sm text-slate-500">
            Pastikan ruangan, tanggal, dan sesi penggunaan sudah benar.
            Jadwal yang bertabrakan dengan agenda lain akan ditolak oleh sistem.
        </p>

    </div>

</main>


{{-- JAVASCRIPT SESI OTOMATIS & VALIDASI TANGGAL SELESAI --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const sessionSelect = document.getElementById('session');

    const startDisplay = document.getElementById('start_time_display');
    const endDisplay = document.getElementById('end_time_display');

    const startInput = document.getElementById('start_time');
    const endInput = document.getElementById('end_time');

    const startDateInput = document.getElementById('event_date');
    const endDateInput = document.getElementById('end_date');

    // Sinkronisasi minimal tanggal selesai berdasarkan tanggal mulai
    startDateInput.addEventListener('change', function() {
        endDateInput.min = startDateInput.value;
        if (endDateInput.value && endDateInput.value < startDateInput.value) {
            endDateInput.value = startDateInput.value;
        }
    });

    const schedules = {
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

    function updateSchedule() {

        const selectedSession = sessionSelect.value;
        const schedule = schedules[selectedSession];

        if (schedule) {

            startDisplay.value = schedule.start;
            endDisplay.value = schedule.end;

            startInput.value = schedule.start;
            endInput.value = schedule.end;

        } else {

            startDisplay.value = '';
            endDisplay.value = '';

            startInput.value = '';
            endInput.value = '';

        }

    }

    sessionSelect.addEventListener('change', updateSchedule);

    // Mengisi ulang jam ketika halaman dimuat kembali.
    updateSchedule();

});
</script>

@endsection