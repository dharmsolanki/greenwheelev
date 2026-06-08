<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class BlogAdminController extends Controller {
    public function index() { return view('admin.blog.index', ['posts'=>BlogPost::latest()->paginate(20)]); }
    public function create() { return view('admin.blog.form', ['post'=>new BlogPost]); }
    public function store(Request $request) {
        $request->validate(['title'=>'required','excerpt'=>'required','content'=>'required','category'=>'required']);
        $data = $request->all(); $data['slug'] = Str::slug($request->title);
        if($request->hasFile('image')) $data['image'] = $request->file('image')->store('blog','public');
        if($request->is_published) $data['published_at'] = now();
        BlogPost::create($data);
        return redirect()->route('admin.blog.index')->with('success','Post created!');
    }
    public function edit(BlogPost $blog) { return view('admin.blog.form', ['post'=>$blog]); }
    public function update(Request $request, BlogPost $blog) {
        $data = $request->all();
        if($request->hasFile('image')) $data['image'] = $request->file('image')->store('blog','public');
        if($request->is_published && !$blog->published_at) $data['published_at'] = now();
        $blog->update($data);
        return redirect()->route('admin.blog.index')->with('success','Post updated!');
    }
    public function destroy(BlogPost $blog) { $blog->delete(); return back()->with('success','Deleted.'); }
    public function show(BlogPost $blog) { return view('admin.blog.show', compact('blog')); }
}
