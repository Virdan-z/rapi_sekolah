@extends('layouts.rapi')

@section('title', 'Laporan Pengaduan')
@section('page-title', 'Laporan Pengaduan')
@section('breadcrumb', 'Laporan Pengaduan')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Laporan Pengaduan
            </h2>

            <p class="text-gray-500 text-sm mt-1">
                Rekap dan laporan seluruh pengaduan fasilitas sekolah.
            </p>
        </div>

        <div class="flex flex-wrap gap-2">

            <a href="{{ route('admin.complaint-reports.print', request()->query()) }}"
               target="_blank"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">
                Cetak PDF
            </a>

            <a href="{{ route('admin.complaint-reports.export', request()->query()) }}"
               class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium">
                Export Excel
            </a>

        </div>
    </div>


    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

        <div class="bg-white p-5 rounded-xl shadow-sm border">
            <p class="text-sm text-gray-500">Total Pengaduan</p>

            <h3 class="text-3xl font-bold text-gray-800 mt-2">
                {{ $totalPengaduan }}
            </h3>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border">
            <p class="text-sm text-gray-500">Dilaporkan</p>

            <h3 class="text-3xl font-bold text-red-600 mt-2">
                {{ $totalDilaporkan }}
            </h3>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border">
            <p class="text-sm text-gray-500">Diproses</p>

            <h3 class="text-3xl font-bold text-yellow-600 mt-2">
                {{ $totalDiproses }}
            </h3>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border">
            <p class="text-sm text-gray-500">Selesai</p>

            <h3 class="text-3xl font-bold text-green-600 mt-2">
                {{ $totalSelesai }}
            </h3>
        </div>

    </div>


    {{-- FILTER --}}
    <div class="bg-white p-5 rounded-xl shadow-sm border">

        <h3 class="font-semibold text-gray-800 mb-4">
            Filter Laporan
        </h3>

        <form action="{{ route('admin.complaint-reports.index') }}"
              method="GET"
              class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Tanggal Mulai
                </label>

                <input type="date"
                       name="tanggal_mulai"
                       value="{{ request('tanggal_mulai') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Tanggal Akhir
                </label>

                <input type="date"
                       name="tanggal_akhir"
                       value="{{ request('tanggal_akhir') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Status
                </label>

                <select name="status"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">

                    <option value="">Semua Status</option>

                    <option value="dilaporkan" @selected(request('status') == 'dilaporkan')>
                        Dilaporkan
                    </option>

                    <option value="diproses" @selected(request('status') == 'diproses')>
                        Diproses
                    </option>

                    <option value="selesai" @selected(request('status') == 'selesai')>
                        Selesai
                    </option>

                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Pencarian
                </label>

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Judul atau nama pelapor"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>

            <div class="flex items-end gap-2">

                <button type="submit"
                        class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                    Cari
                </button>

                <a href="{{ route('admin.complaint-reports.index') }}"
                   class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm">
                    Reset
                </a>

            </div>

        </form>

    </div>


    {{-- TABEL LAPORAN --}}
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

        <div class="p-5 border-b">
            <h3 class="font-semibold text-gray-800">
                Data Laporan Pengaduan
            </h3>

            <p class="text-sm text-gray-500 mt-1">
                Total data ditemukan: {{ $complaints->total() }} pengaduan
            </p>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left">

                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-5 py-4">No</th>
                        <th class="px-5 py-4">Tanggal</th>
                        <th class="px-5 py-4">Judul Pengaduan</th>
                        <th class="px-5 py-4">Pelapor</th>
                        <th class="px-5 py-4">Ruangan</th>
                        <th class="px-5 py-4">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse ($complaints as $index => $complaint)

                        <tr class="hover:bg-gray-50">

                            <td class="px-5 py-4">
                                {{ $complaints->firstItem() + $index }}
                            </td>

                            <td class="px-5 py-4 whitespace-nowrap">
                                {{ $complaint->created_at?->format('d/m/Y') }}
                            </td>

                            <td class="px-5 py-4 font-medium text-gray-800">
                                {{ $complaint->title }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $complaint->user?->name ?? '-' }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $complaint->room?->name ?? '-' }}
                            </td>

                            <td class="px-5 py-4">

                                @php
                                    $statusClass = match ($complaint->status) {
                                        'dilaporkan' => 'bg-red-100 text-red-700',
                                        'diproses' => 'bg-yellow-100 text-yellow-700',
                                        'selesai' => 'bg-green-100 text-green-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp

                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                    {{ ucfirst($complaint->status) }}
                                </span>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6"
                                class="px-5 py-10 text-center text-gray-500">

                                Belum ada data pengaduan.

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        <div class="p-5 border-t">
            {{ $complaints->links() }}
        </div>

    </div>

</div>

@endsection