@extends('layouts.admin')
@section('title','Order #'.$order->order_no)
@section('content')

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;max-width:900px">
  {{-- Customer Details --}}
  <div class="admin-card">
    <div class="card-header"><h3><i class="fas fa-user"></i> Customer Details</h3></div>
    <div style="padding:16px">
      @foreach([['Name',$order->name],['Phone','<a href="tel:'.$order->phone.'">'.$order->phone.'</a>'],['Email',$order->email??'—'],['Address',$order->address],['City',$order->city.' - '.$order->pincode],['State',$order->state]] as [$l,$v])
      <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f0f0f0;font-size:13.5px">
        <span style="color:#999">{{ $l }}</span><strong>{!! $v !!}</strong>
      </div>
      @endforeach
    </div>
  </div>

  {{-- Order Details --}}
  <div class="admin-card">
    <div class="card-header"><h3><i class="fas fa-box"></i> Order Details</h3></div>
    <div style="padding:16px">
      @foreach([['Order No',$order->order_no],['Date',$order->created_at->format('d M Y H:i')],['Payment',strtoupper($order->payment_method)],['Payment ID',$order->payment_id??'—']] as [$l,$v])
      <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f0f0f0;font-size:13.5px">
        <span style="color:#999">{{ $l }}</span><strong>{{ $v }}</strong>
      </div>
      @endforeach

      {{-- Status Update --}}
      <div style="margin-top:14px">
        <form method="POST" action="{{ route('admin.orders.status',$order) }}">
          @csrf @method('PATCH')
          <label style="font-size:12px;color:#999;display:block;margin-bottom:6px">Update Status</label>
          <div style="display:flex;gap:8px">
            <select name="status" class="a-input" style="flex:1">
              @foreach(['pending','confirmed','processing','shipped','delivered','cancelled'] as $s)
              <option value="{{ $s }}" {{ $order->status===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
              @endforeach
            </select>
            <button type="submit" class="a-btn">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Shiprocket Section --}}
<div class="admin-card" style="max-width:900px;margin-top:20px">
  <div class="card-header"><h3><i class="fas fa-truck"></i> Shiprocket Shipment</h3></div>
  <div style="padding:16px">
    @if($order->shiprocket_order_id)
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:16px">
        <div style="background:#f0fff4;border-radius:8px;padding:12px">
          <div style="font-size:11px;color:#999;margin-bottom:4px">Shiprocket Order ID</div>
          <div style="font-weight:700;font-size:13px">{{ $order->shiprocket_order_id }}</div>
        </div>
        <div style="background:#f0fff4;border-radius:8px;padding:12px">
          <div style="font-size:11px;color:#999;margin-bottom:4px">Tracking Number (AWB)</div>
          <div style="font-weight:700;font-size:13px">{{ $order->tracking_number ?? '—' }}</div>
        </div>
        <div style="background:#f0fff4;border-radius:8px;padding:12px">
          <div style="font-size:11px;color:#999;margin-bottom:4px">Courier</div>
          <div style="font-weight:700;font-size:13px">{{ $order->courier_name ?? '—' }}</div>
        </div>
      </div>
      <div style="display:flex;gap:8px;flex-wrap:wrap">
        <a href="{{ route('admin.orders.track',$order) }}" class="a-btn"><i class="fas fa-map-marker-alt"></i> Track Live</a>
        <form method="POST" action="{{ route('admin.orders.cancel-shipment',$order) }}" onsubmit="return confirm('Cancel shipment?')">
          @csrf <button type="submit" class="a-btn-outline" style="color:#ef4444;border-color:#ef4444"><i class="fas fa-times"></i> Cancel Shipment</button>
        </form>
      </div>
    @else
      <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px">
        <div>
          <p style="color:#666;font-size:13.5px">Shipment not created on Shiprocket yet.</p>
          <p style="color:#999;font-size:12px;margin-top:4px">Click button to create shipment & assign courier automatically.</p>
        </div>
        <form method="POST" action="{{ route('admin.orders.ship',$order) }}">
          @csrf
          <button type="submit" class="a-btn"><i class="fas fa-truck"></i> Create Shiprocket Shipment</button>
        </form>
      </div>
    @endif

    {{-- Live Tracking Data --}}
    @if(isset($trackingData) && $trackingData)
    <div style="margin-top:16px;background:#f8fffe;border-radius:10px;padding:16px;border:1px solid #c0e8d0">
      <h4 style="font-size:14px;font-weight:700;margin-bottom:12px"><i class="fas fa-map-marker-alt"></i> Live Tracking</h4>
      @if(isset($trackingData['shipment_track']))
        @php $track = $trackingData['shipment_track'][0] ?? []; @endphp
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;font-size:13px">
          <div><span style="color:#999">Status:</span> <strong>{{ $track['current_status'] ?? '—' }}</strong></div>
          <div><span style="color:#999">Courier:</span> <strong>{{ $track['courier_name'] ?? '—' }}</strong></div>
          <div><span style="color:#999">ETA:</span> <strong>{{ $track['etd'] ?? '—' }}</strong></div>
        </div>
      @endif
    </div>
    @endif
  </div>
</div>

{{-- Order Items --}}
<div class="admin-card" style="max-width:900px;margin-top:20px">
  <div class="card-header"><h3><i class="fas fa-shopping-cart"></i> Order Items</h3></div>
  <table class="a-table">
    <thead><tr><th>Item</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr></thead>
    <tbody>
      @foreach($order->items as $item)
      <tr>
        <td>{{ $item->part_name }}</td>
        <td>₹{{ number_format($item->price) }}</td>
        <td>{{ $item->qty }}</td>
        <td>₹{{ number_format($item->subtotal) }}</td>
      </tr>
      @endforeach
      <tr style="font-weight:700;background:#f8fffe">
        <td colspan="3">Total</td>
        <td>₹{{ number_format($order->total) }}</td>
      </tr>
    </tbody>
  </table>
  @if($order->notes)
  <div style="padding:14px;font-size:13.5px"><strong>Notes:</strong> {{ $order->notes }}</div>
  @endif
</div>

<div style="margin-top:16px">
  <a href="{{ route('admin.orders.index') }}" class="a-btn-outline"><i class="fas fa-arrow-left"></i> Back to Orders</a>
</div>
@endsection
