@extends('layouts.app')
@section('title','Track Order')
@section('content')
<section class="section" style="padding-top:90px">
  <div class="section-inner" style="max-width:660px">
    <h2 class="section-title"><i class="fas fa-box"></i> Track Your Order</h2>
    <div class="admin-card">
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:20px">
        <div><label style="font-size:12px;color:#999">Order Number</label><p><strong>{{ $order->order_no }}</strong></p></div>
        <div><label style="font-size:12px;color:#999">Amount</label><p><strong>₹{{ number_format($order->total) }}</strong></p></div>
        <div><label style="font-size:12px;color:#999">Payment</label><p><strong>{{ strtoupper($order->payment_method) }}</strong></p></div>
        <div><label style="font-size:12px;color:#999">Order Date</label><p>{{ $order->created_at->format('d M Y') }}</p></div>
        <div><label style="font-size:12px;color:#999">Delivery Address</label><p>{{ $order->address }}, {{ $order->city }}, {{ $order->state }}</p></div>
        <div><label style="font-size:12px;color:#999">Current Status</label><p><span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></p></div>
      </div>
      @php $steps=['pending','confirmed','processing','shipped','delivered']; $ci=array_search($order->status,$steps); @endphp
      @if($order->status!=='cancelled')
      <div style="display:flex;justify-content:space-between;padding:20px 0;position:relative">
        <div style="position:absolute;top:50%;left:0;right:0;height:3px;background:#e0e0e0;transform:translateY(-50%)"></div>
        @foreach($steps as $i=>$s)
        <div style="display:flex;flex-direction:column;align-items:center;position:relative;z-index:1">
          <div style="width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:14px;background:{{ $i<=$ci?'var(--green)':'#e0e0e0' }};color:{{ $i<=$ci?'white':'#999' }}">{{ $i<=$ci?'<i class="fas fa-check"></i>':$i+1 }}</div>
          <div style="font-size:11px;margin-top:6px;color:{{ $i<=$ci?'var(--green)':'#999' }};text-align:center">{{ ucfirst($s) }}</div>
        </div>
        @endforeach
      </div>
      @endif
      <div style="margin-top:16px">
        <h4 style="font-size:15px;font-weight:700;margin-bottom:10px">Items</h4>
        @foreach($order->items as $item)
        <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f0f0f0;font-size:14px">
          <span>{{ $item->part_name }} × {{ $item->qty }}</span>
          <span>₹{{ number_format($item->subtotal) }}</span>
        </div>
        @endforeach
      </div>
      <div style="margin-top:16px;display:flex;gap:10px">
        <a href="https://wa.me/917984304504?text=Hi!+My+order+{{ $order->order_no }}+status+query" target="_blank" class="btn-primary"><i class="fab fa-whatsapp"></i> Chat Support</a>
        <a href="{{ route('parts.index') }}" class="btn-outline">Continue Shopping</a>
      </div>
    </div>
  </div>
</section>
@endsection
