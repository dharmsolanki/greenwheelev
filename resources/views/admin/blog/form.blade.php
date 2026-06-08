@extends('layouts.admin')
@section('title', $post->id ? 'Edit Post' : 'New Blog Post')
@section('content')
<div class="admin-card" style="max-width:800px">
  <form method="POST" action="{{ $post->id ? route('admin.blog.update',$post) : route('admin.blog.store') }}" enctype="multipart/form-data">
    @csrf @if($post->id) @method('PUT') @endif
    <div class="form-group"><label>Title *</label><input name="title" required value="{{ old('title',$post->title) }}"></div>
    <div class="form-grid">
      <div class="form-group"><label>Category *</label><input name="category" required value="{{ old('category',$post->category) }}" placeholder="e.g. EV Guide, Tips, Policy"></div>
      <div class="form-group"><label>Author</label><input name="author" value="{{ old('author',$post->author ?? 'Green Wheel EV') }}"></div>
    </div>
    <div class="form-group"><label>Excerpt *</label><textarea name="excerpt" required rows="2">{{ old('excerpt',$post->excerpt) }}</textarea></div>
    <div class="form-group"><label>Content *</label><textarea name="content" required rows="12" style="font-family:monospace">{{ old('content',$post->content) }}</textarea></div>
    <div class="form-grid">
      <div class="form-group"><label>Featured Image</label><input type="file" name="image" accept="image/*"></div>
      <div class="form-group"><label>Publish</label><select name="is_published"><option value="0" {{ !old('is_published',$post->is_published)?'selected':'' }}>Draft</option><option value="1" {{ old('is_published',$post->is_published)?'selected':'' }}>Publish Now</option></select></div>
    </div>
    <div style="display:flex;gap:10px;margin-top:8px">
      <button type="submit" class="a-btn">{{ $post->id ? 'Update' : 'Publish' }} Post</button>
      <a href="{{ route('admin.blog.index') }}" class="a-btn-outline">Cancel</a>
    </div>
  </form>
</div>
@endsection
