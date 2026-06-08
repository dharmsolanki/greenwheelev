@extends('layouts.admin')
@section('title',$scooter->name)
@section('content')
<div class="admin-card" style="max-width:600px">
  <div style="font-size:60px;text-align:center;margin-bottom:16px">{{ $scooter->icon }}</div>
  <h2 style="font-size:24px;font-weight:800;text-align:center;margin-bottom:4px">{{ $scooter->name }}</h2>
  <p style="text-align:center;color:#999;margin-bottom:20px">{{ $scooter->category_label }}</p>
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
    @foreach([['Range',$scooter->range],['Top Speed',$scooter->top_speed],['Charging',$scooter->charging_time],['Motor',$scooter->motor_power],['Price','₹'.number_format($scooter->price)],['Status',$scooter->is_active?'Active':'Inactive']] as [$l,$v])
    <div style="background:#f8fffe;border:1px solid #e0f5ea;border-radius:8px;padding:12px;text-align:center">
      <div style="font-size:16px;font-weight:700">{{ $v }}</div><div style="font-size:11px;color:#999;margin-top:2px">{{ $l }}</div>
    </div>
    @endforeach
  </div>
  @if($scooter->description)<p style="margin-top:16px;color:#666;font-size:14px;line-height:1.7">{{ $scooter->description }}</p>@endif
  <div style="margin-top:20px;display:flex;gap:10px">
    <a href="{{ route('admin.scooters.edit',$scooter) }}" class="a-btn">Edit</a>
    <a href="{{ route('admin.scooters.index') }}" class="a-btn-outline">Back</a>
  </div>
</div>
@endsection
