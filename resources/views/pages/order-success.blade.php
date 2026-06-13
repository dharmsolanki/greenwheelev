@extends('layouts.app')
@section('title','Order Placed!')
@section('content')
<section class="section" style="padding-top:90px">
  <div class="section-inner" style="max-width:600px">
    <div class="order-success-card text-center">
      <div style="font-size:60px;margin-bottom:16px"><i class="fas fa-check-circle" style="color:var(--green)"></i></div>
      <h2 style="font-size:26px;font-weight:800;margin-bottom:8px">{{ $order->payment_method==='razorpay'?'Payment Successful!':'Order Placed!' }}</h2>
      <p style="color:#666;margin-bottom:20px">{{ $order->payment_method==='razorpay'?'Your order is confirmed. Parts will be shipped within 1-2 business days.':'COD order placed! Our team will call you to confirm delivery.' }}</p>
      <div class="order-detail-box">
        <div class="od-row"><span>Order No</span><strong>{{ $order->order_no }}</strong></div>
        <div class="od-row"><span>Amount</span><strong>₹{{ number_format($order->total) }}</strong></div>
        <div class="od-row"><span>Payment</span><strong>{{ strtoupper($order->payment_method) }}</strong></div>
        <div class="od-row"><span>Status</span><span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></div>
      </div>
      <div style="margin-top:20px;display:flex;gap:10px;justify-content:center;flex-wrap:wrap">
        <a href="{{ route('order.track',$order->order_no) }}" class="btn-primary"><i class="fas fa-box"></i> Track Order</a>
        <a href="https://wa.me/917984304504?text=Hi!+My+order+number+is+{{ $order->order_no }}" target="_blank" class="btn-outline"><i class="fab fa-whatsapp"></i> WhatsApp</a>
        <a href="{{ route('parts.index') }}" class="btn-outline">Continue Shopping</a>
      </div>
    </div>
  </div>
</section>
@endsection
