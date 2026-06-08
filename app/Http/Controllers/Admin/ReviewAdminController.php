<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Review;
class ReviewAdminController extends Controller {
    public function index() { return view('admin.reviews', ['reviews'=>Review::latest()->paginate(20)]); }
    public function approve(Review $review) { $review->update(['is_approved'=>!$review->is_approved]); return back()->with('success','Review status updated.'); }
    public function destroy(Review $review) { $review->delete(); return back()->with('success','Deleted.'); }
}
