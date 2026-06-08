@extends('layouts.app')
@section('title','EV Service Center')
@section('content')
<section class="page-hero"><div class="page-hero-inner"><h1>Professional EV Service</h1><p>Expert care by certified technicians · Genuine parts · Quick turnaround</p></div></section>
<section class="section">
  <div class="section-inner">
    <div class="grid-3" style="margin-bottom:48px">
      @foreach([['🔋','Battery Service','Complete battery health check, cell balancing, BMS repair & replacement'],['⚙️','Motor Repair','Hub motor diagnostics, winding repair, bearing replacement & tuning'],['🖥️','Controller Repair','Controller diagnostics, firmware updates & MOSFET replacement'],['🔌','Electrical Check','Complete wiring inspection, charger testing & circuit repair'],['🛞','Mechanical Service','Brake adjustment, suspension service & vehicle inspection'],['📱','Software Update','Vehicle software updates, app connectivity & smart feature calibration']] as [$ico,$name,$desc])
      <div class="card"><div class="card-icon">{{ $ico }}</div><h3>{{ $name }}</h3><p>{{ $desc }}</p></div>
      @endforeach
    </div>
    <div class="grid-2">
      <div class="form-card">
        <h3 class="form-title">🔧 Book a Service</h3>
        <p class="form-sub">Schedule your EV service appointment</p>
        @if(session('success'))<div class="alert-success">{{ session('success') }}</div>@endif
        @if($errors->any())<div class="alert-error">@foreach($errors->all() as $e){{ $e }}<br>@endforeach</div>@endif
        <form method="POST" action="{{ route('service.book') }}">
          @csrf
          <div class="form-grid">
            <div class="form-group"><label>Name *</label><input name="name" required value="{{ old('name') }}"></div>
            <div class="form-group"><label>Mobile *</label><input name="phone" required value="{{ old('phone') }}"></div>
            <div class="form-group"><label>Vehicle Brand *</label>
              <select name="vehicle_brand" required><option value="">Select</option>
                @foreach(['Ola','Ather','Hero Electric','TVS iQube','Bajaj Chetak','Ampere','Other'] as $b)<option {{ old('vehicle_brand')===$b?'selected':'' }}>{{ $b }}</option>@endforeach
              </select></div>
            <div class="form-group"><label>Service Type *</label>
              <select name="service_type" required>
                @foreach(['General Service','Battery Check','Motor Repair','Controller Issue','Electrical Problem','Accident Repair'] as $s)<option {{ old('service_type')===$s?'selected':'' }}>{{ $s }}</option>@endforeach
              </select></div>
            <div class="form-group"><label>Date *</label><input type="date" name="preferred_date" required min="{{ date('Y-m-d',strtotime('+1 day')) }}"></div>
            <div class="form-group"><label>Time *</label>
              <select name="preferred_time" required>
                @foreach(['9:00 AM','10:00 AM','11:00 AM','12:00 PM','2:00 PM','3:00 PM','4:00 PM','5:00 PM'] as $t)<option>{{ $t }}</option>@endforeach
              </select></div>
            <div class="form-group full"><label>Problem Description</label><textarea name="description" rows="3" placeholder="Describe your issue...">{{ old('description') }}</textarea></div>
          </div>
          <button type="submit" class="submit-btn"><i class="fas fa-calendar-check"></i> Confirm Booking</button>
        </form>
      </div>
      <div>
        <h3 style="font-size:20px;font-weight:700;margin-bottom:20px">Service Benefits</h3>
        @foreach(['Genuine Parts Only','Certified Technicians','Quick Turnaround (Same day)','30-Day Service Warranty','Transparent Pricing (No hidden costs)'] as $b)
        <div style="display:flex;gap:12px;margin-bottom:16px"><span style="color:var(--green);font-size:18px">✓</span><span>{{ $b }}</span></div>
        @endforeach
        <div style="background:var(--green3);border-radius:12px;padding:20px;text-align:center;margin-top:24px">
          <p style="font-size:13px;color:#338a57;margin-bottom:8px">Business Hours</p>
          <p style="font-weight:700;color:#00692e">Mon–Sat: 9:00 AM – 7:00 PM</p>
          <a href="tel:+917984304504" style="display:inline-block;margin-top:10px;color:var(--green);font-weight:700;text-decoration:none">📞 +91 79843 04504</a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
