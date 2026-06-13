@extends('layouts.admin')
@section('title', $scooter->id ? 'Edit Scooter' : 'Add Scooter')
@section('content')
<div class="admin-card" style="max-width:800px">
  <form method="POST" action="{{ $scooter->id ? route('admin.scooters.update',$scooter) : route('admin.scooters.store') }}" enctype="multipart/form-data">
    @csrf @if($scooter->id) @method('PUT') @endif

    {{-- Basic Info --}}
    <h3 style="font-size:15px;font-weight:700;margin-bottom:16px;padding-bottom:10px;border-bottom:1px solid #f0f0f0"><i class="fas fa-clipboard-list"></i> Basic Info</h3>
    <div class="form-grid">
      <div class="form-group"><label>Scooter Name *</label><input name="name" required value="{{ old('name',$scooter->name) }}" placeholder="e.g. EcoRider X1"></div>
      <div class="form-group"><label>Category *</label>
        <select name="category" required>
          @foreach(['city'=>'City Commuter','premium'=>'Premium','longrange'=>'Long Range','highspeed'=>'High Speed','delivery'=>'Delivery'] as $v=>$l)
          <option value="{{ $v }}" {{ old('category',$scooter->category)===$v?'selected':'' }}>{{ $l }}</option>
          @endforeach
        </select></div>
      <div class="form-group"><label>Price (₹) *</label><input type="number" name="price" required value="{{ old('price',$scooter->price) }}" step="100" placeholder="75000"></div>
      <div class="form-group"><label>Icon (emoji)</label><input name="icon" value="{{ old('icon',$scooter->icon ?? '<i class="fas fa-motorcycle"></i>') }}" placeholder="<i class="fas fa-motorcycle"></i>"></div>
      <div class="form-group"><label>Tag/Badge</label><input name="tag" value="{{ old('tag',$scooter->tag) }}" placeholder="e.g. Best Seller, New Launch"></div>
      <div class="form-group"><label>Status</label>
        <select name="is_active"><option value="1" {{ old('is_active',$scooter->is_active??1)?'selected':'' }}>Active</option><option value="0" {{ !old('is_active',$scooter->is_active??1)?'selected':'' }}>Inactive</option></select></div>
      <div class="form-group"><label>Featured on Home?</label>
        <select name="is_featured"><option value="0">No</option><option value="1" {{ old('is_featured',$scooter->is_featured)?'selected':'' }}>Yes</option></select></div>
    </div>

    {{-- Specifications --}}
    <h3 style="font-size:15px;font-weight:700;margin:20px 0 16px;padding-bottom:10px;border-bottom:1px solid #f0f0f0"><i class="fas fa-bolt"></i> Specifications</h3>
    <div class="form-grid">
      <div class="form-group"><label>Range *</label><input name="range" required value="{{ old('range',$scooter->range) }}" placeholder="80 km"></div>
      <div class="form-group"><label>Top Speed *</label><input name="top_speed" required value="{{ old('top_speed',$scooter->top_speed) }}" placeholder="45 km/h"></div>
      <div class="form-group"><label>Charging Time *</label><input name="charging_time" required value="{{ old('charging_time',$scooter->charging_time) }}" placeholder="4 hrs"></div>
      <div class="form-group"><label>Motor Power *</label><input name="motor_power" required value="{{ old('motor_power',$scooter->motor_power) }}" placeholder="1.2 kW"></div>
      <div class="form-group full"><label>Description</label><textarea name="description" rows="3" placeholder="Scooter ke baare mein 2-3 lines...">{{ old('description',$scooter->description) }}</textarea></div>
    </div>

    {{-- Images --}}
    <h3 style="font-size:15px;font-weight:700;margin:20px 0 16px;padding-bottom:10px;border-bottom:1px solid #f0f0f0"><i class="fas fa-images"></i> Images</h3>

    {{-- Existing Images (Edit mode) --}}
    @if($scooter->id && $scooter->images->count() > 0)
    <div style="margin-bottom:20px">
      <p style="font-size:13px;color:#666;margin-bottom:12px">Existing images — <i class="fas fa-star"></i> click to set primary, <i class="fas fa-times"></i> to delete</p>
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:12px" id="existingImages">
        @foreach($scooter->images as $img)
        <div class="img-thumb {{ $img->is_primary?'is-primary':'' }}" id="img-{{ $img->id }}" style="position:relative;border-radius:10px;overflow:hidden;border:2px solid {{ $img->is_primary?'#00a651':'#e0e0e0' }}">
          <img src="{{ asset('storage/'.$img->image_path) }}" style="width:100%;height:110px;object-fit:cover">
          <div style="position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,.4);opacity:0;transition:.2s;display:flex;align-items:center;justify-content:center;gap:8px" class="img-overlay">
            <button type="button" onclick="setPrimary({{ $img->id }})" title="Set as Primary" style="background:#00a651;border:none;color:#fff;width:28px;height:28px;border-radius:50%;cursor:pointer;font-size:14px"><i class="fas fa-star"></i></button>
            <button type="button" onclick="deleteImage({{ $img->id }})" title="Delete" style="background:#ef4444;border:none;color:#fff;width:28px;height:28px;border-radius:50%;cursor:pointer;font-size:14px"><i class="fas fa-times"></i></button>
          </div>
          @if($img->is_primary)<div style="position:absolute;bottom:0;left:0;right:0;background:#00a651;color:#fff;text-align:center;font-size:10px;padding:3px;font-weight:700">PRIMARY</div>@endif
        </div>
        @endforeach
      </div>
    </div>
    @endif

    {{-- Upload New Images --}}
    <div class="form-group">
      <label>{{ $scooter->id ? 'Add More Images' : 'Upload Images' }} (multiple select kar sakte ho)</label>
      <input type="file" name="images[]" accept="image/*" multiple id="imageInput" style="padding:10px">
      <p style="font-size:12px;color:#999;margin-top:4px">Max 5MB per image · JPG, PNG, WebP · First image automatically primary banega</p>
    </div>

    {{-- Image Preview --}}
    <div id="imagePreview" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:12px;margin-top:12px"></div>

    <div style="display:flex;gap:10px;margin-top:20px">
      <button type="submit" class="a-btn">{{ $scooter->id ? '<i class="fas fa-save"></i> Update Scooter' : '<i class="fas fa-plus"></i> Add Scooter' }}</button>
      <a href="{{ route('admin.scooters.index') }}" class="a-btn-outline">Cancel</a>
    </div>
  </form>
