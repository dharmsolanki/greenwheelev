<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\ShiprocketService;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    public function index(Request $request) {
        $q = Order::with('items')->latest();
        if($request->status) $q->where('status',$request->status);
        if($request->payment) $q->where('payment_method',$request->payment);
        if($request->search) $q->where(fn($q2)=>$q2
            ->where('order_no','like','%'.$request->search.'%')
            ->orWhere('name','like','%'.$request->search.'%')
            ->orWhere('phone','like','%'.$request->search.'%'));
        $orders = $q->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order) {
        $order->load('items');

        // Get live tracking if available
        $trackingData = null;
        if ($order->tracking_number) {
            try {
                $sr           = new ShiprocketService();
                $trackingData = $sr->trackByAwb($order->tracking_number);
            } catch (\Exception $e) {}
        }

        return view('admin.orders.show', compact('order','trackingData'));
    }

    public function updateStatus(Order $order, Request $request) {
        $request->validate(['status'=>'required|in:pending,confirmed,processing,shipped,delivered,cancelled']);
        $order->update(['status'=>$request->status]);
        return back()->with('success','Order status updated to '.$request->status);
    }

    public function destroy(Order $order) {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success','Order deleted.');
    }

    // Manually create Shiprocket shipment from admin
    public function createShipment(Order $order) {
        try {
            $sr     = new ShiprocketService();
            $order->load('items');
            $result = $sr->createOrder($order);

            if ($result['success']) {
                $order->update([
                    'shiprocket_order_id'    => $result['order_id'],
                    'shiprocket_shipment_id' => $result['shipment_id'],
                    'status'                 => 'confirmed',
                ]);
                return back()->with('success','Shipment created on Shiprocket! Order ID: '.$result['order_id']);
            }
            return back()->with('error','❌ Shiprocket error: '.json_encode($result['error']));
        } catch (\Exception $e) {
            return back()->with('error','❌ Error: '.$e->getMessage());
        }
    }

    // Track shipment from admin
    public function trackShipment(Order $order) {
        if (!$order->tracking_number && !$order->shiprocket_order_id) {
            return back()->with('error','No tracking info available yet.');
        }
        try {
            $sr   = new ShiprocketService();
            $data = $order->tracking_number
                ? $sr->trackByAwb($order->tracking_number)
                : $sr->trackOrder($order->shiprocket_order_id);
            return back()->with('tracking', $data);
        } catch (\Exception $e) {
            return back()->with('error','Tracking error: '.$e->getMessage());
        }
    }

    // Cancel shipment
    public function cancelShipment(Order $order) {
        if (!$order->shiprocket_order_id) {
            return back()->with('error','No Shiprocket order found.');
        }
        try {
            $sr = new ShiprocketService();
            $sr->cancelOrder([$order->shiprocket_order_id]);
            $order->update(['status'=>'cancelled']);
            return back()->with('success','Shipment cancelled.');
        } catch (\Exception $e) {
            return back()->with('error','Cancel error: '.$e->getMessage());
        }
    }
}
