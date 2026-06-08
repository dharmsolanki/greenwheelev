@extends('layouts.app')
@section('title',$post->title)
@section('content')
<section class="section" style="padding-top:90px">
  <div class="section-inner" style="max-width:760px">
    <div style="margin-bottom:16px"><span class="section-badge">{{ $post->category }}</span></div>
    <h1 style="font-size:30px;font-weight:800;line-height:1.3;margin-bottom:16px">{{ $post->title }}</h1>
    <div style="display:flex;gap:16px;font-size:13px;color:#999;margin-bottom:24px">
      <span>✍️ {{ $post->author }}</span>
      <span>📅 {{ $post->published_at?->format('d M Y') }}</span>
    </div>
    @if($post->image)<img src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}" style="width:100%;border-radius:16px;margin-bottom:28px;max-height:400px;object-fit:cover">@endif
    <div class="blog-content">{!! $post->content !!}</div>
    @if($related->count())
    <div style="margin-top:48px;padding-top:32px;border-top:1px solid #f0f0f0">
      <h3 style="font-size:20px;font-weight:700;margin-bottom:20px">Related Posts</h3>
      <div class="grid-3">
        @foreach($related as $p)
        <div class="blog-card">
          <div class="blog-cat">{{ $p->category }}</div>
          <h3 class="blog-title"><a href="{{ route('blog.show',$p) }}">{{ $p->title }}</a></h3>
          <p class="blog-excerpt">{{ $p->excerpt }}</p>
        </div>
        @endforeach
      </div>
    </div>
    @endif
  </div>
</section>
@endsection
