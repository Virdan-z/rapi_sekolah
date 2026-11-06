<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Dashboard Siswa - RAPI Sekolah</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body class="min-h-screen bg-slate-50">

    {{-- NAVBAR --}}
    <nav class="bg-cyan-700 shadow-sm">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="flex h-16 items-center justify-between">

                <div>
                    <h1 class="text-lg font-bold text-white">
                        RAPI-Sekolah
                    </h1>

                    <p class="text-xs text-cyan-100">
                        Portal Siswa
                    </p>
                </div>


                <div class="hidden items-center gap-2 md:flex">

                    <a
                        href="{{ route('siswa.dashboard') }}"
                        class="
                            rounded-lg
                            bg-white/15
                            px-4
                            py-2
                            text-sm
                            font-medium
                            text-white
                        "
                    >
                        Dashboard
                    </a>


                    <a
                        href="{{ route('siswa.events.index') }}"
                        class="
                            rounded-lg
                            px-4
                            py-2
                            text-sm
                            font-medium
                            text-cyan-50
                            hover:bg-white/10
                        "
                    >
                        Agenda
                    </a>


                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="
                                rounded-lg
                                bg-white
                                px-4
                                py-2
                                text-sm
                                font-medium
                                text-cyan-700
                                hover:bg-cyan-50
                            "
                        >
                            Logout
                        </button>
                    </form>

                </div>

            </div>

        </div>

    </nav>


    {{-- CONTENT --}}
    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- HERO --}}
        <section
            class="
                mb-8
                rounded-3xl
                bg-gradient-to-r
                from-cyan-600
                via-sky-600
                to-blue-600
                p-8
                text-white
                shadow-sm
            "
        >

            <p class="mb-2 text-sm font-medium text-cyan-100">
                Dashboard Siswa
            </p>

            <h2 class="mb-3 text-3xl font-bold">
                Selamat datang, {{ auth()->user()->name }}
            </h2>

            <p class="max-w-2xl text-cyan-50">
                Lihat informasi agenda sekolah yang sudah disetujui
                serta jadwal penggunaan ruangan.
            </p>

        </section>


        {{-- STATISTIK --}}
        <section
            class="
                mb-8
                grid
                grid-cols-1
                gap-5
                md:grid-cols-3
            "
        >

            {{-- TOTAL RUANGAN --}}
            <div
                class="
                    rounded-2xl
                    border
                    border-slate-200
                    bg-white
                    p-6
                    shadow-sm
                "
            >

                <p class="mb-2 text-sm font-medium text-slate-500">
                    Total Ruangan
                </p>

                <p class="text-3xl font-bold text-slate-900">
                    {{ $totalRooms }}
                </p>

            </div>


            {{-- TOTAL AGENDA --}}
            <div
                class="
                    rounded-2xl
                    border
                    border-slate-200
                    bg-white
                    p-6
                    shadow-sm
                "
            >

                <p class="mb-2 text-sm font-medium text-slate-500">
                    Agenda Disetujui
                </p>

                <p class="text-3xl font-bold text-cyan-700">
                    {{ $totalEvents }}
                </p>

            </div>


            {{-- AGENDA HARI INI --}}
            <div
                class="
                    rounded-2xl
                    border
                    border-slate-200
                    bg-white
                    p-6
                    shadow-sm
                "
            >

                <p class="mb-2 text-sm font-medium text-slate-500">
                    Agenda Hari Ini
                </p>

                <p class="text-3xl font-bold text-blue-700">
                    {{ $todayEvents->count() }}
                </p>

            </div>

        </section>


        {{-- AGENDA HARI INI --}}
        <section
            class="
                mb-8
                rounded-2xl
                border
                border-slate-200
                bg-white
                shadow-sm
            "
        >

            <div class="border-b border-slate-200 p-6">

                <h3 class="text-lg font-bold text-slate-900">
                    Agenda Hari Ini
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Agenda sekolah yang berlangsung hari ini.
                </p>

            </div>


            <div class="p-6">

                @forelse ($todayEvents as $event)

                    <div
                        class="
                            mb-4
                            rounded-xl
                            border
                            border-slate-200
                            p-5
                            last:mb-0
                        "
                    >

                        <div
                            class="
                                flex
                                flex-col
                                gap-4
                                md:flex-row
                                md:items-center
                                md:justify-between
                            "
                        >

                            <div>

                                <h4 class="mb-1 font-semibold text-slate-900">
                                    {{ $event->title }}
                                </h4>

                                <p class="text-sm text-slate-500">
                                    {{ $event->room->name ?? '-' }}
                                </p>

                            </div>


                            <div class="text-sm font-medium text-cyan-700">

                                {{ substr($event->start_time, 0, 5) }}

                                -

                                {{ substr($event->end_time, 0, 5) }}

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="py-10 text-center text-slate-500">
                        Tidak ada agenda hari ini.
                    </div>

                @endforelse

            </div>

        </section>


        {{-- AGENDA MENDATANG --}}
        <section
            class="
                rounded-2xl
                border
                border-slate-200
                bg-white
                shadow-sm
            "
        >

            <div
                class="
                    flex
                    flex-col
                    gap-4
                    border-b
                    border-slate-200
                    p-6
                    sm:flex-row
                    sm:items-center
                    sm:justify-between
                "
            >

                <div>

                    <h3 class="text-lg font-bold text-slate-900">
                        Agenda Mendatang
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Agenda sekolah yang sudah disetujui.
                    </p>

                </div>


                <a
                    href="{{ route('siswa.events.index') }}"
                    class="
                        inline-flex
                        justify-center
                        rounded-lg
                        bg-cyan-700
                        px-4
                        py-2
                        text-sm
                        font-medium
                        text-white
                        hover:bg-cyan-800
                    "
                >
                    Lihat Semua
                </a>

            </div>


            <div class="p-6">

                @forelse ($upcomingEvents as $event)

                    <a
                        href="{{ route('siswa.events.show', $event) }}"
                        class="
                            mb-4
                            block
                            rounded-xl
                            border
                            border-slate-200
                            p-5
                            transition
                            last:mb-0
                            hover:border-cyan-300
                            hover:bg-cyan-50/40
                        "
                    >

                        <div
                            class="
                                flex
                                flex-col
                                gap-4
                                md:flex-row
                                md:items-center
                                md:justify-between
                            "
                        >

                            <div>

                                <h4 class="mb-2 font-semibold text-slate-900">
                                    {{ $event->title }}
                                </h4>

                                <div
                                    class="
                                        flex
                                        flex-wrap
                                        gap-x-5
                                        gap-y-2
                                        text-sm
                                        text-slate-500
                                    "
                                >

                                    <span>
                                        {{ $event->room->name ?? '-' }}
                                    </span>

                                    <span>
                                        {{ \Carbon\Carbon::parse(
                                            $event->event_date
                                        )->format('d-m-Y') }}
                                    </span>

                                    <span>
                                        {{ substr(
                                            $event->start_time,
                                            0,
                                            5
                                        ) }}
                                        -
                                        {{ substr(
                                            $event->end_time,
                                            0,
                                            5
                                        ) }}
                                    </span>

                                </div>

                            </div>


                            <span
                                class="
                                    inline-flex
                                    w-fit
                                    rounded-full
                                    bg-emerald-100
                                    px-3
                                    py-1
                                    text-xs
                                    font-semibold
                                    text-emerald-700
                                "
                            >
                                Disetujui
                            </span>

                        </div>

                    </a>

                @empty

                    <div class="py-10 text-center text-slate-500">
                        Belum ada agenda mendatang.
                    </div>

                @endforelse

            </div>

        </section>

    </main>

</body>

</html>