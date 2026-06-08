@extends('layouts.app')
@section('title','EV Dealership Opportunity')
@section('content')
<section class="page-hero dark-hero"><div class="page-hero-inner"><h1>Become a Green Wheel EV Partner</h1><p>Join India's growing EV revolution. Build a profitable business with full brand support.</p></div></section>
<section class="section">
  <div class="section-inner">
    <div class="grid-3" style="margin-bottom:48px">
      @foreach([['📚','Product Training','Complete training on all EV models, features & specifications'],['🔧','Technical Training','Hands-on service training for your technicians'],['📣','Marketing Support','Promotional materials, digital marketing & lead generation'],['📦','Parts Supply','Priority spare parts supply with wholesale pricing'],['💻','Dealer Portal','Dedicated portal for inventory & order management'],['📈','Business Growth','Ongoing business development guidance & support']] as [$ico,$name,$desc])
      <div class="card"><div class="card-icon">{{ $ico }}</div><h3>{{ $name }}</h3><p>{{ $desc }}</p></div>
      @endforeach
    </div>
    <div class="grid-2">
      <div class="form-card">
        <h3 class="form-title">🤝 Apply for Dealership</h3>
        <p class="form-sub">Fill the form and our team will contact you within 24 hours</p>
        @if(session('success'))<div class="alert-success">{{ session('success') }}</div>@endif
        <form method="POST" action="{{ route('dealership.apply') }}">
          @csrf
          <div class="form-grid">
            <div class="form-group"><label>Full Name *</label><input name="name" required value="{{ old('name') }}"></div>
            <div class="form-group"><label>Mobile *</label><input name="phone" required value="{{ old('phone') }}"></div>
            <div class="form-group"><label>Email *</label><input type="email" name="email" required value="{{ old('email') }}"></div>
            <div class="form-group"><label>City *</label><input name="city" required value="{{ old('city') }}"></div>
            <div class="form-group"><label>State *</label>
              <select name="state" required>
                @foreach(['Gujarat','Rajasthan','Maharashtra','Madhya Pradesh','Uttar Pradesh','Other'] as $s)<option {{ old('state')===$s?'selected':'' }}>{{ $s }}</option>@endforeach
              </select></div>
            <div class="form-group"><label>Investment Capacity *</label>
              <select name="investment_capacity" required>
                @foreach(['₹5–10 Lakhs','₹10–20 Lakhs','₹20–50 Lakhs','50+ Lakhs'] as $i)<option>{{ $i }}</option>@endforeach
              </select></div>
            <div class="form-group full"><label>Showroom Space</label><textarea name="showroom_space" rows="2" placeholder="e.g. 500 sq ft commercial space in city center">{{ old('showroom_space') }}</textarea></div>
          </div>
          <button type="submit" class="submit-btn"><i class="fas fa-paper-plane"></i> Submit Application</button>
        </form>
      </div>
      <div>
        <h3 style="font-size:20px;font-weight:700;margin-bottom:16px">Requirements</h3>
        @foreach([['🏪','Commercial Showroom','Min. 400 sq ft showroom in main market area'],['💰','Investment Capacity','Minimum ₹5–10 lakhs for setup & inventory'],['👥','Service Team','Basic service infrastructure with trained staff'],['📋','Business Registration','Valid GST registration & business documents']] as [$ico,$title,$desc])
        <div style="display:flex;gap:12px;padding:14px;background:#f8fffe;border-radius:10px;border:1px solid #e0f5ea;margin-bottom:10px">
          <span style="font-size:24px">{{ $ico }}</span><div><strong style="font-size:14px">{{ $title }}</strong><p style="font-size:12.5px;color:#666;margin-top:3px">{{ $desc }}</p></div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
@endsection
