<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Airplane;
use App\Models\Seat;

class AirplaneController extends Controller
{
    public function index() {
        $airplanes = Airplane::with('airline')->latest()->paginate(10);
        return view('admin.airplanes.index', compact('airplanes'));
    }
    public function create() { 
        $airlines = \App\Models\Airline::all();
        return view('admin.airplanes.create', compact('airlines')); 
    }
    
    public function store(Request $request) {
        $validated = $request->validate([
            'airline_id' => 'required|exists:airlines,id',
            'model' => 'required|string|max:255',
            'registration_number' => 'required|string|unique:airplanes,registration_number',
            'capacity' => 'required|integer|min:10',
        ]);

        DB::beginTransaction();
        try {
            $plane = Airplane::create($validated);
            
            // Auto-generate seats berdasarkan kapasitas
            $seats = [];
            $rows = intdiv($plane->capacity, 6);
            for ($r = 1; $r <= $rows; $r++) {
                foreach (['A','B','C','D','E','F'] as $col) {
                    $seats[] = [
                        'airplane_id' => $plane->id,
                        'seat_number' => $r . $col,
                        'class' => ($r <= 3) ? 'business' : 'economy', // Logika kelas sederhana
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
            if (!empty($seats)) Seat::insert($seats);
            
            DB::commit();
            return redirect()->route('admin.airplanes.index')->with('success', 'Pesawat & kursi berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function edit(Airplane $airplane) {
        $airlines = \App\Models\Airline::all();
        return view('admin.airplanes.edit', compact('airplane', 'airlines'));
    }
    
    public function update(Request $request, Airplane $airplane) {
        $validated = $request->validate([
            'airline_id' => 'required|exists:airlines,id',
            'model' => 'required|string|max:255',
            'registration_number' => 'required|string|unique:airplanes,registration_number,' . $airplane->id,
            'capacity' => 'required|integer|min:10',
        ]);
        $airplane->update($validated);
        return redirect()->route('admin.airplanes.index')->with('success', 'Data pesawat diperbarui.');
    }

    public function destroy(Airplane $airplane) {
        $airplane->delete();
        return back()->with('success', 'Pesawat dihapus.');
    }
}