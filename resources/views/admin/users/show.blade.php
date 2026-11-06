@extends('layouts.rapi')

@section('title', 'Detail Pengguna')

@section('page-title', 'Detail Pengguna')

@section('breadcrumb', 'Admin / Kelola Pengguna / Detail')

@section('content')

<main class="max-w-5xl mx-auto px-6 py-8">

    {{-- CARD DETAIL PENGGUNA --}}
    <section class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

        {{-- HEADER --}}
        <div class="bg-blue-600 px-6 py-8 text-white">

            <div class="flex flex-col sm:flex-row sm:items-center gap-5">

                {{-- FOTO / INISIAL --}}
                <div class="w-20 h-20 rounded-full
                            bg-white text-blue-600
                            flex items-center justify-center
                            text-3xl font-bold
                            shadow-sm">

                    {{ strtoupper(substr($user->name, 0, 1)) }}

                </div>

                {{-- IDENTITAS --}}
                <div>

                    <h1 class="text-2xl font-bold">
                        {{ $user->name }}
                    </h1>

                    <p class="text-blue-100 mt-1">
                        {{ $user->email }}
                    </p>

                    <div class="mt-3">

                        @if ($user->role === 'admin')

                            <span class="inline-flex px-3 py-1
                                         rounded-full text-xs
                                         font-semibold
                                         bg-purple-100 text-purple-700">
                                Admin
                            </span>

                        @elseif ($user->role === 'guru')

                            <span class="inline-flex px-3 py-1
                                         rounded-full text-xs
                                         font-semibold
                                         bg-blue-100 text-blue-700">
                                Guru
                            </span>

                        @elseif ($user->role === 'pic')

                            <span class="inline-flex px-3 py-1
                                         rounded-full text-xs
                                         font-semibold
                                         bg-green-100 text-green-700">
                                PIC
                            </span>

                        @elseif ($user->role === 'siswa')

                            <span class="inline-flex px-3 py-1
                                         rounded-full text-xs
                                         font-semibold
                                         bg-orange-100 text-orange-700">
                                Siswa
                            </span>

                        @else

                            <span class="inline-flex px-3 py-1
                                         rounded-full text-xs
                                         font-semibold
                                         bg-gray-100 text-gray-700">
                                {{ ucfirst($user->role) }}
                            </span>

                        @endif

                    </div>

                </div>

            </div>

        </div>


        {{-- INFORMASI PENGGUNA --}}
        <div class="p-6 md:p-8">

            <div class="mb-6">

                <h3 class="text-lg font-bold text-slate-900">
                    Informasi Pengguna
                </h3>

                <p class="text-sm text-slate-500 mt-1">
                    Informasi lengkap pengguna RAPI-Sekolah.
                </p>

            </div>


            {{-- GRID INFORMASI --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- NAMA --}}
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">

                    <p class="text-sm text-slate-500">
                        Nama Lengkap
                    </p>

                    <p class="font-semibold text-slate-800 mt-2">
                        {{ $user->name }}
                    </p>

                </div>


                {{-- EMAIL --}}
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">

                    <p class="text-sm text-slate-500">
                        Email
                    </p>

                    <p class="font-semibold text-slate-800 mt-2 break-all">
                        {{ $user->email }}
                    </p>

                </div>


                {{-- NOMOR TELEPON --}}
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">

                    <p class="text-sm text-slate-500">
                        No. Telepon
                    </p>

                    <p class="font-semibold text-slate-800 mt-2">
                        {{ $user->phone ?? '-' }}
                    </p>

                </div>


                {{-- ROLE --}}
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">

                    <p class="text-sm text-slate-500">
                        Role Pengguna
                    </p>

                    <div class="mt-2">

                        @if ($user->role === 'admin')

                            <span class="inline-flex px-3 py-1
                                         rounded-full text-xs
                                         font-semibold
                                         bg-purple-100 text-purple-700">
                                Admin
                            </span>

                        @elseif ($user->role === 'guru')

                            <span class="inline-flex px-3 py-1
                                         rounded-full text-xs
                                         font-semibold
                                         bg-blue-100 text-blue-700">
                                Guru
                            </span>

                        @elseif ($user->role === 'pic')

                            <span class="inline-flex px-3 py-1
                                         rounded-full text-xs
                                         font-semibold
                                         bg-green-100 text-green-700">
                                PIC
                            </span>

                        @elseif ($user->role === 'siswa')

                            <span class="inline-flex px-3 py-1
                                         rounded-full text-xs
                                         font-semibold
                                         bg-orange-100 text-orange-700">
                                Siswa
                            </span>

                        @else

                            <span class="inline-flex px-3 py-1
                                         rounded-full text-xs
                                         font-semibold
                                         bg-gray-100 text-gray-700">
                                {{ ucfirst($user->role) }}
                            </span>

                        @endif

                    </div>

                </div>


                {{-- TANGGAL DIBUAT --}}
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">

                    <p class="text-sm text-slate-500">
                        Dibuat Pada
                    </p>

                    <p class="font-semibold text-slate-800 mt-2">
                        {{ $user->created_at?->format('d M Y H:i') ?? '-' }}
                    </p>

                </div>


                {{-- TANGGAL DIPERBARUI --}}
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">

                    <p class="text-sm text-slate-500">
                        Terakhir Diperbarui
                    </p>

                    <p class="font-semibold text-slate-800 mt-2">
                        {{ $user->updated_at?->format('d M Y H:i') ?? '-' }}
                    </p>

                </div>

            </div>


            {{-- TOMBOL AKSI --}}
            <div class="flex flex-col sm:flex-row
                        flex-wrap gap-3
                        mt-8 pt-6
                        border-t border-slate-100">

                {{-- KEMBALI --}}
                <a href="{{ route('admin.users.index') }}"
                   class="inline-flex justify-center items-center
                          bg-slate-100 hover:bg-slate-200
                          text-slate-700
                          px-5 py-2.5
                          rounded-lg
                          text-sm font-semibold
                          transition">

                    Kembali

                </a>


                {{-- EDIT --}}
                <a href="{{ route('admin.users.edit', $user) }}"
                   class="inline-flex justify-center items-center
                          bg-blue-600 hover:bg-blue-700
                          text-white
                          px-5 py-2.5
                          rounded-lg
                          text-sm font-semibold
                          transition">

                    Edit Pengguna

                </a>


                {{-- HAPUS --}}
                @if ((int) auth()->id() !== (int) $user->id)

                    <form
                        action="{{ route('admin.users.destroy', $user) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="w-full inline-flex justify-center items-center
                                   bg-red-600 hover:bg-red-700
                                   text-white
                                   px-5 py-2.5
                                   rounded-lg
                                   text-sm font-semibold
                                   transition">

                            Hapus Pengguna

                        </button>

                    </form>

                @endif

            </div>

        </div>

    </section>


    {{-- INFORMASI BAWAH --}}
    <div class="mt-5
                bg-white
                border border-slate-200
                rounded-xl
                px-5 py-4">

        <p class="text-sm text-slate-500">
            Halaman ini menampilkan informasi lengkap pengguna
            yang terdaftar pada sistem RAPI-Sekolah.
        </p>

    </div>

</main>

@endsection