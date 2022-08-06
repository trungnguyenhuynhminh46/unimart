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
                    <a href="#" title="" class="active">Điều khoản</a>
                </li>
            </ul>
        </div>
    </div>
@endsection
@section('content')
    <div class="main-content fl-right">
        <h1 class="h1">Điều khoản Unimart</h1>
        <h3 class="h3">1. GIỚI THIỆU</h3>
        <p class="content">
            1. Chào mừng bạn đến với trang web Shopee Nghề Nghiệp ("Trang Web"). Vui lòng đọc kỹ các Điều khoản dịch vụ này
            cẩn thận trước khi bạn sử dụng Trang để hiểu rõ quyền lợi và nghĩa vụ hợp pháp của mình đối với Công ty TNHH
            Shopee và các công ty liên kết và công ty con của Shopee (sau đây được gọi riêng là “Shopee”, gọi chung là
            “chúng tôi”, “của chúng tôi”).
            <br>
            2. "Dịch vụ" mà chúng tôi cung cấp bao gồm (a) Trang web, (b) bất kỳ dịch vụ hiện hành nào được cung cấp trên
            Trang web và (c) mọi thông tin, các trang được liên kết, tính năng, dữ liệu, văn bản, hình ảnh, hình ảnh, đồ
            họa, âm nhạc, âm thanh, video, tin nhắn, thẻ, nội dung, lập trình, phần mềm, dịch vụ ứng dụng (bao gồm nhưng
            không giới hạn bất kỳ dịch vụ ứng dụng di động nào) hoặc các tài liệu khác được cung cấp thông qua Trang web
            hoặc các dịch vụ liên quan của Trang web ("Nội dung"). Bất kỳ tính năng mới nào được thêm vào hoặc bổ sung cho
            Dịch vụ cũng phải tuân theo Điều khoản dịch vụ này.
            <br>
            3. Bằng cách truy cập và/hoặc ghé thăm Trang web, bạn biểu thị sự chấp nhận không thể thu hồi của bạn đối với
            các Điều khoản Dịch vụ này. Nếu bạn không đồng ý với các điều khoản này, vui lòng không truy cập hoặc truy cập
            Trang Web.
            <br>
            4. Shopee có quyền sửa đổi Điều khoản Dịch vụ này bất kỳ lúc nào mà không cần thông báo cho bạn. Việc bạn tiếp
            tục sử dụng và / hoặc truy cập Dịch vụ hoặc Trang web này, sẽ được coi là sự chấp nhận không thể hủy ngang đối
            với những sửa đổi đó.
            <br>
            5. Shopee có quyền thay đổi, chỉnh sửa, tạm ngừng hoặc ngừng bất kỳ phần nào của Trang web này hoặc các Dịch vụ
            vào bất kỳ lúc nào. Shopee có thể phát hành một số Dịch vụ hoặc các tính năng của chúng trong phiên bản beta,
            phiên bản này có thể không hoạt động chính xác hoặc không giống như cách mà phiên bản cuối cùng có thể hoạt động
            và chúng tôi sẽ không chịu trách nhiệm trong những trường hợp đó. Shopee cũng có thể áp đặt các giới hạn đối với
            một số tính năng nhất định hoặc hạn chế quyền truy cập của bạn vào các phần của hoặc toàn bộ Trang web hoặc Dịch
            vụ theo quyết định riêng của mình mà không cần thông báo hoặc chịu trách nhiệm pháp lý.
            <br>
            6. Shopee có quyền từ chối cung cấp cho bạn quyền truy cập vào Trang web hoặc Dịch vụ vì bất kỳ lý do gì.
        </p>
        <h3 class="h3">2. QUYỀN RIÊNG TƯ</h3>
        <p class="content">
            1. Quyền riêng tư của bạn rất quan trọng đối với chúng tôi tại Shopee. Để bảo vệ quyền lợi của bạn tốt hơn,
            chúng tôi đã cung cấp Chính sách bảo mật của Shopee để giải thích chi tiết các thực tiễn về quyền riêng tư của
            chúng tôi. Vui lòng xem lại Chính sách Bảo mật để hiểu cách Shopee thu thập và sử dụng thông tin liên quan đến
            việc bạn truy cập Trang web và / hoặc việc bạn sử dụng Dịch vụ. Bằng cách sử dụng Dịch vụ, truy cập Trang web
            hoặc đồng ý với Điều khoản dịch vụ này, bạn đồng ý với việc thu thập, sử dụng, tiết lộ và / hoặc xử lý Nội dung
            và dữ liệu cá nhân của bạn như được mô tả trong Chính sách bảo mật của Shopee.
        </p>
        <h3 class="h3">3. GIỚI HẠN TRÁCH NHIỆM LIMITED LICENSE</h3>
        <p class="content">1. Shopee cấp cho bạn quyền và giấy phép không độc quyền, không thể chuyển nhượng, có giới hạn để
            truy cập và sử dụng Dịch vụ và/hoặc Trang web tuân theo các điều khoản và điều kiện của Điều khoản dịch vụ này
            chỉ cho mục đích sử dụng cá nhân. Giấy phép này không cho phép bạn thực hiện bất kỳ mục đích sử dụng thương mại
            hoặc sử dụng phái sinh nào đối với Trang web và/hoặc Dịch vụ (bao gồm nhưng không giới hạn bất kỳ yếu tố hoặc
            Nội dung riêng lẻ nào của Trang web).

            2. Tất cả Nội dung độc quyền, nhãn hiệu, nhãn hiệu dịch vụ, tên thương hiệu, logo và các tài sản trí tuệ khác
            được hiển thị trên Trang web là tài sản của Shopee và nếu có, các chủ sở hữu là bên thứ ba được xác định trên
            Trang web. Không có quyền hoặc giấy phép nào được cấp trực tiếp hoặc gián tiếp cho bất kỳ bên nào truy cập Trang
            web để sử dụng hoặc tái tạo bất kỳ Nội dung độc quyền, nhãn hiệu, nhãn hiệu dịch vụ, tên thương hiệu, biểu tượng
            và tài sản trí tuệ khác, và không bên nào truy cập Trang web sẽ yêu cầu bất kỳ quyền, hoặc lợi ích nào. Bằng
            cách sử dụng hoặc truy cập Dịch vụ, bạn đồng ý tuân thủ quyền tác giả, nhãn hiệu, nhãn hiệu dịch vụ và tất cả
            các luật hiện hành khác bảo vệ Dịch vụ, Trang web và Nội dung của nó. Bạn đồng ý không sao chép, phân phối, xuất
            bản lại, truyền tải, hiển thị công khai, thực hiện công khai, sửa đổi, điều chỉnh, cho thuê, bán hoặc tạo các
            sản phẩm phái sinh của bất kỳ phần nào của Dịch vụ, Trang web hoặc Nội dung của nó. Bạn cũng không được, nếu
            không có sự đồng ý trước bằng văn bản của chúng tôi, sao chép hoặc đóng khung bất kỳ phần nào hoặc toàn bộ nội
            dung của Trang web này trên bất kỳ máy chủ nào khác hoặc như một phần của bất kỳ trang web nào khác. Ngoài ra,
            bạn đồng ý rằng bạn sẽ không sử dụng bất kỳ rô bốt, trình thu thập dữ liệu hoặc bất kỳ thiết bị tự động hoặc quy
            trình thủ công nào khác để giám sát hoặc sao chép Nội dung của chúng tôi mà không có sự đồng ý trước bằng văn
            bản của chúng tôi (sự đồng ý đó được coi là cấp cho công nghệ công cụ tìm kiếm tiêu chuẩn được sử dụng bởi các
            trang web tìm kiếm trên Internet để hướng người dùng Internet đến trang web này).

            3. Bạn xác nhận rằng Shopee có thể, theo quyết định riêng của mình và vào bất kỳ lúc nào, ngừng cung cấp bất kỳ
            phần nào của Dịch vụ mà không cần thông báo.</p>
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
