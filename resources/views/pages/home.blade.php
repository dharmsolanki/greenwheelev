@extends('layouts.app')
@section('title','Green Wheel EV – Electric Scooters Sales & Service')
@section('content')

{{-- HERO --}}
<section class="hero">
  <div class="hero-inner">
    <div class="hero-content">
      <div class="hero-badge"><i class="fas fa-bolt"></i> Gujarat's Trusted EV Partner</div>
      <h1>Drive the <span class="highlight">Future</span> with Green Wheel EV</h1>
      <p>Authorized electric scooter sales, professional service, genuine spare parts & dealership opportunities in Nadiad, Gujarat.</p>
      <div class="hero-btns">
        <a href="{{ route('scooters.index') }}" class="btn-primary"><i class="fas fa-motorcycle"></i> Explore Scooters</a>
        <a href="#test-ride" class="btn-outline"><i class="fas fa-route"></i> Book Test Ride</a>
      </div>
      <div class="hero-trust">
        <div class="trust-item"><i class="fas fa-check-circle"></i> Authorized Center</div>
        <div class="trust-item"><i class="fas fa-check-circle"></i> Easy Finance</div>
        <div class="trust-item"><i class="fas fa-check-circle"></i> Genuine Parts</div>
      </div>
    </div>
    <div class="hero-visual">
      <div class="hero-card">
        <div class="hero-icon-circle"><i class="fas fa-motorcycle"></i></div>
        <p class="green-text fw-700">100% Electric</p>
        <p class="muted-text">Zero Emissions · Zero Fuel Cost</p>
        <div class="hero-stats">
          <div class="stat-item"><div class="stat-num">500+</div><div class="stat-lbl">Customers</div></div>
          <div class="stat-item"><div class="stat-num">15+</div><div class="stat-lbl">Models</div></div>
          <div class="stat-item"><div class="stat-num">24/7</div><div class="stat-lbl">Support</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- SERVICES --}}
<section class="section">
  <div class="section-inner">
    <div class="section-header">
      <div class="section-badge">OUR SERVICES</div>
      <h2 class="section-title">Everything EV Under One Roof</h2>
    </div>
    <div class="grid-3">
      <a href="{{ route('scooters.index') }}" class="card card-link">
        <div class="card-icon"><i class="fas fa-motorcycle"></i></div>
        <h3>EV Sales</h3>
        <p>Wide range of electric scooters with test ride facility & EMI options</p>
        <span class="card-arrow">Explore <i class="fas fa-arrow-right"></i></span>
      </a>
      <a href="{{ route('service.index') }}" class="card card-link">
        <div class="card-icon"><i class="fas fa-tools"></i></div>
        <h3>Service & Repair</h3>
        <p>Battery checks, motor repair, software updates by certified technicians</p>
        <span class="card-arrow">Book Service <i class="fas fa-arrow-right"></i></span>
      </a>
      <a href="{{ route('parts.index') }}" class="card card-link">
        <div class="card-icon"><i class="fas fa-cogs"></i></div>
        <h3>Spare Parts Shop</h3>
        <p>Original batteries, controllers, chargers — order online with COD & UPI</p>
        <span class="card-arrow">Shop Now <i class="fas fa-arrow-right"></i></span>
      </a>
    </div>
  </div>
</section>

{{-- FEATURED SCOOTERS --}}
@if($scooters->count())
<section class="section bg-light">
  <div class="section-inner">
    <div class="section-header">
      <div class="section-badge">FEATURED</div>
      <h2 class="section-title">Popular EV Models</h2>
      <p class="section-sub">Our bestselling electric scooters</p>
    </div>
    <div class="grid-3">
      @foreach($scooters as $sc)
      <div class="scooter-card">
        @if($sc->images->first())
        <div style="position:relative;overflow:hidden;height:200px">
          <img src="{{ asset('storage/'.$sc->images->first()->image_path) }}" alt="{{ $sc->name }}" style="width:100%;height:100%;object-fit:cover">
          @if($sc->tag)<span class="tag-badge" style="position:absolute;top:12px;left:12px">{{ $sc->tag }}</span>@endif
        </div>
        @else
        <div class="scooter-img"><i class="fas fa-motorcycle"></i>@if($sc->tag)<span class="tag-badge" style="position:absolute;top:12px;left:12px">{{ $sc->tag }}</span>@endif</div>
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
            <a href="{{ route('scooters.show',$sc) }}" class="btn-outline-sm">View Details</a>
            <a href="https://wa.me/917984304504?text=Hi!+I+am+interested+in+{{ urlencode($sc->name) }}" target="_blank" class="btn-primary-sm">Enquire</a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    <div style="text-align:center;margin-top:28px"><a href="{{ route('scooters.index') }}" class="btn-primary">View All Models <i class="fas fa-arrow-right"></i></a></div>
  </div>
</section>
@endif

