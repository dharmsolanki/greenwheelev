@extends('layouts.app')
@section('title','Electric Scooters')
@section('content')
<section class="page-hero"><div class="page-hero-inner"><h1>Electric Scooter Collection</h1><p>Find your perfect EV — test ride available at our Nadiad showroom</p></div></section>
<section class="section">
  <div class="section-inner">
    <div class="filter-row">
      <div class="filter-tabs">
        @foreach(['all'=>'All Models','city'=>'City Commuter','premium'=>'Premium','longrange'=>'Long Range','highspeed'=>'High Speed','delivery'=>'Delivery'] as $cat=>$lbl)
        <a href="{{ route('scooters.index',['category'=>$cat]) }}" class="ftab {{ (!request('category')&&$cat==='all')||(request('category')===$cat) ? 'active':'' }}">{{ $lbl }}</a>
        @endforeach
      </div>
    </div>
    <div class="grid-3 mt-16">
      @forelse($scooters as $sc)
      <div class="scooter-card">
        {{-- Image or Emoji --}}
        @if($sc->images->first())
        <div style="position:relative;overflow:hidden;height:200px">
          <img src="{{ asset('storage/'.$sc->images->first()->image_path) }}" alt="{{ $sc->name }}" style="width:100%;height:100%;object-fit:cover;transition:.3s" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
          @if($sc->tag)<span class="tag-badge" style="position:absolute;top:12px;left:12px">{{ $sc->tag }}</span>@endif
        </div>
        @else
        <div class="scooter-img">{{ $sc->icon }}@if($sc->tag)<span class="tag-badge" style="position:absolute;top:12px;left:12px">{{ $sc->tag }}</span>@endif</div>
        @endif
        <div class="scooter-body">
          <h3 class="scooter-name">{{ $sc->name }}</h3>
          <div class="scooter-cat">{{ $sc->category_label }}</div>
          <div class="specs">
            <div class="spec"><div class="spec-val">{{ $sc->range }}</div><div class="spec-lbl">Range</div></div>
            <div class="spec"><div class="spec-val">{{ $sc->top_speed }}</div><div class="spec-lbl">Speed</div></div>
            <div class="spec"><div class="spec-val">{{ $sc->charging_time }}</div><div class="spec-lbl">Charge</div></div>
            <div class="spec"><div class="spec-val">{{ $sc->motor_power }}</div><div class="spec-lbl">Motor</div></div>
          </div>
          <div class="scooter-price">₹{{ number_format($sc->price) }}</div>
          <div class="scooter-btns">
            <a href="{{ route('scooters.show',$sc) }}" class="btn-outline-sm">Details</a>
            <a href="{{ route('contact.index') }}" class="btn-primary-sm">Book Now</a>
          </div>
        </div>
      </div>
      @empty<div style="grid-column:1/-1;text-align:center;color:#999;padding:40px">No scooters found.</div>
      @endforelse
    </div>
  </div>
</section>
@endsection
