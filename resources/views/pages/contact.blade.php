@extends('layouts.app')
@section('title','Contact Us')
@section('content')
<section class="page-hero"><div class="page-hero-inner"><h1>Get in Touch</h1><p>Visit us, call us, or send a message — we're always here</p></div></section>
<section class="section">
  <div class="section-inner">
    <div class="grid-2">
      <div>
        <div class="contact-info">
          @foreach([['📍','Address','Near Riya Party Plot, Piplag Road,<br>Nadiad, Gujarat'],['📞','Phone','<a href="tel:+917984304504">+91 79843 04504</a>'],['✉️','Email','<a href="mailto:greenwheelev03@gmail.com">greenwheelev03@gmail.com</a>'],['🕐','Business Hours','Monday – Saturday: 9:00 AM – 7:00 PM<br>Sunday: Closed']] as [$ico,$title,$val])
          <div class="ci-item"><div class="ci-icon">{{ $ico }}</div><div><h4>{{ $title }}</h4><p>{!! $val !!}</p></div></div>
          @endforeach
        </div>
        <div class="map-frame" style="margin-top:24px">
          <iframe src="https://maps.google.com/maps?q=Piplag+Road+Nadiad+Gujarat&output=embed" width="100%" height="280" style="border:0;display:block;border-radius:12px" allowfullscreen loading="lazy"></iframe>
        </div>
      </div>
      <div class="form-card">
        <h3 class="form-title">💬 Send a Message</h3>
        @if(session('success'))<div class="alert-success">{{ session('success') }}</div>@endif
        <form method="POST" action="{{ route('contact.send') }}">
          @csrf
          <div class="form-group"><label>Name *</label><input name="name" required value="{{ old('name') }}"></div>
          <div class="form-group"><label>Mobile *</label><input name="phone" required value="{{ old('phone') }}"></div>
          <div class="form-group"><label>Email</label><input type="email" name="email" value="{{ old('email') }}"></div>
          <div class="form-group"><label>Subject</label>
            <select name="subject">
              @foreach(['EV Purchase Inquiry','Service Booking','Spare Parts','Dealership','Finance Query','Other'] as $s)<option>{{ $s }}</option>@endforeach
            </select></div>
          <div class="form-group"><label>Message *</label><textarea name="message" required rows="4" placeholder="How can we help you?">{{ old('message') }}</textarea></div>
          <button type="submit" class="submit-btn"><i class="fas fa-paper-plane"></i> Send Message</button>
        </form>
        <div style="margin-top:18px;padding:14px;background:#f0fff4;border-radius:10px;text-align:center">
          <p style="font-size:13px;color:#338a57;margin-bottom:8px">Prefer WhatsApp?</p>
          <a href="https://wa.me/917984304504" target="_blank" class="btn-primary"><i class="fab fa-whatsapp"></i> Chat on WhatsApp</a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