</div>

<style>
.img-thumb:hover .img-overlay { opacity: 1 !important; }
.preview-img { position:relative; border-radius:10px; overflow:hidden; border:2px solid #e0e0e0; }
.preview-img img { width:100%; height:110px; object-fit:cover; }
.preview-img .remove-btn { position:absolute;top:5px;right:5px;background:#ef4444;border:none;color:#fff;width:24px;height:24px;border-radius:50%;cursor:pointer;font-size:12px; }
.preview-img.first-img { border-color: #00a651; }
.preview-img.first-img::after { content:'PRIMARY'; position:absolute;bottom:0;left:0;right:0;background:#00a651;color:#fff;text-align:center;font-size:10px;padding:3px;font-weight:700; }
</style>
@endsection
@push('scripts')
<script>
// Image preview before upload
document.getElementById('imageInput')?.addEventListener('change', function() {
  const preview = document.getElementById('imagePreview');
  preview.innerHTML = '';
  Array.from(this.files).forEach((file, index) => {
    const reader = new FileReader();
    reader.onload = e => {
      const div = document.createElement('div');
      div.className = 'preview-img' + (index === 0 ? ' first-img' : '');
      div.innerHTML = `<img src="${e.target.result}"><span style="position:absolute;bottom:0;left:0;right:0;background:rgba(0,0,0,.5);color:#fff;font-size:10px;padding:3px;text-align:center">${file.name}</span>`;
      preview.appendChild(div);
    };
    reader.readAsDataURL(file);
  });
  // Update count
  const count = this.files.length;
  document.querySelector('label[for="imageInput"]') && (document.querySelector('label[for="imageInput"]').textContent = `Add More Images (${count} selected)`);
});

// Delete existing image via AJAX
function deleteImage(id) {
  if(!confirm('Delete this image?')) return;
  fetch(`/admin/scooters/image/${id}/delete`, {
    method: 'DELETE',
    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
  }).then(r => r.json()).then(d => {
    if(d.success) {
      document.getElementById('img-' + id)?.remove();
    }
  });
}

// Set primary image via AJAX
function setPrimary(id) {
  fetch(`/admin/scooters/image/${id}/primary`, {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
  }).then(r => r.json()).then(d => {
    if(d.success) location.reload();
  });
}
</script>
@endpush
