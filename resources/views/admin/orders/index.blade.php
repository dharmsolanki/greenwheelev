@extends('layouts.admin')
@section('title','Orders')
@section('content')
<div class="page-actions">
  <form method="GET" style="display:flex;gap:10px;flex-wrap:wrap">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search order/name/phone..." class="a-input">
    <select name="status" class="a-input" style="width:auto">
      <option value="">All Status</option>
      @foreach(['pending','confirmed','processing','shipped','delivered','cancelled'] as $s)
      <option {{ request('status')===$s?'selected':'' }}>{{ $s }}</option>
      @endforeach
    </select>
    <select name="payment" class="a-input" style="width:auto">
      <option value="">All Payment</option>
      <option value="cod" {{ request('payment')==='cod'?'selected':'' }}>COD</option>
      <option value="razorpay" {{ request('payment')==='razorpay'?'selected':'' }}>Online</option>
    </select>
    <button type="submit" class="a-btn">Filter</button>
    <a href="{{ route('admin.orders.index') }}" class="a-btn-outline">Reset</a>
  </form>
</div>
<div class="admin-card">
  <table class="a-table">
    <thead><tr><th>Order No</th><th>Customer</th><th>Items</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th><th>Action</th></tr></thead>
    <tbody>
      @forelse($orders as $o)
      <tr>
        <td><strong>{{ $o->order_no }}</strong></td>
        <td>{{ $o->name }}<br><small>{{ $o->phone }}</small></td>
        <td>{{ $o->items->count() }} items</td>
        <td>₹{{ number_format($o->total) }}</td>
        <td><span class="pay-badge pay-{{ $o->payment_method }}">{{ strtoupper($o->payment_method) }}</span></td>
        <td>
          <form method="POST" action="{{ route('admin.orders.status',$o) }}" style="display:inline">
            @csrf @method('PATCH')
            <select name="status" onchange="this.form.submit()" class="status-select status-{{ $o->status }}">
              @foreach(['pending','confirmed','processing','shipped','delivered','cancelled'] as $s)
              <option value="{{ $s }}" {{ $o->status===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
              @endforeach
            </select>
          </form>
        </td>
        <td>{{ $o->created_at->format('d M Y') }}</td>
        <td><a href="{{ route('admin.orders.show',$o) }}" class="a-btn-sm">View</a></td>
      </tr>
      @empty<tr><td colspan="8" style="text-align:center;padding:30px;color:#999">No orders found.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div style="padding:16px">{{ $orders->withQueryString()->links() }}</div>
</div>
@endsection
