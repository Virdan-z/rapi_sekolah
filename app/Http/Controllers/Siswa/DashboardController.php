<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Room;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard siswa.
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | TOTAL RUANGAN
        |--------------------------------------------------------------------------
        */

        $totalRooms = Room::count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL AGENDA DISETUJUI
        |--------------------------------------------------------------------------
        */

        $totalEvents = Event::where(
            'status',
            'disetujui'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | AGENDA HARI INI
        |--------------------------------------------------------------------------
        */

        $todayEvents = Event::with([
                'room',
                'user',
            ])
            ->where('status', 'disetujui')
            ->whereDate(
                'event_date',
                now()->toDateString()
            )
            ->orderBy('start_time')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | AGENDA MENDATANG
        |--------------------------------------------------------------------------
        */

        $upcomingEvents = Event::with([
                'room.pic',
                'user',
            ])
            ->where('status', 'disetujui')
            ->whereDate(
                'event_date',
                '>=',
                now()->toDateString()
            )
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA KE VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'siswa.dashboard',
            compact(
                'totalRooms',
                'totalEvents',
                'todayEvents',
                'upcomingEvents'
            )
        );
    }
}