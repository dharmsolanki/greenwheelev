<?php
namespace App\Http\Controllers;
use App\Models\DealerApplication;
use Illuminate\Http\Request;
class DealershipController extends Controller {
    public function index() { return view('pages.dealership'); }
    public function apply(Request $request) {
        $request->validate(['name'=>'required','phone'=>'required','email'=>'required|email','city'=>'required','state'=>'required','investment_capacity'=>'required']);
        DealerApplication::create($request->only('name','phone','email','city','state','investment_capacity','showroom_space'));
        return back()->with('success','Application submitted! Our team will contact you within 24 hours.');
    }
}
