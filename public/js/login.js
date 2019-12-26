$(function() {

    $(".postbutton").click(function(){
        $(".validation_error").hide();
        $('#div_msg').removeClass('text-danger').hide();
        let queryString =  $("#frm_signin").serialize();
        $.ajax({
            /* the route pointing to the post function */
            url: baseUrl+'/admin/login_post',
            type: 'POST',
            data:  queryString,
            dataType: "json",

            success: function (data) {
                if(data.success == false) {
                    if(data.errors)
                    {
                        jQuery.each(data.errors, function( key, value ) {
                            // $('#'+key).addClass('alert-danger11');
                            let varSlid = "validation_error";
                            $('#'+key).after('<span class="' + varSlid  + '">'+
                                value+'</span>');
                        });
                    }else{
                        //username or password is wrong!
                        //Show toastr message
                        //toastr.error("Incorrect UserName or Password!");
                        $('#div_msg').addClass('text-danger').text('Incorrect username or password.');
                        $('#div_msg').show();

                    }

								}
								else {
                    window.location.href = baseUrl + '/' + data.redirect;

                   // window.location.href = baseUrl+'/admin/dashboard';
                    // window.location.href  = 'http://demo.pobpro.com/user/dashboard.php';
                    return false;
                }
            }
        });
    });

    /*
    * register form
     */
    $(".postbuttonRegister").click(function(){
        $(".validation_error").hide();
        $('#div_msg').hide();
        let queryString =  $("#frm_register").serialize();
        $.ajax({
            /* the route pointing to the post function */
            url: baseUrl+'/admin/register_post',
            type: 'POST',
            data:  queryString,
            dataType: "json",

            success: function (data) {
                if(data.success == false) {
                    if(data.errors)
                    {
                        jQuery.each(data.errors, function( key, value ) {
                            // $('#'+key).addClass('alert-danger11');
                            let varSlid = "validation_error";
                            $('#'+key).after('<span class="' + varSlid  + '">'+
                                value+'</span>');
                        });
                    }else{
                        //username or password is wrong!
                        //Show toastr message
                        $('#div_msg').text('An Error Occured,Try later!');
                        $('#div_msg').show();

                    }

                }else{
                    window.location.href = baseUrl+'/candidate';
                }
            }
        });
    });
});