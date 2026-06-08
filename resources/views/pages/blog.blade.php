@extends('layouts.app')
@section('title','EV Blog & News')
@section('content')
<section class="page-hero"><div class="page-hero-inner"><h1>EV Blog & News</h1><p>Latest tips, guides and news about electric vehicles</p></div></section>
<section class="section">
  <div class="section-inner">
    <div class="filter-tabs" style="margin-bottom:28px">
      <a href="{{ route('blog.index') }}" class="ftab {{ !request('category')?'active':'' }}">All</a>
      @foreach($categories as $cat)
      <a href="{{ route('blog.index',['category'=>$cat]) }}" class="ftab {{ request('category')===$cat?'active':'' }}">{{ $cat }}</a>
      @endforeach
    </div>
    <div class="grid-3">
      @forelse($posts as $post)
      <div class="blog-card">
        @if($post->image)<img src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}" class="blog-img">@else<div class="blog-img-placeholder">📝</div>@endif
        <div class="blog-body">
          <div class="blog-cat">{{ $post->category }}</div>
          <h3 class="blog-title"><a href="{{ route('blog.show',$post) }}">{{ $post->title }}</a></h3>
          <p class="blog-excerpt">{{ $post->excerpt }}</p>
          <div class="blog-footer">
            <span>{{ $post->author }}</span>
            <span>{{ $post->published_at?->format('d M Y') }}</span>
            <a href="{{ route('blog.show',$post) }}" class="green-text">Read More →</a>
          </div>
        </div>
      </div>
      @empty<div style="grid-column:1/-1;text-align:center;padding:40px;color:#999">No posts yet.</div>
      @endforelse
    </div>
    <div style="margin-top:28px">{{ $posts->links() }}</div>
  </div>
</section>
@endsection
