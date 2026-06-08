<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{ServiceBooking,TestRideBooking,DealerApplication};
use Illuminate\Http\Request;
class BookingController extends Controller {
    public function index(Request $request) {
        $q = ServiceBooking::latest();
        if($request->status) $q->where('status',$request->status);
        $bookings = $q->paginate(20);
        return view('admin.bookings.service', compact('bookings'));
    }
    public function show(ServiceBooking $booking) { return view('admin.bookings.service-show', compact('booking')); }
    public function updateStatus(ServiceBooking $booking, Request $request) {
        $booking->update(['status'=>$request->status,'admin_notes'=>$request->admin_notes]);
        return back()->with('success','Status updated!');
    }
    public function testRides(Request $request) {
        $bookings = TestRideBooking::latest()->paginate(20);
        return view('admin.bookings.test-rides', compact('bookings'));
    }
    public function updateTestRideStatus(TestRideBooking $booking, Request $request) {
        $booking->update(['status'=>$request->status]);
        return back()->with('success','Status updated!');
    }
    public function dealers() {
        $applications = DealerApplication::latest()->paginate(20);
        return view('admin.bookings.dealers', compact('applications'));
    }
    public function dealerShow(DealerApplication $application) { return view('admin.bookings.dealer-show', compact('application')); }
    public function dealerStatus(DealerApplication $application, Request $request) {
        $application->update(['status'=>$request->status,'admin_notes'=>$request->admin_notes]);
        return back()->with('success','Application status updated!');
    }
}
