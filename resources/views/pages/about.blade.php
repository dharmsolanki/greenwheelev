@extends('layouts.app')
@section('title','About Green Wheel EV')
@section('content')
<section class="page-hero dark-hero"><div class="page-hero-inner"><h1>About Green Wheel EV</h1><p>Driving India's EV Revolution from Nadiad, Gujarat</p></div></section>
<section class="section">
  <div class="section-inner">
    <div class="grid-2" style="margin-bottom:48px">
      <div>
        <h2 style="font-size:28px;font-weight:800;margin-bottom:16px">Our Story</h2>
        <p style="color:#555;line-height:1.8;margin-bottom:14px">Green Wheel EV was founded with a vision to accelerate India's transition to electric mobility. Located in Nadiad, Gujarat, we serve customers across the region with a complete range of EV services.</p>
        <p style="color:#555;line-height:1.8;margin-bottom:14px">From sales and service to spare parts and dealership opportunities, we are your one-stop destination for everything electric two-wheeler related.</p>
        <p style="color:#555;line-height:1.8">Our team of trained technicians and passionate EV enthusiasts work every day to ensure you have the best electric vehicle ownership experience.</p>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
        @foreach([['500+','Happy Customers','green'],['15+','EV Models','dark'],['5+','Years Experience','dark'],['24/7','Support','green']] as [$num,$lbl,$type])
        <div style="background:{{ $type==='green'?'linear-gradient(135deg,var(--green),var(--green2))':'linear-gradient(135deg,#1a1a2e,#2d2d4e)' }};border-radius:16px;padding:28px;color:white;text-align:center">
          <div style="font-size:36px;font-weight:800;margin-bottom:6px">{{ $num }}</div>
          <div style="font-size:13px;opacity:.85">{{ $lbl }}</div>
        </div>
        @endforeach
      </div>
    </div>
    <div class="grid-2">
      <div style="background:var(--green3);border-radius:18px;padding:32px">
        <h3 style="font-size:22px;font-weight:700;color:#00692e;margin-bottom:14px"><i class="fas fa-bullseye"></i> Our Mission</h3>
        <p style="color:#338a57;font-size:14.5px;line-height:1.8">To make electric mobility accessible, affordable, and dependable for every customer — contributing to a cleaner and greener India one EV at a time.</p>
      </div>
      <div style="background:#f0f0ff;border-radius:18px;padding:32px">
        <h3 style="font-size:22px;font-weight:700;color:#1a1a5e;margin-bottom:14px"><i class="fas fa-eye"></i> Our Vision</h3>
        <p style="color:#4444aa;font-size:14.5px;line-height:1.8">To become one of India's leading EV sales, service, and dealership networks — empowering entrepreneurs and customers to embrace electric mobility.</p>
      </div>
    </div>
  </div>
</section>
@endsection
