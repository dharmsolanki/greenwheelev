<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Order,ServiceBooking,DealerApplication,ContactMessage,SparePart,Scooter,TestRideBooking,Review};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class DashboardController extends Controller {
    public function loginForm() {
        if(session('admin_logged_in')) return redirect()->route('admin.dashboard');
        return view('admin.login');
    }
    public function login(Request $request) {
        $request->validate(['email'=>'required|email','password'=>'required']);
        $user = \App\Models\User::where('email',$request->email)->first();
        if($user && Hash::check($request->password,$user->password) && in_array($user->role,['admin','staff'])) {
            session(['admin_logged_in'=>true,'admin_name'=>$user->name,'admin_role'=>$user->role,'admin_id'=>$user->id]);
            return redirect()->route('admin.dashboard');
        }
        return back()->withErrors(['email'=>'Invalid credentials.']);
    }
    public function logout() { session()->flush(); return redirect()->route('admin.login'); }
    public function index() {
        $stats = [
            'orders_today' => Order::whereDate('created_at',today())->count(),
            'orders_pending' => Order::where('status','pending')->count(),
            'revenue_today' => Order::whereDate('created_at',today())->whereIn('status',['confirmed','processing','shipped','delivered'])->sum('total'),
            'revenue_month' => Order::whereMonth('created_at',now()->month)->whereIn('status',['confirmed','processing','shipped','delivered'])->sum('total'),
            'service_pending' => ServiceBooking::where('status','pending')->count(),
            'dealer_pending' => DealerApplication::where('status','pending')->count(),
            'low_stock' => SparePart::where('stock','<=',5)->where('is_active',true)->count(),
            'unread_messages' => ContactMessage::where('is_read',false)->count(),
            'test_rides_today' => TestRideBooking::whereDate('preferred_date',today())->count(),
            'pending_reviews' => Review::where('is_approved',false)->count(),
        ];
        $recent_orders = Order::with('items')->latest()->take(8)->get();
        $recent_bookings = ServiceBooking::latest()->take(5)->get();
        $monthly_revenue = Order::selectRaw('MONTH(created_at) as month, SUM(total) as total')
            ->whereYear('created_at',now()->year)->whereIn('status',['confirmed','processing','shipped','delivered'])
            ->groupBy('month')->pluck('total','month');
        return view('admin.dashboard', compact('stats','recent_orders','recent_bookings','monthly_revenue'));
    }
    public function messages() {
        $messages = ContactMessage::latest()->paginate(20);
        return view('admin.messages', compact('messages'));
    }
    public function markRead(ContactMessage $message) {
        $message->update(['is_read'=>true]);
        return back()->with('success','Marked as read.');
    }
    public function destroyMessage(ContactMessage $message) {
        $message->delete(); return back()->with('success','Message deleted.');
    }
}
