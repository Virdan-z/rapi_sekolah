<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Event;
use App\Models\Complaint;

class DashboardController extends Controller
{
    public function index()
    {
        // =========================
        // RUANGAN
        // =========================
        $totalRooms = Room::count();


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