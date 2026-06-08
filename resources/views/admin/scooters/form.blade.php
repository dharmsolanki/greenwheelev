@extends('layouts.admin')
@section('title', $scooter->id ? 'Edit Scooter' : 'Add Scooter')
@section('content')
<div class="admin-card" style="max-width:700px">
  <form method="POST" action="{{ $scooter->id ? route('admin.scooters.update',$scooter) : route('admin.scooters.store') }}" enctype="multipart/form-data">
    @csrf @if($scooter->id) @method('PUT') @endif
    <div class="form-grid">
      <div class="form-group"><label>Name *</label><input name="name" required value="{{ old('name',$scooter->name) }}"></div>
      <div class="form-group"><label>Category *</label>
        <select name="category" required>
          @foreach(['city'=>'City Commuter','premium'=>'Premium','longrange'=>'Long Range','highspeed'=>'High Speed','delivery'=>'Delivery'] as $v=>$l)
          <option value="{{ $v }}" {{ old('category',$scooter->category)===$v?'selected':'' }}>{{ $l }}</option>
          @endforeach
        </select></div>
      <div class="form-group"><label>Price (₹) *</label><input type="number" name="price" required value="{{ old('price',$scooter->price) }}" step="100"></div>
      <div class="form-group"><label>Icon (emoji)</label><input name="icon" value="{{ old('icon',$scooter->icon ?? '🛵') }}"></div>
      <div class="form-group"><label>Range *</label><input name="range" required value="{{ old('range',$scooter->range) }}" placeholder="e.g. 80 km"></div>
      <div class="form-group"><label>Top Speed *</label><input name="top_speed" required value="{{ old('top_speed',$scooter->top_speed) }}" placeholder="e.g. 45 km/h"></div>
      <div class="form-group"><label>Charging Time *</label><input name="charging_time" required value="{{ old('charging_time',$scooter->charging_time) }}" placeholder="e.g. 4 hrs"></div>
      <div class="form-group"><label>Motor Power *</label><input name="motor_power" required value="{{ old('motor_power',$scooter->motor_power) }}" placeholder="e.g. 1.2 kW"></div>
      <div class="form-group"><label>Tag</label><input name="tag" value="{{ old('tag',$scooter->tag) }}" placeholder="e.g. Best Seller"></div>
      <div class="form-group"><label>Status</label>
        <select name="is_active"><option value="1" {{ old('is_active',$scooter->is_active??1)?'selected':'' }}>Active</option><option value="0">Inactive</option></select></div>
      <div class="form-group"><label>Featured</label>
        <select name="is_featured"><option value="0">No</option><option value="1" {{ old('is_featured',$scooter->is_featured)?'selected':'' }}>Yes</option></select></div>
      <div class="form-group"><label>Image</label><input type="file" name="image" accept="image/*"></div>
      <div class="form-group full"><label>Description</label><textarea name="description" rows="3">{{ old('description',$scooter->description) }}</textarea></div>
    </div>
    <div style="display:flex;gap:10px;margin-top:8px">
      <button type="submit" class="a-btn">{{ $scooter->id ? 'Update' : 'Add' }} Scooter</button>
      <a href="{{ route('admin.scooters.index') }}" class="a-btn-outline">Cancel</a>
    </div>
  </form>
</div>
@endsection
