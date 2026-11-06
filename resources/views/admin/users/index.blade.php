@extends('layouts.rapi')

@section('title', 'Kelola Pengguna')

@section('page-title', 'Kelola Pengguna')

@section('breadcrumb', 'Admin / Kelola Pengguna / Daftar')

@section('content')



<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Data Pengguna - RAPI Sekolah</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body class="min-h-screen bg-slate-50">

    {{-- ===================================================== --}}

    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

      

        {{-- ================================================= --}}
        {{-- STATISTIK --}}
        {{-- ================================================= --}}

        

        {{-- ================================================= --}}
        {{-- ALERT --}}
        {{-- ================================================= --}}

        @if (session('success'))

            <div
                class="
                    mb-6
                    rounded-xl
                    border
                    border-emerald-200
                    bg-emerald-50
                    px-5
                    py-4
                    text-sm
                    font-medium
                    text-emerald-700
                "
            >
                {{ session('success') }}
            </div>

        @endif


        @if (session('error'))

            <div
                class="
                    mb-6
                    rounded-xl
                    border
                    border-red-200
                    bg-red-50
                    px-5
                    py-4
                    text-sm
                    font-medium
                    text-red-700
                "
            >
                {{ session('error') }}
            </div>

        @endif


        {{-- ================================================= --}}
        {{-- TABLE --}}
        {{-- ================================================= --}}

        <section
            class="
                overflow-hidden
                rounded-2xl
                border
                border-slate-200
                bg-white
                shadow-sm
            "
        >

            {{-- HEADER TABLE --}}
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
                        Daftar Pengguna
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Total {{ $users->count() }} pengguna terdaftar.
                    </p>

                </div>


                <a
                    href="{{ route('admin.users.create') }}"
                    class="
                        inline-flex
                        justify-center
                        rounded-xl
                        bg-blue-600
                        px-5
                        py-2.5
                        text-sm
                        font-semibold
                        text-white
                        shadow-sm
                        hover:bg-blue-700
                    "
                >
                    Tambah Pengguna
                </a>

            </div>


            {{-- TABLE WRAPPER --}}
            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="bg-slate-50">

                        <tr
                            class="
                                border-b
                                border-slate-200
                                text-left
                                text-xs
                                font-semibold
                                uppercase
                                tracking-wider
                                text-slate-500
                            "
                        >

                            <th class="px-6 py-4">
                                No
                            </th>

                            <th class="px-6 py-4">
                                Pengguna
                            </th>

                            <th class="px-6 py-4">
                                Email
                            </th>

                            <th class="px-6 py-4">
                                Role
                            </th>

                            <th class="px-6 py-4">
                                No. Telepon
                            </th>

                            <th class="px-6 py-4 text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse ($users as $user)

                            <tr
                                class="
                                    transition
                                    hover:bg-slate-50/80
                                "
                            >

                                {{-- NO --}}
                                <td
                                    class="
                                        whitespace-nowrap
                                        px-6
                                        py-5
                                        text-sm
                                        text-slate-500
                                    "
                                >
                                    {{ $loop->iteration }}
                                </td>


                                {{-- NAMA --}}
                                <td class="px-6 py-5">

                                    <div>

                                        <p
                                            class="
                                                font-semibold
                                                text-slate-900
                                            "
                                        >
                                            {{ $user->name }}
                                        </p>

                                        <p
                                            class="
                                                mt-1
                                                text-xs
                                                text-slate-400
                                            "
                                        >
                                            ID Pengguna:
                                            {{ $user->id }}
                                        </p>

                                    </div>

                                </td>


                                {{-- EMAIL --}}
                                <td
                                    class="
                                        px-6
                                        py-5
                                        text-sm
                                        text-slate-600
                                    "
                                >
                                    {{ $user->email }}
                                </td>


                                {{-- ROLE --}}
                                <td class="px-6 py-5">

                                    @if ($user->role === 'admin')

                                        <span
                                            class="
                                                inline-flex
                                                rounded-full
                                                bg-violet-100
                                                px-3
                                                py-1
                                                text-xs
                                                font-semibold
                                                text-violet-700
                                            "
                                        >
                                            Admin
                                        </span>

                                    @elseif ($user->role === 'guru')

                                        <span
                                            class="
                                                inline-flex
                                                rounded-full
                                                bg-blue-100
                                                px-3
                                                py-1
                                                text-xs
                                                font-semibold
                                                text-blue-700
                                            "
                                        >
                                            Guru
                                        </span>

                                    @elseif ($user->role === 'pic')

                                        <span
                                            class="
                                                inline-flex
                                                rounded-full
                                                bg-emerald-100
                                                px-3
                                                py-1
                                                text-xs
                                                font-semibold
                                                text-emerald-700
                                            "
                                        >
                                            PIC
                                        </span>

                                    @elseif ($user->role === 'siswa')

                                        <span
                                            class="
                                                inline-flex
                                                rounded-full
                                                bg-amber-100
                                                px-3
                                                py-1
                                                text-xs
                                                font-semibold
                                                text-amber-700
                                            "
                                        >
                                            Siswa
                                        </span>

                                    @else

                                        <span
                                            class="
                                                inline-flex
                                                rounded-full
                                                bg-slate-100
                                                px-3
                                                py-1
                                                text-xs
                                                font-semibold
                                                text-slate-600
                                            "
                                        >
                                            {{ ucfirst($user->role) }}
                                        </span>

                                    @endif

                                </td>


                                {{-- PHONE --}}
                                <td
                                    class="
                                        whitespace-nowrap
                                        px-6
                                        py-5
                                        text-sm
                                        text-slate-600
                                    "
                                >

                                    {{ $user->phone ?: '-' }}

                                </td>


                                {{-- ACTION --}}
                                <td class="px-6 py-5">

                                    <div
                                        class="
                                            flex
                                            flex-wrap
                                            justify-center
                                            gap-2
                                        "
                                    >

                                        {{-- SHOW --}}
                                        <a
                                            href="{{ route(
                                                'admin.users.show',
                                                $user
                                            ) }}"
                                            class="
                                                rounded-lg
                                                bg-blue-50
                                                px-3
                                                py-2
                                                text-xs
                                                font-semibold
                                                text-blue-700
                                                hover:bg-blue-100
                                            "
                                        >
                                            Lihat
                                        </a>


                                        {{-- EDIT --}}
                                        <a
                                            href="{{ route(
                                                'admin.users.edit',
                                                $user
                                            ) }}"
                                            class="
                                                rounded-lg
                                                bg-amber-50
                                                px-3
                                                py-2
                                                text-xs
                                                font-semibold
                                                text-amber-700
                                                hover:bg-amber-100
                                            "
                                        >
                                            Edit
                                        </a>


                                        {{-- DELETE --}}
                                        @if (auth()->id() !== $user->id)

                                            <form
                                                method="POST"
                                                action="{{ route(
                                                    'admin.users.destroy',
                                                    $user
                                                ) }}"
                                                onsubmit="
                                                    return confirm(
                                                        'Yakin ingin menghapus pengguna ini?'
                                                    )
                                                "
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="
                                                        rounded-lg
                                                        bg-red-50
                                                        px-3
                                                        py-2
                                                        text-xs
                                                        font-semibold
                                                        text-red-700
                                                        hover:bg-red-100
                                                    "
                                                >
                                                    Hapus
                                                </button>

                                            </form>

                                        @else

                                            <span
                                                class="
                                                    rounded-lg
                                                    bg-slate-100
                                                    px-3
                                                    py-2
                                                    text-xs
                                                    font-medium
                                                    text-slate-400
                                                "
                                            >
                                                Akun Aktif
                                            </span>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="
                                        px-6
                                        py-14
                                        text-center
                                    "
                                >

                                    <p
                                        class="
                                            font-semibold
                                            text-slate-700
                                        "
                                    >
                                        Belum ada pengguna
                                    </p>

                                    <p
                                        class="
                                            mt-2
                                            text-sm
                                            text-slate-500
                                        "
                                    >
                                        Tambahkan pengguna baru
                                        untuk mulai menggunakan sistem.
                                    </p>

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