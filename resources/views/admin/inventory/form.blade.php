@extends('layouts.admin')
@section('title', $part->id ? 'Edit Part' : 'Add New Part')
@section('content')
<div class="admin-card" style="max-width:700px">
  <h3 style="margin-bottom:24px">{{ $part->id ? 'Edit' : 'Add New' }} Spare Part</h3>
  <form method="POST" action="{{ $part->id ? route('admin.inventory.update',$part) : route('admin.inventory.store') }}" enctype="multipart/form-data">
    @csrf @if($part->id) @method('PUT') @endif
    <div class="form-grid">
      <div class="form-group"><label>Name *</label><input name="name" required value="{{ old('name',$part->name) }}"></div>
      <div class="form-group"><label>Category *</label>
        <select name="category" required>
          @foreach(['battery','electrical','mechanical','accessories'] as $c)
          <option value="{{ $c }}" {{ old('category',$part->category)===$c?'selected':'' }}>{{ ucfirst($c) }}</option>
          @endforeach
        </select></div>
      <div class="form-group"><label>Selling Price *</label><input type="number" name="price" required value="{{ old('price',$part->price) }}" step="0.01"></div>
      <div class="form-group"><label>MRP *</label><input type="number" name="mrp" required value="{{ old('mrp',$part->mrp) }}" step="0.01"></div>
      <div class="form-group"><label>Stock Quantity *</label><input type="number" name="stock" required value="{{ old('stock',$part->stock) }}"></div>
      <div class="form-group"><label>Icon (emoji)</label><input name="icon" value="{{ old('icon',$part->icon ?? '⚙️') }}"></div>
      <div class="form-group"><label>Tag</label><input name="tag" value="{{ old('tag',$part->tag) }}" placeholder="e.g. Original, Compatible"></div>
      <div class="form-group"><label>Active</label>
        <select name="is_active"><option value="1" {{ old('is_active',$part->is_active ?? 1)?'selected':'' }}>Active</option><option value="0">Inactive</option></select></div>
      <div class="form-group full"><label>Description</label><textarea name="description" rows="3">{{ old('description',$part->description) }}</textarea></div>
      <div class="form-group"><label>Image</label><input type="file" name="image" accept="image/*"></div>
    </div>
    <div style="display:flex;gap:10px;margin-top:8px">
      <button type="submit" class="a-btn">{{ $part->id ? 'Update Part' : 'Add Part' }}</button>
      <a href="{{ route('admin.inventory.index') }}" class="a-btn-outline">Cancel</a>
    </div>
  </form>
</div>
@endsection
