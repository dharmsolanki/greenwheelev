@extends('layouts.admin')
@section('title','Service Bookings')
@section('content')
<div class="admin-card">
  <table class="a-table">
    <thead><tr><th>Name</th><th>Phone</th><th>Brand</th><th>Service</th><th>Date</th><th>Time</th><th>Status</th><th>Action</th></tr></thead>
    <tbody>
      @forelse($bookings as $b)
      <tr>
        <td><strong>{{ $b->name }}</strong></td>
        <td><a href="tel:{{ $b->phone }}">{{ $b->phone }}</a></td>
        <td>{{ $b->vehicle_brand }}</td>
        <td>{{ $b->service_type }}</td>
        <td>{{ $b->preferred_date->format('d M Y') }}</td>
        <td>{{ $b->preferred_time }}</td>
        <td>
          <form method="POST" action="{{ route('admin.bookings.status',$b) }}" style="display:inline">
            @csrf @method('PATCH')
            <select name="status" onchange="this.form.submit()" class="status-select">
              @foreach(['pending','confirmed','in_progress','completed','cancelled'] as $s)
              <option value="{{ $s }}" {{ $b->status===$s?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
              @endforeach
            </select>
          </form>
        </td>
        <td><a href="{{ route('admin.bookings.show',$b) }}" class="a-btn-sm">View</a></td>
      </tr>
      @empty<tr><td colspan="8" style="text-align:center;padding:30px;color:#999">No bookings.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div style="padding:16px">{{ $bookings->links() }}</div>
</div>
@endsection
