<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
class GalleryAdminController extends Controller {
    public function index() { return view('admin.gallery.index', ['images'=>GalleryImage::orderBy('sort_order')->paginate(24)]); }
    public function create() { return view('admin.gallery.form', ['image'=>new GalleryImage]); }
    public function store(Request $request) {
        $request->validate(['title'=>'required','category'=>'required','image'=>'required|image|max:5120']);
        $path = $request->file('image')->store('gallery','public');
        GalleryImage::create([...$request->only('title','category','description','sort_order'),'image_path'=>$path]);
        return redirect()->route('admin.gallery.index')->with('success','Image uploaded!');
    }
    public function edit(GalleryImage $gallery) { return view('admin.gallery.form', ['image'=>$gallery]); }
    public function update(Request $request, GalleryImage $gallery) {
        $data = $request->only('title','category','description','sort_order','is_active');
        if($request->hasFile('image')) $data['image_path'] = $request->file('image')->store('gallery','public');
        $gallery->update($data);
        return redirect()->route('admin.gallery.index')->with('success','Updated!');
    }
    public function destroy(GalleryImage $gallery) { $gallery->delete(); return back()->with('success','Deleted.'); }
    public function show(GalleryImage $gallery) { return view('admin.gallery.show', compact('gallery')); }
}
