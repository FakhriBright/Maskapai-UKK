<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Airport;

class AirportController extends Controller
{
    public function index() {
        $airports = Airport::orderBy('city')->paginate(15);
        return view('admin.airports.index', compact('airports'));
    }
    public function create() { return view('admin.airports.create'); }
    
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'iata_code' => 'required|string|max:5|unique:airports,iata_code',
        ]);
        Airport::create($validated);
        return redirect()->route('admin.airports.index')->with('success', 'Bandara berhasil ditambahkan.');
    }

    public function edit(Airport $airport) { return view('admin.airports.edit', compact('airport')); }
    
    public function update(Request $request, Airport $airport) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'iata_code' => 'required|string|max:5|unique:airports,iata_code,' . $airport->id,
        ]);
        $airport->update($validated);
        return redirect()->route('admin.airports.index')->with('success', 'Data bandara diperbarui.');
    }

    public function destroy(Airport $airport) {
        $airport->delete();
        return back()->with('success', 'Bandara dihapus.');
    }
}