@extends('layouts.master')
@section('css')
    <link href="{{ asset('home/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('home/css/responsive.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('breadcrumb')
    <div class="secion" id="breadcrumb-wp">
        <div class="secion-detail">
            <ul class="list-item clearfix">
                <li>
                    <a href="{{ route('home') }}" title="">Trang chủ</a>
                </li>
                <li>
                    <a href="{{ route('post.index') }}" title="">Bài viết</a>
                </li>
                <li>
                    <a href="{{ route('post.show_by_cat', $post->category->slug) }}">{{ $post->category->name }}</a>
                </li>
                <li>
                    <a href="#" class="active">{{ $post->title }}</a>
                </li>
            </ul>
        </div>
    </div>
@endsection
@section('content')
    <div class="main-content fl-right">
        <div class="section" id="detail-blog-wp">
            <div class="section-head clearfix">
                <a href="{{ route('post.show_by_cat', $post->category->slug) }}"
                    class="category">{{ $post->category->name }}</a>
                <h3 class="section-title">{{ $post->title }}</h3>
                <div class="tags">
                    <span>Tags: </span>
                    <i class="fa-solid fa-tags"></i>
                    @php
                        $tags = explode(',', $post->tags);
                    @endphp
                    @foreach ($tags as $tag)
                        <a href="{{ route('post.show_by_tag', Str::slug($tag, '-')) }}"
                            class="tag">{{ $tag }}</a>
                    @endforeach
                </div>
            </div>
            <div class="section-detail">
                <span class="create-date">{{ $post->created_at }} - {{ $post->author->name }}</span>
                <div class="detail" id="check-height">
                    {!! $post->content !!}
                    <a href="javascript:void();" class="btn readmore-btn readmore">Xem thêm</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('home/js/jquery.exzoom.js') }}"></script>
    <script src="{{ asset('home/js/main.js') }}" type="text/javascript"></script>
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id))
                return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=849340975164592";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
@endsection
