<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    /**
     * Menampilkan semua pengaduan.
     */
    public function index()
    {
        $complaints = Complaint::with([
                'room.pic',
                'user',
            ])
            ->latest()
            ->get();

        return view(
            'admin.complaints.index',
            compact('complaints')
        );
    }


    /**
     * Menampilkan form tambah pengaduan.
     */
    public function create()
    {
        $rooms = Room::with('pic')
            ->orderBy('name')
            ->get();

        return view(
            'admin.complaints.create',
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
            'status' => 'dilaporkan',
            'pic_note' => null,
        ]);


        return redirect()
            ->route('admin.complaints.index')
            ->with(
                'success',
                'Pengaduan berhasil ditambahkan.'
            );
    }


    /**
     * Menampilkan detail pengaduan.
     */
    public function show(Complaint $complaint)
    {
        $complaint->load([
            'room.pic',
            'user',
        ]);

        return view(
            'admin.complaints.show',
            compact('complaint')
        );
    }


    /**
     * Menampilkan form edit pengaduan.
     */
    public function edit(Complaint $complaint)
    {
        $rooms = Room::with('pic')
            ->orderBy('name')
            ->get();

        $complaint->load([
            'room.pic',
            'user',
        ]);

        return view(
            'admin.complaints.edit',
            compact(
                'complaint',
                'rooms'
            )
        );
    }


    /**
     * Memperbarui pengaduan.
     */
    public function update(
        Request $request,
        Complaint $complaint
    ) {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'status' => 'required|in:dilaporkan,diproses,selesai',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);


        /*
        |--------------------------------------------------------------------------
        | FOTO LAMA
        |--------------------------------------------------------------------------
        */

        $photoPath = $complaint->photo;


        /*
        |--------------------------------------------------------------------------
        | GANTI FOTO
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('photo')) {

            /*
             * Upload foto baru terlebih dahulu.
             *
             * Dengan cara ini foto lama tidak langsung hilang
             * sebelum foto baru berhasil disimpan.
             */
            $newPhotoPath = $request
                ->file('photo')
                ->store('complaints', 'public');


            /*
             * Setelah upload baru berhasil,
             * hapus foto lama.
             */
            if ($complaint->photo) {
                Storage::disk('public')
                    ->delete($complaint->photo);
            }

            $photoPath = $newPhotoPath;
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE PENGADUAN
        |--------------------------------------------------------------------------
        |
        | pic_note sengaja tidak diubah di sini.
        | Catatan tersebut tetap menjadi catatan dari PIC.
        |
        */

        $complaint->update([
            'room_id' => $validated['room_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'photo' => $photoPath,
        ]);


        return redirect()
            ->route(
                'admin.complaints.show',
                $complaint
            )
            ->with(
                'success',
                'Pengaduan berhasil diperbarui.'
            );
    }


    /**
     * Menghapus pengaduan.
     */
    public function destroy(Complaint $complaint)
    {
        /*
        |--------------------------------------------------------------------------
        | HAPUS FOTO
        |--------------------------------------------------------------------------
        */

        if ($complaint->photo) {
            Storage::disk('public')
                ->delete($complaint->photo);
        }


        /*
        |--------------------------------------------------------------------------
        | HAPUS DATA
        |--------------------------------------------------------------------------
        */

        $complaint->delete();


        return redirect()
            ->route('admin.complaints.index')
            ->with(
                'success',
                'Pengaduan berhasil dihapus.'
            );
    }
}