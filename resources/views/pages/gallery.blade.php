@extends('layouts.app')
@section('title','Gallery')
@section('content')
<section class="page-hero"><div class="page-hero-inner"><h1>Our Gallery</h1><p>Showroom, vehicles, service center & customer deliveries</p></div></section>
<section class="section">
  <div class="section-inner">
    <div class="filter-tabs" style="margin-bottom:28px">
      @foreach(['all'=>'All','showroom'=>'Showroom','vehicles'=>'Vehicles','service'=>'Service','delivery'=>'Deliveries','events'=>'Events'] as $cat=>$lbl)
      <a href="{{ route('gallery.index',['category'=>$cat]) }}" class="ftab {{ request('category',$cat==='all'?null:null)===$cat||(request('category')===null&&$cat==='all') ? 'active':'' }}">{{ $lbl }}</a>
      @endforeach
    </div>
    @if($images->count())
    <div class="gallery-grid">
      @foreach($images as $img)
      <div class="gallery-item" onclick="openLightbox('{{ asset('storage/'.$img->image_path) }}','{{ $img->title }}')">
        <img src="{{ asset('storage/'.$img->image_path) }}" alt="{{ $img->title }}" loading="lazy">
        <div class="gallery-overlay"><span>{{ $img->title }}</span></div>
      </div>
      @endforeach
    </div>
    @else
    <div style="text-align:center;padding:60px;color:#999">
      <div style="font-size:48px;margin-bottom:16px"><i class="fas fa-camera"></i></div>
      <p>Gallery images coming soon!</p>
    </div>
    @endif
  </div>
</section>
<div class="lightbox" id="lightbox" onclick="closeLightbox()">
  <img id="lightboxImg" src="" alt=""><p id="lightboxCaption"></p>
</div>
@endsection
@push('scripts')
<script>
function openLightbox(src,cap){document.getElementById('lightboxImg').src=src;document.getElementById('lightboxCaption').textContent=cap;document.getElementById('lightbox').classList.add('open');}
function closeLightbox(){document.getElementById('lightbox').classList.remove('open');}
</script>
@endpush
