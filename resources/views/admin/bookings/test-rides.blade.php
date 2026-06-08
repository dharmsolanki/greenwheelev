@extends('layouts.admin')
@section('title','Test Ride Bookings')
@section('content')
<div class="admin-card">
  <table class="a-table">
    <thead><tr><th>Name</th><th>Phone</th><th>Vehicle Interest</th><th>Date</th><th>Status</th></tr></thead>
    <tbody>
      @forelse($bookings as $b)
      <tr>
        <td><strong>{{ $b->name }}</strong></td>
        <td><a href="tel:{{ $b->phone }}">{{ $b->phone }}</a></td>
        <td>{{ $b->vehicle_interest }}</td>
        <td>{{ $b->preferred_date->format('d M Y') }}</td>
        <td>
          <form method="POST" action="{{ route('admin.test-rides.status',$b) }}" style="display:inline">
            @csrf @method('PATCH')
            <select name="status" onchange="this.form.submit()" class="status-select">
              @foreach(['pending','confirmed','completed','cancelled'] as $s)
              <option value="{{ $s }}" {{ $b->status===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
              @endforeach
            </select>
          </form>
        </td>
      </tr>
      @empty<tr><td colspan="5" style="text-align:center;padding:30px;color:#999">No test ride bookings.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div style="padding:16px">{{ $bookings->links() }}</div>
</div>
@endsection
