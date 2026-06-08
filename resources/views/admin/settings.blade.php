@extends('layouts.admin')
@section('title','Settings')
@section('content')
<div class="admin-card" style="max-width:700px">
  <form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf
    <h3 style="margin-bottom:20px;font-size:16px;font-weight:700">General Settings</h3>
    <div class="form-grid">
      <div class="form-group"><label>Site Name</label><input name="site_name" value="{{ $settings['site_name'] ?? 'Green Wheel EV' }}"></div>
      <div class="form-group"><label>Phone</label><input name="phone" value="{{ $settings['phone'] ?? '' }}"></div>
      <div class="form-group"><label>Email</label><input type="email" name="email" value="{{ $settings['email'] ?? '' }}"></div>
      <div class="form-group"><label>WhatsApp Number</label><input name="whatsapp" value="{{ $settings['whatsapp'] ?? '' }}" placeholder="91XXXXXXXXXX"></div>
      <div class="form-group full"><label>Address</label><textarea name="address" rows="2">{{ $settings['address'] ?? '' }}</textarea></div>
      <div class="form-group"><label>Business Hours</label><input name="business_hours" value="{{ $settings['business_hours'] ?? '' }}"></div>
    </div>
    <h3 style="margin:20px 0;font-size:16px;font-weight:700">Payment Settings</h3>
    <div class="form-grid">
      <div class="form-group"><label>Razorpay Key ID</label><input name="razorpay_key_id" value="{{ $settings['razorpay_key_id'] ?? '' }}" placeholder="rzp_live_..."></div>
      <div class="form-group"><label>Razorpay Key Secret</label><input type="password" name="razorpay_key_secret" placeholder="Leave blank to keep current"></div>
      <div class="form-group"><label>Free Shipping Above (₹)</label><input type="number" name="free_shipping_above" value="{{ $settings['free_shipping_above'] ?? 500 }}"></div>
      <div class="form-group"><label>Shipping Charge (₹)</label><input type="number" name="shipping_charge" value="{{ $settings['shipping_charge'] ?? 80 }}"></div>
    </div>
    <button type="submit" class="a-btn" style="margin-top:8px">💾 Save Settings</button>
  </form>
</div>
@endsection
