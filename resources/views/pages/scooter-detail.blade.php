@extends('layouts.app')
@section('title',$scooter->name.' – Green Wheel EV')
@section('content')
<section class="section" style="padding-top:90px">
  <div class="section-inner">
    <div class="grid-2">
      <div style="text-align:center">
        <div style="font-size:120px;background:var(--green3);border-radius:20px;padding:40px;margin-bottom:20px">{{ $scooter->icon }}</div>
        @if($scooter->tag)<span class="tag-badge">{{ $scooter->tag }}</span>@endif
      </div>
      <div>
        <div class="scooter-cat" style="margin-bottom:8px">{{ $scooter->category_label }}</div>
        <h1 style="font-size:32px;font-weight:800;margin-bottom:16px">{{ $scooter->name }}</h1>
        <div style="font-size:28px;font-weight:800;color:var(--green);margin-bottom:20px">₹{{ number_format($scooter->price) }}</div>
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px;margin-bottom:24px">
          @foreach([['Range',$scooter->range],['Top Speed',$scooter->top_speed],['Charging',$scooter->charging_time],['Motor',$scooter->motor_power]] as [$l,$v])
          <div style="background:var(--green3);border-radius:10px;padding:14px;text-align:center">
            <div style="font-size:16px;font-weight:700;color:var(--green-dark)">{{ $v }}</div>
            <div style="font-size:11px;color:#338a57;margin-top:3px">{{ $l }}</div>
          </div>
          @endforeach
        </div>
        @if($scooter->description)<p style="color:#555;line-height:1.8;margin-bottom:20px">{{ $scooter->description }}</p>@endif
        <div style="display:flex;gap:10px;flex-wrap:wrap">
          <a href="{{ route('contact.index') }}" class="btn-primary">📞 Book Now</a>
          <a href="https://wa.me/917984304504?text=Hi!+I+am+interested+in+{{ urlencode($scooter->name) }}" target="_blank" class="btn-outline"><i class="fab fa-whatsapp"></i> WhatsApp</a>
          <a href="#test-ride" class="btn-outline">🏍️ Test Ride</a>
        </div>
      </div>
    </div>
    @if($related->count())
    <div style="margin-top:48px">
      <h3 style="font-size:20px;font-weight:700;margin-bottom:20px">Similar Models</h3>
      <div class="grid-3">
        @foreach($related as $sc)
        <div class="scooter-card">
          <div class="scooter-img">{{ $sc->icon }}</div>
          <div class="scooter-body">
            <h3 class="scooter-name">{{ $sc->name }}</h3>
            <div class="scooter-price">₹{{ number_format($sc->price) }}</div>
            <a href="{{ route('scooters.show',$sc) }}" class="btn-outline-sm">View Details</a>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endif
    {{-- Test Ride Form --}}
    <div style="margin-top:48px" id="test-ride">
      <div class="form-card" style="max-width:540px;margin:0 auto">
        <h3 class="form-title">🏍️ Book Test Ride for {{ $scooter->name }}</h3>
        @if(session('success'))<div class="alert-success">{{ session('success') }}</div>@endif
        <form method="POST" action="{{ route('test-ride.book') }}">
          @csrf
          <input type="hidden" name="vehicle_interest" value="{{ $scooter->name }}">
          <div class="form-grid">
            <div class="form-group"><label>Name *</label><input name="name" required></div>
            <div class="form-group"><label>Phone *</label><input name="phone" required></div>
            <div class="form-group full"><label>Preferred Date *</label><input type="date" name="preferred_date" required min="{{ date('Y-m-d',strtotime('+1 day')) }}"></div>
          </div>
          <button type="submit" class="submit-btn">Confirm Test Ride</button>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
