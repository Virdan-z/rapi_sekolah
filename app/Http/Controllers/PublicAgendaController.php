<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PublicAgendaController extends Controller
{
    public function index(Request $request)
    {
        // Menentukan bulan kalender
        $selectedMonth = Carbon::now()->startOfMonth();

        $monthInput = $request->query('month');

        if (
            is_string($monthInput) &&
            preg_match('/^\d{4}-\d{2}$/', $monthInput)
        ) {
            $year = (int) substr($monthInput, 0, 4);
            $month = (int) substr($monthInput, 5, 2);

            if (checkdate($month, 1, $year)) {
                $selectedMonth = Carbon::create(
                    $year,
                    $month,
                    1
                )->startOfMonth();
            }
        }

        // Agenda mendatang yang sudah disetujui
        $events = Event::with(['room', 'user'])
            ->where('status', 'disetujui')
            ->whereDate('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->get();

        // Mengambil agenda sesuai bulan yang dipilih
        $startDate = $selectedMonth
            ->copy()
            ->startOfMonth()
            ->toDateString();

        $endDate = $selectedMonth
            ->copy()
            ->endOfMonth()
            ->toDateString();

        $calendarEvents = Event::with('room')
            ->where('status', 'disetujui')
            ->whereBetween('event_date', [
                $startDate,
                $endDate,
            ])
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->get();

        // Mengelompokkan agenda berdasarkan tanggal
        $eventsByDate = $calendarEvents->groupBy(function ($event) {
            return Carbon::parse($event->event_date)->toDateString();
        });

        // Daftar hari libur nasional Indonesia tahun 2026
        $nationalHolidays = [
            '2026-01-01' => 'Tahun Baru 2026',
            '2026-01-16' => 'Isra Mikraj Nabi Muhammad SAW',
            '2026-02-17' => 'Tahun Baru Imlek',
            '2026-03-19' => 'Hari Suci Nyepi',
            '2026-03-21' => 'Idulfitri',
            '2026-03-22' => 'Idulfitri',
            '2026-04-03' => 'Wafat Yesus Kristus',
            '2026-04-05' => 'Paskah',
            '2026-05-01' => 'Hari Buruh Internasional',
            '2026-05-14' => 'Kenaikan Yesus Kristus',
            '2026-05-27' => 'Iduladha',
            '2026-05-31' => 'Hari Raya Waisak',
            '2026-06-01' => 'Hari Lahir Pancasila',
            '2026-06-16' => 'Tahun Baru Islam',
            '2026-08-17' => 'Hari Kemerdekaan RI',
            '2026-08-25' => 'Maulid Nabi Muhammad SAW',
            '2026-12-25' => 'Hari Raya Natal',
        ];

        // Mengambil data ruangan
        $rooms = Room::orderBy('name')->get();

        return view('public.agenda', compact(
            'events',
            'rooms',
            'selectedMonth',
            'calendarEvents',
            'eventsByDate',
            'nationalHolidays'
        ));
    }
}