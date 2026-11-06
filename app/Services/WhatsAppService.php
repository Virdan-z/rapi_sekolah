<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Kirim WhatsApp melalui Fonnte.
     */
    public function send(?string $phone, string $message): bool
    {
        if (empty($phone)) {
            Log::warning('Nomor WhatsApp tujuan kosong.');

            return false;
        }

        $token = config('services.fonnte.token');

        if (empty($token)) {
            Log::warning('FONNTE_TOKEN belum tersedia.');

            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | NORMALISASI NOMOR
        |--------------------------------------------------------------------------
        |
        | 08123456789 -> 8123456789
        | +628123456789 -> 628123456789
        |
        */

        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (str_starts_with($phone, '0')) {
            $phone = substr($phone, 1);
        }

        try {

            $response = Http::withHeaders([
                    'Authorization' => $token,
                ])
                ->asMultipart()
                ->timeout(20)
                ->post('https://api.fonnte.com/send', [
                    [
                        'name' => 'target',
                        'contents' => $phone,
                    ],
                    [
                        'name' => 'message',
                        'contents' => $message,
                    ],
                    [
                        'name' => 'countryCode',
                        'contents' => '62',
                    ],
                ]);

            if (!$response->successful()) {

                Log::error('Request Fonnte gagal.', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);

                return false;
            }

            $result = $response->json();

            if (($result['status'] ?? false) !== true) {

                Log::warning('Fonnte gagal mengirim pesan.', [
                    'response' => $result,
                ]);

                return false;
            }

            Log::info('WhatsApp berhasil dikirim.', [
                'phone' => $phone,
            ]);

            return true;

        } catch (\Throwable $e) {

            Log::error('Error WhatsApp.', [
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }
}