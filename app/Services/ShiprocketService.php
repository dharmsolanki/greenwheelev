<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ShiprocketService
{
    private string $baseUrl = 'https://apiv2.shiprocket.in/v1/external';
    private string $email;
    private string $password;

    public function __construct()
    {
        $this->email    = config('services.shiprocket.email');
        $this->password = config('services.shiprocket.password');
    }

    // Get Auth Token (cached for 9 days)
    public function getToken(): ?string
    {
        return Cache::remember('shiprocket_token', 60 * 60 * 24 * 9, function () {
            $res = Http::post("{$this->baseUrl}/auth/login", [
                'email'    => $this->email,
                'password' => $this->password,
            ]);
            if ($res->successful()) return $res->json('token');
            Log::error('Shiprocket auth failed', $res->json());
            return null;
        });
    }

    private function headers(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->getToken(),
            'Content-Type'  => 'application/json',
        ];
    }

    // Create Order on Shiprocket
    public function createOrder(\App\Models\Order $order): array
    {
        $items = $order->items->map(fn($i) => [
            'name'     => $i->part_name,
            'sku'      => 'GWE-' . $i->spare_part_id,
            'units'    => $i->qty,
            'selling_price' => $i->price,
        ])->toArray();

        $payload = [
            'order_id'           => $order->order_no,
            'order_date'         => $order->created_at->format('Y-m-d H:i'),
            'pickup_location'    => config('services.shiprocket.pickup_location', 'Primary'),
            'billing_customer_name'  => $order->name,
            'billing_address'        => $order->address,
            'billing_city'           => $order->city,
            'billing_pincode'        => $order->pincode,
            'billing_state'          => $order->state,
            'billing_country'        => 'India',
            'billing_email'          => $order->email ?? 'greenwheelev03@gmail.com',
            'billing_phone'          => $order->phone,
            'shipping_is_billing'    => true,
            'order_items'            => $items,
            'payment_method'         => $order->payment_method === 'cod' ? 'COD' : 'Prepaid',
            'sub_total'              => $order->subtotal,
            'length'                 => 20,
            'breadth'                => 15,
            'height'                 => 10,
            'weight'                 => 0.5,
        ];

        $res = Http::withHeaders($this->headers())
            ->post("{$this->baseUrl}/orders/create/adhoc", $payload);

        if ($res->successful()) {
            return [
                'success'     => true,
                'order_id'    => $res->json('order_id'),
                'shipment_id' => $res->json('shipment_id'),
            ];
        }

        Log::error('Shiprocket create order failed', [
            'order' => $order->order_no,
            'error' => $res->json(),
        ]);
        return ['success' => false, 'error' => $res->json()];
    }

    // Auto assign best courier
    public function assignCourier(int $shipmentId): bool
    {
        // Get recommended courier
        $res = Http::withHeaders($this->headers())
            ->get("{$this->baseUrl}/courier/serviceability/", [
                'pickup_postcode'   => config('services.shiprocket.pickup_pincode', '387001'),
                'delivery_postcode' => '000000',
                'weight'            => 0.5,
                'cod'               => 0,
            ]);

        $courierId = $res->json('data.available_courier_companies.0.courier_company_id') ?? 1;

        $assign = Http::withHeaders($this->headers())
            ->post("{$this->baseUrl}/courier/assign/awb", [
                'shipment_id' => $shipmentId,
                'courier_id'  => $courierId,
            ]);

        return $assign->successful();
    }

    // Request Pickup
    public function requestPickup(int $shipmentId): bool
    {
        $res = Http::withHeaders($this->headers())
            ->post("{$this->baseUrl}/courier/generate/pickup", [
                'shipment_id' => [$shipmentId],
            ]);
        return $res->successful();
    }

    // Track Order
    public function trackOrder(string $orderId): ?array
    {
        $res = Http::withHeaders($this->headers())
            ->get("{$this->baseUrl}/orders/show/{$orderId}");

        if ($res->successful()) {
            return $res->json('data');
        }
        return null;
    }

    // Track by AWB
    public function trackByAwb(string $awb): ?array
    {
        $res = Http::withHeaders($this->headers())
            ->get("{$this->baseUrl}/courier/track/awb/{$awb}");

        if ($res->successful()) {
            return $res->json('tracking_data');
        }
        return null;
    }

    // Cancel Order
    public function cancelOrder(array $ids): bool
    {
        $res = Http::withHeaders($this->headers())
            ->post("{$this->baseUrl}/orders/cancel", ['ids' => $ids]);
        return $res->successful();
    }

    // Map Shiprocket status to our status
    public static function mapStatus(string $srStatus): string
    {
        $map = [
            'NEW'              => 'confirmed',
            'READY TO SHIP'    => 'processing',
            'PICKUP SCHEDULED' => 'processing',
            'PICKUP GENERATED' => 'processing',
            'PICKED UP'        => 'processing',
            'IN TRANSIT'       => 'shipped',
            'OUT FOR DELIVERY' => 'shipped',
            'DELIVERED'        => 'delivered',
            'CANCELED'         => 'cancelled',
            'RTO'              => 'cancelled',
            'UNDELIVERED'      => 'cancelled',
        ];
        return $map[strtoupper($srStatus)] ?? 'processing';
    }
}
