<?php
namespace App\Http\Controllers;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
class GalleryController extends Controller {
    public function index(Request $request) {
        $q = GalleryImage::active()->orderBy('sort_order');
        if($request->category) $q->where('category',$request->category);
        $images = $q->get();
        return view('pages.gallery', compact('images'));
    }
}
