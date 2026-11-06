<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Complaint;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();


        // =========================
        // AGENDA
        // =========================

        $totalEvents = Event::where('user_id', $userId)
            ->count();

        $pendingEvents = Event::where('user_id', $userId)
            ->where('status', 'diajukan')
            ->count();

        $approvedEvents = Event::where('user_id', $userId)
            ->where('status', 'disetujui')
            ->count();

        $rejectedEvents = Event::where('user_id', $userId)
            ->where('status', 'ditolak')
            ->count();


        // Agenda yang pernah dipindahkan Admin
        $movedEvents = Event::where('user_id', $userId)
            ->whereNotNull('move_reason')
            ->where('move_reason', '!=', '')
            ->count();


        // Agenda yang sudah memiliki catatan PIC
        $notedEvents = Event::where('user_id', $userId)
            ->whereNotNull('pic_note')
            ->where('pic_note', '!=', '')
            ->count();


        // Agenda terbaru
        $latestEvents = Event::with([
                'room.pic'
            ])
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();


        // =========================
        // INFORMASI / NOTIFIKASI AGENDA
        // =========================

        $importantEvents = Event::with('room')
            ->where('user_id', $userId)
            ->where(function ($query) {

                $query->whereIn('status', [
                    'disetujui',
                    'ditolak'
                ])
                ->orWhereNotNull('move_reason')
                ->orWhereNotNull('pic_note');

            })
            ->latest('updated_at')
            ->take(5)
            ->get();


        // =========================
        // PENGADUAN
        // =========================

        $totalComplaints = Complaint::where('user_id', $userId)
            ->count();

        $reportedComplaints = Complaint::where('user_id', $userId)
            ->where('status', 'dilaporkan')
            ->count();

        $processingComplaints = Complaint::where('user_id', $userId)
            ->where('status', 'diproses')
            ->count();

        $completedComplaints = Complaint::where('user_id', $userId)
            ->where('status', 'selesai')
            ->count();


        // Pengaduan terbaru
        $latestComplaints = Complaint::with('room')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();


        // =========================
        // VIEW
        // =========================

        return view('guru.dashboard', compact(

            // Agenda
            'totalEvents',
            'pendingEvents',
            'approvedEvents',
            'rejectedEvents',
            'movedEvents',
            'notedEvents',
            'latestEvents',
            'importantEvents',

            // Pengaduan
            'totalComplaints',
            'reportedComplaints',
            'processingComplaints',
            'completedComplaints',
            'latestComplaints'

        ));
    }
}