<?php

namespace App\Http\Controllers\Pic;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Daftar agenda pada ruangan PIC.
     */
    public function index()
    {
        $userId = auth()->id();

        $events = Event::with([
                'room',
                'user',
            ])
            ->whereHas('room', function ($query) use ($userId) {
                $query->where('pic_id', $userId);
            })
            ->latest()
            ->get();

        return view(
            'pic.events.index',
            compact('events')
        );
    }


    /**
     * Detail agenda.
     */
    public function show(Event $event)
    {
        $event->load([
            'room.pic',
            'user',
        ]);

        $this->authorizePicRoom($event);

        return view(
            'pic.events.show',
            compact('event')
        );
    }


    /**
     * Form update status.
     */
    public function edit(Event $event)
    {
        $event->load([
            'room.pic',
            'user',
        ]);

        $this->authorizePicRoom($event);

        return view(
            'pic.events.edit',
            compact('event')
        );
    }


    /**
     * PIC menyetujui atau menolak agenda.
     */
    public function update(
        Request $request,
        Event $event,
        WhatsAppService $whatsApp
    ) {
        /*
        |--------------------------------------------------------------------------
        | CEK AKSES PIC
        |--------------------------------------------------------------------------
        */

        $event->load([
            'room',
            'user',
        ]);

        $this->authorizePicRoom($event);


        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'status' => [
                'required',
                'in:disetujui,ditolak',
            ],

            'pic_note' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | CATATAN WAJIB JIKA DITOLAK
        |--------------------------------------------------------------------------
        */

        if (
            $validated['status'] === 'ditolak' &&
            empty(trim($validated['pic_note'] ?? ''))
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'pic_note' =>
                        'Catatan PIC wajib diisi jika agenda ditolak.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE AGENDA
        |--------------------------------------------------------------------------
        */

        $event->update([
            'status' => $validated['status'],
            'pic_note' => $validated['pic_note'] ?? null,
        ]);


        /*
        |--------------------------------------------------------------------------
        | LOAD ULANG DATA
        |--------------------------------------------------------------------------
        */

        $event->load([
            'room.pic',
            'user',
        ]);


        /*
        |--------------------------------------------------------------------------
        | DATA PESAN WHATSAPP
        |--------------------------------------------------------------------------
        */

        $tanggal = Carbon::parse(
            $event->event_date
        )->format('d-m-Y');

        $jamMulai = substr(
            $event->start_time,
            0,
            5
        );

        $jamSelesai = substr(
            $event->end_time,
            0,
            5
        );

        $namaPengaju = $event->user->name ?? 'Pengguna';

        $namaRuangan = $event->room->name ?? '-';

        $catatan = trim(
            $validated['pic_note'] ?? ''
        );


        /*
        |--------------------------------------------------------------------------
        | PESAN JIKA DISETUJUI
        |--------------------------------------------------------------------------
        */

        if ($validated['status'] === 'disetujui') {

            $message =
                "RAPI-Sekolah\n\n" .
                "Halo {$namaPengaju},\n\n" .
                "Pengajuan agenda Anda telah DISETUJUI.\n\n" .
                "Agenda: {$event->title}\n" .
                "Ruangan: {$namaRuangan}\n" .
                "Tanggal: {$tanggal}\n" .
                "Waktu: {$jamMulai} - {$jamSelesai}";

            if ($catatan !== '') {
                $message .=
                    "\nCatatan PIC: {$catatan}";
            }

            $message .=
                "\n\nSilakan cek RAPI-Sekolah untuk informasi lengkap.";
        }


        /*
        |--------------------------------------------------------------------------
        | PESAN JIKA DITOLAK
        |--------------------------------------------------------------------------
        */

        else {

            $message =
                "RAPI-Sekolah\n\n" .
                "Halo {$namaPengaju},\n\n" .
                "Pengajuan agenda Anda DITOLAK.\n\n" .
                "Agenda: {$event->title}\n" .
                "Ruangan: {$namaRuangan}\n" .
                "Tanggal: {$tanggal}\n" .
                "Waktu: {$jamMulai} - {$jamSelesai}\n" .
                "Catatan PIC: {$catatan}\n\n" .
                "Silakan cek RAPI-Sekolah untuk informasi lengkap.";
        }


        /*
        |--------------------------------------------------------------------------
        | KIRIM WHATSAPP KE PENGAJU
        |--------------------------------------------------------------------------
        */

        $waSent = $whatsApp->send(
            $event->user->phone ?? null,
            $message
        );


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        $successMessage = match ($validated['status']) {

            'disetujui' =>
                'Agenda berhasil disetujui.',

            'ditolak' =>
                'Agenda berhasil ditolak.',
        };


        if (!$waSent) {

            return redirect()
                ->route(
                    'pic.events.show',
                    $event
                )
                ->with(
                    'success',
                    $successMessage
                )
                ->with(
                    'warning',
                    'Status agenda berhasil diperbarui, tetapi notifikasi WhatsApp gagal dikirim.'
                );
        }


        return redirect()
            ->route(
                'pic.events.show',
                $event
            )
            ->with(
                'success',
                $successMessage .
                ' Notifikasi WhatsApp berhasil dikirim.'
            );
    }


    /**
     * Memastikan agenda memang berasal
     * dari ruangan yang ditangani PIC.
     */
    private function authorizePicRoom(
        Event $event
    ): void {
        if (
            !$event->room ||
            (int) $event->room->pic_id !==
            (int) auth()->id()
        ) {
            abort(
                403,
                'Anda tidak memiliki akses ke agenda ini.'
            );
        }
    }
}