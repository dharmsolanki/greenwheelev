<?php
namespace App\Http\Controllers;
use App\Models\BlogPost;
use Illuminate\Http\Request;
class BlogController extends Controller {
    public function index(Request $request) {
        $q = BlogPost::published();
        if($request->category) $q->where('category',$request->category);
        $posts = $q->latest('published_at')->paginate(9);
        $categories = BlogPost::published()->distinct()->pluck('category');
        return view('pages.blog', compact('posts','categories'));
    }
    public function show(BlogPost $post) {
        abort_unless($post->is_published, 404);
        $related = BlogPost::published()->where('category',$post->category)->where('id','!=',$post->id)->take(3)->get();
        return view('pages.blog-detail', compact('post','related'));
    }
}
