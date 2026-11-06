<?php

namespace App\Http\Controllers\Admin;

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
    public function index()
    {
        $users = User::latest()
            ->get();

        return view(
            'admin.users.index',
            compact('users')
        );
    }


    /**
     * Menampilkan form tambah pengguna.
     */
    public function create()
    {
        return view('admin.users.create');
    }


    /**
     * Menyimpan pengguna baru.
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | SIMPAN PENGGUNA
        |--------------------------------------------------------------------------
        */

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],

            'password' => Hash::make(
                $validated['password']
            ),

            'role' => $validated['role'],
            'phone' => $validated['phone'] ?? null,
        ]);


        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'Pengguna berhasil ditambahkan.'
            );
    }


    /**
     * Menampilkan detail pengguna.
     */
    public function show(User $user)
    {
        return view(
            'admin.users.show',
            compact('user')
        );
    }


    /**
     * Menampilkan form edit pengguna.
     */
    public function edit(User $user)
    {
        return view(
            'admin.users.edit',
            compact('user')
        );
    }


    /**
     * Memperbarui pengguna.
     */
    public function update(
        Request $request,
        User $user
    ) {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

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
        | CEGAH ADMIN MENGUBAH ROLE AKUN SENDIRI
        |--------------------------------------------------------------------------
        |
        | Admin yang sedang login tidak boleh mengubah
        | role dirinya menjadi Guru/PIC/Siswa.
        |
        */

        if (
            (int) auth()->id() === (int) $user->id &&
            $validated['role'] !== 'admin'
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'role' =>
                        'Anda tidak dapat mengubah role akun sendiri dari Admin.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE DATA
        |--------------------------------------------------------------------------
        */

        $user->name = $validated['name'];

        $user->email = $validated['email'];

        $user->role = $validated['role'];

        $user->phone =
            $validated['phone'] ?? null;


        /*
        |--------------------------------------------------------------------------
        | UPDATE PASSWORD
        |--------------------------------------------------------------------------
        |
        | Password hanya diubah jika Admin mengisi
        | password baru.
        |
        */

        if (!empty($validated['password'])) {

            $user->password = Hash::make(
                $validated['password']
            );
        }


        $user->save();


        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'Data pengguna berhasil diperbarui.'
            );
    }


    /**
     * Menghapus pengguna.
     */
    public function destroy(User $user)
    {
        /*
        |--------------------------------------------------------------------------
        | CEGAH HAPUS AKUN SENDIRI
        |--------------------------------------------------------------------------
        */

        if (
            (int) auth()->id() === (int) $user->id
        ) {
            return redirect()
                ->route('admin.users.index')
                ->with(
                    'error',
                    'Anda tidak dapat menghapus akun sendiri.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CEGAH HAPUS PIC YANG MASIH MEMEGANG RUANGAN
        |--------------------------------------------------------------------------
        */

        if (
            $user->role === 'pic' &&
            $user->managedRooms()->exists()
        ) {
            return redirect()
                ->route('admin.users.index')
                ->with(
                    'error',
                    'PIC tidak dapat dihapus karena masih ditugaskan pada ruangan. Pindahkan PIC ruangan terlebih dahulu.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | HAPUS PENGGUNA
        |--------------------------------------------------------------------------
        */

        $user->delete();


        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'Pengguna berhasil dihapus.'
            );
    }
}