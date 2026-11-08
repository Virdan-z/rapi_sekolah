@extends('layouts.rapi')

@section('title', 'Pengaduan Kerusakan')

@section('page-title', 'Daftar Pengaduan Kerusakan')

@section('breadcrumb', 'Admin / Pengaduan / Daftar')

@section('content')

<main class="max-w-7xl mx-auto px-6 py-8">

    {{-- SUCCESS ALERT --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-5 py-4 mb-6">
            <p class="font-semibold">Berhasil</p>
            <p class="text-sm mt-1">{{ session('success') }}</p>
        </div>
    @endif

    {{-- STATISTIK RINGKAS --}}
    <section class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white border border-slate-200 border-l-4 border-l-green-500 rounded-xl p-5 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-wider text-green-600">Total Pengaduan</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">{{ method_exists($complaints, 'total') ? $complaints->total() : $complaints->count() }}</p>
            <p class="text-sm text-slate-500 mt-1">Semua laporan kerusakan</p>
        </div>
        <div class="bg-white border border-slate-200 border-l-4 border-l-yellow-500 rounded-xl p-5 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-wider text-yellow-600">Pending / Menunggu</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">
                {{ $complaints->where('status', 'pending')->count() }}
            </p>
            <p class="text-sm text-slate-500 mt-1">Belum ditangani</p>
        </div>
        <div class="bg-white border border-slate-200 border-l-4 border-l-emerald-500 rounded-xl p-5 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-wider text-emerald-600">Selesai / Diperbaiki</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">
                {{ $complaints->where('status', 'selesai')->count() }}
            </p>
            <p class="text-sm text-slate-500 mt-1">Kerusakan telah beres</p>
        </div>
    </section>

    {{-- TABLE CARD --}}
    <section class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-slate-900">Data Pengaduan Kerusakan</h3>
                <p class="text-sm text-slate-500 mt-1">Daftar laporan kerusakan fasilitas atau ruangan sekolah.</p>
            </div>
            
            {{-- TOMBOL TAMBAH PENGADUAN --}}
            <a href="{{ route('admin.complaints.create') }}"
               class="inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-sm transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Pengaduan
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">No</th>
                        <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Pelapor</th>
                        <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Ruangan / Fasilitas</th>
                        <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Kerusakan</th>
                        <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Status & Keterangan</th>
                        <th class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($complaints as $complaint)
                        <tr class="hover:bg-slate-50 transition">
                            {{-- NO (Menyesuaikan Pagination) --}}
                            <td class="px-5 py-5">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-slate-100 text-slate-600 rounded-lg text-sm font-semibold">
                                    {{ method_exists($complaints, 'firstItem') ? $complaints->firstItem() + $loop->index : $loop->iteration }}
                                </span>
                            </td>

                            {{-- PELAPOR --}}
                            <td class="px-5 py-5 min-w-[160px]">
                                <p class="font-semibold text-slate-900">{{ $complaint->user->name ?? '-' }}</p>
                                <p class="text-xs text-slate-400 mt-1">{{ $complaint->user->email ?? '-' }}</p>
                            </td>

                            {{-- RUANGAN --}}
                            <td class="px-5 py-5 min-w-[150px]">
                                <span class="inline-flex bg-green-50 border border-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $complaint->room->name ?? 'Fasilitas Umum' }}
                                </span>
                            </td>

                            {{-- KERUSAKAN --}}
                            <td class="px-5 py-5 min-w-[220px]">
                                <p class="font-semibold text-slate-900">{{ $complaint->title ?? 'Kerusakan Fasilitas' }}</p>
                                <p class="text-xs text-slate-500 mt-1 leading-5">
                                    {{ \Illuminate\Support\Str::limit($complaint->description, 60) }}
                                </p>
                            </td>

                            {{-- STATUS & KETERANGAN --}}
                            <td class="px-5 py-5 min-w-[180px]">
                                @if($complaint->status === 'selesai')
                                    <span class="inline-flex bg-emerald-50 border border-emerald-200 text-emerald-700 px-3 py-1 rounded-full text-xs font-semibold mb-2">
                                        Selesai Diperbaiki
                                    </span>
                                @else
                                    <span class="inline-flex bg-yellow-50 border border-yellow-200 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold mb-2">
                                        Pending / Diproses
                                    </span>
                                @endif

                                @if($complaint->repair_note)
                                    <p class="text-xs text-slate-600 mt-1 bg-slate-50 border border-slate-200 p-2 rounded-lg">
                                        <span class="font-semibold text-slate-700">Catatan Perbaikan:</span> {{ $complaint->repair_note }}
                                    </p>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td class="px-5 py-5 text-center">
                                <a href="{{ route('admin.complaints.show', $complaint) }}"
                                   class="inline-flex justify-center bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-2 rounded-lg text-xs font-semibold transition">
                                    Kelola / Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <p class="text-lg font-semibold text-slate-700">Belum Ada Pengaduan Kerusakan</p>
                                <p class="text-sm text-slate-500 mt-1">Belum ada laporan kerusakan yang dikirimkan ke sistem.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION LINK --}}
        @if(method_exists($complaints, 'hasPages') && $complaints->hasPages())
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                {{ $complaints->links() }}
            </div>
        @endif
    </section>

</main>

@endsection