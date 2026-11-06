<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EventController extends Controller
{
    /**
     * Menampilkan agenda berdasarkan role.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Event::with([
            'room.pic',
            'user',
        ]);

        if ($user->role === 'guru') {
            $query->where('user_id', $user->id);

        } elseif ($user->role === 'pic') {
            $query->whereHas('room', function ($query) use ($user) {
                $query->where('pic_id', $user->id);
            });

        } elseif ($user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke data agenda.',
            ], 403);
        }

        $events = $query->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Data agenda berhasil diambil.',
            'data' => $events,
        ]);
    }

    /**
     * Detail agenda.
     */
    public function show(Request $request, Event $event)
    {
        $user = $request->user();

        if (!in_array($user->role, ['admin', 'guru', 'pic'])) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak.',
            ], 403);
        }

        $event->load([
            'room.pic',
            'user',
        ]);

        if (
            $user->role === 'guru' &&
            (int) $event->user_id !== (int) $user->id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke agenda ini.',
            ], 403);
        }

        if (
            $user->role === 'pic' &&
            (
                !$event->room ||
                (int) $event->room->pic_id !== (int) $user->id
            )
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke agenda ini.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail agenda berhasil diambil.',
            'data' => $event,
        ]);
    }

    /**
     * Guru atau Admin membuat agenda.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        if (!in_array($user->role, ['admin', 'guru'])) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk membuat agenda.',
            ], 403);
        }

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'title' => 'required|string|max:255',
            'event_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'description' => 'nullable|string|max:2000',
        ]);

        // CEK BENTROK JADWAL
        $conflict = Event::where('room_id', $validated['room_id'])
            ->where('event_date', $validated['event_date'])
            ->whereIn('status', ['diajukan', 'disetujui'])
            ->where(function ($query) use ($validated) {
                $query->where(
                    'start_time',
                    '<',
                    $validated['end_time']
                )->where(
                    'end_time',
                    '>',
                    $validated['start_time']
                );
            })
            ->exists();

        if ($conflict) {
            return response()->json([
                'success' => false,
                'message' => 'Ruangan sudah digunakan pada rentang waktu tersebut.',
            ], 422);
        }

        $event = Event::create([
            'room_id' => $validated['room_id'],
            'user_id' => $user->id,
            'title' => $validated['title'],
            'event_date' => $validated['event_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'description' => $validated['description'] ?? null,
            'status' => 'diajukan',
            'pic_note' => null,
            'move_reason' => null,
        ]);

        $event->load([
            'room.pic',
            'user',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Agenda berhasil ditambahkan.',
            'data' => $event,
        ], 201);
    }

    /**
     * Admin memperbarui detail agenda.
     * Status tidak boleh diubah oleh Admin.
     */
    public function update(Request $request, Event $event)
    {
        $user = $request->user();

        if ($user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya Admin yang dapat mengubah agenda.',
            ], 403);
        }

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'move_reason' => 'nullable|string|max:2000',
            'description' => 'nullable|string|max:2000',
        ]);

        $oldStart = substr($event->start_time, 0, 5);
        $oldEnd = substr($event->end_time, 0, 5);

        $newStart = substr($validated['start_time'], 0, 5);
        $newEnd = substr($validated['end_time'], 0, 5);

        $isMoved =
            (int) $event->room_id !== (int) $validated['room_id']
            || $event->event_date !== $validated['event_date']
            || $oldStart !== $newStart
            || $oldEnd !== $newEnd;

        // ALASAN PEMINDAHAN WAJIB DIISI
        if (
            $isMoved &&
            empty(trim($validated['move_reason'] ?? ''))
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Alasan pemindahan wajib diisi jika ruangan atau jadwal diubah.',
            ], 422);
        }

        // CEK BENTROK JADWAL
        if (in_array($event->status, ['diajukan', 'disetujui'])) {
            $conflict = Event::where('room_id', $validated['room_id'])
                ->where('event_date', $validated['event_date'])
                ->where('id', '!=', $event->id)
                ->whereIn('status', ['diajukan', 'disetujui'])
                ->where(function ($query) use ($validated) {
                    $query->where(
                        'start_time',
                        '<',
                        $validated['end_time']
                    )->where(
                        'end_time',
                        '>',
                        $validated['start_time']
                    );
                })
                ->exists();

            if ($conflict) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ruangan sudah digunakan pada rentang waktu tersebut.',
                ], 422);
            }
        }

        if (
            !$isMoved &&
            empty(trim($validated['move_reason'] ?? ''))
        ) {
            $validated['move_reason'] = $event->move_reason;
        }

        $event->update([
            'room_id' => $validated['room_id'],
            'title' => $validated['title'],
            'event_date' => $validated['event_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'move_reason' => $validated['move_reason'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        $event->load([
            'room.pic',
            'user',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Agenda berhasil diperbarui.',
            'data' => $event,
        ]);
    }

    /**
     * Admin menghapus agenda.
     */
    public function destroy(Request $request, Event $event)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya Admin yang dapat menghapus agenda.',
            ], 403);
        }

        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Agenda berhasil dihapus.',
        ]);
    }

    /**
     * PIC memperbarui status agenda.
     */
    public function updateStatus(Request $request, Event $event)
    {
        $user = $request->user();

        if ($user->role !== 'pic') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya PIC yang dapat memperbarui status agenda.',
            ], 403);
        }

        $event->load('room');

        if (
            !$event->room ||
            (int) $event->room->pic_id !== (int) $user->id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Anda bukan PIC dari ruangan agenda ini.',
            ], 403);
        }

        $validated = $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'pic_note' => 'nullable|string|max:2000',
        ]);

        if (
            $validated['status'] === 'ditolak' &&
            empty(trim($validated['pic_note'] ?? ''))
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Catatan PIC wajib diisi jika agenda ditolak.',
            ], 422);
        }

        $event->update([
            'status' => $validated['status'],
            'pic_note' => $validated['pic_note'] ?? $event->pic_note,
        ]);

        $event->load([
            'room.pic',
            'user',
        ]);

        return response()->json([
            'success' => true,
            'message' => $validated['status'] === 'disetujui'
                ? 'Agenda berhasil disetujui.'
                : 'Agenda berhasil ditolak.',
            'data' => $event,
        ]);
    }

    /**
     * Menampilkan agenda yang disetujui untuk kalender publik.
     */
    public function publicIndex(Request $request)
    {
        $monthInput = $request->query('month');

        $selectedMonth = now()->startOfMonth();

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

        $events = Event::with('room')
            ->where('status', 'disetujui')
            ->whereBetween('event_date', [
                $selectedMonth->copy()->startOfMonth()->toDateString(),
                $selectedMonth->copy()->endOfMonth()->toDateString(),
            ])
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data kalender berhasil diambil.',
            'month' => $selectedMonth->format('Y-m'),
            'data' => $events,
        ]);
    }
}