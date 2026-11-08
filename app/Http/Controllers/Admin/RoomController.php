<?php

namespace App\Http\Controllers\Admin;

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
    public function index()
    {
        $rooms = Room::with('pics')
            ->latest()
            ->get();

        return view(
            'admin.rooms.index',
            compact('rooms')
        );
    }


    /**
     * Menampilkan form tambah ruangan.
     */
    public function create()
    {
        $pics = User::where('role', 'pic')
            ->orderBy('name')
            ->get();

        return view(
            'admin.rooms.create',
            compact('pics')
        );
    }


    /**
     * Menyimpan ruangan baru.
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'location' => 'required|string|max:255',

            'capacity' => 'required|integer|min:1',

            'pic_ids' => 'nullable|array',

            'pic_ids.*' => [
                'required',
                'distinct',
                Rule::exists('users', 'id')
                    ->where(function ($query) {
                        $query->where('role', 'pic');
                    }),
            ],

            'description' => 'nullable|string|max:2000',
        ]);

        /*
        |--------------------------------------------------------------------------
        | SIMPAN RUANGAN
        |--------------------------------------------------------------------------
        */

        $room = Room::create([
            'name' => $validated['name'],
            'location' => $validated['location'],
            'capacity' => $validated['capacity'],
            'description' => $validated['description'] ?? null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | SIMPAN PIC KE TABEL PIVOT
        |--------------------------------------------------------------------------
        */

        $room->pics()->sync($validated['pic_ids'] ?? []);

        return redirect()
            ->route('admin.rooms.index')
            ->with(
                'success',
                'Ruangan berhasil ditambahkan.'
            );
    }


    /**
     * Menampilkan detail ruangan.
     */
    public function show(Room $room)
    {
        $room->load('pics');

        return view(
            'admin.rooms.show',
            compact('room')
        );
    }


    /**
     * Menampilkan form edit ruangan.
     */
    public function edit(Room $room)
    {
        $pics = User::where('role', 'pic')
            ->orderBy('name')
            ->get();

        $room->load('pics');

        return view(
            'admin.rooms.edit',
            compact(
                'room',
                'pics'
            )
        );
    }


    /**
     * Memperbarui ruangan.
     */
    public function update(
        Request $request,
        Room $room
    ) {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'location' => 'required|string|max:255',

            'capacity' => 'required|integer|min:1',

            'pic_ids' => 'nullable|array',

            'pic_ids.*' => [
                'required',
                'distinct',
                Rule::exists('users', 'id')
                    ->where(function ($query) {
                        $query->where('role', 'pic');
                    }),
            ],

            'description' => 'nullable|string|max:2000',
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE RUANGAN
        |--------------------------------------------------------------------------
        */

        $room->update([
            'name' => $validated['name'],
            'location' => $validated['location'],
            'capacity' => $validated['capacity'],
            'description' => $validated['description'] ?? null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE PIC
        |--------------------------------------------------------------------------
        */

        $room->pics()->sync($validated['pic_ids'] ?? []);

        return redirect()
            ->route('admin.rooms.index')
            ->with(
                'success',
                'Ruangan berhasil diperbarui.'
            );
    }


    /**
     * Menghapus ruangan.
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()
            ->route('admin.rooms.index')
            ->with(
                'success',
                'Ruangan berhasil dihapus.'
            );
    }
}