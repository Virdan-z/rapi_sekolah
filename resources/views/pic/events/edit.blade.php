@extends('layouts.rapi')

@section('title', 'Agenda')

@section('page-title', 'Edit Agenda')

@section('breadcrumb', 'PIC / Agenda / Edit')

@section('content')

<main class="max-w-6xl mx-auto px-6 py-8">

    {{-- ERRORS --}}
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-5 py-4 mb-6">
            <p class="font-semibold">
                Data belum dapat disimpan
            </p>
            <ul class="list-disc list-inside text-sm mt-2 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- MAIN GRID --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- DETAIL AGENDA --}}
            <section class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-900">
                        Informasi Agenda
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Periksa detail pengajuan sebelum memberikan keputusan.
                    </p>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        {{-- ROOM --}}
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">
                            <p class="text-xs font-bold uppercase tracking-wider text-green-600">
                                Ruangan
                            </p>
                            <p class="font-bold text-slate-900 mt-2">
                                {{ $event->room->name ?? '-' }}
                            </p>
                            <p class="text-sm text-slate-500 mt-1">
                                {{ $event->room->location ?? '-' }}
                            </p>
                        </div>

                        {{-- PENGAJU --}}
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">
                            <p class="text-xs font-bold uppercase tracking-wider text-emerald-600">
                                Pengaju
                            </p>
                            <p class="font-bold text-slate-900 mt-2">
                                {{ $event->user->name ?? '-' }}
                            </p>
                            <p class="text-sm text-slate-500 mt-1">
                                {{ $event->user->email ?? '-' }}
                            </p>
                        </div>

                        {{-- DATE (Mendukung Multi-day) --}}
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">
                            <p class="text-xs font-bold uppercase tracking-wider text-teal-600">
                                Tanggal
                            </p>
                            <p class="font-bold text-slate-900 mt-2">
                                {{ \Carbon\Carbon::parse($event->event_date)->format('d-m-Y') }}
                                @if (!empty($event->end_date) && $event->end_date !== $event->event_date)
                                    <br><span class="text-xs text-slate-500 font-normal">s/d {{ \Carbon\Carbon::parse($event->end_date)->format('d-m-Y') }}</span>
                                @endif
                            </p>
                            <p class="text-sm text-slate-500 mt-1">
                                Tanggal kegiatan
                            </p>
                        </div>

                        {{-- TIME --}}
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">
                            <p class="text-xs font-bold uppercase tracking-wider text-green-600">
                                Waktu
                            </p>
                            <p class="font-bold text-slate-900 mt-2">
                                {{ substr($event->start_time, 0, 5) }} - {{ substr($event->end_time, 0, 5) }}
                            </p>
                            <p class="text-sm text-slate-500 mt-1">
                                Waktu penggunaan ruangan
                            </p>
                        </div>

                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="mt-6">
                        <p class="text-sm font-semibold text-slate-700 mb-2">
                            Deskripsi Agenda
                        </p>
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">
                            <p class="text-slate-700 leading-7 whitespace-pre-line">{{ $event->description ?: 'Tidak ada deskripsi.' }}</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- MOVE REASON --}}
            @if($event->move_reason)
                <section class="bg-white border border-violet-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-5 bg-violet-50 border-b border-violet-100">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div>
                                <h3 class="text-lg font-bold text-violet-900">
                                    Informasi Pemindahan Agenda
                                </h3>
                                <p class="text-sm text-violet-700 mt-1">
                                    Admin telah mengubah ruangan atau jadwal agenda.
                                </p>
                            </div>
                            <span class="inline-flex self-start sm:self-auto bg-violet-100 border border-violet-200 text-violet-700 px-3 py-1 rounded-full text-xs font-semibold">
                                Dipindahkan
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-xs font-bold uppercase tracking-wider text-violet-500">
                            Alasan Pemindahan
                        </p>
                        <div class="bg-violet-50 border border-violet-100 rounded-xl p-5 mt-3">
                            <p class="text-violet-800 leading-7 whitespace-pre-line">{{ $event->move_reason }}</p>
                        </div>
                    </div>
                </section>
            @endif

            {{-- FORM --}}
            <section class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-900">
                        Keputusan PIC
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Tentukan status agenda dan berikan catatan kepada pengaju.
                    </p>
                </div>

                <form action="{{ route('pic.events.update', $event) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    {{-- STATUS --}}
                    <div class="mb-6">
                        <label for="status" class="block text-sm font-semibold text-slate-700 mb-2">
                            Status Agenda
                        </label>
                        <select id="status" name="status" required
                            class="w-full border border-slate-300 bg-white text-slate-800 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                            <option value="diajukan" {{ old('status', $event->status) === 'diajukan' ? 'selected' : '' }}>
                                Diajukan
                            </option>
                            <option value="disetujui" {{ old('status', $event->status) === 'disetujui' ? 'selected' : '' }}>
                                Disetujui
                            </option>
                            <option value="ditolak" {{ old('status', $event->status) === 'ditolak' ? 'selected' : '' }}>
                                Ditolak
                            </option>
                        </select>
                        @error('status')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- STATUS GUIDE --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-6">
                        <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-4">
                            <p class="text-sm font-semibold text-yellow-700">Diajukan</p>
                            <p class="text-xs text-yellow-600 mt-1 leading-5">Pengajuan masih menunggu keputusan PIC.</p>
                        </div>
                        <div class="bg-green-50 border border-green-100 rounded-xl p-4">
                            <p class="text-sm font-semibold text-green-700">Disetujui</p>
                            <p class="text-xs text-green-600 mt-1 leading-5">Ruangan dapat digunakan sesuai jadwal.</p>
                        </div>
                        <div class="bg-red-50 border border-red-100 rounded-xl p-4">
                            <p class="text-sm font-semibold text-red-700">Ditolak</p>
                            <p class="text-xs text-red-600 mt-1 leading-5">Pengajuan tidak dapat disetujui.</p>
                        </div>
                    </div>

                    {{-- PIC NOTE --}}
                    <div>
                        <label for="pic_note" class="block text-sm font-semibold text-slate-700 mb-2">
                            Catatan PIC
                        </label>
                        <textarea id="pic_note" name="pic_note" rows="6" maxlength="2000"
                            placeholder="Contoh: Agenda disetujui. Pastikan ruangan dikembalikan dalam kondisi rapi."
                            class="w-full border border-slate-300 bg-white text-slate-800 placeholder-slate-400 rounded-xl px-4 py-3 outline-none resize-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">{{ old('pic_note', $event->pic_note) }}</textarea>

                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mt-2">
                            <p class="text-xs text-slate-400">Berikan alasan, informasi, atau catatan terkait keputusan agenda.</p>
                            <p class="text-xs text-slate-400">Maksimal 2000 karakter</p>
                        </div>

                        @error('pic_note')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ACTION --}}
                    <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3 mt-8 pt-6 border-t border-slate-100">
                        <a href="{{ route('pic.events.show', $event) }}"
                           class="inline-flex justify-center bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 rounded-lg text-sm font-semibold transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="inline-flex justify-center bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg text-sm font-semibold shadow-sm transition">
                            Simpan Keputusan
                        </button>
                    </div>
                </form>
            </section>

        </div>

        {{-- RIGHT --}}
        <div class="space-y-6">

            {{-- STATUS --}}
            <section class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100">
                    <h3 class="font-bold text-slate-900">Status Agenda</h3>
                    <p class="text-xs text-slate-500 mt-1">Kondisi pengajuan saat ini.</p>
                </div>
                <div class="p-5">
                    @if($event->status === 'disetujui')
                        <div class="bg-green-50 border border-green-200 rounded-xl p-5">
                            <span class="inline-flex bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Disetujui</span>
                            <p class="font-semibold text-green-800 mt-3">Agenda Telah Disetujui</p>
                            <p class="text-sm text-green-700 mt-1 leading-6">Ruangan dapat digunakan sesuai jadwal yang tertera.</p>
                        </div>
                    @elseif($event->status === 'ditolak')
                        <div class="bg-red-50 border border-red-200 rounded-xl p-5">
                            <span class="inline-flex bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">Ditolak</span>
                            <p class="font-semibold text-red-800 mt-3">Agenda Ditolak</p>
                            <p class="text-sm text-red-700 mt-1 leading-6">Pengajuan tidak disetujui. Berikan catatan agar pengaju mengetahui alasannya.</p>
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5">
                            <span class="inline-flex bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Diajukan</span>
                            <p class="font-semibold text-yellow-800 mt-3">Menunggu Keputusan</p>
                            <p class="text-sm text-yellow-700 mt-1 leading-6">Pengajuan masih menunggu pemeriksaan dari PIC.</p>
                        </div>
                    @endif
                </div>
            </section>

            {{-- ROOM --}}
            <section class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100">
                    <h3 class="font-bold text-slate-900">Informasi Ruangan</h3>
                </div>
                <div class="p-5">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Nama Ruangan</p>
                    <p class="font-bold text-slate-900 mt-1">{{ $event->room->name ?? '-' }}</p>

                    <div class="border-t border-slate-100 my-4"></div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Lokasi</p>
                    <p class="text-sm text-slate-700 mt-1">{{ $event->room->location ?? '-' }}</p>

                    @if($event->room?->capacity)
                        <div class="border-t border-slate-100 my-4"></div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Kapasitas</p>
                        <p class="text-sm font-semibold text-slate-700 mt-1">{{ $event->room->capacity }} orang</p>
                    @endif
                </div>
            </section>

            {{-- PENGAJU --}}
            <section class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100">
                    <h3 class="font-bold text-slate-900">Informasi Pengaju</h3>
                </div>
                <div class="p-5">
                    <p class="font-semibold text-slate-900">{{ $event->user->name ?? '-' }}</p>
                    <p class="text-sm text-slate-500 mt-1">{{ $event->user->email ?? '-' }}</p>

                    @if($event->user?->role)
                        <span class="inline-flex mt-3 bg-green-50 border border-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                            {{ ucfirst($event->user->role) }}
                        </span>
                    @endif
                </div>
            </section>

        </div>

    </div>

</main>

@endsection