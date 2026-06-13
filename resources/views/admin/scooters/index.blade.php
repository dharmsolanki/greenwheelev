@extends('layouts.admin')
@section('title','Scooters')
@section('content')
<div class="page-actions"><a href="{{ route('admin.scooters.create') }}" class="a-btn"><i class="fas fa-motorcycle"></i> Add Scooter</a></div>
<div class="admin-card">
  <table class="a-table">
    <thead><tr><th>Icon</th><th>Name</th><th>Category</th><th>Price</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
      @forelse($scooters as $sc)
      <tr>
        <td style="font-size:24px">{{ $sc->icon }}</td>
        <td><strong>{{ $sc->name }}</strong><br><small>{{ $sc->tag }}</small></td>
        <td>{{ $sc->category_label }}</td>
        <td>₹{{ number_format($sc->price) }}</td>
        <td><span class="status-badge {{ $sc->is_active?'status-delivered':'status-cancelled' }}">{{ $sc->is_active?'Active':'Inactive' }}</span></td>
        <td>
          <a href="{{ route('admin.scooters.edit',$sc) }}" class="a-btn-sm">Edit</a>
          <form method="POST" action="{{ route('admin.scooters.destroy',$sc) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="a-btn-sm a-btn-danger">Del</button></form>
        </td>
      </tr>
      @empty<tr><td colspan="6" style="text-align:center;padding:30px;color:#999">No scooters yet.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div style="padding:16px">{{ $scooters->links() }}</div>
</div>
@endsection
