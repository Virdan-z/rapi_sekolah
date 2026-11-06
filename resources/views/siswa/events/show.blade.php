<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Detail Agenda - RAPI Sekolah</title>

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
                            "
                        >
                            Logout
                        </button>
                    </form>

                </div>

            </div>

        </div>

    </nav>


    <main class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">

        <div class="mb-6">

            <a
                href="{{ route('siswa.events.index') }}"
                class="
                    text-sm
                    font-medium
                    text-cyan-700
                    hover:text-cyan-800
                "
            >
                Kembali ke Daftar Agenda
            </a>

        </div>


        <section
            class="
                overflow-hidden
                rounded-3xl
                border
                border-slate-200
                bg-white
                shadow-sm
            "
        >

            <div
                class="
                    bg-gradient-to-r
                    from-cyan-600
                    via-sky-600
                    to-blue-600
                    p-8
                    text-white
                "
            >

                <p class="mb-2 text-sm font-medium text-cyan-100">
                    Detail Agenda
                </p>

                <h2 class="text-3xl font-bold">
                    {{ $event->title }}
                </h2>

                <div class="mt-4">

                    <span
                        class="
                            inline-flex
                            rounded-full
                            bg-white/20
                            px-3
                            py-1
                            text-xs
                            font-semibold
                        "
                    >
                        Disetujui
                    </span>

                </div>

            </div>


            <div class="p-8">

                <div
                    class="
                        mb-8
                        grid
                        grid-cols-1
                        gap-5
                        md:grid-cols-2
                    "
                >

                    <div
                        class="
                            rounded-2xl
                            border
                            border-slate-200
                            bg-slate-50
                            p-5
                        "
                    >
                        <p class="text-sm text-slate-500">
                            Ruangan
                        </p>

                        <p class="mt-2 font-semibold text-slate-900">
                            {{ $event->room->name ?? '-' }}
                        </p>
                    </div>


                    <div
                        class="
                            rounded-2xl
                            border
                            border-slate-200
                            bg-slate-50
                            p-5
                        "
                    >
                        <p class="text-sm text-slate-500">
                            Lokasi
                        </p>

                        <p class="mt-2 font-semibold text-slate-900">
                            {{ $event->room->location ?? '-' }}
                        </p>
                    </div>


                    <div
                        class="
                            rounded-2xl
                            border
                            border-slate-200
                            bg-slate-50
                            p-5
                        "
                    >
                        <p class="text-sm text-slate-500">
                            Tanggal
                        </p>

                        <p class="mt-2 font-semibold text-slate-900">
                            {{ \Carbon\Carbon::parse(
                                $event->event_date
                            )->format('d-m-Y') }}
                        </p>
                    </div>


                    <div
                        class="
                            rounded-2xl
                            border
                            border-slate-200
                            bg-slate-50
                            p-5
                        "
                    >
                        <p class="text-sm text-slate-500">
                            Waktu
                        </p>

                        <p class="mt-2 font-semibold text-slate-900">
                            {{ substr($event->start_time, 0, 5) }}
                            -
                            {{ substr($event->end_time, 0, 5) }}
                        </p>
                    </div>

                </div>


                <div class="mb-8">

                    <h3 class="mb-3 text-lg font-bold text-slate-900">
                        Deskripsi
                    </h3>

                    <div
                        class="
                            rounded-2xl
                            border
                            border-slate-200
                            bg-slate-50
                            p-5
                            text-slate-700
                        "
                    >
                        {{ $event->description ?: 'Tidak ada deskripsi.' }}
                    </div>

                </div>


                <div
                    class="
                        grid
                        grid-cols-1
                        gap-5
                        md:grid-cols-2
                    "
                >

                    <div
                        class="
                            rounded-2xl
                            border
                            border-slate-200
                            p-5
                        "
                    >
                        <p class="text-sm text-slate-500">
                            Penanggung Jawab Ruangan
                        </p>

                        <p class="mt-2 font-semibold text-slate-900">
                            {{ $event->room->pic->name ?? 'Belum ditentukan' }}
                        </p>
                    </div>


                    <div
                        class="
                            rounded-2xl
                            border
                            border-slate-200
                            p-5
                        "
                    >
                        <p class="text-sm text-slate-500">
                            Pengaju Agenda
                        </p>

                        <p class="mt-2 font-semibold text-slate-900">
                            {{ $event->user->name ?? '-' }}
                        </p>
                    </div>

                </div>

            </div>

        </section>

    </main>

</body>

</html>