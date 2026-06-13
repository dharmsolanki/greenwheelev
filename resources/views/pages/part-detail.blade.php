@extends('layouts.app')
@section('title',$part->name)
@section('content')
<section class="section" style="padding-top:90px">
  <div class="section-inner">
    <div class="grid-2">
      <div style="text-align:center">
        <div style="font-size:100px;background:var(--green3);border-radius:20px;padding:40px;margin-bottom:16px">{{ $part->icon }}</div>
        @if($part->tag)<span class="tag-badge">{{ $part->tag }}</span>@endif
      </div>
      <div>
        <div class="product-cat" style="margin-bottom:8px">{{ $part->category_label }}</div>
        <h1 style="font-size:28px;font-weight:800;margin-bottom:16px">{{ $part->name }}</h1>
        <div style="display:flex;align-items:center;gap:16px;margin-bottom:16px">
          <span style="font-size:26px;font-weight:800;color:var(--green)">₹{{ number_format($part->price) }}</span>
          @if($part->mrp > $part->price)<span style="font-size:16px;text-decoration:line-through;color:#999">₹{{ number_format($part->mrp) }}</span><span style="background:var(--green);color:#fff;padding:3px 8px;border-radius:5px;font-size:12px;font-weight:700">{{ $part->discount_percent }}% OFF</span>@endif
        </div>
        <div style="margin-bottom:16px">
          @if($part->stock > 10)<span style="color:var(--green);font-weight:600"><i class="fas fa-check-circle"></i> In Stock ({{ $part->stock }} units)</span>
          @elseif($part->stock > 0)<span style="color:#f59e0b;font-weight:600"><i class="fas fa-exclamation-triangle"></i> Only {{ $part->stock }} left</span>
          @else<span style="color:#ef4444;font-weight:600"><i class="fas fa-times-circle"></i> Out of Stock</span>@endif
        </div>
        @if($part->description)<p style="color:#555;line-height:1.8;margin-bottom:20px">{{ $part->description }}</p>@endif
        <div style="display:flex;gap:10px;flex-wrap:wrap">
          @if($part->stock > 0)<button onclick="addToCart({{ $part->id }})" class="btn-primary"><i class="fas fa-cart-plus"></i> Add to Cart</button>@endif
          <a href="https://wa.me/917984304504?text=Hi!+I+need+{{ urlencode($part->name) }}" target="_blank" class="btn-outline"><i class="fab fa-whatsapp"></i> Order via WhatsApp</a>
        </div>
      </div>
    </div>
    @if($related->count())
    <div style="margin-top:48px">
      <h3 style="font-size:20px;font-weight:700;margin-bottom:20px">Related Parts</h3>
      <div class="products-grid">
        @foreach($related as $p)
        <div class="product-card">
          <div class="product-img">{{ $p->icon }}</div>
          <div class="product-body">
            <div class="product-name">{{ $p->name }}</div>
            <div class="product-price">₹{{ number_format($p->price) }}</div>
            <button onclick="addToCart({{ $p->id }})" class="btn-cart">Add to Cart</button>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endif
  </div>
</section>
@endsection
@push('scripts')
<script>
function addToCart(id){
  fetch('{{ route("cart.add") }}',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},body:JSON.stringify({part_id:id,qty:1})})
  .then(r=>r.json()).then(d=>{if(d.success){document.getElementById('navCartCount').textContent=d.count;showNotification(d.message);loadCart();}});
}
</script>
@endpush
