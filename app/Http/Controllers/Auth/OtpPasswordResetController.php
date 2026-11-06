<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class OtpPasswordResetController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN LUPA PASSWORD
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('auth.forgot-password');
    }


    /*
    |--------------------------------------------------------------------------
    | KIRIM OTP KE EMAIL
    |--------------------------------------------------------------------------
    */

    public function sendOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        $email = strtolower(trim($validated['email']));

        // Cek apakah email terdaftar.
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->with(
                'status',
                'Jika email terdaftar, kode OTP akan dikirim.'
            );
        }

        // Batasi pengiriman OTP setiap 60 detik.
        $recentOtp = DB::table('password_reset_otps')
            ->where('email', $email)
            ->where('created_at', '>=', now()->subSeconds(60))
            ->exists();

        if ($recentOtp) {
            return back()
                ->withErrors([
                    'email' => 'Tunggu 60 detik sebelum meminta OTP baru.'
                ])
                ->withInput($request->only('email'));
        }

        // Membuat OTP 6 digit.
        $otp = (string) random_int(100000, 999999);

        // Simpan OTP dalam bentuk hash.
        DB::table('password_reset_otps')->updateOrInsert(
            ['email' => $email],
            [
                'otp_hash' => Hash::make($otp),
                'attempts' => 0,
                'expires_at' => now()->addMinutes(10),
                'verified_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Kirim OTP melalui email.
        try {
            Mail::raw(
                "Halo!\n\n"
                . "Kode OTP untuk reset password RAPI-Sekolah kamu adalah:\n\n"
                . $otp
                . "\n\nKode ini berlaku selama 10 menit."
                . "\nJangan berikan kode ini kepada siapa pun.\n\n"
                . "Jika kamu tidak meminta reset password, abaikan email ini.",
                function ($message) use ($email) {
                    $message->to($email)
                        ->subject('Kode OTP Reset Password RAPI-Sekolah');
                }
            );
        } catch (\Throwable $e) {

            DB::table('password_reset_otps')
                ->where('email', $email)
                ->delete();

            Log::error('Gagal mengirim OTP reset password.', [
                'email' => $email,
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withErrors([
                    'email' => 'OTP gagal dikirim. Periksa konfigurasi email.'
                ])
                ->withInput($request->only('email'));
        }

        // Simpan email pada session.
        $request->session()->put('password_reset_email', $email);

        $request->session()->forget('password_reset_verified');

        return redirect()
            ->route('password.otp.form')
            ->with('status', 'Kode OTP berhasil dikirim ke email kamu.');
    }


    /*
    |--------------------------------------------------------------------------
    | HALAMAN VERIFIKASI OTP
    |--------------------------------------------------------------------------
    */

    public function showVerifyOtp(Request $request)
    {
        $email = $request->session()->get('password_reset_email');

        if (!$email) {
            return redirect()->route('password.request');
        }

        return view('auth.verify-otp', compact('email'));
    }


    /*
    |--------------------------------------------------------------------------
    | PROSES VERIFIKASI OTP
    |--------------------------------------------------------------------------
    */

    public function verifyOtp(Request $request)
    {
        $validated = $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $email = $request->session()->get('password_reset_email');

        if (!$email) {
            return redirect()->route('password.request');
        }

        $record = DB::table('password_reset_otps')
            ->where('email', $email)
            ->first();

        // Cek OTP dan masa berlakunya.
        if (
            !$record ||
            now()->greaterThan(Carbon::parse($record->expires_at))
        ) {
            DB::table('password_reset_otps')
                ->where('email', $email)
                ->delete();

            $request->session()->forget([
                'password_reset_email',
                'password_reset_verified',
            ]);

            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'OTP sudah kedaluwarsa. Silakan minta OTP baru.'
                ]);
        }

        // Jika OTP sudah diverifikasi sebelumnya.
        if ($record->verified_at !== null) {
            $request->session()->put('password_reset_verified', true);

            return redirect()->route('password.reset');
        }

        // Maksimal 5 kali percobaan.
        if ($record->attempts >= 5) {

            DB::table('password_reset_otps')
                ->where('email', $email)
                ->delete();

            $request->session()->forget([
                'password_reset_email',
                'password_reset_verified',
            ]);

            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'Batas percobaan OTP sudah habis. Minta OTP baru.'
                ]);
        }

        // Periksa kode OTP.
        if (!Hash::check($validated['otp'], $record->otp_hash)) {

            $attempts = $record->attempts + 1;

            DB::table('password_reset_otps')
                ->where('email', $email)
                ->update([
                    'attempts' => $attempts,
                    'updated_at' => now(),
                ]);

            if ($attempts >= 5) {

                DB::table('password_reset_otps')
                    ->where('email', $email)
                    ->delete();

                $request->session()->forget([
                    'password_reset_email',
                    'password_reset_verified',
                ]);

                return redirect()
                    ->route('password.request')
                    ->withErrors([
                        'email' => 'Batas percobaan OTP sudah habis. Minta OTP baru.'
                    ]);
            }

            return back()->withErrors([
                'otp' => 'Kode OTP salah. Sisa percobaan: ' . (5 - $attempts),
            ]);
        }

        // OTP benar.
        DB::table('password_reset_otps')
            ->where('email', $email)
            ->update([
                'verified_at' => now(),
                'updated_at' => now(),
            ]);

        $request->session()->put('password_reset_verified', true);

        return redirect()
            ->route('password.reset')
            ->with('status', 'Verifikasi OTP berhasil.');
    }


    /*
    |--------------------------------------------------------------------------
    | HALAMAN PASSWORD BARU
    |--------------------------------------------------------------------------
    */

    public function showResetPassword(Request $request)
    {
        $email = $request->session()->get('password_reset_email');

        $verified = $request->session()->get('password_reset_verified');

        if (!$email || !$verified) {
            return redirect()->route('password.request');
        }

        $record = DB::table('password_reset_otps')
            ->where('email', $email)
            ->whereNotNull('verified_at')
            ->first();

        if (
            !$record ||
            now()->greaterThan(Carbon::parse($record->expires_at))
        ) {
            DB::table('password_reset_otps')
                ->where('email', $email)
                ->delete();

            $request->session()->forget([
                'password_reset_email',
                'password_reset_verified',
            ]);

            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'Sesi reset password sudah berakhir. Silakan ulangi.'
                ]);
        }

        return view('auth.reset-password');
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN PASSWORD BARU
    |--------------------------------------------------------------------------
    */

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $email = $request->session()->get('password_reset_email');

        $verified = $request->session()->get('password_reset_verified');

        if (!$email || !$verified) {
            return redirect()->route('password.request');
        }

        $record = DB::table('password_reset_otps')
            ->where('email', $email)
            ->whereNotNull('verified_at')
            ->first();

        if (
            !$record ||
            now()->greaterThan(Carbon::parse($record->expires_at))
        ) {
            DB::table('password_reset_otps')
                ->where('email', $email)
                ->delete();

            $request->session()->forget([
                'password_reset_email',
                'password_reset_verified',
            ]);

            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'Sesi reset password sudah berakhir.'
                ]);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.request');
        }

        // Model User sudah menggunakan cast hashed.
        $user->password = $validated['password'];
        $user->save();

        // Hapus OTP setelah password berhasil diperbarui.
        DB::table('password_reset_otps')
            ->where('email', $email)
            ->delete();

        // Hapus session reset password.
        $request->session()->forget([
            'password_reset_email',
            'password_reset_verified',
        ]);

        return redirect()
            ->route('login')
            ->with('status', 'Password berhasil diperbarui. Silakan login.');
    }
}