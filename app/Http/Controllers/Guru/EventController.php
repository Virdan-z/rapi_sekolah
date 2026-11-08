<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Room;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Throwable;

class EventController extends Controller
{
    /**
     * Menampilkan daftar agenda milik Guru.
     */
    public function index()
    {
        $events = Event::with('room')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('guru.events.index', compact('events'));
    }

    /**
     * Menampilkan form pengajuan agenda.
     */
    public function create()
    {
        $rooms = Room::orderBy('name')->get();

        return view('guru.events.create', compact('rooms'));
    }

    /**
     * Menyimpan pengajuan agenda dan mengirim WhatsApp ke PIC.
     */
    public function store(Request $request)
    {
        // Jadwal sesi
        $sessionSchedules = [
            '1' => [
                'start_time' => '08:00',
                'end_time' => '10:00',
            ],
            '2' => [
                'start_time' => '10:00',
                'end_time' => '12:00',
            ],
            '3' => [
                'start_time' => '13:00',
                'end_time' => '15:00',
            ],
        ];

        // Validasi input
        $today = Carbon::now('Asia/Jakarta')->toDateString();

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'title' => 'required|string|max:255',
            'event_date' => [
                'required',
                'date',
                'after_or_equal:' . $today,
            ],
            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:event_date',
            ],
            'session' => 'required|in:1,2,3',
            'description' => 'nullable|string',
        ]);

        // Ambil jam berdasarkan sesi yang dipilih
        $selectedSession = $validated['session'];

        $startTime = $sessionSchedules[$selectedSession]['start_time'];
        $endTime = $sessionSchedules[$selectedSession]['end_time'];

        // Cek bentrok ruangan
        $conflict = Event::where('room_id', $validated['room_id'])
            ->where('event_date', $validated['event_date'])
            ->whereIn('status', ['diajukan', 'disetujui'])
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where('start_time', '<', $endTime)
                    ->where('end_time', '>', $startTime);
            })
            ->exists();

        if ($conflict) {
            return back()
                ->withInput()
                ->withErrors([
                    'session' => 'Ruangan sudah digunakan pada sesi tersebut.',
                ]);
        }

        // Simpan agenda
        $event = Event::create([
            'room_id' => $validated['room_id'],
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'event_date' => $validated['event_date'],
            'end_date' => $validated['end_date'] ?? null,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'description' => $validated['description'] ?? null,
            'status' => 'diajukan',
        ]);

        // Ambil data ruangan, PIC, dan Guru
        $event->load(['room.pics', 'user']);

        $room = $event->room;
        // Karena relasi room ke pics menggunakan Many-to-Many, kita ambil PIC pertama atau foreach nomornya
        $pics = $room?->pics;
        $guru = $event->user;

        // Jika PIC atau nomor telepon belum tersedia
        if (!$pics || $pics->isEmpty() || $pics->every(fn($p) => empty($p->phone))) {
            Log::warning(
                'Notifikasi WhatsApp ke PIC tidak dikirim karena PIC atau nomor telepon belum tersedia.',
                [
                    'event_id' => $event->id,
                    'room_id' => $event->room_id,
                ]
            );

            return redirect()
                ->route('guru.events.index')
                ->with('success', 'Pengajuan agenda berhasil dikirim.')
                ->with(
                    'warning',
                    'Notifikasi WhatsApp belum dikirim. Pastikan ruangan memiliki PIC dan nomor telepon.'
                );
        }

        // Susun pesan WhatsApp
        $tanggalMulai = Carbon::parse($event->event_date)->format('d-m-Y');
        $tanggalSelesai = $event->end_date ? Carbon::parse($event->end_date)->format('d-m-Y') : null;
        
        $infoTanggal = $tanggalSelesai && $tanggalSelesai !== $tanggalMulai 
            ? "{$tanggalMulai} s/d {$tanggalSelesai}" 
            : $tanggalMulai;

        $jamMulai = substr((string) $event->start_time, 0, 5);
        $jamSelesai = substr((string) $event->end_time, 0, 5);

        $lokasi = $room->location ?? '-';
        $namaGuru = $guru?->name ?? 'Guru';

        $waSent = false;
        $whatsApp = app(WhatsAppService::class);

        // Kirim ke semua PIC yang bertugas di ruangan tersebut
        foreach ($pics as $pic) {
            if (empty($pic->phone)) continue;

            $message =
                "Halo {$pic->name},\n\n" .
                "Ada pengajuan agenda baru di RAPI-Sekolah.\n\n" .
                "Judul Agenda: {$event->title}\n" .
                "Pengaju: {$namaGuru}\n" .
                "Ruangan: {$room->name}\n" .
                "Lokasi: {$lokasi}\n" .
                "Tanggal: {$infoTanggal}\n" .
                "Waktu: {$jamMulai} - {$jamSelesai}\n" .
                "Status: Diajukan\n\n" .
                "Silakan login ke RAPI-Sekolah untuk memeriksa dan memproses pengajuan agenda ini.";

            try {
                $result = $whatsApp->send($pic->phone, $message);
                if ($result) {
                    $waSent = true;
                }

                Log::info(
                    'Hasil notifikasi WhatsApp pengajuan agenda ke PIC.',
                    [
                        'event_id' => $event->id,
                        'pic_id' => $pic->id,
                        'phone' => $pic->phone,
                        'result' => $result,
                    ]
                );
            } catch (Throwable $e) {
                Log::error(
                    'Terjadi kesalahan saat mengirim notifikasi WhatsApp ke PIC.',
                    [
                        'event_id' => $event->id,
                        'pic_id' => $pic->id,
                        'error' => $e->getMessage(),
                    ]
                );
            }
        }

        // Tampilkan hasil kepada Guru
        if ($waSent) {
            return redirect()
                ->route('guru.events.index')
                ->with(
                    'success',
                    'Pengajuan agenda berhasil dikirim. Permintaan notifikasi WhatsApp ke PIC berhasil diproses.'
                );
        }

        return redirect()
            ->route('guru.events.index')
            ->with('success', 'Pengajuan agenda berhasil dikirim.')
            ->with(
                'warning',
                'Agenda tersimpan, tetapi notifikasi WhatsApp ke PIC belum berhasil dikirim. Periksa nomor PIC dan koneksi.'
            );
    }

    /**
     * Menampilkan detail agenda milik Guru.
     */
    public function show(Event $event)
    {
        abort_unless(
            $event->user_id === auth()->id(),
            403
        );

        $event->load('room');

        return view('guru.events.show', compact('event'));
    }
}