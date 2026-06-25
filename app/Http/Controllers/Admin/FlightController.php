<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\Airline;
use App\Models\Airplane;
use App\Models\Airport;

class FlightController extends Controller
{
    public function index() {
        $flights = Flight::with(['airline', 'departureAirport', 'arrivalAirport'])->latest()->paginate(15);
        return view('admin.flights.index', compact('flights'));
    }
    public function create() {
        $airlines = Airline::all();
        $airplanes = Airplane::all();
        $airports = Airport::all();
        return view('admin.flights.create', compact('airlines', 'airplanes', 'airports'));
    }
    
    public function store(Request $request) {
        $validated = $request->validate([
            'airline_id' => 'required|exists:airlines,id',
            'airplane_id' => 'required|exists:airplanes,id',
            'departure_airport_id' => 'required|exists:airports,id',
            'arrival_airport_id' => 'required|exists:airports,id|different:departure_airport_id',
            'flight_number' => 'required|string|unique:flights,flight_number',
            'departure_time' => 'required|date|before:arrival_time',
            'arrival_time' => 'required|date|after:departure_time',
            'price' => 'required|numeric|min:0',
        ]);

        // Ambil kapasitas pesawat untuk set available_seats awal
        $plane = Airplane::find($validated['airplane_id']);
        $validated['available_seats'] = $plane->capacity;

        Flight::create($validated);
        return redirect()->route('admin.flights.index')->with('success', 'Jadwal penerbangan ditambahkan.');
    }

    public function edit(Flight $flight) {
        $airlines = Airline::all();
        $airplanes = Airplane::all();
        $airports = Airport::all();
        return view('admin.flights.edit', compact('flight', 'airlines', 'airplanes', 'airports'));
    }
    
    public function update(Request $request, Flight $flight) {
        $validated = $request->validate([
            'airline_id' => 'required|exists:airlines,id',
            'airplane_id' => 'required|exists:airplanes,id',
            'departure_airport_id' => 'required|exists:airports,id',
            'arrival_airport_id' => 'required|exists:airports,id|different:departure_airport_id',
            'flight_number' => 'required|string|unique:flights,flight_number,' . $flight->id,
            'departure_time' => 'required|date|before:arrival_time',
            'arrival_time' => 'required|date|after:departure_time',
            'price' => 'required|numeric|min:0',
        ]);
        $flight->update($validated);
        return redirect()->route('admin.flights.index')->with('success', 'Jadwal diperbarui.');
    }

    public function destroy(Flight $flight) {
        $flight->delete();
        return back()->with('success', 'Jadwal dihapus.');
    }
}