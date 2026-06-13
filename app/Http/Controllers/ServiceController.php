<?php
namespace App\Http\Controllers;
use App\Models\ServiceBooking;
use Illuminate\Http\Request;
class ServiceController extends Controller {
    public function index() { return view('pages.service'); }
    public function book(Request $request) {
        $request->validate(['name'=>'required','phone'=>'required','vehicle_brand'=>'required','service_type'=>'required','preferred_date'=>'required|date|after:today','preferred_time'=>'required']);
        ServiceBooking::create($request->only('name','phone','vehicle_brand','service_type','preferred_date','preferred_time','description'));
        return back()->with('success','Service booked! Confirmation SMS will be sent to '.$request->phone);
    }
}
