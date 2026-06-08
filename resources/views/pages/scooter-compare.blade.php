@extends('layouts.app')
@section('title','Compare EV Scooters')
@section('content')
<section class="section" style="padding-top:90px">
  <div class="section-inner">
    <h2 class="section-title">Compare EV Models</h2>
    @if($scooters->count() >= 2)
    <div style="overflow-x:auto">
      <table class="table" style="min-width:600px">
        <thead><tr><th style="width:140px">Feature</th>@foreach($scooters as $sc)<th style="text-align:center"><div style="font-size:36px">{{ $sc->icon }}</div>{{ $sc->name }}</th>@endforeach</tr></thead>
        <tbody>
          @foreach(['range'=>'Range','top_speed'=>'Top Speed','charging_time'=>'Charging Time','motor_power'=>'Motor Power','price'=>'Price','category_label'=>'Category'] as $key=>$lbl)
          <tr><td><strong>{{ $lbl }}</strong></td>@foreach($scooters as $sc)<td style="text-align:center">{{ $key==='price'?'₹'.number_format($sc->price):$sc->$key }}</td>@endforeach</tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @else
    <div style="text-align:center;padding:40px">
      <p style="margin-bottom:20px;color:#666">Select at least 2 models to compare</p>
      <a href="{{ route('scooters.index') }}" class="btn-primary">Browse Scooters</a>
    </div>
    @endif
  </div>
</section>
@endsection
