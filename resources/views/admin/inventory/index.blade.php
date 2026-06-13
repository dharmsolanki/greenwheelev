@extends('layouts.admin')
@section('title','Inventory Management')
@section('content')
<div class="page-actions">
  <a href="{{ route('admin.inventory.create') }}" class="a-btn"><i class="fas fa-plus"></i> Add New Part</a>
  <form method="GET" style="display:flex;gap:10px;flex-wrap:wrap;margin-left:auto">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search parts..." class="a-input">
    <select name="category" class="a-input" style="width:auto">
      <option value="">All Categories</option>
      @foreach(['battery','electrical','mechanical','accessories'] as $c)
      <option {{ request('category')===$c?'selected':'' }}>{{ $c }}</option>
      @endforeach
    </select>
    <select name="stock" class="a-input" style="width:auto">
      <option value="">All Stock</option>
      <option value="low" {{ request('stock')==='low'?'selected':'' }}>Low Stock (≤5)</option>
    </select>
    <button type="submit" class="a-btn">Filter</button>
  </form>
</div>
<div class="admin-card">
  <table class="a-table">
    <thead><tr><th>Icon</th><th>Name</th><th>Category</th><th>Price</th><th>MRP</th><th>Stock</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
      @forelse($parts as $part)
      <tr>
        <td style="font-size:24px">{{ $part->icon }}</td>
        <td><strong>{{ $part->name }}</strong><br><small>{{ $part->tag }}</small></td>
        <td>{{ ucfirst($part->category) }}</td>
        <td>₹{{ number_format($part->price) }}</td>
        <td>₹{{ number_format($part->mrp) }}</td>
        <td>
          <span class="{{ $part->stock<=5?'text-red':($part->stock<=20?'text-orange':'text-green') }}">{{ $part->stock }}</span>
          <button onclick="updateStock({{ $part->id }},prompt('New stock:',{{ $part->stock }}))" class="a-btn-xs">Edit</button>
        </td>
        <td><span class="status-badge {{ $part->is_active?'status-delivered':'status-cancelled' }}">{{ $part->is_active?'Active':'Inactive' }}</span></td>
        <td>
          <a href="{{ route('admin.inventory.edit',$part) }}" class="a-btn-sm">Edit</a>
          <form method="POST" action="{{ route('admin.inventory.destroy',$part) }}" style="display:inline" onsubmit="return confirm('Delete this part?')">@csrf @method('DELETE')<button type="submit" class="a-btn-sm a-btn-danger">Del</button></form>
        </td>
      </tr>
      @empty<tr><td colspan="8" style="text-align:center;padding:30px;color:#999">No parts found.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div style="padding:16px">{{ $parts->withQueryString()->links() }}</div>
</div>
@endsection
@push('scripts')
<script>
function updateStock(id,qty){
  if(!qty)return;
  fetch('/admin/inventory/'+id+'/stock',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content},body:JSON.stringify({stock:parseInt(qty)})})
  .then(r=>r.json()).then(d=>{if(d.success)location.reload();});
}
</script>
@endpush
