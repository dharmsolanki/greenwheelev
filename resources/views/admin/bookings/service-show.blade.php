@extends('layouts.admin')
@section('title','Booking Details')
@section('content')
<div class="admin-card" style="max-width:600px">
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px">
    <div><label style="font-size:12px;color:#999">Customer</label><p><strong>{{ $booking->name }}</strong></p></div>
    <div><label style="font-size:12px;color:#999">Phone</label><p><a href="tel:{{ $booking->phone }}">{{ $booking->phone }}</a></p></div>
    <div><label style="font-size:12px;color:#999">Vehicle Brand</label><p>{{ $booking->vehicle_brand }}</p></div>
    <div><label style="font-size:12px;color:#999">Service Type</label><p>{{ $booking->service_type }}</p></div>
    <div><label style="font-size:12px;color:#999">Date & Time</label><p>{{ $booking->preferred_date->format('d M Y') }} at {{ $booking->preferred_time }}</p></div>
    <div><label style="font-size:12px;color:#999">Status</label><p><span class="status-badge status-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span></p></div>
  </div>
  @if($booking->description)<div style="background:#f8f8f8;padding:14px;border-radius:8px;margin-bottom:20px"><label style="font-size:12px;color:#999">Problem Description</label><p>{{ $booking->description }}</p></div>@endif
  <form method="POST" action="{{ route('admin.bookings.status',$booking) }}">
    @csrf @method('PATCH')
    <div class="form-grid">
      <div class="form-group"><label>Update Status</label>
        <select name="status">
          @foreach(['pending','confirmed','in_progress','completed','cancelled'] as $s)
          <option value="{{ $s }}" {{ $booking->status===$s?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
          @endforeach
        </select></div>
      <div class="form-group"><label>Admin Notes</label><textarea name="admin_notes" rows="2">{{ $booking->admin_notes }}</textarea></div>
    </div>
    <button type="submit" class="a-btn">Update Booking</button>
  </form>
</div>
@endsection