{{-- WHY CHOOSE --}}
<section class="section">
  <div class="section-inner">
    <div class="section-header">
      <div class="section-badge">WHY US</div>
      <h2 class="section-title">Why Choose Green Wheel EV?</h2>
    </div>
    <div class="grid-4">
      <div class="card"><div class="card-icon"><i class="fas fa-award"></i></div><h3>Authorized Center</h3><p>Official authorized sales & service center for multiple EV brands</p></div>
      <div class="card"><div class="card-icon"><i class="fas fa-user-cog"></i></div><h3>Expert Technicians</h3><p>Certified EV technicians with advanced diagnostic tools</p></div>
      <div class="card"><div class="card-icon"><i class="fas fa-shield-alt"></i></div><h3>Genuine Parts</h3><p>100% original spare parts with manufacturer warranty</p></div>
      <div class="card"><div class="card-icon"><i class="fas fa-hand-holding-usd"></i></div><h3>Easy Finance</h3><p>Low EMI options with fast approval from leading banks</p></div>
      <div class="card"><div class="card-icon"><i class="fas fa-battery-three-quarters"></i></div><h3>Battery Experts</h3><p>Specialized battery diagnostics, repair & replacement</p></div>
      <div class="card"><div class="card-icon"><i class="fas fa-map-marker-alt"></i></div><h3>Roadside Support</h3><p>24/7 roadside assistance across Gujarat</p></div>
      <div class="card"><div class="card-icon"><i class="fas fa-handshake"></i></div><h3>Dealership Network</h3><p>Franchise opportunities for entrepreneurs across India</p></div>
      <div class="card"><div class="card-icon"><i class="fas fa-leaf"></i></div><h3>Eco Friendly</h3><p>Promoting sustainable transport for a greener India</p></div>
    </div>
  </div>
</section>

{{-- EMI CALCULATOR --}}
<section class="section bg-dark">
  <div class="section-inner">
    <div class="grid-2">
      <div>
        <div class="section-badge" style="background:rgba(0,166,81,.2);color:#3de887">EMI CALCULATOR</div>
        <h2 class="section-title" style="color:#fff">Plan Your EV Purchase</h2>
        <p style="color:#8b949e;font-size:14px;line-height:1.7;margin-bottom:24px">Calculate your monthly EMI. We partner with leading banks for quick approvals with minimal documentation.</p>
        <div style="display:flex;flex-wrap:wrap;gap:8px">
          <span class="feature-tag"><i class="fas fa-check"></i> Low Down Payment</span>
          <span class="feature-tag"><i class="fas fa-check"></i> 12–48 Month Tenure</span>
          <span class="feature-tag"><i class="fas fa-check"></i> Fast Approval</span>
          <span class="feature-tag"><i class="fas fa-check"></i> No Hidden Charges</span>
        </div>
      </div>
      <div class="emi-calc">
        <h3 style="font-size:20px;font-weight:700;color:#fff;margin-bottom:22px"><i class="fas fa-calculator"></i> EMI Calculator</h3>
        <div class="range-group">
          <div class="range-label"><span>Loan Amount</span><span class="range-val" id="loanAmt">₹80,000</span></div>
          <input type="range" id="rLoan" min="30000" max="200000" step="5000" value="80000">
        </div>
        <div class="range-group">
          <div class="range-label"><span>Interest Rate</span><span class="range-val" id="intRate">10%</span></div>
          <input type="range" id="rRate" min="8" max="18" step="0.5" value="10">
        </div>
        <div class="range-group">
          <div class="range-label"><span>Tenure</span><span class="range-val" id="tenure">24 Months</span></div>
          <input type="range" id="rTenure" min="6" max="48" step="6" value="24">
        </div>
        <div class="emi-result">
          <div><div class="er-val" id="emiAmt">₹3,686</div><div class="er-lbl">Monthly EMI</div></div>
          <div><div class="er-val" id="totalAmt">₹88,464</div><div class="er-lbl">Total Payable</div></div>
          <div><div class="er-val" id="intAmt">₹8,464</div><div class="er-lbl">Total Interest</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- TEST RIDE FORM --}}
