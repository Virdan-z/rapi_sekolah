@extends('layouts.rapi')

@section('title', 'Ajukan Agenda')

@section('page-title', 'Ajukan Agenda')

@section('breadcrumb', 'Guru / Agenda / Tambah')

@section('content')

<main class="max-w-4xl mx-auto px-6 py-8">

    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">
            Ajukan Agenda
        </h2>

        <p class="text-gray-500 mt-1">
            Ajukan penggunaan ruangan untuk kegiatan sekolah.
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border p-6">

        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-300
                        text-red-700 px-4 py-3 rounded-xl">

                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif

        <form action="{{ route('guru.events.store') }}" method="POST">

            @csrf

            {{-- Nama Agenda --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Agenda
                </label>

                <input
                    type="text"
                    name="title"
                    value="{{ old('title') }}"
                    placeholder="Contoh: Rapat Koordinasi"
                    class="w-full rounded-xl border-gray-300
                           focus:border-indigo-500 focus:ring-indigo-500"
                    required>
            </div>

            {{-- Ruangan --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Ruangan
                </label>

                <select
                    name="room_id"
                    class="w-full rounded-xl border-gray-300
                           focus:border-indigo-500 focus:ring-indigo-500"
                    required>

                    <option value="">-- Pilih Ruangan --</option>

                    @foreach ($rooms as $room)
                        <option
                            value="{{ $room->id }}"
                            {{ old('room_id') == $room->id ? 'selected' : '' }}>
                            {{ $room->name }} - {{ $room->location }} ({{ $room->capacity }} orang)
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- Tanggal Mulai dan Tanggal Selesai (Multi-day) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">

                {{-- Tanggal Mulai --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Tanggal Mulai
                    </label>

                    <input
                        type="date"
                        id="event_date"
                        name="event_date"
                        value="{{ old('event_date') }}"
                        min="{{ now()->setTimezone('Asia/Jakarta')->toDateString() }}"
                        class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                        required>
                </div>

                {{-- Tanggal Selesai --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Tanggal Selesai <span class="text-xs font-normal text-gray-400">(Opsional)</span>
                    </label>

                    <input
                        type="date"
                        id="end_date"
                        name="end_date"
                        value="{{ old('end_date') }}"
                        min="{{ now()->setTimezone('Asia/Jakarta')->toDateString() }}"
                        class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <p class="text-xs text-gray-400 mt-1">Kosongkan jika kegiatan hanya 1 hari.</p>
                </div>

            </div>

            {{-- Pilihan Sesi --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Pilih Sesi
                </label>

                <select
                    name="session"
                    id="session"
                    class="w-full rounded-xl border-gray-300
                           focus:border-indigo-500 focus:ring-indigo-500"
                    required>

                    <option value="">-- Pilih Sesi --</option>

                    <option
                        value="1"
                        {{ old('session') == '1' ? 'selected' : '' }}>
                        Sesi 1 (08:00 - 10:00)
                    </option>

                    <option
                        value="2"
                        {{ old('session') == '2' ? 'selected' : '' }}>
                        Sesi 2 (10:00 - 12:00)
                    </option>

                    <option
                        value="3"
                        {{ old('session') == '3' ? 'selected' : '' }}>
                        Sesi 3 (13:00 - 15:00)
                    </option>

                </select>
            </div>

            {{-- Jam Otomatis --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Jam Mulai
                    </label>

                    <input
                        type="time"
                        id="start_time"
                        name="start_time"
                        class="w-full rounded-xl border-gray-300 bg-gray-100"
                        readonly>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Jam Selesai
                    </label>

                    <input
                        type="time"
                        id="end_time"
                        name="end_time"
                        class="w-full rounded-xl border-gray-300 bg-gray-100"
                        readonly>
                </div>

            </div>

            {{-- Deskripsi --}}
            <div class="mb-7">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Deskripsi
                </label>

                <textarea
                    name="description"
                    rows="4"
                    class="w-full rounded-xl border-gray-300
                           focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Masukkan keterangan agenda...">{{ old('description') }}</textarea>
            </div>

            {{-- Tombol --}}
            <div class="flex gap-3">

                <a href="{{ route('guru.events.index') }}"
                   class="bg-gray-200 hover:bg-gray-300
                          text-gray-700 px-5 py-2.5
                          rounded-xl font-semibold">
                    Kembali
                </a>

                <button
                    type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700
                           text-white px-5 py-2.5
                           rounded-xl font-semibold">
                    Kirim Pengajuan
                </button>

            </div>

        </form>

    </div>

</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sessionSelect = document.getElementById('session');
        const startTimeInput = document.getElementById('start_time');
        const endTimeInput = document.getElementById('end_time');

        const startDateInput = document.getElementById('event_date');
        const endDateInput = document.getElementById('end_date');

        // Sinkronisasi minimal tanggal selesai berdasarkan tanggal mulai
        if (startDateInput && endDateInput) {
            startDateInput.addEventListener('change', function() {
                endDateInput.min = startDateInput.value;
                if (endDateInput.value && endDateInput.value < startDateInput.value) {
                    endDateInput.value = startDateInput.value;
                }
            });
        }

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
                startTimeInput.value = sessionSchedules[selectedSession].start;
                endTimeInput.value = sessionSchedules[selectedSession].end;
            } else {
                startTimeInput.value = '';
                endTimeInput.value = '';
            }
        }

        sessionSelect.addEventListener('change', updateSessionTime);
        updateSessionTime();
    });
</script>

@endsection