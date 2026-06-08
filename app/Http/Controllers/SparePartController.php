<?php
namespace App\Http\Controllers;
use App\Models\SparePart;
use Illuminate\Http\Request;
class SparePartController extends Controller {
    public function index(Request $request) {
        $q = SparePart::active();
        if ($request->category && $request->category !== 'all') $q->where('category',$request->category);
        if ($request->search) $q->where('name','like','%'.$request->search.'%');
        $parts = $q->get();
        return view('pages.parts', compact('parts'));
    }
    public function show(SparePart $part) {
        $related = SparePart::active()->where('category',$part->category)->where('id','!=',$part->id)->take(4)->get();
        return view('pages.part-detail', compact('part','related'));
    }
}
