<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Airport;
use App\Models\Flight;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data bandara untuk dropdown pencarian
        $airports = Airport::orderBy('city')->get();
        
        // Jika ada parameter pencarian, lakukan query
        $flights = collect();
        if ($request->filled(['origin', 'destination', 'date'])) {
            $flights = Flight::with(['airline', 'departureAirport', 'arrivalAirport'])
                ->where('departure_airport_id', $request->origin)
                ->where('arrival_airport_id', $request->destination)
                ->whereDate('departure_time', $request->date)
                ->where('available_seats', '>', 0)
                ->get();
        }

        return view('customer.dashboard', compact('airports', 'flights'));
    }
}