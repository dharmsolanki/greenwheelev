@extends('layouts.admin')
@section('title','Dealer Applications')
@section('content')
<div class="admin-card">
  <table class="a-table">
    <thead><tr><th>Name</th><th>Phone</th><th>City/State</th><th>Investment</th><th>Status</th><th>Date</th><th>Action</th></tr></thead>
    <tbody>
      @forelse($applications as $a)
      <tr>
        <td><strong>{{ $a->name }}</strong><br><small>{{ $a->email }}</small></td>
        <td><a href="tel:{{ $a->phone }}">{{ $a->phone }}</a></td>
        <td>{{ $a->city }}, {{ $a->state }}</td>
        <td>{{ $a->investment_capacity }}</td>
        <td>
          <form method="POST" action="{{ route('admin.dealers.status',$a) }}" style="display:inline">
            @csrf @method('PATCH')
            <select name="status" onchange="this.form.submit()" class="status-select">
              @foreach(['pending','reviewing','approved','rejected'] as $s)
              <option value="{{ $s }}" {{ $a->status===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
              @endforeach
            </select>
          </form>
        </td>
        <td>{{ $a->created_at->format('d M Y') }}</td>
        <td><a href="{{ route('admin.dealers.show',$a) }}" class="a-btn-sm">View</a></td>
      </tr>
      @empty<tr><td colspan="7" style="text-align:center;padding:30px;color:#999">No applications yet.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div style="padding:16px">{{ $applications->links() }}</div>
</div>
@endsection
