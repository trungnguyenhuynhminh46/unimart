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
                    <a href="#" title="" class="active">{{ $page->title }}</a>
                </li>
            </ul>
        </div>
    </div>
@endsection
@section('content')
    <div class="main-content fl-right">
        @if ($page != null)
            <div class="section" id="detail-page-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title h1" style="font-weight: 600">{{ $page->title }}</h3>
                </div>
                <div class="section-detail">
                    <span class="create-date">{{ $page->created_at }}</span>
                    <div class="detail content">
                        {!! $page->content !!}
                    </div>
                </div>
            </div>
        @else
            <h1 class="h1">Không tìm thấy trang yêu cầu</h1>
        @endif
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
