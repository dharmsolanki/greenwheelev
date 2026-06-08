<?php
namespace App\Http\Controllers;

use App\Models\{Order, OrderItem, SparePart};
use App\Services\ShiprocketService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function addToCart(Request $request) {
        $part = SparePart::findOrFail($request->part_id);
        $cart = session()->get('cart', []);
        if (isset($cart[$part->id])) $cart[$part->id]['qty'] += $request->qty ?? 1;
        else $cart[$part->id] = ['id'=>$part->id,'name'=>$part->name,'icon'=>$part->icon,'price'=>(float)$part->price,'qty'=>$request->qty ?? 1];
        session()->put('cart', $cart);
        $count = array_sum(array_column($cart,'qty'));
        $total = array_sum(array_map(fn($i)=>$i['price']*$i['qty'], $cart));
        return response()->json(['success'=>true,'count'=>$count,'message'=>$part->name.' added to cart!','cart'=>$cart,'total'=>$total]);
    }

    public function updateCart(Request $request) {
        $cart = session()->get('cart',[]);
        if (isset($cart[$request->id])) {
            if ($request->qty <= 0) unset($cart[$request->id]);
            else $cart[$request->id]['qty'] = $request->qty;
            session()->put('cart',$cart);
        }
        $total = array_sum(array_map(fn($i)=>$i['price']*$i['qty'],$cart));
        return response()->json(['success'=>true,'cart'=>$cart,'total'=>$total]);
    }

    public function removeFromCart(Request $request) {
        $cart = session()->get('cart',[]);
        unset($cart[$request->id]);
        session()->put('cart',$cart);
        $count = array_sum(array_column($cart,'qty'));
        $total = array_sum(array_map(fn($i)=>$i['price']*$i['qty'],$cart));
        return response()->json(['success'=>true,'cart'=>$cart,'total'=>$total,'count'=>$count]);
    }

    public function clearCart() {
        session()->forget('cart');
        return response()->json(['success'=>true]);
    }

    public function cart() {
        $cart  = session()->get('cart',[]);
        $total = array_sum(array_map(fn($i)=>$i['price']*$i['qty'],$cart));
        return view('pages.cart', compact('cart','total'));
    }

    public function checkout() {
        $cart = session()->get('cart',[]);
        if(empty($cart)) return redirect()->route('parts.index')->with('error','Cart is empty!');
        $total = array_sum(array_map(fn($i)=>$i['price']*$i['qty'],$cart));
        return view('pages.checkout', compact('cart','total'));
    }

    public function placeCOD(Request $request) {
        $request->validate([
            'name'    => 'required',
            'phone'   => 'required',
            'address' => 'required',
            'city'    => 'required',
            'state'   => 'required',
            'pincode' => 'required|digits:6',
        ]);

        $cart     = session()->get('cart',[]);
        if(empty($cart)) return redirect()->route('cart.index');
        $subtotal = array_sum(array_map(fn($i)=>$i['price']*$i['qty'],$cart));

        $order = Order::create([
            ...$request->only('name','phone','email','address','city','state','pincode','notes'),
            'order_no'       => Order::generateOrderNo(),
            'payment_method' => 'cod',
            'subtotal'       => $subtotal,
            'shipping'       => 0,
            'total'          => $subtotal,
        ]);

        foreach($cart as $item) {
            OrderItem::create([
                'order_id'      => $order->id,
                'spare_part_id' => $item['id'],
                'part_name'     => $item['name'],
                'price'         => $item['price'],
                'qty'           => $item['qty'],
                'subtotal'      => $item['price'] * $item['qty'],
            ]);
            SparePart::where('id',$item['id'])->decrement('stock',$item['qty']);
        }

        session()->forget('cart');

        // Create Shiprocket shipment
        $this->createShiprocketShipment($order);

        return redirect()->route('order.success', $order->order_no);
    }

    public function createRazorpayOrder(Request $request) {
        $cart  = session()->get('cart',[]);
        $total = array_sum(array_map(fn($i)=>$i['price']*$i['qty'],$cart));
        $key   = config('services.razorpay.key_secret');
        $ch    = curl_init('https://api.razorpay.com/v1/orders');
        curl_setopt_array($ch,[
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_USERPWD        => config('services.razorpay.key_id').':'.$key,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS     => json_encode(['amount'=>$total*100,'currency'=>'INR','receipt'=>'gwe_'.time()]),
        ]);
        $res = json_decode(curl_exec($ch),true);
        curl_close($ch);
        return response()->json([
            'order_id' => $res['id'] ?? null,
            'amount'   => $total * 100,
            'key'      => config('services.razorpay.key_id'),
            'name'     => $request->name,
            'phone'    => $request->phone,
        ]);
    }

    public function verifyRazorpay(Request $request) {
        $cart     = session()->get('cart',[]);
        $subtotal = array_sum(array_map(fn($i)=>$i['price']*$i['qty'],$cart));

        $order = Order::create([
            ...$request->only('name','phone','email','address','city','state','pincode'),
            'order_no'            => Order::generateOrderNo(),
            'payment_method'      => 'razorpay',
            'payment_id'          => $request->payment_id,
            'razorpay_order_id'   => $request->razorpay_order_id,
            'status'              => 'confirmed',
            'subtotal'            => $subtotal,
            'shipping'            => 0,
            'total'               => $subtotal,
        ]);

        foreach($cart as $item) {
            OrderItem::create([
                'order_id'      => $order->id,
                'spare_part_id' => $item['id'],
                'part_name'     => $item['name'],
                'price'         => $item['price'],
                'qty'           => $item['qty'],
                'subtotal'      => $item['price'] * $item['qty'],
            ]);
            SparePart::where('id',$item['id'])->decrement('stock',$item['qty']);
        }

        session()->forget('cart');

        // Create Shiprocket shipment
        $this->createShiprocketShipment($order);

        return response()->json(['success'=>true,'order_no'=>$order->order_no]);
    }

    // Create Shiprocket Shipment (called after both COD & Online orders)
    private function createShiprocketShipment(Order $order): void
    {
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
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Shiprocket error: '.$e->getMessage());
        }
    }

    public function orderSuccess($orderNo) {
        $order = Order::with('items')->where('order_no',$orderNo)->firstOrFail();
        return view('pages.order-success', compact('order'));
    }

    public function trackOrder($orderNo) {
        $order = Order::with('items')->where('order_no',$orderNo)->firstOrFail();

        // Live tracking from Shiprocket
        $trackingData = null;
        if ($order->tracking_number) {
            try {
                $sr           = new ShiprocketService();
                $trackingData = $sr->trackByAwb($order->tracking_number);
            } catch (\Exception $e) {}
        }

        return view('pages.order-track', compact('order','trackingData'));
    }
}
