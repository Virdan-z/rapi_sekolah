@extends('layouts.rapi')

@section('title', 'Laporan Sistem')

@section('page-title', 'Laporan & Rekapitulasi')

@section('breadcrumb', 'Admin / Laporan')

@section('content')

<main class="max-w-7xl mx-auto px-6 py-8">

    {{-- HEADER DAN TOMBOL CETAK PDF --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Rekapitulasi Sistem</h2>
            <p class="text-sm text-slate-500">Data rekapitulasi pengaduan dan penggunaan ruangan (agenda).</p>
        </div>
        
        <button onclick="window.print()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-sm transition inline-flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Cetak / Simpan PDF
        </button>
    </div>

    {{-- FILTER FORM --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 mb-8">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Ruangan</label>
                <select name="room_id" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Semua Ruangan --</option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}" {{ request('room_id') == $room->id ? 'selected' : '' }}>
                            {{ $room->name }} 
                            @if($room->pics->isNotEmpty())
                                [PIC: {{ $room->pics->pluck('name')->implode(', ') }}]
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Status Pengaduan</label>
                <select name="status" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Semua Status --</option>
                    <option value="dilaporkan" {{ request('status') == 'dilaporkan' ? 'selected' : '' }}>Dilaporkan</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full border border-slate-300 rounded-xl px-4 py-2 outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2.5 rounded-xl shadow-sm transition">
                    Filter
                </button>
                <a href="{{ route('admin.reports.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-4 py-2.5 rounded-xl transition text-center">
                    Reset
                </a>
            </div>

        </form>
    </div>

    {{-- TABEL LAPORAN PENGADUAN --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-8">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-900">Rekapitulasi Pengaduan Kerusakan Ruangan</h3>
            <span class="text-sm bg-blue-50 text-blue-700 font-medium px-3 py-1 rounded-full">Total: {{ $complaints->count() }} Data</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-700 text-xs uppercase font-semibold">
                    <tr>
                        <th class="px-6 py-3">No</th>
                        <th class="px-6 py-3">Ruangan & PIC</th>
                        <th class="px-6 py-3">Judul Pengaduan</th>
                        <th class="px-6 py-3">Pelapor</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                    @forelse ($complaints as $c)
                        <tr>
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-medium text-slate-900">
                                {{ $c->room->name ?? '-' }}
                                <div class="text-xs text-slate-400 font-normal">
                                    PIC: {{ $c->room->pics->pluck('name')->implode(', ') ?: 'Tanpa PIC' }}
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $c->title }}</td>
                            <td class="px-6 py-4">{{ $c->user->name ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold 
                                    {{ $c->status == 'selesai' ? 'bg-green-100 text-green-700' : ($c->status == 'diproses' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                                    {{ ucfirst($c->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $c->created_at->format('d-m-Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400">Tidak ada data pengaduan yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- TABEL LAPORAN AGENDA --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-900">Rekapitulasi Penggunaan Ruangan (Agenda)</h3>
            <span class="text-sm bg-blue-50 text-blue-700 font-medium px-3 py-1 rounded-full">Total: {{ $events->count() }} Data</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-700 text-xs uppercase font-semibold">
                    <tr>
                        <th class="px-6 py-3">No</th>
                        <th class="px-6 py-3">Agenda</th>
                        <th class="px-6 py-3">Ruangan & PIC</th>
                        <th class="px-6 py-3">Tanggal & Sesi</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                    @forelse ($events as $e)
                        <tr>
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $e->title }}</td>
                            <td class="px-6 py-4">
                                {{ $e->room->name ?? '-' }}
                                <div class="text-xs text-slate-400 font-normal">
                                    PIC: {{ $e->room->pics->pluck('name')->implode(', ') ?: 'Tanpa PIC' }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($e->event_date)->format('d-m-Y') }}
                                <div class="text-xs text-slate-400">{{ substr($e->start_time, 0, 5) }} - {{ substr($e->end_time, 0, 5) }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold 
                                    {{ $e->status == 'disetujui' ? 'bg-green-100 text-green-700' : ($e->status == 'diajukan' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                                    {{ ucfirst($e->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-400">Tidak ada data agenda yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</main>

@endsection

@push('styles')
<style>
@media print {
    /* Sembunyikan sidebar, navbar, form filter, dan tombol cetak saat dicetak */
    .sidebar, .topbar, form, button, .page-footer, a[href] {
        display: none !important;
    }

    /* Sesuaikan tata letak halaman cetak */
    .main-area {
        margin-left: 0 !important;
    }

    .page-container {
        padding: 0 !important;
        max-width: 100% !important;
    }

    body {
        background: white !important;
        color: black !important;
    }

    table {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 20px !important;
    }

    th, td {
        border: 1px solid #94a3b8 !important;
        padding: 6px 8px !important;
    }
}
</style>
@endpush