<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }


    /**
     * Proses login.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | AUTENTIKASI
        |--------------------------------------------------------------------------
        */

        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | REDIRECT BERDASARKAN ROLE
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'admin') {

            return redirect()
                ->route('dashboard');

        }


        if ($user->role === 'pic') {

            return redirect()
                ->route('pic.dashboard');

        }


        if ($user->role === 'guru') {

            return redirect()
                ->route('guru.dashboard');

        }


        if ($user->role === 'siswa') {

            return redirect()
                ->route('siswa.dashboard');

        }


        /*
        |--------------------------------------------------------------------------
        | ROLE TIDAK DIKENALI
        |--------------------------------------------------------------------------
        */

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->withErrors([
                'email' => 'Role akun tidak dikenali.',
            ]);
    }


    /**
     * Logout.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}