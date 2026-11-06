@extends('layouts.rapi')

@section('title', 'Tambah Pengguna')

@section('page-title', 'Tambah Pengguna')

@section('breadcrumb', 'Admin / Kelola Pengguna / Tambah')

@section('content')



<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Tambah Pengguna - RAPI Sekolah</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body class="min-h-screen bg-slate-50">

   

    <main class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">

        

        {{-- ERROR VALIDATION --}}
        @if ($errors->any())

            <div
                class="
                    mb-6
                    rounded-2xl
                    border
                    border-red-200
                    bg-red-50
                    p-5
                "
            >

                <p class="font-semibold text-red-700">
                    Data belum dapat disimpan.
                </p>

                <ul
                    class="
                        mt-3
                        list-inside
                        list-disc
                        space-y-1
                        text-sm
                        text-red-600
                    "
                >

                    @foreach ($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- FORM --}}
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

            {{-- HEADER FORM --}}
            <div class="border-b border-slate-200 p-6">

                <h3 class="text-xl font-bold text-slate-900">
                    Form Tambah Pengguna
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Lengkapi data pengguna di bawah ini.
                </p>

            </div>


            <form
                action="{{ route('admin.users.store') }}"
                method="POST"
                autocomplete="off"
            >

                @csrf


                <div class="space-y-6 p-6 md:p-8">

                    {{-- NAMA --}}
                    <div>

                        <label
                            for="name"
                            class="
                                mb-2
                                block
                                text-sm
                                font-semibold
                                text-slate-700
                            "
                        >
                            Nama Pengguna
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            placeholder="Masukkan nama pengguna"
                            class="
                                w-full
                                rounded-xl
                                border
                                border-slate-300
                                bg-white
                                px-4
                                py-3
                                text-sm
                                text-slate-900
                                outline-none
                                transition
                                placeholder:text-slate-400
                                focus:border-blue-500
                                focus:ring-4
                                focus:ring-blue-100
                            "
                        >

                        @error('name')

                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- EMAIL --}}
                    <div>

                        <label
                            for="email"
                            class="
                                mb-2
                                block
                                text-sm
                                font-semibold
                                text-slate-700
                            "
                        >
                            Email
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="off"
                            placeholder="contoh@email.com"
                            class="
                                w-full
                                rounded-xl
                                border
                                border-slate-300
                                bg-white
                                px-4
                                py-3
                                text-sm
                                text-slate-900
                                outline-none
                                transition
                                placeholder:text-slate-400
                                focus:border-blue-500
                                focus:ring-4
                                focus:ring-blue-100
                            "
                        >

                        @error('email')

                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- PHONE --}}
                    <div>

                        <label
                            for="phone"
                            class="
                                mb-2
                                block
                                text-sm
                                font-semibold
                                text-slate-700
                            "
                        >
                            No. Telepon
                        </label>

                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="Contoh: 081234567890"
                            class="
                                w-full
                                rounded-xl
                                border
                                border-slate-300
                                bg-white
                                px-4
                                py-3
                                text-sm
                                text-slate-900
                                outline-none
                                transition
                                placeholder:text-slate-400
                                focus:border-blue-500
                                focus:ring-4
                                focus:ring-blue-100
                            "
                        >

                        @error('phone')

                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- ROLE --}}
                    <div>

                        <label
                            for="role"
                            class="
                                mb-2
                                block
                                text-sm
                                font-semibold
                                text-slate-700
                            "
                        >
                            Role
                        </label>

                        <select
                            id="role"
                            name="role"
                            required
                            class="
                                w-full
                                rounded-xl
                                border
                                border-slate-300
                                bg-white
                                px-4
                                py-3
                                text-sm
                                text-slate-900
                                outline-none
                                transition
                                focus:border-blue-500
                                focus:ring-4
                                focus:ring-blue-100
                            "
                        >

                            <option value="">
                                -- Pilih Role --
                            </option>

                            <option
                                value="admin"
                                {{ old('role') === 'admin' ? 'selected' : '' }}
                            >
                                Admin
                            </option>

                            <option
                                value="guru"
                                {{ old('role') === 'guru' ? 'selected' : '' }}
                            >
                                Guru
                            </option>

                            <option
                                value="pic"
                                {{ old('role') === 'pic' ? 'selected' : '' }}
                            >
                                PIC
                            </option>

                            <option
                                value="siswa"
                                {{ old('role') === 'siswa' ? 'selected' : '' }}
                            >
                                Siswa
                            </option>

                        </select>

                        @error('role')

                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- PASSWORD --}}
                    <div
                        class="
                            grid
                            grid-cols-1
                            gap-6
                            md:grid-cols-2
                        "
                    >

                        <div>

                            <label
                                for="password"
                                class="
                                    mb-2
                                    block
                                    text-sm
                                    font-semibold
                                    text-slate-700
                                "
                            >
                                Password
                            </label>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                autocomplete="new-password"
                                placeholder="Minimal 6 karakter"
                                class="
                                    w-full
                                    rounded-xl
                                    border
                                    border-slate-300
                                    bg-white
                                    px-4
                                    py-3
                                    text-sm
                                    text-slate-900
                                    outline-none
                                    transition
                                    placeholder:text-slate-400
                                    focus:border-blue-500
                                    focus:ring-4
                                    focus:ring-blue-100
                                "
                            >

                            @error('password')

                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- PASSWORD CONFIRMATION --}}
                        <div>

                            <label
                                for="password_confirmation"
                                class="
                                    mb-2
                                    block
                                    text-sm
                                    font-semibold
                                    text-slate-700
                                "
                            >
                                Konfirmasi Password
                            </label>

                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                placeholder="Ulangi password"
                                class="
                                    w-full
                                    rounded-xl
                                    border
                                    border-slate-300
                                    bg-white
                                    px-4
                                    py-3
                                    text-sm
                                    text-slate-900
                                    outline-none
                                    transition
                                    placeholder:text-slate-400
                                    focus:border-blue-500
                                    focus:ring-4
                                    focus:ring-blue-100
                                "
                            >

                        </div>

                    </div>


                    {{-- INFO --}}
                    <div
                        class="
                            rounded-xl
                            border
                            border-blue-100
                            bg-blue-50
                            px-5
                            py-4
                        "
                    >

                        <p class="text-sm font-semibold text-blue-800">
                            Hak Akses Pengguna
                        </p>

                        <p class="mt-1 text-sm leading-relaxed text-blue-700">
                            Admin mengelola seluruh sistem, Guru mengajukan
                            agenda dan pengaduan, PIC menangani ruangan,
                            sedangkan Siswa hanya melihat agenda yang
                            sudah disetujui.
                        </p>

                    </div>

                </div>


                {{-- FOOTER --}}
                <div
                    class="
                        flex
                        flex-col-reverse
                        gap-3
                        border-t
                        border-slate-200
                        bg-slate-50
                        px-6
                        py-5
                        sm:flex-row
                        sm:justify-end
                    "
                >

                    <a
                        href="{{ route('admin.users.index') }}"
                        class="
                            inline-flex
                            justify-center
                            rounded-xl
                            border
                            border-slate-300
                            bg-white
                            px-5
                            py-2.5
                            text-sm
                            font-semibold
                            text-slate-700
                            hover:bg-slate-100
                        "
                    >
                        Batal
                    </a>


                    <button
                        type="submit"
                        class="
                            inline-flex
                            justify-center
                            rounded-xl
                            bg-blue-600
                            px-6
                            py-2.5
                            text-sm
                            font-semibold
                            text-white
                            shadow-sm
                            hover:bg-blue-700
                        "
                    >
                        Simpan Pengguna
                    </button>

                </div>

            </form>

        </section>

    </main>

</body>

</html>
@endsection