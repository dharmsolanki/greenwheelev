@extends('layouts.admin')
@section('title','Contact Messages')
@section('content')
<div class="admin-card">
  <table class="a-table">
    <thead><tr><th>Name</th><th>Phone</th><th>Subject</th><th>Message</th><th>Date</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
      @forelse($messages as $m)
      <tr style="{{ !$m->is_read?'background:#fffbf0':'' }}">
        <td><strong>{{ $m->name }}</strong><br><small>{{ $m->email }}</small></td>
        <td><a href="tel:{{ $m->phone }}">{{ $m->phone }}</a></td>
        <td>{{ $m->subject }}</td>
        <td>{{ Str::limit($m->message,60) }}</td>
        <td>{{ $m->created_at->format('d M') }}</td>
        <td><span class="status-badge {{ $m->is_read?'status-delivered':'status-pending' }}">{{ $m->is_read?'Read':'New' }}</span></td>
        <td>
          @if(!$m->is_read)<form method="POST" action="{{ route('admin.messages.read',$m) }}" style="display:inline">@csrf @method('PATCH')<button type="submit" class="a-btn-xs">Mark Read</button></form>@endif
          <form method="POST" action="{{ route('admin.messages.destroy',$m) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="a-btn-xs a-btn-danger">Del</button></form>
        </td>
      </tr>
      @empty<tr><td colspan="7" style="text-align:center;padding:30px;color:#999">No messages.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div style="padding:16px">{{ $messages->links() }}</div>
</div>
@endsection
