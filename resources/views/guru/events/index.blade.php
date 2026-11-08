@extends('layouts.rapi')

@section('title', 'Agenda Guru')

@section('page-title', 'Agenda Guru')

@section('breadcrumb', 'Guru / Agenda')

@section('content')

<main class="max-w-7xl mx-auto px-6 py-8">

    <div class="bg-white rounded-2xl shadow border overflow-hidden">

        <div class="p-6 flex justify-between items-center flex-wrap gap-4">

            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Agenda Saya
                </h2>

                <p class="text-gray-500 text-sm mt-1">
                    Total: {{ $events->count() }}
                </p>
            </div>

            <a href="{{ route('guru.events.create') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-xl font-semibold">
                + Ajukan Agenda
            </a>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-50 text-gray-600 text-sm uppercase">

                    <tr>
                        <th class="px-6 py-4 text-left">No</th>
                        <th class="px-6 py-4 text-left">Agenda</th>
                        <th class="px-6 py-4 text-left">Ruangan</th>
                        <th class="px-6 py-4 text-left">Tanggal</th>
                        <th class="px-6 py-4 text-left">Waktu</th>
                        <th class="px-6 py-4 text-left">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($events as $event)

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-5">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-6 py-5">

                                <p class="font-semibold text-gray-800">
                                    {{ $event->title }}
                                </p>

                                {{-- Badge dipindahkan --}}
                                @if($event->move_reason)

                                    <div class="mt-2">

                                        <span class="inline-flex items-center gap-1
                                                     px-3 py-1 rounded-full
                                                     bg-orange-100 text-orange-700
                                                     text-xs font-semibold">
                                            🔄 Dipindahkan
                                        </span>

                                    </div>

                                    <p class="text-xs text-orange-600 mt-2 max-w-xs truncate">
                                        {{ $event->move_reason }}
                                    </p>

                                @endif

                            </td>

                            <td class="px-6 py-5">
                                {{ $event->room->name ?? '-' }}
                            </td>

                            {{-- Tanggal (Mendukung Multi-day) --}}
                            <td class="px-6 py-5 text-sm text-gray-600 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($event->event_date)->format('d-m-Y') }}
                                @if (!empty($event->end_date) && $event->end_date !== $event->event_date)
                                    <br><span class="text-xs text-gray-400">s/d {{ \Carbon\Carbon::parse($event->end_date)->format('d-m-Y') }}</span>
                                @endif
                            </td>

                            <td class="px-6 py-5">
                                {{ substr($event->start_time,0,5) }}
                                -
                                {{ substr($event->end_time,0,5) }}
                            </td>

                            <td class="px-6 py-5">

                                @if($event->status == 'disetujui')

                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                        Disetujui
                                    </span>

                                @elseif($event->status == 'ditolak')

                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                        Ditolak
                                    </span>

                                @else

                                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                                        Diajukan
                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-5 text-center">

                                <a href="{{ route('guru.events.show', $event) }}"
                                   class="inline-block bg-blue-100 hover:bg-blue-200
                                          text-blue-700 px-4 py-2 rounded-lg font-semibold text-sm">
                                    Lihat
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">

                                <div class="text-5xl mb-3">📅</div>

                                <p class="font-semibold">
                                    Belum ada agenda
                                </p>

                                <p class="text-sm mt-1">
                                    Silakan ajukan agenda baru.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</main>

@endsection