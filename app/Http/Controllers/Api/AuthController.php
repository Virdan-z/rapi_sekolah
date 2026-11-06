<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    // ==========================================
    // LOGIN
    // ==========================================
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.',
            ], 401);
        }

        // Hapus token sebelumnya
        $user->tokens()->delete();

        // Buat token baru
        $token = $user->createToken('rapi-sekolah-api')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'phone' => $user->phone,
            ],
        ]);
    }


    // ==========================================
    // PROFILE / ME
    // ==========================================
    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'phone' => $user->phone,
            ],
        ]);
    }


    // ==========================================
    // LOGOUT
    // ==========================================
    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken();

        if ($token instanceof PersonalAccessToken) {
            $token->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.',
        ]);
    }


    // ==========================================
    // KIRIM OTP KE EMAIL
    // ==========================================
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $email = strtolower(trim($request->email));

        $user = User::where('email', $email)->first();

        // Pesan dibuat sama agar tidak membocorkan email terdaftar
        if (!$user) {
            return response()->json([
                'success' => true,
                'message' => 'Jika email terdaftar, OTP akan dikirim.',
            ]);
        }

        // Batasi pengiriman OTP selama 60 detik
        $recentOtp = DB::table('password_reset_otps')
            ->where('email', $email)
            ->where('created_at', '>=', now()->subSeconds(60))
            ->exists();

        if ($recentOtp) {
            return response()->json([
                'success' => false,
                'message' => 'Tunggu 60 detik sebelum meminta OTP baru.',
            ], 429);
        }

        // Buat OTP 6 digit
        $otp = (string) random_int(100000, 999999);

        // Simpan OTP dalam bentuk hash
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

        try {
            Mail::raw(
                "Kode OTP reset password RAPI-Sekolah kamu: $otp\n\n"
                . "Kode berlaku selama 10 menit.\n"
                . "Jangan bagikan kode ini kepada siapa pun.",
                function ($message) use ($email) {
                    $message->to($email)
                        ->subject('OTP Reset Password RAPI-Sekolah');
                }
            );
        } catch (\Throwable $e) {
            DB::table('password_reset_otps')
                ->where('email', $email)
                ->delete();

            Log::error('Gagal mengirim OTP: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim OTP. Periksa konfigurasi email.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Jika email terdaftar, OTP akan dikirim.',
        ]);
    }


    // ==========================================
    // VERIFIKASI OTP
    // ==========================================
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $email = strtolower(trim($request->email));

        $otpData = DB::table('password_reset_otps')
            ->where('email', $email)
            ->first();

        if (!$otpData) {
            return response()->json([
                'success' => false,
                'message' => 'OTP tidak ditemukan. Silakan minta OTP baru.',
            ], 404);
        }

        // Periksa masa berlaku OTP
        if (now()->greaterThanOrEqualTo($otpData->expires_at)) {
            DB::table('password_reset_otps')
                ->where('email', $email)
                ->delete();

            return response()->json([
                'success' => false,
                'message' => 'OTP sudah kedaluwarsa. Silakan minta OTP baru.',
            ], 422);
        }

        // Batasi maksimal 5 percobaan
        if ($otpData->attempts >= 5) {
            DB::table('password_reset_otps')
                ->where('email', $email)
                ->delete();

            return response()->json([
                'success' => false,
                'message' => 'Batas percobaan OTP habis. Silakan minta OTP baru.',
            ], 429);
        }

        // Periksa kecocokan OTP
        if (!Hash::check($request->otp, $otpData->otp_hash)) {
            $attempts = $otpData->attempts + 1;

            if ($attempts >= 5) {
                DB::table('password_reset_otps')
                    ->where('email', $email)
                    ->delete();

                return response()->json([
                    'success' => false,
                    'message' => 'Batas percobaan OTP habis. Silakan minta OTP baru.',
                ], 429);
            }

            DB::table('password_reset_otps')
                ->where('email', $email)
                ->update([
                    'attempts' => $attempts,
                    'updated_at' => now(),
                ]);

            return response()->json([
                'success' => false,
                'message' => 'Kode OTP yang kamu masukkan salah.',
                'remaining_attempts' => 5 - $attempts,
            ], 422);
        }

        // Tandai OTP sudah terverifikasi
        DB::table('password_reset_otps')
            ->where('email', $email)
            ->update([
                'verified_at' => now(),
                'updated_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'OTP berhasil diverifikasi.',
        ]);
    }


    // ==========================================
    // RESET PASSWORD
    // ==========================================
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $email = strtolower(trim($request->email));

        $otpData = DB::table('password_reset_otps')
            ->where('email', $email)
            ->first();

        if (!$otpData) {
            return response()->json([
                'success' => false,
                'message' => 'Data OTP tidak ditemukan. Silakan ulangi proses.',
            ], 404);
        }

        // Periksa apakah OTP sudah diverifikasi
        if (!$otpData->verified_at) {
            return response()->json([
                'success' => false,
                'message' => 'Verifikasi OTP terlebih dahulu.',
            ], 422);
        }

        // Periksa masa berlaku OTP
        if (now()->greaterThanOrEqualTo($otpData->expires_at)) {
            DB::table('password_reset_otps')
                ->where('email', $email)
                ->delete();

            return response()->json([
                'success' => false,
                'message' => 'OTP sudah kedaluwarsa. Silakan ulangi proses.',
            ], 422);
        }

        // Periksa jumlah percobaan
        if ($otpData->attempts >= 5) {
            DB::table('password_reset_otps')
                ->where('email', $email)
                ->delete();

            return response()->json([
                'success' => false,
                'message' => 'OTP tidak dapat digunakan lagi.',
            ], 429);
        }

        // Periksa kembali OTP saat mengganti password
        if (!Hash::check($request->otp, $otpData->otp_hash)) {
            return response()->json([
                'success' => false,
                'message' => 'OTP tidak valid.',
            ], 422);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak ditemukan.',
            ], 404);
        }

        DB::transaction(function () use ($user, $request, $email) {

            // Password otomatis di-hash oleh cast pada model User
            $user->password = $request->password;
            $user->save();

            // Hapus token login lama
            $user->tokens()->delete();

            // Hapus OTP setelah berhasil digunakan
            DB::table('password_reset_otps')
                ->where('email', $email)
                ->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah. Silakan login kembali.',
        ]);
    }
}