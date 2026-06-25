<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Airline;

class AirlineController extends Controller
{
    public function index() {
        $airlines = Airline::latest()->paginate(10);
        return view('admin.airlines.index', compact('airlines'));
    }
    public function create() { return view('admin.airlines.create'); }
    
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:airlines,code',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('airlines/logos', 'public');
        }

        Airline::create($validated);
        return redirect()->route('admin.airlines.index')->with('success', 'Maskapai berhasil ditambahkan.');
    }

    public function edit(Airline $airline) { return view('admin.airlines.edit', compact('airline')); }
    
    public function update(Request $request, Airline $airline) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:airlines,code,' . $airline->id,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('airlines/logos', 'public');
        }

        $airline->update($validated);
        return redirect()->route('admin.airlines.index')->with('success', 'Data maskapai diperbarui.');
    }

    public function destroy(Airline $airline) {
        $airline->delete();
        return back()->with('success', 'Maskapai dihapus.');
    }
}