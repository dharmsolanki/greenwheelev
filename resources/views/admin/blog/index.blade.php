@extends('layouts.admin')
@section('title','Blog Posts')
@section('content')
<div class="page-actions"><a href="{{ route('admin.blog.create') }}" class="a-btn">✍️ New Post</a></div>
<div class="admin-card">
  <table class="a-table">
    <thead><tr><th>Title</th><th>Category</th><th>Author</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
    <tbody>
      @forelse($posts as $post)
      <tr>
        <td><strong>{{ $post->title }}</strong></td>
        <td>{{ $post->category }}</td>
        <td>{{ $post->author }}</td>
        <td><span class="status-badge {{ $post->is_published?'status-delivered':'status-cancelled' }}">{{ $post->is_published?'Published':'Draft' }}</span></td>
        <td>{{ $post->created_at->format('d M Y') }}</td>
        <td>
          <a href="{{ route('admin.blog.edit',$post) }}" class="a-btn-sm">Edit</a>
          <form method="POST" action="{{ route('admin.blog.destroy',$post) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="a-btn-sm a-btn-danger">Del</button></form>
        </td>
      </tr>
      @empty<tr><td colspan="6" style="text-align:center;padding:30px;color:#999">No posts yet.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div style="padding:16px">{{ $posts->links() }}</div>
</div>
@endsection
