@extends('layouts.app')
@section('title',$scooter->name.' – Green Wheel EV')
@section('content')
<section class="section" style="padding-top:90px">
  <div class="section-inner">
    <div class="grid-2" style="gap:40px;align-items:start">

      {{-- Image Slider --}}
      <div>
        @if($scooter->images->count() > 0)
        <div class="scooter-slider">
          {{-- Main Image --}}
          <div class="slider-main">
            <img id="mainImg" src="{{ asset('storage/'.$scooter->images->first()->image_path) }}" alt="{{ $scooter->name }}" style="width:100%;height:400px;object-fit:contain;border-radius:16px">
          </div>
          {{-- Thumbnails --}}
          @if($scooter->images->count() > 1)
          <div class="slider-thumbs">
            @foreach($scooter->images as $i=>$img)
            <div class="thumb {{ $i===0?'active':'' }}" onclick="changeImage('{{ asset('storage/'.$img->image_path) }}',this)">
              <img src="{{ asset('storage/'.$img->image_path) }}" alt="{{ $scooter->name }}">
            </div>
            @endforeach
          </div>
          @endif
        </div>
        @else
        <div style="background:var(--green3);border-radius:16px;padding:80px;text-align:center;font-size:100px">{{ $scooter->icon }}</div>
        @endif
      </div>

      {{-- Details --}}
      <div>
        <div class="scooter-cat">{{ $scooter->category_label }}</div>
        <h1 style="font-size:32px;font-weight:800;margin:8px 0 16px">{{ $scooter->name }}</h1>
        @if($scooter->tag)<span class="tag-badge" style="margin-bottom:16px;display:inline-block">{{ $scooter->tag }}</span>@endif
        <div style="font-size:30px;font-weight:800;color:var(--green);margin:16px 0 24px">₹{{ number_format($scooter->price) }}</div>

        {{-- Specs --}}
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px;margin-bottom:24px">
          @foreach([['⚡','Range',$scooter->range],['🏎️','Top Speed',$scooter->top_speed],['🔌','Charging',$scooter->charging_time],['⚙️','Motor',$scooter->motor_power]] as [$ico,$lbl,$val])
          <div style="background:var(--green3);border-radius:10px;padding:14px;display:flex;gap:10px;align-items:center">
            <span style="font-size:22px">{{ $ico }}</span>
            <div><div style="font-size:15px;font-weight:700;color:var(--green-dark)">{{ $val }}</div><div style="font-size:11px;color:#338a57">{{ $lbl }}</div></div>
          </div>
          @endforeach
        </div>

        @if($scooter->description)<p style="color:#555;line-height:1.8;margin-bottom:20px;font-size:14.5px">{{ $scooter->description }}</p>@endif

        <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:20px">
          <a href="{{ route('contact.index') }}" class="btn-primary">📞 Book Now</a>
          <a href="https://wa.me/917984304504?text=Hi!+I+am+interested+in+{{ urlencode($scooter->name) }}" target="_blank" class="btn-outline" style="color:var(--text);border-color:var(--border)"><i class="fab fa-whatsapp" style="color:#25d366"></i> WhatsApp</a>
          <a href="#test-ride" class="btn-outline" style="color:var(--text);border-color:var(--border)">🏍️ Test Ride</a>
        </div>

        <div style="background:#f8f8f8;border-radius:10px;padding:14px;font-size:13px;color:#666">
          <div style="display:flex;gap:20px;flex-wrap:wrap">
            <span>✅ Authorized Dealer</span>
            <span>✅ EMI Available</span>
            <span>✅ 1 Year Warranty</span>
          </div>
        </div>
      </div>
    </div>

    {{-- Related Scooters --}}
    @if($related->count())
    <div style="margin-top:60px">
      <h3 style="font-size:22px;font-weight:700;margin-bottom:24px">Similar Models</h3>
      <div class="grid-3">
        @foreach($related as $sc)
        <div class="scooter-card">
          @if($sc->images->first())
          <img src="{{ asset('storage/'.$sc->images->first()->image_path) }}" alt="{{ $sc->name }}" style="width:100%;height:180px;object-fit:cover">
          @else
          <div class="scooter-img">{{ $sc->icon }}</div>
          @endif
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
    <div style="margin-top:60px" id="test-ride">
      <div class="form-card" style="max-width:540px;margin:0 auto">
        <h3 class="form-title">🏍️ Book Test Ride – {{ $scooter->name }}</h3>
        @if(session('success'))<div class="alert-success mb-16">{{ session('success') }}</div>@endif
        <form method="POST" action="{{ route('test-ride.book') }}">
          @csrf
          <input type="hidden" name="vehicle_interest" value="{{ $scooter->name }}">
          <div class="form-grid">
            <div class="form-group"><label>Name *</label><input name="name" required></div>
            <div class="form-group"><label>Phone *</label><input name="phone" required></div>
            <div class="form-group full"><label>Preferred Date *</label><input type="date" name="preferred_date" required min="{{ date('Y-m-d',strtotime('+1 day')) }}"></div>
          </div>
          <button type="submit" class="submit-btn">✅ Confirm Test Ride</button>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
@push('styles')
<style>
.scooter-slider { position:relative; }
.slider-main { border-radius:16px; overflow:hidden; margin-bottom:12px; background:#f0f0f0; }
.slider-thumbs { display:flex; gap:8px; flex-wrap:wrap; }
.thumb { width:80px; height:60px; border-radius:8px; overflow:hidden; cursor:pointer; border:2px solid transparent; transition:.2s; flex-shrink:0; }
.thumb:hover, .thumb.active { border-color:var(--green); }
.thumb img { width:100%; height:100%; object-fit:cover; }
</style>
@endpush
@push('scripts')
<script>
function changeImage(src, thumb) {
  document.getElementById('mainImg').src = src;
  document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
  thumb.classList.add('active');
}
</script>
@endpush
