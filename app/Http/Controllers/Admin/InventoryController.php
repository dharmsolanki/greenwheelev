<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\SparePart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class InventoryController extends Controller {
    public function index(Request $request) {
        $q = SparePart::query();
        if($request->category) $q->where('category',$request->category);
        if($request->search) $q->where('name','like','%'.$request->search.'%');
        if($request->stock === 'low') $q->where('stock','<=',5);
        $parts = $q->latest()->paginate(20);
        return view('admin.inventory.index', compact('parts'));
    }
    public function create() { return view('admin.inventory.form', ['part'=>new SparePart]); }
    public function store(Request $request) {
        $request->validate(['name'=>'required','category'=>'required','price'=>'required|numeric','mrp'=>'required|numeric','stock'=>'required|integer']);
        SparePart::create([...$request->all(),'slug'=>Str::slug($request->name)]);
        return redirect()->route('admin.inventory.index')->with('success','Part added successfully!');
    }
    public function edit(SparePart $inventory) { return view('admin.inventory.form', ['part'=>$inventory]); }
    public function update(Request $request, SparePart $inventory) {
        $request->validate(['name'=>'required','category'=>'required','price'=>'required|numeric','mrp'=>'required|numeric','stock'=>'required|integer']);
        $inventory->update($request->all());
        return redirect()->route('admin.inventory.index')->with('success','Part updated!');
    }
    public function destroy(SparePart $inventory) { $inventory->delete(); return back()->with('success','Part deleted.'); }
    public function updateStock(SparePart $part, Request $request) {
        $request->validate(['stock'=>'required|integer|min:0']);
        $part->update(['stock'=>$request->stock]);
        return response()->json(['success'=>true,'stock'=>$part->stock]);
    }
}
