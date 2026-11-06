@extends('layouts.rapi')

@section('title', 'Agenda Publik')
@section('page-title', 'Agenda Publik')
@section('breadcrumb', 'Agenda Publik')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | DATA KALENDER
    |--------------------------------------------------------------------------
    */

    $monthNames = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    $dayNames = [
        'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min',
    ];

    $monthTitle = $monthNames[(int) $selectedMonth->format('n')]
        . ' '
        . $selectedMonth->format('Y');

    $previousMonth = $selectedMonth->copy()->subMonth()->format('Y-m');
    $nextMonth = $selectedMonth->copy()->addMonth()->format('Y-m');
    $currentMonth = now()->format('Y-m');
    $today = now()->toDateString();

    /*
    |--------------------------------------------------------------------------
    | MEMBUAT TANGGAL KALENDER
    |--------------------------------------------------------------------------
    */

    $calendarStart = $selectedMonth
        ->copy()
        ->startOfMonth()
        ->startOfWeek(\Illuminate\Support\Carbon::MONDAY);

    $calendarEnd = $selectedMonth
        ->copy()
        ->endOfMonth()
        ->endOfWeek(\Illuminate\Support\Carbon::SUNDAY);

    $calendarDays = [];

    $cursor = $calendarStart->copy();

    while ($cursor->lte($calendarEnd)) {
        $calendarDays[] = $cursor->copy();
        $cursor->addDay();
    }

    /*
    |--------------------------------------------------------------------------
    | TANGGAL YANG DIPILIH PERTAMA KALI
    |--------------------------------------------------------------------------
    */

    $firstCalendarEvent = $calendarEvents->first();

    if ($firstCalendarEvent) {
        $initialSelectedDate = \Illuminate\Support\Carbon::parse(
            $firstCalendarEvent->event_date
        )->toDateString();
    } else {
        $initialSelectedDate = $selectedMonth
            ->copy()
            ->startOfMonth()
            ->toDateString();
    }
@endphp


@push('styles')
<style>
    [hidden] {
        display: none !important;
    }

    /* ==================================================
       KALENDER
    ================================================== */

    .calendar-wrapper {
        width: 100%;
        overflow-x: auto;
        border-radius: 12px;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, minmax(0, 1fr));
        width: 100%;
    }

    .calendar-weekday {
        padding: 13px 5px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        text-align: center;
        font-size: 12px;
        font-weight: 700;
        color: #475569;
    }

    .calendar-day {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 6px;

        width: 100%;
        min-width: 0;
        min-height: 125px;
        height: auto;

        padding: 9px;
        border: 1px solid #e2e8f0;

        background: white;
        color: #1e293b;

        text-align: left;
        overflow: hidden;

        transition: background-color 0.2s ease;
    }

    .calendar-day:hover {
        background-color: #eff6ff;
    }

    .calendar-day.outside {
        background-color: #f8fafc;
        color: #94a3b8;
    }

    .calendar-day.selected {
        background-color: #eff6ff;
        box-shadow: inset 0 0 0 2px #2563eb;
    }

    .day-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 29px;
        height: 29px;
        flex-shrink: 0;

        border-radius: 50%;
        font-size: 13px;
        font-weight: 700;
    }

    /* HARI INI */

    .calendar-day.today .day-number {
        background-color: #2563eb;
        color: white;
    }

    .calendar-day.today.selected .day-number {
        background-color: #2563eb;
        color: white;
    }

    /* HARI MINGGU */

    .calendar-day.sunday {
        background-color: #eff6ff;
    }

    .calendar-day.sunday .day-number {
        color: #2563eb;
    }

    /* HARI LIBUR NASIONAL */

    .calendar-day.holiday {
        background-color: #fef2f2;
    }

    .calendar-day.holiday .day-number {
        background-color: #dc2626;
        color: white;
    }

    .calendar-day.holiday.selected {
        box-shadow: inset 0 0 0 2px #dc2626;
    }

    .calendar-day.holiday.sunday {
        background-color: #fef2f2;
    }

    /* NAMA LIBUR */

    .holiday-label {
        display: block;
        width: 100%;

        color: #dc2626;
        font-size: 10px;
        font-weight: 700;
        line-height: 1.3;

        overflow-wrap: anywhere;
    }

    /* NAMA AGENDA */

    .calendar-event-name {
        display: block;
        width: 100%;

        padding: 4px 6px;
        border-radius: 5px;

        background: #dbeafe;
        color: #1d4ed8;

        font-size: 10px;
        font-weight: 600;
        line-height: 1.4;

        overflow: hidden;
        text-overflow: ellipsis;
        overflow-wrap: anywhere;
    }

    .more-events {
        display: block;
        color: #64748b;
        font-size: 10px;
        font-weight: 700;
    }

    .today-label {
        color: #059669;
        font-size: 10px;
        font-weight: 700;
    }

    .calendar-day:focus-visible {
        outline: 2px solid #2563eb;
        outline-offset: -3px;
    }

    /* ==================================================
       RESPONSIVE
    ================================================== */

    @media (max-width: 768px) {
        .calendar-grid {
            min-width: 650px;
        }

        .calendar-day {
            min-height: 105px;
            padding: 7px;
        }

        .calendar-event-name {
            font-size: 9px;
        }

        .holiday-label {
            font-size: 9px;
        }
    }

    @media (max-width: 480px) {
        .calendar-day {
            min-height: 90px;
            padding: 5px;
        }

        .day-number {
            width: 25px;
            height: 25px;
            font-size: 11px;
        }
    }
