@extends('admin.layouts.clean')

@section('title')
    Wechat login
@endsection
@section('scripts')
    <script>
        function request(paras) {
            var url = location.href;
            var paraString = url.substring(url.indexOf("?") + 1, url.length).split("&");
            var paraObj = {}
            for (i = 0; j = paraString[i]; i++) {
                paraObj[j.substring(0, j.indexOf("=")).toLowerCase()] = j.substring(j.indexOf("=") + 1, j.length);
            }
            var returnValue = paraObj[paras.toLowerCase()];
            if (typeof (returnValue) == "undefined") {
                return "";
            }
            else {
                return decodeURIComponent(returnValue);
            }
        }

        function get_Token(str_code) {
            var url = baseUrl +"/api/get_Token"; // get Token API(refer to 3,Create API  api/get_Token(GET):)
            $.ajax({
                type: 'GET',
                url: url,
                cache: false,
                dataType: "json",
                success: function (data) {
                    if(data.success == false)
                    {
                        alert("An error occurred, try again later! ");
                        return false;
                    }
                    var token = data.access_token;

                    // alert('ACCESS_TOKEN='+ token+'&CODE='+ str_code+'&corpid='+data.corpid);
                    // console.log('ACCESS_TOKEN='+ token+'&CODE='+ str_code+'&corpid='+data.corpid);
                    $.ajax({
                        type: 'post',
                        url: baseUrl+"/api/get_userinfo",

                        data:'ACCESS_TOKEN='+ token+'&CODE='+ str_code+'&corpid='+data.corpid,

                        success: function (data) {
                            //Ger userId & POBPro token
                           // alert('url called = '+ data.url);
                            if(data.success == false)
                            {
                                alert("An error occured! "+ data.message);
                            }else{
                                //alert("Your UserID: "+data.UserId);
                                window.location.href = baseUrl+'/admin/login_wechatwork_final?userid='+data.UserId+'&uuid='+data.uuid;
                            }


                        },
                        error: function (err) {
                            alert('get_userinfo error');
                        }
                    });
                },
                error: function (err) {
                    alert('get_userinfo error 2');
                }
            });
        }

        $(function () {
            //alert("Your Code: "+request('CODE'));
            var str_code = request('CODE');
            get_Token(str_code);
        });
    </script>
@endsection
