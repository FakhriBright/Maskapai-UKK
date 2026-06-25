<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Airline;
use App\Models\Airport;
use App\Models\Flight;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_airlines' => Airline::count(),
            'total_airports' => Airport::count(),
            'active_flights' => Flight::where('departure_time', '>', now())->count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}