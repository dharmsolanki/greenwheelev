@extends('layouts.admin')
@section('title','Reviews')
@section('content')
<div class="admin-card">
  <table class="a-table">
    <thead><tr><th>Name</th><th>Location</th><th>Rating</th><th>Review</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
      @forelse($reviews as $r)
      <tr>
        <td><strong>{{ $r->name }}</strong></td>
        <td>{{ $r->location }}</td>
        <td>{!! str_repeat('<i class="fas fa-star"></i>',$r->rating) }}{{ str_repeat('<i class="far fa-star"></i>',5-$r->rating) !!}</td>
        <td>{{ Str::limit($r->review,80) }}</td>
        <td><span class="status-badge {{ $r->is_approved?'status-delivered':'status-pending' }}">{{ $r->is_approved?'Approved':'Pending' }}</span></td>
        <td>
          <form method="POST" action="{{ route('admin.reviews.approve',$r) }}" style="display:inline">@csrf @method('PATCH')<button type="submit" class="a-btn-sm">{{ $r->is_approved?'Unapprove':'Approve' }}</button></form>
          <form method="POST" action="{{ route('admin.reviews.destroy',$r) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="a-btn-sm a-btn-danger">Del</button></form>
        </td>
      </tr>
      @empty<tr><td colspan="6" style="text-align:center;padding:30px;color:#999">No reviews yet.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div style="padding:16px">{{ $reviews->links() }}</div>
</div>
@endsection
