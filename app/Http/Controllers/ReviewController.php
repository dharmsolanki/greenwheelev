<?php
namespace App\Http\Controllers;
use App\Models\Review;
use Illuminate\Http\Request;
class ReviewController extends Controller {
    public function store(Request $request) {
        $request->validate(['name'=>'required','rating'=>'required|integer|min:1|max:5','review'=>'required|min:20']);
        Review::create($request->only('name','location','rating','review'));
        return back()->with('success','Thank you! Your review will be published after verification.');
    }
}
