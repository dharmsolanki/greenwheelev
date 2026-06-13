@extends('layouts.admin')
@section('title','Gallery Management')
@section('content')
<div class="page-actions"><a href="{{ route('admin.gallery.create') }}" class="a-btn"><i class="fas fa-camera"></i> Upload Image</a></div>
<div class="admin-card">
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:16px;padding:8px">
    @forelse($images as $img)
    <div class="gallery-admin-item">
      <img src="{{ asset('storage/'.$img->image_path) }}" alt="{{ $img->title }}" style="width:100%;height:150px;object-fit:cover;border-radius:8px">
      <div style="padding:10px">
        <div style="font-weight:600;font-size:13px">{{ $img->title }}</div>
        <div style="font-size:11px;color:#999;margin-bottom:8px">{{ ucfirst($img->category) }}</div>
        <div style="display:flex;gap:6px">
          <a href="{{ route('admin.gallery.edit',$img) }}" class="a-btn-xs">Edit</a>
          <form method="POST" action="{{ route('admin.gallery.destroy',$img) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="a-btn-xs a-btn-danger">Del</button></form>
        </div>
      </div>
    </div>
    @empty<div style="grid-column:1/-1;text-align:center;padding:40px;color:#999">No images uploaded yet.</div>
    @endforelse
  </div>
  <div style="padding:16px">{{ $images->links() }}</div>
</div>
@endsection
