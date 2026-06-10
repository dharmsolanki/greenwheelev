<?php
namespace App\Http\Controllers;
use App\Models\{Scooter, TestRideBooking};
use Illuminate\Http\Request;
class ScooterController extends Controller {
    public function index(Request $request) {
        $q = Scooter::with('images')->active();
        if ($request->category && $request->category !== 'all') $q->where('category',$request->category);
        $scooters = $q->get();
        $compare  = $request->compare ? Scooter::with('images')->whereIn('id', explode(',', $request->compare))->get() : collect();
        return view('pages.scooters', compact('scooters','compare'));
    }
    public function show(Scooter $scooter) {
        $scooter->load('images');
        $related = Scooter::with('images')->active()->where('category',$scooter->category)->where('id','!=',$scooter->id)->take(3)->get();
        return view('pages.scooter-detail', compact('scooter','related'));
    }
    public function compare(Request $request) {
        $ids      = explode(',', $request->ids ?? '');
        $scooters = Scooter::with('images')->whereIn('id', array_slice($ids,0,3))->get();
        return view('pages.scooter-compare', compact('scooters'));
    }
    public function bookTestRide(Request $request) {
        $request->validate(['name'=>'required','phone'=>'required','preferred_date'=>'required|date|after:today','vehicle_interest'=>'required']);
        TestRideBooking::create($request->only('name','phone','preferred_date','vehicle_interest'));
        return back()->with('success','✅ Test ride booked! We will call you to confirm.');
    }
}
