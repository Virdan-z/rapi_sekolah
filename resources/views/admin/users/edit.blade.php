@extends('layouts.rapi')

@section('title', 'Edit Pengguna')

@section('page-title', 'Edit Pengguna')

@section('breadcrumb', 'Admin / Kelola Pengguna / Edit')

@section('content')

<main class="max-w-4xl mx-auto px-6 py-8">

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">

        {{-- Header Form --}}
        <div class="mb-6">
            <h1 class="text-xl font-bold text-gray-800">
                Form Edit Pengguna
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Ubah informasi akun pengguna {{ $user->name }}.
            </p>
        </div>

        {{-- Form Edit Pengguna --}}
        <form action="{{ route('admin.users.update', $user) }}"
              method="POST">

            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div class="mb-5">
                <label for="name"
                       class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >

                @error('name')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-5">
                <label for="email"
                       class="block text-sm font-semibold text-gray-700 mb-2">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >

                @error('email')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- No Telepon --}}
            <div class="mb-5">
                <label for="phone"
                       class="block text-sm font-semibold text-gray-700 mb-2">
                    No. Telepon
                </label>

                <input
                    type="text"
                    id="phone"
                    name="phone"
                    value="{{ old('phone', $user->phone) }}"
                    placeholder="Contoh: 081234567890"
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >

                @error('phone')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Role --}}
            <div class="mb-5">
                <label for="role"
                       class="block text-sm font-semibold text-gray-700 mb-2">
                    Role
                </label>

                <select
                    id="role"
                    name="role"
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                    <option value="admin"
                        {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>

                    <option value="guru"
                        {{ old('role', $user->role) === 'guru' ? 'selected' : '' }}>
                        Guru
                    </option>

                    <option value="pic"
                        {{ old('role', $user->role) === 'pic' ? 'selected' : '' }}>
                        PIC
                    </option>

                    <option value="siswa"
                        {{ old('role', $user->role) === 'siswa' ? 'selected' : '' }}>
                        Siswa
                    </option>

                </select>

                @error('role')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-5">
                <label for="password"
                       class="block text-sm font-semibold text-gray-700 mb-2">
                    Password Baru
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Kosongkan jika tidak ingin mengubah password"
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >

                <p class="text-xs text-gray-500 mt-1">
                    Isi hanya jika ingin mengganti password.
                </p>

                @error('password')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="mb-7">
                <label for="password_confirmation"
                       class="block text-sm font-semibold text-gray-700 mb-2">
                    Konfirmasi Password Baru
                </label>

                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Ulangi password baru"
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >
            </div>

            {{-- Tombol --}}
            <div class="flex flex-wrap items-center gap-3">

                <a href="{{ route('admin.users.index') }}"
                   class="px-5 py-2.5 rounded-xl bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300 transition">
                    Kembali
                </a>

                <a href="{{ route('admin.users.show', $user) }}"
                   class="px-5 py-2.5 rounded-xl bg-blue-100 text-blue-700 font-semibold hover:bg-blue-200 transition">
                    Batal
                </a>

                <button
                    type="submit"
                    class="px-5 py-2.5 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</main>

@endsection