<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\ShiprocketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShiprocketWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Shiprocket Webhook', $request->all());

        $orderId  = $request->input('order_id') ?? $request->input('awb');
        $srStatus = $request->input('current_status') ?? $request->input('status');
        $awb      = $request->input('awb');

        if (!$orderId || !$srStatus) {
            return response()->json(['ok' => false, 'msg' => 'Missing data'], 400);
        }

        // Find order by shiprocket order id OR order_no
        $order = Order::where('shiprocket_order_id', $orderId)
                    ->orWhere('order_no', $orderId)
                    ->first();

        if (!$order) {
            return response()->json(['ok' => false, 'msg' => 'Order not found'], 404);
        }

        $newStatus = ShiprocketService::mapStatus($srStatus);
        
        $updateData = ['status' => $newStatus];
        if ($awb) $updateData['tracking_number'] = $awb;

        $order->update($updateData);

        Log::info("Order {$order->order_no} status updated to {$newStatus}");

        return response()->json(['ok' => true]);
    }
}
