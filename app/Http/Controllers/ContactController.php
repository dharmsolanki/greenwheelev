<?php
namespace App\Http\Controllers;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
class ContactController extends Controller {
    public function index() { return view('pages.contact'); }
    public function send(Request $request) {
        $request->validate(['name'=>'required','phone'=>'required','subject'=>'required','message'=>'required']);
        ContactMessage::create($request->only('name','phone','email','subject','message'));
        return back()->with('success','✅ Message sent! We will reply within a few hours.');
    }
}
