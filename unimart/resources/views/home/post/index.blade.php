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
                    <a href="#" title="" class="active">Bài viết</a>
                </li>
            </ul>
        </div>
    </div>
@endsection
@section('content')
    <div class="main-content fl-right">
        <div class="section" id="list-blog-wp">
            <div class="section-head clearfix">
                @if ($posts->total() > 0)
                    <h1 class="section-title blog-title">Danh sách bài viết</h1>
                @else
                    <h1 class="section-title blog-title">Chưa có bài viết nào</h1>
                @endif
            </div>
            <div class="section-detail">
                <ul class="list-item">
                    @foreach ($posts as $post)
                        <li class="clearfix">
                            <a href="{{ route('post.detail', $post->slug) }}" title="" class="thumb fl-left">
                                <img src="{{ $post->thumbnail }}" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="{{ route('post.detail', $post->slug) }}" title=""
                                    class="title">{{ $post->title }}</a>
                                <span class="create-date">{{ $post->created_at }}</span>
                                <p class="desc">{{ $post->summary }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="section" id="paging-wp">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
@section('js')
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
