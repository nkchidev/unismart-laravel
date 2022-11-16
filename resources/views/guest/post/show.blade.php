@extends('layouts.guest')

@section('content')
    <div id="main-content-wp" class="clearfix blog-page">
        <div class="wp-inner">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Blog</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content fl-right">
                <div class="section" id="list-blog-wp">
                    <div class="section-head clearfix">
                        <h3 class="section-title">Blog</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item">
                            @foreach ($posts as $post)
                                <li class="clearfix">
                                    <a href="{{ url("tin-tuc/{$post->category->slug}/{$post->slug}/{$post->id}") }}" title="" class="thumb fl-left">
                                        <img src="{{ url($post->post_thumb) }}" alt="">
                                    </a>
                                    <div class="info fl-right">
                                        <a href="{{ url("tin-tuc/{$post->category->slug}/{$post->slug}/{$post->id}") }}" title="" class="title">{{ $post->title }}</a>
                                        @if ($post->created_at != null)
                                            <span class="create-date">{{ $post->created_at }}</span>
                                        @endif
                                        {{-- <p class="desc">{!! Str::of()->limit(100) !!}</p> --}}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="section float-right" id="paging-wp">
                    {{ $posts->links() }}
                </div>
            </div>
            <div class="sidebar fl-left">
                @include('partials.celling')
                @include('partials.banner')
            </div>
        </div>
    </div>
@endsection
