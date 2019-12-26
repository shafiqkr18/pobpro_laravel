function loadDynamicHTMLEnrollment(type=1)
{
    var queryString = 'type='+type+'&candidate_id='+$('#candidate_idd').val()+'&_token='+$('meta[name=csrf-token]').attr('content');
    jQuery.ajax({
        url: baseUrl+'/admin/getEnrollmentHtml',
        data:queryString,
        type: "POST",
        success:function(data){
					setTimeout(function() {
						$('fieldset.current .input-daterange').datepicker({
							keyboardNavigation: false,
							forceParse: false,
							autoclose: true
						});
					}, 1000);

            if(type==2)
            {
                $("#type_2").html(data['list_data']);
            }else if(type==3)
            {
                $("#type_3").html(data['list_data']);
            }if(type==4)
            {
                $("#type_4").html(data['list_data']);
            }else{
                $("#type_1").html(data['list_data']);
            }


        },
        error:function (){}
    });
}
