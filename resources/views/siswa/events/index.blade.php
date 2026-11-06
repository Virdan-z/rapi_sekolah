<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Agenda Siswa - RAPI Sekolah</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body class="min-h-screen bg-slate-50">

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
                            px-4
                            py-2
                            text-sm
                            font-medium
                            text-cyan-50
                            hover:bg-white/10
                        "
                    >
                        Dashboard
                    </a>

                    <a
                        href="{{ route('siswa.events.index') }}"
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


    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

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
            "
        >
            <p class="mb-2 text-sm font-medium text-cyan-100">
                Agenda Sekolah
            </p>

            <h2 class="text-3xl font-bold">
                Daftar Agenda Disetujui
            </h2>

            <p class="mt-3 max-w-2xl text-cyan-50">
                Siswa hanya dapat melihat agenda yang sudah disetujui.
            </p>
        </section>


        <section
            class="
                rounded-2xl
                border
                border-slate-200
                bg-white
                shadow-sm
            "
        >

            <div class="border-b border-slate-200 p-6">

                <h3 class="text-lg font-bold text-slate-900">
                    Semua Agenda
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Jadwal agenda sekolah yang tersedia untuk siswa.
                </p>

            </div>


            <div class="p-6">

                @forelse ($events as $event)

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
                                        Ruangan:
                                        {{ $event->room->name ?? '-' }}
                                    </span>

                                    <span>
                                        Tanggal:
                                        {{ \Carbon\Carbon::parse(
                                            $event->event_date
                                        )->format('d-m-Y') }}
                                    </span>

                                    <span>
                                        Jam:
                                        {{ substr($event->start_time, 0, 5) }}
                                        -
                                        {{ substr($event->end_time, 0, 5) }}
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

                    <div class="py-12 text-center">

                        <h4 class="font-semibold text-slate-800">
                            Belum ada agenda
                        </h4>

                        <p class="mt-2 text-sm text-slate-500">
                            Belum ada agenda sekolah yang disetujui.
                        </p>

                    </div>

                @endforelse

            </div>

        </section>

    </main>

</body>

</html>