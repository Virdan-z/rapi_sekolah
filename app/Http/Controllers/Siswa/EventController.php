<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Menampilkan agenda yang sudah disetujui.
     */
    public function index()
    {
        $events = Event::with([
                'room.pic',
                'user',
            ])
            ->where('status', 'disetujui')
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->get();

        return view(
            'siswa.events.index',
            compact('events')
        );
    }


    /**
     * Menampilkan detail agenda.
     */
    public function show(Event $event)
    {
        if ($event->status !== 'disetujui') {
            abort(404, 'Agenda tidak tersedia.');
        }

        $event->load([
            'room.pic',
            'user',
        ]);

        return view(
            'siswa.events.show',
            compact('event')
        );
    }
}