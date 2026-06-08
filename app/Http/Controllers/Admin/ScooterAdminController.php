<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Scooter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class ScooterAdminController extends Controller {
    public function index() { return view('admin.scooters.index', ['scooters'=>Scooter::latest()->paginate(20)]); }
    public function create() { return view('admin.scooters.form', ['scooter'=>new Scooter]); }
    public function store(Request $request) {
        $request->validate(['name'=>'required','category'=>'required','price'=>'required|numeric','range'=>'required','top_speed'=>'required','charging_time'=>'required','motor_power'=>'required']);
        $data = $request->all(); $data['slug'] = Str::slug($request->name);
        if($request->hasFile('image')) $data['image'] = $request->file('image')->store('scooters','public');
        Scooter::create($data);
        return redirect()->route('admin.scooters.index')->with('success','Scooter added!');
    }
    public function edit(Scooter $scooter) { return view('admin.scooters.form', compact('scooter')); }
    public function update(Request $request, Scooter $scooter) {
        $data = $request->all();
        if($request->hasFile('image')) $data['image'] = $request->file('image')->store('scooters','public');
        $scooter->update($data);
        return redirect()->route('admin.scooters.index')->with('success','Scooter updated!');
    }
    public function destroy(Scooter $scooter) { $scooter->delete(); return back()->with('success','Deleted.'); }
    public function show(Scooter $scooter) { return view('admin.scooters.show', compact('scooter')); }
}
