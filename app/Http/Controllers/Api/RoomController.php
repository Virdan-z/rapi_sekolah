<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    /**
     * Menampilkan semua ruangan.
     */
    public function index(Request $request)
    {
        $rooms = Room::with('pic')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data ruangan berhasil diambil.',
            'data' => $rooms,
        ], 200);
    }


    /**
     * Menampilkan detail ruangan.
     */
    public function show(
        Request $request,
        Room $room
    ) {
        $room->load('pic');

        return response()->json([
            'success' => true,
            'message' => 'Detail ruangan berhasil diambil.',
            'data' => $room,
        ], 200);
    }


    /**
     * Admin menambah ruangan.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya Admin yang dapat menambah ruangan.',
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'location' => 'required|string|max:255',

            'capacity' => 'required|integer|min:1',

            'pic_id' => [
                'nullable',
                Rule::exists('users', 'id')
                    ->where(function ($query) {
                        $query->where('role', 'pic');
                    }),
            ],

            'description' => 'nullable|string|max:2000',
        ]);

        $room = Room::create([
            'name' => $validated['name'],
            'location' => $validated['location'],
            'capacity' => $validated['capacity'],
            'pic_id' => $validated['pic_id'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        $room->load('pic');

        return response()->json([
            'success' => true,
            'message' => 'Ruangan berhasil ditambahkan.',
            'data' => $room,
        ], 201);
    }


    /**
     * Admin memperbarui ruangan.
     */
    public function update(
        Request $request,
        Room $room
    ) {
        $user = $request->user();

        if ($user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya Admin yang dapat memperbarui ruangan.',
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'location' => 'required|string|max:255',

            'capacity' => 'required|integer|min:1',

            'pic_id' => [
                'nullable',
                Rule::exists('users', 'id')
                    ->where(function ($query) {
                        $query->where('role', 'pic');
                    }),
            ],

            'description' => 'nullable|string|max:2000',
        ]);

        $room->update([
            'name' => $validated['name'],
            'location' => $validated['location'],
            'capacity' => $validated['capacity'],
            'pic_id' => $validated['pic_id'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        $room->load('pic');

        return response()->json([
            'success' => true,
            'message' => 'Ruangan berhasil diperbarui.',
            'data' => $room,
        ], 200);
    }


    /**
     * Admin menghapus ruangan.
     */
    public function destroy(
        Request $request,
        Room $room
    ) {
        $user = $request->user();

        if ($user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya Admin yang dapat menghapus ruangan.',
            ], 403);
        }

        $room->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ruangan berhasil dihapus.',
        ], 200);
    }
}