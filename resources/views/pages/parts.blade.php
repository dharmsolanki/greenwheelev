@extends('layouts.app')
@section('title','Genuine EV Spare Parts')
@section('content')
<section class="page-hero"><div class="page-hero-inner"><h1>Genuine EV Spare Parts</h1><p>Original & compatible parts — COD & Online Payment | Free delivery above ₹500</p></div></section>
<section class="section">
  <div class="section-inner">
    <div class="filter-row">
      <div class="filter-tabs">
        @foreach(['all'=>'All Parts','battery'=>'Battery','electrical'=>'Electrical','mechanical'=>'Mechanical','accessories'=>'Accessories'] as $cat=>$lbl)
        <a href="{{ route('parts.index',['category'=>$cat]) }}" class="ftab {{ request('category',$cat)===$cat || (!request('category')&&$cat==='all') ? 'active':'' }}">{{ $lbl }}</a>
        @endforeach
      </div>
      <form method="GET" action="{{ route('parts.index') }}" style="display:flex;gap:8px">
        @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search parts..." style="padding:8px 12px;border:1px solid #ddd;border-radius:8px;font-size:13px">
        <button type="submit" class="btn-primary-sm">🔍</button>
      </form>
    </div>
    <div class="products-grid">
      @forelse($parts as $part)
      <div class="product-card">
        <div class="product-img">{{ $part->icon }}@if($part->tag)<span class="product-badge">{{ $part->tag }}</span>@endif</div>
        <div class="product-body">
          <div class="product-cat">{{ $part->category_label }}</div>
          <div class="product-name">{{ $part->name }}</div>
          @if($part->discount_percent > 0)<div class="discount-badge">{{ $part->discount_percent }}% OFF</div>@endif
          <div class="product-price">₹{{ number_format($part->price) }}<span>₹{{ number_format($part->mrp) }}</span></div>
          <div class="stock-info {{ $part->stock <= 5 ? 'low-stock':'' }}">
            @if($part->stock > 10) ✅ In Stock @elseif($part->stock > 0) ⚠️ Only {{ $part->stock }} left @else ❌ Out of Stock @endif
          </div>
          <div class="product-btns" style="margin-top:10px">
            <button class="btn-cart" onclick="addToCart({{ $part->id }})">🛒 Add to Cart</button>
            <a href="{{ route('parts.show',$part) }}" class="btn-outline-sm">Details</a>
          </div>
        </div>
      </div>
      @empty<div style="grid-column:1/-1;text-align:center;padding:40px;color:#999">No parts found.</div>
      @endforelse
    </div>
    <div class="bulk-banner">
      <span style="font-size:30px">📦</span>
      <div><h4>Bulk Orders Available</h4><p>Dealers & workshops: contact us for wholesale pricing</p></div>
      <a href="https://wa.me/917984304504?text=Hi!+I+need+bulk+spare+parts+quote." target="_blank" class="btn-primary">WhatsApp for Bulk</a>
    </div>
  </div>
</section>
@endsection
@push('scripts')
<script>
function addToCart(id) {
  const csrf = document.querySelector('meta[name=csrf-token]')?.content;
  fetch('{{ route("cart.add") }}', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
    body: JSON.stringify({ part_id: id, qty: 1 })
  })
  .then(r => r.json())
  .then(d => {
    if (d.success) {
      document.getElementById('navCartCount').textContent = d.count;
      renderCart(d.cart, d.total);
      showNotification('✅ ' + d.message);
      openCart();
    }
  });
}
</script>
@endpush
