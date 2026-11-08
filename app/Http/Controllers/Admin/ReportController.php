<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Event;
use App\Models\Room;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $roomId = $request->input('room_id');
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Query Laporan Pengaduan
        $complaintsQuery = Complaint::with(['room.pics', 'user'])->latest();
        if ($roomId) {
            $complaintsQuery->where('room_id', $roomId);
        }
        if ($status) {
            $complaintsQuery->where('status', $status);
        }
        if ($startDate && $endDate) {
            $complaintsQuery->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }
        $complaints = $complaintsQuery->get();

        // Query Laporan Agenda
        $eventsQuery = Event::with(['room.pics', 'user'])->latest();
        if ($roomId) {
            $eventsQuery->where('room_id', $roomId);
        }
        if ($startDate && $endDate) {
            $eventsQuery->whereBetween('event_date', [$startDate, $endDate]);
        }
        $events = $eventsQuery->get();

        $rooms = Room::with('pics')->orderBy('name')->get();

        return view('admin.reports.index', compact('complaints', 'events', 'rooms', 'roomId', 'status', 'startDate', 'endDate'));
    }
}