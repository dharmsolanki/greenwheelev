@extends('layouts.admin')
@section('title','Dealer Application')
@section('content')
<div class="admin-card" style="max-width:600px">
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:20px">
    @foreach([['Name',$application->name],['Phone',$application->phone],['Email',$application->email],['City',$application->city],['State',$application->state],['Investment',$application->investment_capacity]] as [$lbl,$val])
    <div><label style="font-size:12px;color:#999">{{ $lbl }}</label><p><strong>{{ $val }}</strong></p></div>
    @endforeach
    @if($application->showroom_space)<div style="grid-column:1/-1"><label style="font-size:12px;color:#999">Showroom Space</label><p>{{ $application->showroom_space }}</p></div>@endif
  </div>
  <form method="POST" action="{{ route('admin.dealers.status',$application) }}">
    @csrf @method('PATCH')
    <div class="form-grid">
      <div class="form-group"><label>Status</label>
        <select name="status">
          @foreach(['pending','reviewing','approved','rejected'] as $s)
          <option value="{{ $s }}" {{ $application->status===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
          @endforeach
        </select></div>
      <div class="form-group"><label>Admin Notes</label><textarea name="admin_notes" rows="2">{{ $application->admin_notes }}</textarea></div>
    </div>
    <button type="submit" class="a-btn">Update Application</button>
  </form>
</div>
@endsection
