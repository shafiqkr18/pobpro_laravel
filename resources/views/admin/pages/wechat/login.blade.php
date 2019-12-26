@extends('admin.layouts.clean')

@section('title')
   Wechat login
@endsection
@section('scripts')
    <script>
        var appid = "ww940ffc36d366b31e";
        var redirect_uri = "http://itforce.pobpro.com/admin/login_wechatwork";
        //var redirect_uri = "http://localhost/pobpro/public/admin/login_wechatwork";
        redirect_uri = encodeURI(redirect_uri);
        var url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" + appid
            + "&redirect_uri=" + redirect_uri + "&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
        location.href = url;
    </script>
@endsection
