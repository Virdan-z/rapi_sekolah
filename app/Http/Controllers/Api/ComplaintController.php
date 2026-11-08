<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    /**
     * Menampilkan pengaduan berdasarkan role.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Complaint::with([
            'room.pics',
            'user',
        ]);

        if ($user->role === 'guru') {

            // Guru hanya melihat pengaduannya sendiri.
            $query->where('user_id', $user->id);

        } elseif ($user->role === 'pic') {

            // PIC melihat pengaduan dari semua ruangan tugasnya.
            $query->whereHas('room.pics', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            });

        } elseif ($user->role !== 'admin') {

            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke data pengaduan.',
            ], 403);
        }

        $complaints = $query
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data pengaduan berhasil diambil.',
            'data' => $complaints,
        ], 200);
    }


    /**
     * Menampilkan detail pengaduan.
     */
    public function show(
        Request $request,
        Complaint $complaint
    ) {
        $user = $request->user();

        $complaint->load([
            'room.pics',
            'user',
        ]);

        // Guru hanya boleh melihat pengaduannya sendiri.
        if (
            $user->role === 'guru' &&
            (int) $complaint->user_id !== (int) $user->id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke pengaduan ini.',
            ], 403);
        }

        // PIC hanya boleh melihat pengaduan dari ruangan tugasnya.
        if (
            $user->role === 'pic' &&
            !$this->isPicAssigned($complaint, $user->id)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke pengaduan ini.',
            ], 403);
        }

        if (!in_array($user->role, ['admin', 'guru', 'pic'])) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail pengaduan berhasil diambil.',
            'data' => $complaint,
        ], 200);
    }


    /**
     * Guru atau Admin membuat pengaduan.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        if (!in_array($user->role, ['admin', 'guru'])) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk membuat pengaduan.',
            ], 403);
        }

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',

            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
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

        $complaint = Complaint::create([
            'room_id' => $validated['room_id'],
            'user_id' => $user->id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'photo' => $photoPath,
            'status' => 'dilaporkan',
            'pic_note' => null,
        ]);

        $complaint->load([
            'room.pics',
            'user',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengaduan berhasil ditambahkan.',
            'data' => $complaint,
        ], 201);
    }


    /**
     * Admin memperbarui pengaduan.
     */
    public function update(
        Request $request,
        Complaint $complaint
    ) {
        $user = $request->user();

        if ($user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya Admin yang dapat memperbarui pengaduan.',
            ], 403);
        }

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',

            'status' => [
                'required',
                'in:dilaporkan,diproses,selesai',
            ],

            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | FOTO LAMA
        |--------------------------------------------------------------------------
        */

        $photoPath = $complaint->photo;

        /*
        |--------------------------------------------------------------------------
        | UPLOAD FOTO BARU
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('photo')) {

            $newPhotoPath = $request
                ->file('photo')
                ->store('complaints', 'public');

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
        */

        $complaint->update([
            'room_id' => $validated['room_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'photo' => $photoPath,
        ]);

        $complaint->load([
            'room.pics',
            'user',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengaduan berhasil diperbarui.',
            'data' => $complaint,
        ], 200);
    }


    /**
     * Admin menghapus pengaduan.
     */
    public function destroy(
        Request $request,
        Complaint $complaint
    ) {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya Admin yang dapat menghapus pengaduan.',
            ], 403);
        }

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

        return response()->json([
            'success' => true,
            'message' => 'Pengaduan berhasil dihapus.',
        ], 200);
    }


    /**
     * PIC memperbarui status pengaduan.
     */
    public function updateStatus(
        Request $request,
        Complaint $complaint
    ) {
        $user = $request->user();

        if ($user->role !== 'pic') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya PIC yang dapat memperbarui status pengaduan.',
            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | CEK PENUGASAN PIC
        |--------------------------------------------------------------------------
        */

        if (!$this->isPicAssigned($complaint, $user->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Anda bukan PIC dari ruangan pengaduan ini.',
            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'status' => [
                'required',
                'in:dilaporkan,diproses,selesai',
            ],

            'pic_note' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE STATUS
        |--------------------------------------------------------------------------
        */

        $complaint->update([
            'status' => $validated['status'],
            'pic_note' => $validated['pic_note'] ?? $complaint->pic_note,
        ]);

        $complaint->load([
            'room.pics',
            'user',
        ]);

        $message = match ($validated['status']) {
            'dilaporkan' =>
                'Status pengaduan berhasil diubah menjadi Dilaporkan.',

            'diproses' =>
                'Pengaduan sedang dalam proses penanganan.',

            'selesai' =>
                'Pengaduan berhasil diselesaikan.',
        };

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $complaint,
        ], 200);
    }


    /**
     * Memeriksa apakah PIC ditugaskan pada ruangan pengaduan.
     */
    private function isPicAssigned(
        Complaint $complaint,
        int $userId
    ): bool {
        return $complaint->room()
            ->whereHas('pics', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->exists();
    }
}