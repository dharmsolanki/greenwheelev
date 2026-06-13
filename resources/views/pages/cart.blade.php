@extends('layouts.app')
@section('title','Your Cart')
@section('content')
<section class="section" style="padding-top:90px">
  <div class="section-inner">
    <h2 class="section-title"><i class="fas fa-shopping-cart"></i> Your Cart</h2>
    @if(empty($cart))
    <div style="text-align:center;padding:60px">
      <div style="font-size:60px;margin-bottom:16px"><i class="fas fa-shopping-cart"></i></div>
      <p style="color:#999;margin-bottom:20px">Cart is empty</p>
      <a href="{{ route('parts.index') }}" class="btn-primary">Shop Spare Parts</a>
    </div>
    @else
    <div class="grid-2" style="align-items:start">
      <div>
        @foreach($cart as $id=>$item)
        <div class="cart-row">
          <div style="font-size:32px">{{ $item['icon'] }}</div>
          <div style="flex:1"><div style="font-weight:600">{{ $item['name'] }}</div><div style="font-size:13px;color:#999">₹{{ number_format($item['price']) }} each</div></div>
          <div style="display:flex;align-items:center;gap:8px">
            <button onclick="updateQty({{ $id }},{{ $item['qty']-1 }})" class="qty-btn">−</button>
            <span style="font-weight:700;min-width:24px;text-align:center">{{ $item['qty'] }}</span>
            <button onclick="updateQty({{ $id }},{{ $item['qty']+1 }})" class="qty-btn">+</button>
          </div>
          <div style="font-weight:700;color:var(--green)">₹{{ number_format($item['price']*$item['qty']) }}</div>
          <button onclick="removeItem({{ $id }})" style="background:none;border:none;cursor:pointer;color:#ef4444;font-size:18px"><i class="fas fa-times"></i></button>
        </div>
        @endforeach
      </div>
      <div class="order-summary">
        <h3 style="font-size:18px;font-weight:700;margin-bottom:16px">Order Summary</h3>
        <div class="summary-item"><span>Subtotal</span><span>₹{{ number_format($total) }}</span></div>
        <div class="summary-item"><span>Shipping</span><span class="{{ $total>=500?'green-text':'' }}">{{ $total>=500?'FREE':'₹80' }}</span></div>
        @if($total < 500)<div style="font-size:12px;color:#f59e0b;margin-bottom:8px">Add ₹{{ number_format(500-$total) }} more for free shipping!</div>@endif
        <div class="summary-total"><span>Total</span><span>₹{{ number_format($total>=500?$total:$total+80) }}</span></div>
        <a href="{{ route('checkout') }}" class="btn-primary" style="display:block;text-align:center;margin-top:16px">Proceed to Checkout <i class="fas fa-arrow-right"></i></a>
        <a href="{{ route('parts.index') }}" class="btn-outline" style="display:block;text-align:center;margin-top:8px">Continue Shopping</a>
      </div>
    </div>
    @endif
  </div>
</section>
@endsection
@push('scripts')
<script>
function updateQty(id,qty){
  if(qty<1){removeItem(id);return;}
  fetch('{{ route("cart.update") }}',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},body:JSON.stringify({id,qty})}).then(()=>location.reload());
}
function removeItem(id){
  fetch('{{ route("cart.remove") }}',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},body:JSON.stringify({id})}).then(()=>location.reload());
}
</script>
@endpush
