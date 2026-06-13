@extends('layouts.admin')
@section('title','Dashboard')
@section('content')
<div class="stats-grid">
  <div class="stat-card green"><div class="sc-icon"><i class="fas fa-box"></i></div><div class="sc-body"><div class="sc-num">{{ $stats['orders_today'] }}</div><div class="sc-lbl">Orders Today</div></div></div>
  <div class="stat-card orange"><div class="sc-icon">⏳</div><div class="sc-body"><div class="sc-num">{{ $stats['orders_pending'] }}</div><div class="sc-lbl">Pending Orders</div></div></div>
  <div class="stat-card blue"><div class="sc-icon"><i class="fas fa-rupee-sign"></i></div><div class="sc-body"><div class="sc-num">₹{{ number_format($stats['revenue_today']) }}</div><div class="sc-lbl">Revenue Today</div></div></div>
  <div class="stat-card purple"><div class="sc-icon"><i class="fas fa-chart-line"></i></div><div class="sc-body"><div class="sc-num">₹{{ number_format($stats['revenue_month']) }}</div><div class="sc-lbl">Month Revenue</div></div></div>
  <div class="stat-card teal"><div class="sc-icon"><i class="fas fa-tools"></i></div><div class="sc-body"><div class="sc-num">{{ $stats['service_pending'] }}</div><div class="sc-lbl">Service Pending</div></div></div>
  <div class="stat-card yellow"><div class="sc-icon"><i class="fas fa-handshake"></i></div><div class="sc-body"><div class="sc-num">{{ $stats['dealer_pending'] }}</div><div class="sc-lbl">Dealer Apps</div></div></div>
  <div class="stat-card red"><div class="sc-icon"><i class="fas fa-exclamation-triangle"></i></div><div class="sc-body"><div class="sc-num">{{ $stats['low_stock'] }}</div><div class="sc-lbl">Low Stock Parts</div></div></div>
  <div class="stat-card gray"><div class="sc-icon"><i class="fas fa-envelope"></i></div><div class="sc-body"><div class="sc-num">{{ $stats['unread_messages'] }}</div><div class="sc-lbl">Unread Messages</div></div></div>
</div>
<div class="dashboard-grid">
  <div class="admin-card">
    <div class="card-header"><h3>Recent Orders</h3><a href="{{ route('admin.orders.index') }}">View All</a></div>
    <table class="a-table">
      <thead><tr><th>Order No</th><th>Customer</th><th>Amount</th><th>Payment</th><th>Status</th><th>Action</th></tr></thead>
      <tbody>
        @foreach($recent_orders as $o)
        <tr>
          <td><strong>{{ $o->order_no }}</strong></td>
          <td>{{ $o->name }}<br><small>{{ $o->phone }}</small></td>
          <td>₹{{ number_format($o->total) }}</td>
          <td><span class="pay-badge pay-{{ $o->payment_method }}">{{ strtoupper($o->payment_method) }}</span></td>
          <td><span class="status-badge status-{{ $o->status }}">{{ ucfirst($o->status) }}</span></td>
          <td><a href="{{ route('admin.orders.show',$o) }}" class="a-btn-sm">View</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div>
    <div class="admin-card">
      <div class="card-header"><h3>Service Bookings</h3><a href="{{ route('admin.bookings.index') }}">View All</a></div>
      @foreach($recent_bookings as $b)
      <div class="mini-item"><div><strong>{{ $b->name }}</strong><br><small>{{ $b->service_type }} · {{ $b->preferred_date->format('d M') }}</small></div><span class="status-badge status-{{ $b->status }}">{{ ucfirst($b->status) }}</span></div>
      @endforeach
    </div>
    <div class="admin-card" style="margin-top:20px">
      <div class="card-header"><h3>Quick Actions</h3></div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px">
        <a href="{{ route('admin.inventory.create') }}" class="qa-btn"><i class="fas fa-plus"></i> Add Part</a>
        <a href="{{ route('admin.scooters.create') }}" class="qa-btn"><i class="fas fa-motorcycle"></i> Add Scooter</a>
        <a href="{{ route('admin.blog.create') }}" class="qa-btn"><i class="fas fa-pen"></i> New Post</a>
        <a href="{{ route('admin.gallery.create') }}" class="qa-btn"><i class="fas fa-camera"></i> Upload Photo</a>
      </div>
    </div>
  </div>
</div>
@endsection
