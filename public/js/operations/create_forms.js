$(function() {
/*save contract*/
    $("#save_contract").click(function(e) {
        e.preventDefault();

        $(".validation_error").hide();
        //let queryString =  $("#frm_contract").serialize();
        let formData = new FormData($('#frm_contract')[0]);
        $.ajax({
            /* the route pointing to the post function */
            url: baseUrl + '/admin/save_contract',
            type: 'POST',
            dataType: "JSON",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if(data.success == false) {
                    if(data.errors)
                    {
                        toastr.warning("Fill the required fields!");
                        jQuery.each(data.errors, function( key, value ) {
                            //$('#'+key).addClass('text-danger');
                            $('#'+key).closest('.form-group').addClass('has-error');
                            // let varSlid = "validation_error";
                            // $('#'+key).after('<span class="' + varSlid  + '">'+
                            //     value+'</span>');
                        });

                    }else{
                        //Show toastr message
                        toastr.error("Error Saving Data");
                    }
                }else{
                    toastr.success("Saved Successfully! ");
                    setTimeout(function(){
                        window.location.href = baseUrl+'/admin/contract-management';
                    },3000);

                    //console.log('dddd');
                }

            }
        });
    });

    /*save enrollment*/
    $("#save_my_enrollment").click(function(e) {
        e.preventDefault();
        $(".validation_error").hide();
        let formData = new FormData($('#frm_enrollment')[0]);
        $.ajax({
            /* the route pointing to the post function */
            url: baseUrl + '/admin/save_enrollment',
            type: 'POST',
            dataType: "JSON",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data.success == false) {
                    if (data.errors) {
                        toastr.warning("Fill the required fields!");
                        jQuery.each(data.errors, function (key, value) {
                            $('#' + key).closest('.form-group').addClass('has-error');

                        });
                    }else{
                        //Show toastr message
                        toastr.error("Error Saving Data");
                    }
                    }else{
                    toastr.success("Saved Successfully! ");
                    setTimeout(function(){
                        window.location.href = baseUrl+'/admin/employees';

                    },2000);

                }
                }

        });
    });

    /*save organization*/

    $("#save_org").click(function(e) {
        e.preventDefault();

        $(".validation_error").hide();
        let buttonpressed = $(this).attr('role-type');
        let formData = new FormData($('#frm_org')[0]);
        $.ajax({
            /* the route pointing to the post function */
            url: baseUrl + '/admin/save_organization',
            type: 'POST',
            dataType: "JSON",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if(data.success == false) {
                    if(data.errors)
                    {
                        toastr.warning("Fill the required fields!");
                        jQuery.each(data.errors, function( key, value ) {
                           $('#'+key).closest('.form-group').addClass('has-error');

                        });

                    }else{
                        //Show toastr message
                        toastr.error("Error Saving Data");
                    }
                }else{
                    toastr.success("Saved Successfully! ");
                    setTimeout(function(){
                        if(buttonpressed == 1)
                        {
                        window.location.href = baseUrl+'/admin/my-organization';
                        }else{
                            window.location.href = baseUrl+'/admin/organization-management';
                        }

                    },2000);

                }

            }
        });
    });


    /*save Position*/

    $("#save_position").click(function(e) {
        e.preventDefault();

        $(".validation_error").hide();
        //let queryString =  $("#frm_contract").serialize();
        let formData = new FormData($('#frm_position')[0]);
        $.ajax({
            /* the route pointing to the post function */
            url: baseUrl + '/admin/save_position',
            type: 'POST',
            dataType: "JSON",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if(data.success == false) {
                    if(data.errors)
                    {
                        toastr.warning("Fill the required fields!");
                        jQuery.each(data.errors, function( key, value ) {
                            $('#'+key).closest('.form-group').addClass('has-error');

                        });

                    }else{
                        //Show toastr message
                        data.message ? toastr.error(data.message) : toastr.error("Error Saving Data");

                    }
                }else{
                    toastr.success("Position Saved Successfully! ");
                    $('#myPositions').modal('toggle');
                        window.location.href = baseUrl+'/admin/organization-plan';
                    // setTimeout(function(){
                    //     window.location.href = baseUrl+'/admin/organization-plan';
                    // },3000);

                }

            }
        });
    });



    /*save candidate*/
    $("#save_candidate,#save_candidate1").click(function(e) {
        e.preventDefault();

        $(".validation_error").hide();
        //let queryString =  $("#frm_contract").serialize();
        let formData = new FormData($('#frm_candidate')[0]);
        $.ajax({
            /* the route pointing to the post function */
            url: baseUrl + '/admin/save_candidate',
            type: 'POST',
            dataType: "JSON",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if(data.success == false) {
                    if(data.errors)
                    {
                        toastr.warning("Please fix the fields have error!");
                        jQuery.each(data.errors, function( key, value ) {
                            //$('#'+key).addClass('text-danger');
                            $('#'+key).closest('.form-group').addClass('has-error');
                            toastr.warning(value);
                        });

                    }else{
                        //Show toastr message
                        toastr.error("Error Saving Data");
                    }
                }else{
										var msg = data.is_update ? 'Candidate data updated.' : 'New candidated added.';
                    toastr.success(msg, 'Success!');
                    setTimeout(function(){
                        window.location.href = baseUrl+'/admin/candidates';
                    },2000);

                }

            }
        });
    });



    /*save jobs*/
    $("#save_job").click(function(e) {
        e.preventDefault();

        $(".validation_error").hide();
        //let queryString =  $("#frm_contract").serialize();
        let formData = new FormData($('#frm_post_job')[0]);
        $.ajax({
            /* the route pointing to the post function */
            url: baseUrl + '/admin/save_job',
            type: 'POST',
            dataType: "JSON",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if(data.success == false) {
                    if(data.errors)
                    {
                        toastr.warning("Fill the required fields!");
                        jQuery.each(data.errors, function( key, value ) {
                            //$('#'+key).addClass('text-danger');
                            $('#'+key).closest('.form-group').addClass('has-error');

                        });

                    }else{
                        //Show toastr message
                        toastr.error("Error Saving Data");
                    }
                }else{
                    toastr.success("Successfully Added New Job! ");
                    setTimeout(function(){
                        window.location.href = baseUrl+'/admin/vacancy-management';
                    },3000);

                }

            }
        });
    });



    /*save save_division*/
    $("#save_division").click(function(e) {
        e.preventDefault();

        $(".validation_error").hide();
        let buttonpressed = $(this).attr('role-type');


        let formData = new FormData($('#frm_division')[0]);
        $.ajax({
            /* the route pointing to the post function */
            url: baseUrl + '/admin/save_division',
            type: 'POST',
            dataType: "JSON",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if(data.success == false) {
                    if(data.errors)
                    {
                        toastr.warning("Fill the required fields!");
                        jQuery.each(data.errors, function( key, value ) {
                            //$('#'+key).addClass('text-danger');
                            $('#'+key).closest('.form-group').addClass('has-error');

                        });

                    }else{
                        //Show toastr message
                        toastr.error("Error Saving Data");
                    }
                }else{
										var msg = data.is_update ? 'Division data updated.' : 'New division added.';
										toastr.success(msg, 'Success!');

										if (data.redirect) {
											window.location.href = data.redirect
										}
										else {
											$('#myDivisions').modal('toggle');

											if (buttonpressed == 1) {
												window.location.href = baseUrl + '/admin/my-organization';
											} else {
												window.location.href = baseUrl + '/admin/organization-plan';
											}
										}

                }

            }
        });
    });



    /*save departments*/
    $("#save_dept").click(function(e) {
        e.preventDefault();

        $(".validation_error").hide();
        let buttonpressed = $(this).attr('role-type');
        let formData = new FormData($('#frm_dept')[0]);

        $.ajax({
            /* the route pointing to the post function */
            url: baseUrl + '/admin/save_department',
            type: 'POST',
            dataType: "JSON",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if(data.success == false) {
                    if(data.errors)
                    {
                        toastr.warning("Fill the required fields!");
                        jQuery.each(data.errors, function( key, value ) {
                            //$('#'+key).addClass('text-danger');
                            $('#'+key).closest('.form-group').addClass('has-error');

                        });

                    }else{
                        //Show toastr message
                        toastr.error("Error Saving Data");
                    }
                }else{
										var msg = data.is_update ? 'Department data updated.' : 'New department added.';
										toastr.success(msg, 'Success!');

										if (data.redirect) {
											setTimeout(function () {
												window.location.href = data.redirect
											}, 500);
										}
										else {
											$('#myDepartments').modal('toggle');

											if (buttonpressed == 1) {
												window.location.href = baseUrl + '/admin/my-organization';
											} else {
												window.location.href = baseUrl + '/admin/organization-plan';
											}
										}

                }

            }
        });
    });

    /*save section*/
    $("#save_section").click(function(e) {
        e.preventDefault();

        $(".validation_error").hide();
        let buttonpressed = $(this).attr('role-type');
        let formData = new FormData($('#frm_section')[0]);
        $.ajax({
            /* the route pointing to the post function */
            url: baseUrl + '/admin/save_section',
            type: 'POST',
            dataType: "JSON",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if(data.success == false) {
                    if(data.errors)
                    {
                        toastr.warning("Fill the required fields!");
                        jQuery.each(data.errors, function( key, value ) {
                            toastr.warning(value);
                            $('#'+key).closest('.form-group').addClass('has-error');

                        });

                    }else{
                        //Show toastr message
                        toastr.error("Error Saving Data");
                    }
                }else{
									var msg = data.is_update ? 'Section data updated.' : 'New section added.';
									toastr.success(msg, 'Success!');
									$('#mySections').modal('toggle');
									$('.dept_list[data-id="' + data.department_id + '"]').trigger('click');
									$('#frm_section').trigger('reset');

									if (data.redirect) {
										setTimeout(function () {
											window.location.href = data.redirect
										}, 500);
									}

                }

            }
        });
    });


    /*save user*/
    $("#save_user").click(function(e) {
        e.preventDefault();

				$(".validation_error").hide();
				$('.has-error').removeClass('has-error');
        //let queryString =  $("#frm_contract").serialize();
        let formData = new FormData($('#frm_user')[0]);
        $.ajax({
            /* the route pointing to the post function */
            url: baseUrl + '/admin/save_new_user',
            type: 'POST',
            dataType: "JSON",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if(data.success == false) {
                    if(data.errors)
                    {
                        toastr.warning("Fill the required fields!");
                        jQuery.each(data.errors, function( key, value ) {
													//$('#'+key).addClass('text-danger');
													$('#'+key).closest('.form-group').addClass('has-error');
													if (key == 'password') {
														$('#password_confirmation').closest('.form-group').addClass('has-error');
													}
													toastr.warning(value);

                        });

                    }else{
                        //Show toastr message
                        toastr.error("Error Saving Data");
                    }
                }else{
                    var msg = data.is_update ? 'User data updated.' : 'New User added.';
                    toastr.success(msg, 'Success!');
                    setTimeout(function(){
                        window.location.href = baseUrl+'/admin/user-management';
                    },3000);

                }

            }
        });
    });


    /*save user*/
    $("#save_role").click(function(e) {
        e.preventDefault();

        $(".validation_error").hide();
        //let queryString =  $("#frm_contract").serialize();
        let formData = new FormData($('#frm_role')[0]);
        $.ajax({
            /* the route pointing to the post function */
            url: baseUrl + '/admin/save_new_role',
            type: 'POST',
            dataType: "JSON",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if(data.success == false) {
                    if(data.errors)
                    {
                        toastr.warning("Fill the required fields!");
                        jQuery.each(data.errors, function( key, value ) {
                            toastr.warning(value);
                            $('#'+key).closest('.form-group').addClass('has-error');

                        });

                    }else{
                        //Show toastr message
                        toastr.error("Error Saving Data");
                    }
                }else{
                    var msg = data.is_update ? 'Role data updated.' : 'New Role added.';
                    toastr.success(msg, 'Success!');
                    setTimeout(function(){
                        window.location.href = baseUrl+'/admin/role-management';
                    },2000);

                }

            }
        });
    });


    /*save user*/
    $("#save_interview").click(function(e) {
        e.preventDefault();

        $(".validation_error").hide();
        //let queryString =  $("#frm_contract").serialize();
        let formData = new FormData($('#frm_interview')[0]);
        $.ajax({
            /* the route pointing to the post function */
            url: baseUrl + '/admin/save_interview',
            type: 'POST',
            dataType: "JSON",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if(data.success == false) {
                    if(data.errors)
                    {
                        toastr.warning("Fill the required fields!");
                        jQuery.each(data.errors, function( key, value ) {
                            //$('#'+key).addClass('text-danger');
                            $('#'+key).closest('.form-group').addClass('has-error');

                        });

                    }else{
                        //Show toastr message
                        toastr.error("Error Saving Data");
                    }
                }else{
                    var msg = data.is_update ? 'Interview data updated.' : 'Email for Interview Sent.';
                    toastr.success(msg, 'Success!');
                    setTimeout(function(){
                        window.location.href = baseUrl+'/admin/recruitment';
                    },3000);

                }

            }
        });
		});

	/*save template*/
	$("#save_template").click(function (e) {
		e.preventDefault();

		$('input[name="contents"]').val($('.summernote').summernote('code'));

		$(".validation_error").hide();
		//let queryString =  $("#frm_contract").serialize();
		let formData = new FormData($('#frm_template')[0]);
		$.ajax({
			/* the route pointing to the post function */
			url: baseUrl + '/admin/save_template',
			type: 'POST',
			dataType: "JSON",
			data: formData,
			processData: false,
			contentType: false,
			success: function (data) {
				if (data.success == false) {
					if (data.errors) {
						toastr.warning("Fill the required fields!");
						jQuery.each(data.errors, function (key, value) {
							//$('#'+key).addClass('text-danger');
							$('#' + key).addClass('has-error');

						});

					} else {
						//Show toastr message
						toastr.error("Error Saving Data");
					}
				} else {
					var msg = data.is_update ? 'Template data updated.' : 'New template added.';
					toastr.success(msg, 'Success!');
					setTimeout(function () {
						window.location.href = baseUrl + '/admin/templates';
					}, 3000);

				}

			}
		});
	});


    /*save meeting*/
    $(document).on('click', '#save_meeting,#save_meeting_record432432432', function (e) {//record not working now,
				e.preventDefault();
        let btn_type = $(this).attr('btn-type');


        //let queryString =  $("#frm_contract").serialize();
        let formData = new FormData($('#frm_meeting')[0]);
        $.ajax({
            /* the route pointing to the post function */
            url: baseUrl + '/admin/save_meeting',
            type: 'POST',
            dataType: "JSON",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data.success == false) {
                    if (data.errors) {
                        toastr.warning("Fill the required fields!");
                        jQuery.each(data.errors, function (key, value) {
													$('#frm_meeting #' + key).closest('.form-group').addClass('has-error');

                        });

                    } else {
                        //Show toastr message
                        toastr.error("Error Saving Data");
                    }
                } else {
                    var msg = data.is_update ? 'Meeting data updated.' : 'New Meeting added.';
                    toastr.success(msg, 'Success!');
                    $('#meeting_id').val(data.meeting_id);
                    if(btn_type == 1)//save and record button
                    {
                    //    show popup to record
                    }else{
											if (data.is_modal) {
												$('#mom_list').DataTable().ajax.reload();
												$('.modal').modal('hide');
											}
											else {
												setTimeout(function () {
													window.location.href = baseUrl + '/admin/minutes-of-meeting';
												}, 1000);
											}
                    }


                }

            }
        });
    });


    /*send offer*/
    $("#btn_send_offer").click(function (e) {
				e.preventDefault();

				var $this = $(this);
				$this.addClass('disabled');

				var iboxContent = $('.ibox-content');
				iboxContent.toggleClass('sk-loading');

        $('input[name="contents"]').val($('.summernote').summernote('code'));

        $(".validation_error").hide();
        //let queryString =  $("#frm_contract").serialize();
        let formData = new FormData($('#frm_send_offer')[0]);
        $.ajax({
            /* the route pointing to the post function */
            url: baseUrl + '/admin/send_offer_letter',
            type: 'POST',
            dataType: "JSON",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
							$this.removeClass('disabled');
							iboxContent.toggleClass('sk-loading');

                if (data.success == false) {
                    if (data.errors) {
                        toastr.warning("Fill the required fields!");
                        jQuery.each(data.errors, function (key, value) {
                            //$('#'+key).addClass('text-danger');
                            $('#' + key).closest('.form-group').addClass('has-error');

                        });

                    } else {
                        //Show toastr message
                        toastr.error("Error Saving Data");
                    }
                } else {
                    var msg = data.is_update ? 'Offer data updated.' : 'Offer Letter Prepared.';
                    toastr.success(msg, 'Success!');
                    setTimeout(function () {
                        window.location.href = baseUrl + '/admin/recruitment';
                    }, 2000);

                }

            }
        });
    });


    /*send contract*/
    $("#btn_send_contract").click(function (e) {
				e.preventDefault();

				var $this = $(this);
				$this.addClass('disabled');

				var iboxContent = $('.ibox-content');
				iboxContent.toggleClass('sk-loading');

        $('input[name="contents"]').val($('.summernote').summernote('code'));

        $(".validation_error").hide();
        //let queryString =  $("#frm_contract").serialize();
        let formData = new FormData($('#frm_send_contract')[0]);
        $.ajax({
            /* the route pointing to the post function */
            url: baseUrl + '/admin/send_contract_letter',
            type: 'POST',
            dataType: "JSON",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
							$this.removeClass('disabled');
							iboxContent.toggleClass('sk-loading');

                if (data.success == false) {
                    if (data.errors) {
                        toastr.warning("Fill the required fields!");
                        jQuery.each(data.errors, function (key, value) {
                            //$('#'+key).addClass('text-danger');
                            $('#' + key).closest('.form-group').addClass('has-error');

                        });

                    } else {
                        //Show toastr message
                        toastr.error("Error Saving Data");
                    }
                } else {
                    var msg = data.is_update ? 'Contract data updated.' : 'Contract Letter Sent.';
                    toastr.success(msg, 'Success!');
                    setTimeout(function () {
                        window.location.href = baseUrl + '/admin/recruitment';
                    }, 2000);

                }

            }
        });
    });



    /*save plan*/
    $(".save_plan").click(function (e) {
				e.preventDefault();

				$('[name="is_draft"]').val($(this).attr('data-draft'));

				let formData = new FormData($('#frm_plan')[0]);
        $.ajax({
            /* the route pointing to the post function */
            url: baseUrl + '/admin/save_plan_new',
            type: 'POST',
            dataType: "JSON",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data.success == false) {
                    if (data.errors) {
                        toastr.warning("Fill the required fields!");
                        jQuery.each(data.errors, function (key, value) {
                            //$('#'+key).addClass('text-danger');
                            $('#' + key).closest('.form-group').addClass('has-error');

                        });

                    } else {
                        //Show toastr message
                        toastr.error("Error Saving Data");
                    }
                } else {
										var msg = data.is_update ? 'Plan data updated.' : 'New plan added!.';
										if (data.is_draft == 1) {
											toastr.success('Plan saved as draft.');
										}
										else {
											toastr.success(msg, 'Success!');
										}
                    setTimeout(function () {
                        window.location.href = baseUrl + '/admin/hr-plan';
                    }, 2000);

                }

            }
        });
    });


    /*save employee*/
    $("#save_employee").click(function (e) {
        e.preventDefault();

        let formData = new FormData($('#frm_employee')[0]);
        $.ajax({
            /* the route pointing to the post function */
            url: baseUrl + '/admin/save_employee',
            type: 'POST',
            dataType: "JSON",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data.success == false) {
                    if (data.errors) {
                        toastr.warning("Fill the required fields!");
                        jQuery.each(data.errors, function (key, value) {
                            //$('#'+key).addClass('text-danger');
                            $('#' + key).addClass('has-error');

                        });

                    } else {
                        //Show toastr message
                        toastr.error("Error Saving Data");
                    }
                } else {
                    var msg = data.is_update ? 'Employee data updated.' : 'New Employee added!.';
                    toastr.success(msg, 'Success!');
                    setTimeout(function () {
                        window.location.href = baseUrl + '/admin/employees';
                    }, 2000);

                }

            }
        });
		});

	/*save question*/
	$("#save_question, #save_question_draft").click(function (e) {
		e.preventDefault();

		var $this = $(this);
		$this.addClass('disabled');

		var iboxContent = $('.ibox-content');
		iboxContent.toggleClass('sk-loading');

		$('[name="status_id"]').val($(this).attr('data-status'));
		$('input[name="content"]').val($('.summernote').summernote('code'));

		$('.validation_error').hide();
		let formData = new FormData($('#frm_question')[0]);

		$.ajax({
			/* the route pointing to the post function */
			url: baseUrl + '/admin/question/save',
			type: 'POST',
			dataType: 'JSON',
			data: formData,
			processData: false,
			contentType: false,
			success: function (data) {
				$this.removeClass('disabled');
				iboxContent.toggleClass('sk-loading');

				if (data.success == false) {
					if (data.errors) {
						toastr.warning('Fill the required fields.');
						jQuery.each(data.errors, function (key, value) {
							$('#' + key).closest('.form-group').addClass('has-error');
						});

					} else {
						//Show toastr message
						toastr.error('Error Saving Data');
					}
				} else {
					toastr.success(data.message, 'Success!');
					setTimeout(function () {
						window.location.href = baseUrl + '/admin/question/detail/' + data.question_id;
					}, 1000);

				}

			}
		});
	});

	// create company
	$(document).on('click', '.register-company', function (e) {
		e.preventDefault();

		$('.validation_error').hide();
		let formData = new FormData($('#frm_saas')[0]);

		$.ajax({
			url: $(this).attr('href'),
			type: 'POST',
			dataType: 'JSON',
			data: formData,
			processData: false,
			contentType: false,
			success: function (data) {
				if (data.success == false) {
					if (data.errors) {
						toastr.warning('Fill the required fields!');
						jQuery.each(data.errors, function (key, value) {
							$('#' + key).closest('.form-group').addClass('has-error');
						});
					}
					else {
						//Show toastr message
						toastr.error('Error Saving Data');
					}
				}
				else {
					toastr.success(data.message, 'Success!');
					setTimeout(function () {
						window.location.href = baseUrl + '/admin/enterprise/detail/' + data.company_id;
					}, 1500);
				}

			}
		});
	});

	// save budget
	$(document).on('click', '.save_budget', function (e) {
		e.preventDefault();

		$('.validation_error').hide();
		let formData = new FormData($('#frm_budget')[0]);

		$.ajax({
			url: $(this).attr('href'),
			type: 'POST',
			dataType: 'JSON',
			data: formData,
			processData: false,
			contentType: false,
			success: function (data) {
				if (data.success == false) {
					if (data.errors) {
						toastr.warning('Fill the required fields!');
						jQuery.each(data.errors, function (key, value) {
							$('#' + key).closest('.form-group').addClass('has-error');
						});
					}
					else {
						//Show toastr message
						toastr.error('Error Saving Data');
					}
				}
				else {
					toastr.success(data.message, 'Success!');
					setTimeout(function () {
						window.location.href = baseUrl + '/admin/main-contract#tab-budgets';
					}, 1500);
				}

			}
		});
	});

	// save pdf template
	$("#save_pdftemplate").click(function (e) {
		e.preventDefault();

		$('input[name="summary"]').val($('.summernote').summernote('code'));

		$(".validation_error").hide();
		//let queryString =  $("#frm_contract").serialize();
		let formData = new FormData($('#frm_template')[0]);
		$.ajax({
			/* the route pointing to the post function */
			url: baseUrl + '/admin/pdf-template/save',
			type: 'POST',
			dataType: "JSON",
			data: formData,
			processData: false,
			contentType: false,
			success: function (data) {
				if (data.success == false) {
					if (data.errors) {
						toastr.warning("Fill the required fields!");
						jQuery.each(data.errors, function (key, value) {
							//$('#'+key).addClass('text-danger');
							$('#' + key).addClass('has-error');

						});

					} else {
						//Show toastr message
						toastr.error("Error Saving Data");
					}
				} else {
					var msg = data.is_update ? 'Template data updated.' : 'New template added.';
					toastr.success(msg, 'Success!');
					setTimeout(function () {
						window.location.href = baseUrl + '/admin/pdf-templates';
					}, 3000);

				}

			}
		});
	});



	//save report
    $("#btn_new_report").click(function (e) {
        e.preventDefault();

       // $('input[name="report_details"]').val($('.summernote').summernote('code'));
        $('#frm_new_report input[name="report_details"]').val($('#frm_new_report .summernote').summernote('code'));
        $('#frm_new_report input[name="next_actions"]').val($('#frm_new_report #summernote1').summernote('code'));

        $(".validation_error").hide();
        //let queryString =  $("#frm_contract").serialize();
        let formData = new FormData($('#frm_new_report')[0]);
        $.ajax({
            /* the route pointing to the post function */
            url: baseUrl + '/admin/report/save_report',
            type: 'POST',
            dataType: "JSON",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data.success == false) {
                    if (data.errors) {
                        toastr.warning("Fill the required fields!");
                        jQuery.each(data.errors, function (key, value) {
                            toastr.warning(value);
                            $('#' + key).addClass('has-error');

                        });

                    } else {
                        //Show toastr message
                        toastr.error("Error Saving Data");
                    }
                } else {
                    var msg = data.is_update ? 'Report data updated.' : 'New Report added.';
                    toastr.success(msg, 'Success!');
                    setTimeout(function () {
                        window.location.href = baseUrl + '/admin/reports';
                    }, 1000);

                }

            }
        });
    });


    $("#btn_meeting_mom").click(function (e)
    {
        $('#frm_meeting_mom input[name="mom_contents"]').val($('#frm_meeting_mom .summernote').summernote('code'));
        $(".validation_error").hide();
        //let queryString =  $("#frm_contract").serialize();
        let formData = new FormData($('#frm_meeting_mom')[0]);
        $.ajax({
            /* the route pointing to the post function */
            url: baseUrl + '/admin/meeting/save_meeting_mom',
            type: 'POST',
            dataType: "JSON",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data.success == false) {
                    if (data.errors) {
                        toastr.warning("Fill the required fields!");
                        jQuery.each(data.errors, function (key, value) {
                            toastr.warning(value);
                            $('#' + key).addClass('has-error');

                        });

                    } else {
                        //Show toastr message
                        toastr.error("Error Saving Data");
                    }
                } else {
                    var msg = data.is_update ? 'MOM data updated.' : 'New MOM added.';
                    toastr.success(msg, 'Success!');
                    setTimeout(function () {
                        window.location.href = baseUrl + '/admin/minutes-of-meeting/detail/'+$('#meeting_id').val();
                    }, 1000);

                }

            }
        });
    });

});