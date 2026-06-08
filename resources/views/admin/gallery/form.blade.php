@extends('layouts.admin')
@section('title','Upload Gallery Image')
@section('content')
<div class="admin-card" style="max-width:500px">
  <form method="POST" action="{{ $image->id ? route('admin.gallery.update',$image) : route('admin.gallery.store') }}" enctype="multipart/form-data">
    @csrf @if($image->id) @method('PUT') @endif
    <div class="form-group"><label>Title *</label><input name="title" required value="{{ old('title',$image->title) }}"></div>
    <div class="form-group"><label>Category *</label>
      <select name="category" required>
        @foreach(['showroom','vehicles','service','delivery','events'] as $c)
        <option value="{{ $c }}" {{ old('category',$image->category)===$c?'selected':'' }}>{{ ucfirst($c) }}</option>
        @endforeach
      </select></div>
    <div class="form-group"><label>Image *</label><input type="file" name="image" accept="image/*" {{ $image->id?'':'required' }}></div>
    <div class="form-group"><label>Description</label><textarea name="description" rows="2">{{ old('description',$image->description) }}</textarea></div>
    <div class="form-group"><label>Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order',$image->sort_order ?? 0) }}"></div>
    <div style="display:flex;gap:10px">
      <button type="submit" class="a-btn">{{ $image->id ? 'Update' : 'Upload' }}</button>
      <a href="{{ route('admin.gallery.index') }}" class="a-btn-outline">Cancel</a>
    </div>
  </form>
</div>
@endsection
