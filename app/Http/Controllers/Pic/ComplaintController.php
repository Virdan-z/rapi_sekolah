<?php

namespace App\Http\Controllers\Pic;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    /**
     * Menampilkan semua pengaduan dari ruangan
     * yang menjadi tanggung jawab PIC.
     */
    public function index()
    {
        $userId = auth()->id();

        $complaints = Complaint::with([
            'room.pics',
            'user',
        ])
            ->whereHas('room.pics', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->latest()
            ->get();

        return view(
            'pic.complaints.index',
            compact('complaints')
        );
    }

    /**
     * Menampilkan detail pengaduan.
     */
    public function show(Complaint $complaint)
    {
        $complaint->load([
            'room.pics',
            'user',
        ]);

        $this->authorizePicRoom($complaint);

        return view(
            'pic.complaints.show',
            compact('complaint')
        );
    }

    /**
     * Menampilkan form penanganan pengaduan.
     */
    public function edit(Complaint $complaint)
    {
        $complaint->load([
            'room.pics',
            'user',
        ]);

        $this->authorizePicRoom($complaint);

        return view(
            'pic.complaints.edit',
            compact('complaint')
        );
    }

    /**
     * Memperbarui status dan catatan penanganan.
     */
    public function update(
        Request $request,
        Complaint $complaint
    ) {
        $complaint->load('room.pics');

        $this->authorizePicRoom($complaint);

        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'status' => 'required|in:dilaporkan,diproses,selesai',
            'pic_note' => 'nullable|string|max:2000',
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE PENGADUAN
        |--------------------------------------------------------------------------
        */

        $complaint->update([
            'status' => $validated['status'],
            'pic_note' => $validated['pic_note'] ?? $complaint->pic_note,
        ]);

        /*
        |--------------------------------------------------------------------------
        | PESAN BERDASARKAN STATUS
        |--------------------------------------------------------------------------
        */

        $message = match ($validated['status']) {
            'dilaporkan' =>
                'Status pengaduan berhasil diperbarui menjadi Dilaporkan.',

            'diproses' =>
                'Pengaduan sedang dalam proses penanganan.',

            'selesai' =>
                'Pengaduan berhasil diselesaikan.',
        };

        return redirect()
            ->route('pic.complaints.show', $complaint)
            ->with('success', $message);
    }

    /**
     * Memastikan PIC hanya dapat mengakses pengaduan
     * dari ruangan yang menjadi tanggung jawabnya.
     */
    private function authorizePicRoom(
        Complaint $complaint
    ): void {
        $userId = auth()->id();

        $hasAccess = $complaint->room
            && $complaint->room->pics()
                ->where('users.id', $userId)
                ->exists();

        if (!$hasAccess) {
            abort(
                403,
                'Anda tidak memiliki akses ke pengaduan ini.'
            );
        }
    }
}