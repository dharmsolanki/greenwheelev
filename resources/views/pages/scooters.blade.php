@extends('layouts.app')
@section('title','Electric Scooters')
@section('content')
<section class="page-hero"><div class="page-hero-inner"><h1>Electric Scooter Collection</h1><p>Find your perfect EV — test ride available at our Nadiad showroom</p></div></section>
<section class="section">
  <div class="section-inner">
    {{-- Filters --}}
    <div class="filter-row">
      <div class="filter-tabs">
        @foreach(['all'=>'All Models','city'=>'City Commuter','premium'=>'Premium','longrange'=>'Long Range','highspeed'=>'High Speed','delivery'=>'Delivery'] as $cat=>$lbl)
        <a href="{{ route('scooters.index',['category'=>$cat]) }}" class="ftab {{ request('category',$cat==='all'?'all':null)===$cat || (!request('category')&&$cat==='all') ? 'active':'' }}">{{ $lbl }}</a>
        @endforeach
      </div>
      <a href="{{ route('scooters.compare') }}" class="btn-outline-sm">⚖️ Compare Models</a>
    </div>
    @if($compare->count()>0)
    <div class="compare-table">
      <h3 style="margin-bottom:16px">Comparison</h3>
      <table class="table"><thead><tr><th>Feature</th>@foreach($compare as $c)<th>{{ $c->name }}</th>@endforeach</tr></thead>
      <tbody>
        @foreach(['range'=>'Range','top_speed'=>'Top Speed','charging_time'=>'Charging','motor_power'=>'Motor','price'=>'Price'] as $key=>$lbl)
        <tr><td>{{ $lbl }}</td>@foreach($compare as $c)<td>{{ $key==='price'?'₹'.number_format($c->price):$c->$key }}</td>@endforeach</tr>
        @endforeach
      </tbody></table>
    </div>
    @endif
    <div class="grid-3 mt-16">
      @forelse($scooters as $sc)
      <div class="scooter-card">
        <div class="scooter-img">{{ $sc->icon }}</div>
        <div class="scooter-body">
          @if($sc->tag)<span class="tag-badge">{{ $sc->tag }}</span>@endif
          <h3 class="scooter-name mt-8">{{ $sc->name }}</h3>
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
    {{-- Purchase Process --}}
    <div class="section-header mt-48"><div class="section-badge">HOW TO BUY</div><h2 class="section-title">Purchase Process</h2></div>
    <div class="process-steps">
      @foreach(['Select Vehicle','Test Ride','Finance Approval','Documentation','Delivery'] as $i=>$step)
      <div class="step"><div class="step-num">{{ $i+1 }}</div><h4>{{ $step }}</h4></div>
      @endforeach
    </div>
  </div>
</section>
@endsection
