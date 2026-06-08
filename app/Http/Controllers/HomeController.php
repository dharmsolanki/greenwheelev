<?php
namespace App\Http\Controllers;
use App\Models\{Scooter, SparePart, Review, BlogPost};
use Illuminate\Http\Request;
class HomeController extends Controller {
    public function index() {
        $scooters = Scooter::active()->where('is_featured',true)->take(3)->get();
        $parts = SparePart::active()->take(6)->get();
        $reviews = Review::approved()->latest()->take(3)->get();
        $blogs = BlogPost::published()->latest()->take(3)->get();
        return view('pages.home', compact('scooters','parts','reviews','blogs'));
    }
    public function about() { return view('pages.about'); }
    public function calculateEMI(Request $request) {
        $loan = $request->loan; $rate = $request->rate / 12 / 100; $months = $request->months;
        $emi = $loan * ($rate * pow(1+$rate,$months)) / (pow(1+$rate,$months)-1);
        $total = round($emi * $months);
        return response()->json(['emi'=>round($emi),'total'=>$total,'interest'=>$total-$loan]);
    }
}