</style>
@endpush


<div class="mx-auto max-w-7xl">

    {{-- ==================================================
         HERO
    ================================================== --}}

    <section class="mb-8 rounded-3xl bg-gradient-to-r from-slate-800 via-slate-700 to-blue-800 p-8 text-white shadow-sm">

        <p class="mb-2 text-sm font-medium text-slate-200">
            Informasi Publik
        </p>

        <h2 class="text-3xl font-bold">
            Agenda Sekolah
        </h2>

        <p class="mt-3 max-w-2xl text-slate-200">
            Informasi agenda sekolah yang sudah disetujui
            dan dapat dilihat tanpa harus login.
        </p>

    </section>


    {{-- ==================================================
         STATISTIK
    ================================================== --}}

    <section class="mb-8 grid grid-cols-1 gap-5 md:grid-cols-2">

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <p class="mb-2 text-sm font-medium text-slate-500">
                Agenda Mendatang
            </p>

            <p class="text-3xl font-bold text-blue-700">
                {{ $events->count() }}
            </p>

        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <p class="mb-2 text-sm font-medium text-slate-500">
                Total Ruangan
            </p>

            <p class="text-3xl font-bold text-slate-900">
                {{ $rooms->count() }}
            </p>

        </div>

    </section>


    {{-- ==================================================
         KALENDER AGENDA
    ================================================== --}}

    <section class="mb-8 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6">

        {{-- HEADER KALENDER --}}

        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <p class="mb-1 text-sm font-medium text-blue-700">
                    KALENDER SEKOLAH
                </p>

                <h3 class="text-2xl font-bold text-slate-900">
                    {{ $monthTitle }}
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Pilih tanggal untuk melihat agenda sekolah.
                </p>

            </div>

            {{-- NAVIGASI BULAN --}}

            <div class="flex items-center gap-2">

                <a
                    href="{{ route('public.agenda', ['month' => $previousMonth]) }}"
                    aria-label="Bulan sebelumnya"
                    class="flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 bg-white text-lg font-bold text-slate-700 hover:bg-blue-50"
                >
                    &larr;
                </a>

                <a
                    href="{{ route('public.agenda', ['month' => $currentMonth]) }}"
                    class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-blue-700 hover:bg-blue-50"
                >
                    Bulan Ini
                </a>

                <a
                    href="{{ route('public.agenda', ['month' => $nextMonth]) }}"
                    aria-label="Bulan berikutnya"
                    class="flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 bg-white text-lg font-bold text-slate-700 hover:bg-blue-50"
                >
                    &rarr;
                </a>

            </div>

        </div>


        {{-- GRID KALENDER --}}

        <div class="calendar-wrapper">

            <div class="calendar-grid">

                {{-- NAMA HARI --}}

                @foreach ($dayNames as $dayName)

                    <div class="calendar-weekday">
                        {{ $dayName }}
                    </div>

                @endforeach


                {{-- TANGGAL --}}

                @foreach ($calendarDays as $day)

                    @php
                        $dateKey = $day->toDateString();

                        $dayEvents = $eventsByDate->get(
                            $dateKey,
                            collect()
                        );

                        $isCurrentMonth =
                            $day->format('Y-m') ===
                            $selectedMonth->format('Y-m');

                        $isSunday = $day->isSunday();

                        $isToday = $dateKey === $today;

                        $isHoliday = isset($nationalHolidays[$dateKey]);

                        $holidayName = $nationalHolidays[$dateKey] ?? null;

                        $isSelected =
                            $dateKey === $initialSelectedDate;
                    @endphp

                    <button
                        type="button"
                        data-date="{{ $dateKey }}"
                        data-month="{{ $day->format('Y-m') }}"
                        aria-label="Tanggal {{ $day->format('d-m-Y') }}"

                        class="calendar-day
                            {{ !$isCurrentMonth ? 'outside' : '' }}
                            {{ $isSunday ? 'sunday' : '' }}
                            {{ $isHoliday ? 'holiday' : '' }}
                            {{ $isToday ? 'today' : '' }}
                            {{ $isSelected ? 'selected' : '' }}"
                    >

                        {{-- ANGKA TANGGAL --}}

                        <span class="day-number">
                            {{ $day->day }}
                        </span>


                        {{-- NAMA HARI LIBUR --}}

                        @if ($isHoliday)

                            <span class="holiday-label">
                                {{ $holidayName }}
                            </span>

                        @endif


                        {{-- NAMA AGENDA --}}

                        @foreach ($dayEvents->take(2) as $event)

                            <span
                                class="calendar-event-name"
                                title="{{ $event->title }}"
                            >
                                {{ $event->title }}
                            </span>

                        @endforeach


                        {{-- AGENDA LAINNYA --}}

                        @if ($dayEvents->count() > 2)

                            <span class="more-events">
                                +{{ $dayEvents->count() - 2 }} agenda lainnya
                            </span>

                        @endif


                        {{-- HARI INI --}}

                        @if ($isToday)

                            <span class="today-label">
                                Hari ini
                            </span>

                        @endif

                    </button>

                @endforeach

            </div>

        </div>


        {{-- KETERANGAN WARNA --}}

        <div class="mt-5 flex flex-wrap items-center gap-4 border-b border-slate-200 pb-6 text-xs text-slate-600">

            <div class="flex items-center gap-2">

                <span class="h-3 w-3 rounded-full bg-blue-600"></span>

                <span>
                    Hari Minggu
                </span>

            </div>

            <div class="flex items-center gap-2">

                <span class="h-3 w-3 rounded-full bg-red-600"></span>

                <span>
                    Hari libur nasional
                </span>

            </div>

            <div class="flex items-center gap-2">

                <span class="h-3 w-3 rounded-full bg-emerald-600"></span>

                <span>
                    Hari ini
                </span>

            </div>

            <div class="flex items-center gap-2">

                <span class="h-3 w-3 rounded-full bg-blue-300"></span>

                <span>
                    Ada agenda
                </span>

            </div>

        </div>


        {{-- ==================================================
             DETAIL AGENDA BERDASARKAN TANGGAL
        ================================================== --}}

        <div class="mt-6">

            <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                <h3
                    id="selectedDateLabel"
                    class="text-lg font-bold text-slate-900"
                >
                    Agenda pada tanggal
                </h3>

                <span class="w-fit rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                    Agenda Disetujui
                </span>

            </div>


            {{-- PESAN JIKA TIDAK ADA AGENDA --}}

            <div
                id="calendarEmptyState"
                class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-5 py-10 text-center"
            >

                <div class="mb-3 text-4xl">
                    📅
                </div>

                <h4 class="font-semibold text-slate-800">
                    Belum Ada Agenda
                </h4>

                <p class="mt-2 text-sm text-slate-500">
                    Tidak ada agenda yang disetujui pada tanggal ini.
                </p>

            </div>


            {{-- DETAIL AGENDA --}}

            <div
                id="calendarEventPanels"
                class="space-y-4"
            >

                @foreach ($eventsByDate as $dateKey => $dayEvents)

                    <div
                        data-event-panel="{{ $dateKey }}"
                        hidden
                    >

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                            @foreach ($dayEvents as $event)

                                <article class="rounded-xl border border-slate-200 p-5 transition hover:border-blue-300 hover:shadow-sm">

                                    {{-- JUDUL --}}

                                    <div class="mb-3 flex flex-wrap items-start justify-between gap-3">

                                        <h4 class="text-lg font-bold text-slate-900">
                                            {{ $event->title }}
                                        </h4>

                                        <span class="shrink-0 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                            Disetujui
                                        </span>

                                    </div>


                                    {{-- DESKRIPSI --}}

                                    @if ($event->description)

                                        <p class="mb-4 text-sm leading-relaxed text-slate-600">
                                            {{ $event->description }}
                                        </p>

                                    @endif


                                    {{-- INFORMASI AGENDA --}}

                                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">

                                        <div class="rounded-lg bg-slate-50 p-3">

                                            <p class="text-xs text-slate-500">
                                                Tanggal
                                            </p>

                                            <p class="mt-1 text-sm font-semibold text-slate-900">
                                                {{ \Illuminate\Support\Carbon::parse($event->event_date)->format('d-m-Y') }}
                                            </p>

                                        </div>

                                        <div class="rounded-lg bg-slate-50 p-3">

                                            <p class="text-xs text-slate-500">
                                                Waktu
                                            </p>

                                            <p class="mt-1 text-sm font-semibold text-slate-900">
                                                {{ substr((string) $event->start_time, 0, 5) }}
                                                -
                                                {{ substr((string) $event->end_time, 0, 5) }}
                                            </p>

                                        </div>

                                        <div class="rounded-lg bg-slate-50 p-3">

                                            <p class="text-xs text-slate-500">
                                                Ruangan
                                            </p>

                                            <p class="mt-1 text-sm font-semibold text-slate-900">
                                                {{ $event->room?->name ?? '-' }}
                                            </p>

                                        </div>

                                        <div class="rounded-lg bg-slate-50 p-3">

                                            <p class="text-xs text-slate-500">
                                                Lokasi
                                            </p>

                                            <p class="mt-1 text-sm font-semibold text-slate-900">
                                                {{ $event->room?->location ?? '-' }}
                                            </p>

                                        </div>

                                    </div>

                                </article>

                            @endforeach

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </section>


    {{-- ==================================================
         DAFTAR AGENDA MENDATANG
    ================================================== --}}

    <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 p-6">

            <h3 class="text-lg font-bold text-slate-900">
                Agenda Mendatang
            </h3>

            <p class="mt-1 text-sm text-slate-500">
                Hanya agenda dengan status disetujui yang ditampilkan.
            </p>

        </div>


        <div class="p-6">

            @forelse ($events as $event)

                <div class="mb-5 rounded-2xl border border-slate-200 p-6 last:mb-0">

                    <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">

                        <div class="flex-1">

                            <div class="mb-3 flex flex-wrap items-center gap-3">

                                <h4 class="text-xl font-bold text-slate-900">
                                    {{ $event->title }}
                                </h4>

                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                    Disetujui
                                </span>

                            </div>


                            @if ($event->description)

                                <p class="mb-5 leading-relaxed text-slate-600">
                                    {{ $event->description }}
                                </p>

                            @endif


                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

                                <div class="rounded-xl bg-slate-50 p-4">

                                    <p class="text-xs font-medium text-slate-500">
                                        Ruangan
                                    </p>

                                    <p class="mt-1 font-semibold text-slate-900">
                                        {{ $event->room?->name ?? '-' }}
                                    </p>

                                </div>


                                <div class="rounded-xl bg-slate-50 p-4">

                                    <p class="text-xs font-medium text-slate-500">
                                        Lokasi
                                    </p>

                                    <p class="mt-1 font-semibold text-slate-900">
                                        {{ $event->room?->location ?? '-' }}
                                    </p>

                                </div>


                                <div class="rounded-xl bg-slate-50 p-4">

                                    <p class="text-xs font-medium text-slate-500">
                                        Tanggal
                                    </p>

                                    <p class="mt-1 font-semibold text-slate-900">
                                        {{ \Illuminate\Support\Carbon::parse($event->event_date)->format('d-m-Y') }}
                                    </p>

                                </div>


                                <div class="rounded-xl bg-slate-50 p-4">

                                    <p class="text-xs font-medium text-slate-500">
                                        Waktu
                                    </p>

                                    <p class="mt-1 font-semibold text-slate-900">
                                        {{ substr((string) $event->start_time, 0, 5) }}
                                        -
                                        {{ substr((string) $event->end_time, 0, 5) }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="py-14 text-center">

                    <div class="mb-3 text-4xl">
                        📅
                    </div>

                    <h4 class="font-semibold text-slate-800">
                        Belum ada agenda
                    </h4>

                    <p class="mt-2 text-sm text-slate-500">
                        Belum ada agenda sekolah yang sudah disetujui
                        untuk hari ini dan seterusnya.
                    </p>

                </div>

            @endforelse

        </div>

    </section>


    {{-- ==================================================
         INFORMASI RUANGAN
    ================================================== --}}

    <section class="mt-8 rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 p-6">

            <h3 class="text-lg font-bold text-slate-900">
                Daftar Ruangan
            </h3>

            <p class="mt-1 text-sm text-slate-500">
                Informasi ruangan yang tersedia di sekolah.
            </p>

        </div>


        <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2 lg:grid-cols-3">

            @forelse ($rooms as $room)

                <div class="rounded-xl border border-slate-200 p-5">

                    <h4 class="font-bold text-slate-900">
                        {{ $room->name }}
                    </h4>

                    <div class="mt-4 space-y-2 text-sm">

                        <p class="text-slate-600">

                            <span class="font-medium text-slate-800">
                                Lokasi:
                            </span>

                            {{ $room->location ?? '-' }}

                        </p>

                        <p class="text-slate-600">

                            <span class="font-medium text-slate-800">
                                Kapasitas:
                            </span>

                            {{ $room->capacity }} orang

                        </p>

                    </div>

                </div>

            @empty

                <p class="text-sm text-slate-500">
                    Belum ada data ruangan.
                </p>

            @endforelse

        </div>

    </section>

</div>

@endsection


{{-- ======================================================
     JAVASCRIPT KALENDER
====================================================== --}}

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const dayButtons = document.querySelectorAll('.calendar-day');

    const eventPanels = document.querySelectorAll('[data-event-panel]');

    const emptyState = document.getElementById('calendarEmptyState');

    const selectedDateLabel = document.getElementById('selectedDateLabel');


    /*
    |--------------------------------------------------------------------------
    | MEMILIH TANGGAL
    |--------------------------------------------------------------------------
    */

    function selectDate(dateString) {

        // Mengubah tanggal yang dipilih.

        dayButtons.forEach(function (button) {

            button.classList.toggle(
                'selected',
                button.dataset.date === dateString
            );

        });


        // Mengubah judul tanggal.

        const parts = dateString.split('-');

        const selectedDate = new Date(
            Number(parts[0]),
            Number(parts[1]) - 1,
            Number(parts[2])
        );

        const formattedDate = new Intl.DateTimeFormat(
            'id-ID',
            {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            }
        ).format(selectedDate);

        selectedDateLabel.textContent = 'Agenda pada ' + formattedDate;


        // Menampilkan agenda berdasarkan tanggal.

        let hasAgenda = false;

        eventPanels.forEach(function (panel) {

            const isActive =
                panel.dataset.eventPanel === dateString;

            panel.hidden = !isActive;

            if (isActive) {
                hasAgenda = true;
            }

        });


        // Menampilkan pesan jika tidak ada agenda.

        emptyState.hidden = hasAgenda;

    }


    /*
    |--------------------------------------------------------------------------
    | EVENT KLIK TANGGAL
    |--------------------------------------------------------------------------
    */

    dayButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            const selectedDate = button.dataset.date;

            const selectedMonth = button.dataset.month;

            const currentSelectedMonth = @json($selectedMonth->format('Y-m'));

            // Jika tanggal berada di bulan berbeda, pindah bulan.

            if (selectedMonth !== currentSelectedMonth) {

                const url = new URL(window.location.href);

                url.searchParams.set('month', selectedMonth);

                window.location.href = url.toString();

                return;
            }

            selectDate(selectedDate);

        });

    });


    /*
    |--------------------------------------------------------------------------
    | MENAMPILKAN TANGGAL AWAL
    |--------------------------------------------------------------------------
    */

    selectDate(@json($initialSelectedDate));

});
</script>
@endpush