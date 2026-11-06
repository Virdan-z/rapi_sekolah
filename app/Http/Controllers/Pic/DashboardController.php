<?php

namespace App\Http\Controllers\Pic;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Complaint;
use App\Models\Event;

class DashboardController extends Controller
{
    public function index()
    {
        $picId = auth()->id();

        $rooms = Room::where('pic_id', $picId)->get();

        $roomIds = $rooms->pluck('id');

        $totalRooms = $rooms->count();

        $totalComplaints = Complaint::whereIn('room_id', $roomIds)->count();

        $reportedComplaints = Complaint::whereIn('room_id', $roomIds)
            ->where('status', 'dilaporkan')
            ->count();

        $processingComplaints = Complaint::whereIn('room_id', $roomIds)
            ->where('status', 'diproses')
            ->count();

        $completedComplaints = Complaint::whereIn('room_id', $roomIds)
            ->where('status', 'selesai')
            ->count();

        $totalEvents = Event::whereIn('room_id', $roomIds)->count();

        $pendingEvents = Event::whereIn('room_id', $roomIds)
            ->where('status', 'diajukan')
            ->count();

        $approvedEvents = Event::whereIn('room_id', $roomIds)
            ->where('status', 'disetujui')
            ->count();

        return view('pic.dashboard', compact(
            'rooms',
            'totalRooms',
            'totalComplaints',
            'reportedComplaints',
            'processingComplaints',
            'completedComplaints',
            'totalEvents',
            'pendingEvents',
            'approvedEvents'
        ));
    }
}