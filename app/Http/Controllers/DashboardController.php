<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Event;
use App\Models\Complaint;
use Carbon\Carbon; // <-- Tambahan library Carbon untuk tanggal

class DashboardController extends Controller
{
    public function index()
    {
        // =========================
        // RUANGAN & RUANGAN KOSONG
        // =========================
        $totalRooms = Room::count();

        $today = Carbon::today()->toDateString();

        // Cari ID ruangan yang sedang dipakai oleh agenda yang disetujui pada hari ini
        $bookedRoomIds = Event::where('status', 'disetujui')
            ->whereDate('event_date', $today)
            ->pluck('room_id');

        // Ruangan kosong adalah ruangan yang ID-nya tidak ada dalam daftar yang dibooking hari ini
        $emptyRooms = Room::with('pics')
            ->whereNotIn('id', $bookedRoomIds)
            ->orderBy('name')
            ->get();


        // =========================
        // PENGGUNA
        // =========================
        $totalPics = User::where('role', 'pic')->count();

        $totalUsers = User::count();


        // =========================
        // AGENDA
        // =========================
        $totalEvents = Event::count();

        $pendingEvents = Event::where(
            'status',
            'diajukan'
        )->count();

        $approvedEvents = Event::where(
            'status',
            'disetujui'
        )->count();

        $rejectedEvents = Event::where(
            'status',
            'ditolak'
        )->count();


        // =========================
        // PENGADUAN
        // =========================
        $totalComplaints = Complaint::count();

        $reportedComplaints = Complaint::where(
            'status',
            'dilaporkan'
        )->count();

        $processingComplaints = Complaint::where(
            'status',
            'diproses'
        )->count();

        $completedComplaints = Complaint::where(
            'status',
            'selesai'
        )->count();


        // =========================
        // TAMPILKAN DASHBOARD
        // =========================
        return view('dashboard', compact(
            'totalRooms',
            'emptyRooms', // <-- Tambahan data ruangan kosong
            'today',      // <-- Tambahan data tanggal hari ini

            'totalPics',
            'totalUsers',

            'totalEvents',
            'pendingEvents',
            'approvedEvents',
            'rejectedEvents',

            'totalComplaints',
            'reportedComplaints',
            'processingComplaints',
            'completedComplaints'
        ));
    }
}