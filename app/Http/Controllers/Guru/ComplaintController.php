<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Room;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    /**
     * Menampilkan semua pengaduan milik Guru yang login.
     */
    public function index()
    {
        $complaints = Complaint::with([
                'room.pic'
            ])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view(
            'guru.complaints.index',
            compact('complaints')
        );
    }


    /**
     * Menampilkan form pengaduan baru.
     */
    public function create()
    {
        $rooms = Room::with('pic')
            ->orderBy('name')
            ->get();

        return view(
            'guru.complaints.create',
            compact('rooms')
        );
    }


    /**
     * Menyimpan pengaduan baru.
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);


        /*
        |--------------------------------------------------------------------------
        | UPLOAD FOTO
        |--------------------------------------------------------------------------
        */

        $photoPath = null;

        if ($request->hasFile('photo')) {

            $photoPath = $request
                ->file('photo')
                ->store('complaints', 'public');
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN PENGADUAN
        |--------------------------------------------------------------------------
        */

        Complaint::create([
            'room_id' => $validated['room_id'],
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'photo' => $photoPath,

            // Semua pengaduan baru dimulai dari status dilaporkan
            'status' => 'dilaporkan',

            // Belum ada catatan dari PIC
            'pic_note' => null,
        ]);


        return redirect()
            ->route('guru.complaints.index')
            ->with(
                'success',
                'Pengaduan berhasil dikirim dan menunggu penanganan PIC.'
            );
    }


    /**
     * Menampilkan detail pengaduan milik Guru.
     */
    public function show(Complaint $complaint)
    {
        /*
        |--------------------------------------------------------------------------
        | CEK KEPEMILIKAN
        |--------------------------------------------------------------------------
        */

        $this->authorizeOwner($complaint);


        /*
        |--------------------------------------------------------------------------
        | LOAD RELASI
        |--------------------------------------------------------------------------
        */

        $complaint->load([
            'room.pic',
            'user',
        ]);


        return view(
            'guru.complaints.show',
            compact('complaint')
        );
    }


    /**
     * Memastikan Guru hanya dapat membuka
     * pengaduan miliknya sendiri.
     */
    private function authorizeOwner(
        Complaint $complaint
    ): void {
        if (
            (int) $complaint->user_id !== (int) auth()->id()
        ) {
            abort(
                403,
                'Anda tidak memiliki akses ke pengaduan ini.'
            );
        }
    }
}