<section class="section" id="test-ride">
  <div class="section-inner">
    <div class="grid-2">
      <div>
        <div class="section-badge">FREE TEST RIDE</div>
        <h2 class="section-title">Book Your Free Test Ride</h2>
        <p style="color:#666;font-size:14.5px;line-height:1.7;margin-bottom:20px">Experience the electric thrill before you buy! No commitment needed. Our experts will guide you through all models.</p>
        <ul style="list-style:none;display:flex;flex-direction:column;gap:10px">
          <li style="display:flex;gap:10px"><span style="color:var(--green)"><i class="fas fa-check"></i></span><span>Try multiple models in one visit</span></li>
          <li style="display:flex;gap:10px"><span style="color:var(--green)"><i class="fas fa-check"></i></span><span>Expert guidance on features</span></li>
          <li style="display:flex;gap:10px"><span style="color:var(--green)"><i class="fas fa-check"></i></span><span>No obligation purchase pressure</span></li>
          <li style="display:flex;gap:10px"><span style="color:var(--green)"><i class="fas fa-check"></i></span><span>Free EMI consultation</span></li>
        </ul>
      </div>
      <div class="form-card">
        @if(session('success'))<div class="alert-success mb-16">{{ session('success') }}</div>@endif
        <form method="POST" action="{{ route('test-ride.book') }}">
          @csrf
          <div class="form-grid">
            <div class="form-group"><label>Full Name *</label><input type="text" name="name" required placeholder="Aapka naam" value="{{ old('name') }}"></div>
            <div class="form-group"><label>Mobile *</label><input type="tel" name="phone" required placeholder="+91 XXXXX XXXXX" value="{{ old('phone') }}"></div>
            <div class="form-group"><label>Preferred Date *</label><input type="date" name="preferred_date" required min="{{ date('Y-m-d',strtotime('+1 day')) }}"></div>
            <div class="form-group"><label>Vehicle Interest</label>
              <select name="vehicle_interest">
                <option>City Commuter</option><option>Premium Scooter</option>
                <option>Long Range</option><option>High Speed</option><option>Delivery EV</option>
              </select>
            </div>
          </div>
          <button type="submit" class="submit-btn"><i class="fas fa-calendar-check"></i> Confirm Test Ride Booking</button>
        </form>
      </div>
    </div>
  </div>
</section>

{{-- REVIEWS --}}
@if($reviews->count())
<section class="section bg-light">
  <div class="section-inner">
    <div class="section-header">
      <div class="section-badge">REVIEWS</div>
      <h2 class="section-title">What Our Customers Say</h2>
    </div>
    <div class="grid-3">
      @foreach($reviews as $r)
      <div class="testi-card">
        <div class="testi-stars">
          @for($i=1;$i<=5;$i++)
            <i class="{{ $i<=$r->rating ? 'fas' : 'far' }} fa-star"></i>
          @endfor
        </div>
        <p class="testi-text">"{{ $r->review }}"</p>
        <div class="testi-author">
          <div class="testi-avatar"><i class="fas fa-user-circle"></i></div>
          <div><div class="testi-name">{{ $r->name }}</div><div class="testi-loc">{{ $r->location }}</div></div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- BLOG --}}
@if($blogs->count())
<section class="section">
  <div class="section-inner">
    <div class="section-header">
      <div class="section-badge">BLOG</div>
      <h2 class="section-title">Latest EV News & Tips</h2>
    </div>
    <div class="grid-3">
      @foreach($blogs as $post)
      <div class="blog-card">
        <div class="blog-cat">{{ $post->category }}</div>
        <h3 class="blog-title"><a href="{{ route('blog.show',$post) }}">{{ $post->title }}</a></h3>
        <p class="blog-excerpt">{{ $post->excerpt }}</p>
        <div class="blog-footer"><span>{{ $post->author }}</span><a href="{{ route('blog.show',$post) }}">Read More <i class="fas fa-arrow-right"></i></a></div>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- CTA --}}
<section class="section bg-dark">
  <div class="section-inner text-center">
    <h2 class="section-title" style="color:#fff">Ready to Go Electric?</h2>
    <p style="color:#8b949e;font-size:15px;margin-bottom:28px">Visit us at Nadiad, Gujarat or book your test ride today</p>
    <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap">
      <a href="#test-ride" class="btn-primary"><i class="fas fa-route"></i> Book Free Test Ride</a>
      <a href="{{ route('contact.index') }}" class="btn-outline"><i class="fas fa-map-marker-alt"></i> Get Directions</a>
      <a href="https://wa.me/917984304504" target="_blank" class="btn-outline"><i class="fab fa-whatsapp"></i> WhatsApp Us</a>
    </div>
  </div>
</section>
@endsection
@push('scripts')
<script>
function calcEMI(){
  const loan=+document.getElementById('rLoan').value;
  const rate=+document.getElementById('rRate').value;
  const months=+document.getElementById('rTenure').value;
  document.getElementById('loanAmt').textContent='₹'+loan.toLocaleString('en-IN');
  document.getElementById('intRate').textContent=rate+'%';
  document.getElementById('tenure').textContent=months+' Months';
  const r=rate/12/100, emi=loan*(r*Math.pow(1+r,months))/(Math.pow(1+r,months)-1);
  const total=Math.round(emi*months);
  document.getElementById('emiAmt').textContent='₹'+Math.round(emi).toLocaleString('en-IN');
  document.getElementById('totalAmt').textContent='₹'+total.toLocaleString('en-IN');
  document.getElementById('intAmt').textContent='₹'+(total-loan).toLocaleString('en-IN');
}
['rLoan','rRate','rTenure'].forEach(id=>document.getElementById(id)?.addEventListener('input',calcEMI));
calcEMI();
</script>
@endpush
