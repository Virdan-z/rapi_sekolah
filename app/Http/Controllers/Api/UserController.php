<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Menampilkan semua pengguna.
     */
    public function index(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya Admin yang dapat melihat data pengguna.',
            ], 403);
        }

        $users = User::latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data pengguna berhasil diambil.',
            'data' => $users,
        ], 200);
    }


    /**
     * Menampilkan detail pengguna.
     */
    public function show(
        Request $request,
        User $user
    ) {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya Admin yang dapat melihat detail pengguna.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail pengguna berhasil diambil.',
            'data' => $user,
        ], 200);
    }


    /**
     * Menambahkan pengguna baru.
     */
    public function store(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya Admin yang dapat menambah pengguna.',
            ], 403);
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
            ],

            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],

            'role' => [
                'required',
                Rule::in([
                    'admin',
                    'guru',
                    'pic',
                    'siswa',
                ]),
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make(
                $validated['password']
            ),
            'role' => $validated['role'],
            'phone' => $validated['phone'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengguna berhasil ditambahkan.',
            'data' => $user,
        ], 201);
    }


    /**
     * Memperbarui pengguna.
     */
    public function update(
        Request $request,
        User $user
    ) {
        $admin = $request->user();

        if ($admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya Admin yang dapat memperbarui pengguna.',
            ], 403);
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],

            'role' => [
                'required',
                Rule::in([
                    'admin',
                    'guru',
                    'pic',
                    'siswa',
                ]),
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'password' => [
                'nullable',
                'string',
                'min:6',
                'confirmed',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | ADMIN TIDAK BOLEH MENGUBAH ROLE DIRINYA SENDIRI
        |--------------------------------------------------------------------------
        */

        if (
            (int) $admin->id === (int) $user->id &&
            $validated['role'] !== 'admin'
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Admin tidak dapat mengubah role akun sendiri.',
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | PIC YANG MASIH MEMEGANG RUANGAN
        |--------------------------------------------------------------------------
        */

        if (
            $user->role === 'pic' &&
            $validated['role'] !== 'pic' &&
            $user->rooms()->exists()
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Role PIC tidak dapat diubah karena masih menjadi PIC ruangan.',
            ], 422);
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->phone = $validated['phone'] ?? null;

        /*
        |--------------------------------------------------------------------------
        | PASSWORD HANYA DIUBAH JIKA DIISI
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['password'])) {
            $user->password = Hash::make(
                $validated['password']
            );
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Data pengguna berhasil diperbarui.',
            'data' => $user,
        ], 200);
    }


    /**
     * Menghapus pengguna.
     */
    public function destroy(
        Request $request,
        User $user
    ) {
        $admin = $request->user();

        if ($admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya Admin yang dapat menghapus pengguna.',
            ], 403);
        }

        /*
        |--------------------------------------------------------------------------
        | CEGAH ADMIN MENGHAPUS DIRI SENDIRI
        |--------------------------------------------------------------------------
        */

        if ((int) $admin->id === (int) $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat menghapus akun sendiri.',
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | CEGAH HAPUS PIC YANG MASIH MEMEGANG RUANGAN
        |--------------------------------------------------------------------------
        */

        if ($user->rooms()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak dapat dihapus karena masih menjadi PIC ruangan.',
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | CEGAH HAPUS USER YANG MEMILIKI RIWAYAT AGENDA
        |--------------------------------------------------------------------------
        */

        if ($user->events()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak dapat dihapus karena masih memiliki riwayat agenda.',
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | CEGAH HAPUS USER YANG MEMILIKI RIWAYAT PENGADUAN
        |--------------------------------------------------------------------------
        */

        if ($user->complaints()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak dapat dihapus karena masih memiliki riwayat pengaduan.',
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | HAPUS TOKEN API USER
        |--------------------------------------------------------------------------
        */

        $user->tokens()->delete();

        /*
        |--------------------------------------------------------------------------
        | HAPUS USER
        |--------------------------------------------------------------------------
        */

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pengguna berhasil dihapus.',
        ], 200);
    }
}