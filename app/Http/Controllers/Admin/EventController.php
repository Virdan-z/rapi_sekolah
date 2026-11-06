<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Room;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Daftar sesi agenda.
     */
    private function sessionSchedules()
    {
        return [
            '1' => [
                'start_time' => '08:00',
                'end_time' => '10:00',
            ],
            '2' => [
                'start_time' => '10:00',
                'end_time' => '12:00',
            ],
            '3' => [
                'start_time' => '13:00',
                'end_time' => '15:00',
            ],
        ];
    }

    /**
     * Menampilkan semua agenda.
     */
    public function index()
    {
        $events = Event::with([
            'room.pic',
            'user'
        ])
            ->latest()
            ->get();

        return view(
            'admin.events.index',
            compact('events')
        );
    }

    /**
     * Menampilkan form tambah agenda.
     */
    public function create()
    {
        $rooms = Room::with('pic')
            ->orderBy('name')
            ->get();

        return view(
            'admin.events.create',
            compact('rooms')
        );
    }

    /**
     * Menyimpan agenda baru.
     */
    public function store(Request $request)
    {
        $sessionSchedules = $this->sessionSchedules();

        $today = now('Asia/Jakarta')->toDateString();

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'title' => 'required|string|max:255',
            'event_date' => [
                'required',
                'date',
                'after_or_equal:' . $today,
            ],
            'session' => 'required|in:1,2,3',
            'description' => 'nullable|string|max:2000',
        ]);

        /*
        |--------------------------------------------------------------------------
        | MENENTUKAN JAM BERDASARKAN SESI
        |--------------------------------------------------------------------------
        */

        $selectedSession = $validated['session'];

        $validated['start_time'] =
            $sessionSchedules[$selectedSession]['start_time'];

        $validated['end_time'] =
            $sessionSchedules[$selectedSession]['end_time'];

        /*
        |--------------------------------------------------------------------------
        | CEK BENTROK JADWAL
        |--------------------------------------------------------------------------
        */

        $conflict = Event::where(
            'room_id',
            $validated['room_id']
        )
            ->where(
                'event_date',
                $validated['event_date']
            )
            ->whereIn(
                'status',
                ['diajukan', 'disetujui']
            )
            ->where(function ($query) use ($validated) {
                $query
                    ->where(
                        'start_time',
                        '<',
                        $validated['end_time']
                    )
                    ->where(
                        'end_time',
                        '>',
                        $validated['start_time']
                    );
            })
            ->exists();

        if ($conflict) {
            return back()
                ->withInput()
                ->withErrors([
                    'room_id' =>
                        'Ruangan sudah digunakan pada sesi tersebut. Silakan pilih sesi atau ruangan lain.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN AGENDA
        |--------------------------------------------------------------------------
        */

        Event::create([
            'room_id' => $validated['room_id'],
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'event_date' => $validated['event_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'status' => 'diajukan',
            'move_reason' => null,
            'pic_note' => null,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()
            ->route('admin.events.index')
            ->with(
                'success',
                'Agenda berhasil ditambahkan.'
            );
    }

    /**
     * Menampilkan detail agenda.
     */
    public function show(Event $event)
    {
        $event->load([
            'room.pic',
            'user',
        ]);

        return view(
            'admin.events.show',
            compact('event')
        );
    }

    /**
     * Menampilkan form edit agenda.
     */
    public function edit(Event $event)
    {
        $rooms = Room::with('pic')
            ->orderBy('name')
            ->get();

        $event->load([
            'room.pic',
            'user',
        ]);

        return view(
            'admin.events.edit',
            compact(
                'event',
                'rooms'
            )
        );
    }

    /**
     * Memperbarui agenda.
     */
    public function update(
        Request $request,
        Event $event
    ) {
        $sessionSchedules = $this->sessionSchedules();

        $today = now('Asia/Jakarta')->toDateString();

        /*
        |--------------------------------------------------------------------------
        | VALIDASI DATA
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'title' => 'required|string|max:255',

            'event_date' => [
                'required',
                'date',
                'after_or_equal:' . $today,
            ],

            'session' => 'required|in:1,2,3',

            'status' => 'required|in:diajukan,disetujui,ditolak',

            'move_reason' => 'nullable|string|max:2000',

            'description' => 'nullable|string|max:2000',
        ]);

        /*
        |--------------------------------------------------------------------------
        | MENENTUKAN JAM BERDASARKAN SESI
        |--------------------------------------------------------------------------
        */

        $selectedSession = $validated['session'];

        $validated['start_time'] =
            $sessionSchedules[$selectedSession]['start_time'];

        $validated['end_time'] =
            $sessionSchedules[$selectedSession]['end_time'];

        /*
        |--------------------------------------------------------------------------
        | CEK APAKAH RUANGAN / JADWAL BERUBAH
        |--------------------------------------------------------------------------
        */

        $oldStartTime = substr(
            (string) $event->start_time,
            0,
            5
        );

        $oldEndTime = substr(
            (string) $event->end_time,
            0,
            5
        );

        $newStartTime = $validated['start_time'];
        $newEndTime = $validated['end_time'];

        $oldEventDate = substr(
            (string) $event->event_date,
            0,
            10
        );

        $isMoved =
            (int) $event->room_id !==
                (int) $validated['room_id']

            || $oldEventDate !==
                $validated['event_date']

            || $oldStartTime !==
                $newStartTime

            || $oldEndTime !==
                $newEndTime;

        /*
        |--------------------------------------------------------------------------
        | ALASAN WAJIB JIKA DIPINDAH
        |--------------------------------------------------------------------------
        */

        if (
            $isMoved &&
            empty(trim($validated['move_reason'] ?? ''))
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'move_reason' =>
                        'Alasan pemindahan wajib diisi jika ruangan, tanggal, atau sesi diubah.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | CEK BENTROK JADWAL
        |--------------------------------------------------------------------------
        */

        if (
            in_array(
                $validated['status'],
                ['diajukan', 'disetujui']
            )
        ) {
            $conflict = Event::where(
                'room_id',
                $validated['room_id']
            )
                ->where(
                    'event_date',
                    $validated['event_date']
                )
                ->where(
                    'id',
                    '!=',
                    $event->id
                )
                ->whereIn(
                    'status',
                    ['diajukan', 'disetujui']
                )
                ->where(function ($query) use ($validated) {
                    $query
                        ->where(
                            'start_time',
                            '<',
                            $validated['end_time']
                        )
                        ->where(
                            'end_time',
                            '>',
                            $validated['start_time']
                        );
                })
                ->exists();

            if ($conflict) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'room_id' =>
                            'Ruangan sudah digunakan pada sesi tersebut. Silakan pilih sesi atau ruangan lain.',
                    ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | PERTAHANKAN ALASAN PEMINDAHAN LAMA
        |--------------------------------------------------------------------------
        */

        if (
            !$isMoved &&
            empty(trim($validated['move_reason'] ?? ''))
        ) {
            $validated['move_reason'] =
                $event->move_reason;
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE AGENDA
        |--------------------------------------------------------------------------
        */

        $event->update([
            'room_id' => $validated['room_id'],
            'title' => $validated['title'],
            'event_date' => $validated['event_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'status' => $validated['status'],
            'move_reason' => $validated['move_reason'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()
            ->route(
                'admin.events.show',
                $event
            )
            ->with(
                'success',
                'Agenda berhasil diperbarui.'
            );
    }

    /**
     * Menghapus agenda.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with(
                'success',
                'Agenda berhasil dihapus.'
            );
    }
}