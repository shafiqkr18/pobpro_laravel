$(document).ready(function(){
    /*contract list*/
    // $('#contract_list').DataTable({
    //     processing: true,
    //     serverSide: true,
    //     pageLength: 10,
    //     responsive: true,
    //     lengthChange: false,
    //     dom: '<"html5buttons"B>lTfgitp',
    //     buttons: [
    //         { extend: 'copy'},
    //         {extend: 'csv'},
    //         {extend: 'excel', title: 'ContractsFile'},
    //         {extend: 'pdf', title: 'ContractsFile'},

    //         {extend: 'print',
    //             customize: function (win){
    //                 $(win.document.body).addClass('white-bg');
    //                 $(win.document.body).css('font-size', '10px');

    //                 $(win.document.body).find('table')
    //                     .addClass('compact')
    //                     .css('font-size', 'inherit');
		// 						}
    //         },
    //         {
    //             className: 'btn-create',
		// 						text: '<i class="fa fa-plus mr-1"></i> Create',
    //             action: function ( e, dt, node, config ) {
    //                 window.location.href = $('.ibox-title h5').attr('data-url');
		// 						}
		// 				}
		// ],
		// ajax: {
    //         url: baseUrl + '/admin/contracts_filter',
    //         type: 'POST',
    //         data: function(data){
		// 		// Append to data
		// 		//data.search_by_name = $('#search_by_name').val();


    //         }
    //     },
    //     createdRow: function (row, data, index) {
		// 	$("td", row).eq(6).addClass("text-right text-nowrap").html("").append('<a href="' + baseUrl + "/admin/contract-management/detail/" + data[0] + '"  title="View"><i class="fa fa-eye text-info"></i>' + '<a href="' + baseUrl + "/admin/contract-management/update/" + data[0] + '"  title="Edit"><i class="fas fa-pen-square text-success"></i>' + '<a href="' + baseUrl + '/admin/modal/delete" id="' + data[0] + '"  title="Delete" confirmation-modal="delete" data-view="table" data-url="' + baseUrl + '/admin/contract-management/delete/' + data[0] + '"><i class="fa fa-trash text-danger"></i></a>');
    //     }

		// });

	$('#contract_list').DataTable({
		processing: true,
		serverSide: true,
		pageLength: 10,
		responsive: true,
		lengthChange: false,
		dom: '<"html5buttons"B>lTfgitp',
        "columnDefs": [
            { "bSortable": false, "targets": 0 }
        ],
		buttons: [
			{ extend: 'copy' },
			{ extend: 'csv' },
			{ extend: 'excel', title: 'ContractFile' },
			{ extend: 'pdf', title: 'ContractFile' },

			{
				extend: 'print',
				customize: function (win) {
					$(win.document.body).addClass('white-bg');
					$(win.document.body).css('font-size', '10px');

					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				}
			}
		],
		ajax: {
			url: baseUrl + '/admin/contract_list_filter',
			type: 'POST',
			data: function (data) {
				// Append to data
				data.pending = $('#pending').val();
				data.ur = $('#ur').val();


			}
		},
		createdRow: function (row, data, index) {
			if (data[0] > 0) {
				$('td', row).eq(0).html('').append(
					'<input type="checkbox" name="row_id" id="checkbox_' + data[0] + '" value="' + data[0] + '">'
				);
			}

			let fa = ['times', 'check'],
				color = ['muted', 'navy'],
				status = ['Pending', 'Accepted'];

			$('td', row).eq(3).html('').append(
				'<span>' + status[data[3]] + '</span>'
			);

			$('td', row).eq(4).html('').append(
				'<a href="' + baseUrl + '/admin/candidate/detail/' + data[4].id + '/1" info-modal="candidate" class="text-success">' + data[4].name + ' ' + (data[4].last_name ? data[4].last_name : '') + '</a>'
			);

			$('td', row).eq(2).html('').append(
				'<i class="fas fa-' + (data[2] == 1 ? 'check' : 'times') + ' text-' + (data[2] == 1 ? 'navy' : 'muted') + '"></i>'
			);

			$('td', row).eq(9).addClass('text-right text-nowrap action-column').html('').append(
				'<a href="' + baseUrl + '/admin/contract/detail/' + data[0] + '"  title="View"><i class="fa fa-eye text-info"></i>'
			);
		}

	});


	$('#contract_list_pending').DataTable({
		processing: true,
		serverSide: true,
		pageLength: 10,
		responsive: true,
		lengthChange: false,
		dom: '<"html5buttons"B>lTfgitp',
		"columnDefs": [
			{ "bSortable": false, "targets": 0 }
		],
		buttons: [
			{ extend: 'copy' },
			{ extend: 'csv' },
			{ extend: 'excel', title: 'ContractFile' },
			{ extend: 'pdf', title: 'ContractFile' },

			{
				extend: 'print',
				customize: function (win) {
					$(win.document.body).addClass('white-bg');
					$(win.document.body).css('font-size', '10px');

					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				}
			}
		],
		ajax: {
			url: baseUrl + '/admin/contract_list_filter_pending',
			type: 'POST',
			data: function (data) {
				// Append to data
				data.pending = $('#pending').val();
				data.ur = $('#ur').val();


			}
		},
		createdRow: function (row, data, index) {
            $(row).attr('id', 'row_' + data[0]);
			if (data[0] > 0) {
				$('td', row).eq(0).html('').append(
                    '<input type="checkbox" dm="' + data[10] + '" hrm="' + data[11] + '" gm="' + data[12] + '" name="row_id" id="checkbox_' + data[0] + '" value="' + data[0] + '">'
				);
			}

			let fa = ['times', 'check'],
				color = ['muted', 'navy'],
				status = ['Pending', 'Accepted'];

			$('td', row).eq(3).html('').append(
				'<span>' + status[data[3]] + '</span>'
			);

			$('td', row).eq(4).html('').append(
				'<a href="' + baseUrl + '/admin/candidate/detail/' + data[4].id + '/1" info-modal="candidate" class="text-success">' + data[4].name + ' ' + (data[4].last_name ? data[4].last_name : '') + '</a>'
			);

			$('td', row).eq(2).html('').append(
				'<i class="fas fa-' + (data[2] == 1 ? 'check' : 'times') + ' text-' + (data[2] == 1 ? 'navy' : 'muted') + '"></i>'
			);

			$('td', row).eq(9).addClass('text-right text-nowrap action-column').html('').append(
				'<a href="' + baseUrl + '/admin/contract/detail/' + data[0] + '"  title="View"><i class="fa fa-eye text-info"></i>'
			);
		}

	});


    /*organization listing*/
    $('#org_list').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        responsive: true,
        lengthChange: false,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            { extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', title: 'OrganizationFile'},
            {extend: 'pdf', title: 'OrganizationFile'},

            {extend: 'print',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
            {
                className: 'btn-create',
                text: '<i class="fa fa-plus mr-1"></i> Create',
                action: function ( e, dt, node, config ) {
                    window.location.href = $('.ibox-title h5').attr('data-url');
                }
            }
        ],
        ajax: {
            url: baseUrl + '/admin/organization_filter',
            type: 'POST',
            data: function(data){
                // Append to data
                //data.search_by_name = $('#search_by_name').val();


            }
        },
        createdRow: function (row, data, index) {
					$('td', row).eq(7).addClass('text-right text-nowrap action-column').html('').append(
                '<a href="'+baseUrl+'/admin/organization-management/detail/'+data[0]+'"  title="View"><i class="fa fa-eye text-info"></i>' +
                '<a href="'+baseUrl+'/admin/organization-management/update/'+data[0]+'"  title="Edit"><i class="fas fa-pen-square text-success"></i>' +
							'<a href="' + baseUrl + '/admin/modal/delete" id="' + data[0] + '"  title="Delete" confirmation-modal="delete" data-view="table" data-url="' + baseUrl + '/admin/organization-management/delete/' + data[0] + '"><i class="fa fa-trash text-danger"></i></a>'
            );
        }

    });


    /*positions listing*/
    $('#position_list').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        responsive: true,
        lengthChange: false,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            { extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', title: 'PositionsFile'},
            {extend: 'pdf', title: 'PositionsFile'},

            {extend: 'print',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
            // {
            //     className: 'btn-create',
            //     text: '<i class="fa fa-plus mr-1"></i> Create',
            //     action: function ( e, dt, node, config ) {
            //         window.location.href = $('.ibox-title h5').attr('data-url');
            //     }
            // }
        ],
        ajax: {
            url: baseUrl + '/admin/position_filter',
            type: 'POST',
            data: function(data){
                // Append to data
                //data.search_by_name = $('#search_by_name').val();


            }
        },
        createdRow: function (row, data, index) {
					$('td', row).eq(1).addClass('text-nowrap').html('').append('<a class="text-success" href="' + baseUrl + '/admin/position-management/detail/' + data[0] + '">' + data[1] + '</a>');
					// $('td', row).eq(8).html('').append(
					// 	'<span title="' + data[8] + '">' + (data[8].length > 12 ? (data[8].substring(0, 12) + '..') : data[8]) + '</span>'
					// );
					$('td', row).eq(9).addClass('text-right text-nowrap action-column').html('').append(
							'<a href="'+baseUrl+'/admin/position-management/detail/'+data[0]+'"  title="View"><i class="fa fa-eye text-info"></i>' +
							'<a href="'+baseUrl+'/admin/position-management/update/'+data[0]+'"  title="Edit"><i class="fas fa-pen-square text-success"></i></a>'
						//'<a href="' + baseUrl + '/admin/modal/delete" id="' + data[0] + '"  title="Delete" confirmation-modal="delete" data-view="table" data-url="' + baseUrl + '/admin/position-management/delete/' + data[0] + '"><i class="fa fa-trash text-danger delete-me"></i></a>'
					);
        }

    });



    /*candidates listing*/
    $('#candidates_list').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        responsive: true,
        lengthChange: false,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
			{ extend: 'copy' },
			{ extend: 'csv' },
			{ extend: 'excel', title: 'CandidatesFile' },
			{ extend: 'pdf', title: 'CandidatesFile' },

			{
				extend: 'print',
				customize: function (win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
            {
                className: 'btn-create',
                text: '<i class="fa fa-plus mr-1"></i> Create',
				action: function (e, dt, node, config) {
                    window.location.href = $('.ibox-title h5').attr('data-url');
                }
			}, {
                className: 'btn-outline',
								text: '<i class="fa fa-upload mr-1 text-navy"></i> <span class="text-navy">Import</span>',
                action: function (e, dt, node, config) {
									window.location.href = baseUrl + '/admin/candidate/import'
            		}
            },
        ],
        ajax: {
            url: baseUrl + '/admin/candidate_filter',
            type: 'POST',
			data: function (data) {
                // Append to data
                //data.search_by_name = $('#search_by_name').val();


            }
        },
        createdRow: function (row, data, index) {
						$('td', row).eq(1).html('').append('<a class="text-success" href="' + baseUrl + '/admin/candidate/detail/' + data[0] + '">' + data[1] + '</a>');

					$('td', row).eq(12).addClass('text-right text-nowrap action-column').html('').append(
				'<a href="' + baseUrl + '/admin/candidate/detail/' + data[0] + '"  title="View"><i class="fa fa-eye text-info"></i>' +
				'<a href="' + baseUrl + '/admin/candidate/update/' + data[0] + '"  title="Edit"><i class="fas fa-pen-square text-success"></i>' +
							'<a href="' + baseUrl + '/admin/modal/delete" id="' + data[0] + '"  title="Delete" confirmation-modal="delete" data-view="table" data-url="' + baseUrl + '/admin/candidate/delete/' + data[0] + '"><i class="fa fa-trash text-danger delete-me"></i></a>'
            );
        }

    });


    $('#applicants_list').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        responsive: true,
        lengthChange: false,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            { extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', title: 'ApplicantsFile'},
            {extend: 'pdf', title: 'ApplicantsFile'},

            {extend: 'print',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
            {
                className: 'btn-create',
                text: '<i class="fa fa-plus mr-1"></i> Create',
                action: function ( e, dt, node, config ) {
                    window.location.href = $('.ibox-title h5').attr('data-url');
                }
            }
        ],
        ajax: {
            url: baseUrl + '/admin/applicant_filter',
            type: 'POST',
            data: function(data){
                // Append to data
                //data.search_by_name = $('#search_by_name').val();


            }
        },
        createdRow: function (row, data, index) {
            $('td', row).eq(1).html('').append('<a class="text-success" href="' + baseUrl + '/admin/candidate/detail/' + data[0] + '">' + data[1] + '</a>');

					$('td', row).eq(11).addClass('text-right text-nowrap action-column').html('').append(
                '<a href="'+baseUrl+'/admin/candidate/detail/'+data[0]+'"  title="View"><i class="fa fa-eye text-info"></i>' +
                '<a href="'+baseUrl+'/admin/candidate/update/'+data[0]+'"  title="Edit"><i class="fas fa-pen-square text-success"></i>' +
                '<a href="' + baseUrl + '/admin/modal/delete" id="' + data[0] + '"  title="Delete" confirmation-modal="delete" data-view="table" data-url="' + baseUrl + '/admin/candidate/delete/' + data[0] + '"><i class="fa fa-trash text-danger delete-me"></i></a>'
            );
        }

    });

    /*vacancy_list listing*/
    $('#vacancy_list').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        responsive: true,
        lengthChange: false,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            { extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', title: 'JobPositionFile'},
            {extend: 'pdf', title: 'JobPositionFile'},

            {extend: 'print',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
            {
                className: 'btn-create',
                text: '<i class="fa fa-plus mr-1"></i> Create',
                action: function ( e, dt, node, config ) {
                    window.location.href = $('.ibox-title h5').attr('data-url');
                }
            }
        ],
        ajax: {
            url: baseUrl + '/admin/vacancy_filter',
            type: 'POST',
            data: function(data){
                // Append to data
                //data.search_by_name = $('#search_by_name').val();


            }
        },
        createdRow: function (row, data, index) {
						$('td', row).eq(1).addClass('text-nowrap');
					$('td', row).eq(6).addClass('text-right text-nowrap action-column').html('').append(
                '<a href="'+baseUrl+'/admin/vacancy/matching_candidates/'+data[0]+'" class="text-success" title="Matching Candidates">Matching Candidates | ' +
                 '<a href="'+baseUrl+'/admin/vacancy/all_jobs/'+data[0]+'" class="text-success" title="View All Jobs">View All Jobs | ' +
                '<a href="'+baseUrl+'/admin/vacancy/post_job/'+data[0]+'" class="text-success" title="Post Job">Post Job'

            );
        }

    });



    /*matching candidates listing*/
    $('#matching_candidates_list').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        responsive: true,
        lengthChange: false,
        dom: '<"html5buttons"B>lTfgitp',
        "columnDefs": [
            { "orderable": false, "targets": 0 }
        ],
        buttons: [
            { extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', title: 'MatchingCandidatesFile'},
            {extend: 'pdf', title: 'MatchingCandidatesFile'},

            {extend: 'print',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
            {
                className: 'btn-create',
                text: '<i class="fa fa-plus mr-1"></i> Create',
                action: function ( e, dt, node, config ) {
                    window.location.href = $('.ibox-title h5').attr('data-url');
                }
            }
        ],
        ajax: {
            url: baseUrl + '/admin/matching_candidate_filter',
            type: 'POST',
            data: function(data){
                // Append to data
                data.position_id = $('#position_id').val();


            }
        },
        createdRow: function (row, data, index) {
            var action_html = '';
            if(data[11] == 'open'){
               // action_html = '<a href="'+baseUrl+'/admin/candidate/short-list/'+data[0]+'" title="Short List" class="btn-short-list">Short List</a>'
            }

            if(data[0]>0){
                $('td', row).eq(0).html('').append(
               '<input type="checkbox" name="row_id" id="checkbox_'+data[0]+'" value="'+data[0]+'">'
                );
            }
					$('td', row).eq(12).addClass('text-right text-nowrap action-column').html('').append(
                // '<a href="'+baseUrl+'/admin/candidate/detail/'+data[0]+'"  title="View"><i class="fa fa-eye text-info"></i>' +
                // '<a href="'+baseUrl+'/admin/candidate/update/'+data[0]+'"  title="Edit"><i class="fas fa-pen-square text-success"></i>' +
                // '<a href="javascript:void(0)" id="'+data[0]+'"  title="Delete"><i class="fa fa-trash text-danger delete-me"></i></a>'
                action_html

            );
        }

    });


    /*interviewee_list listing*/
    $('#interviewee_list').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        responsive: true,
        lengthChange: false,
        dom: '<"html5buttons"B>lTfgitp',
        "columnDefs": [
            { "orderable": false, "targets": 0 }
        ],
        buttons: [
            { extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', title: 'IntervieweeFile'},
            {extend: 'pdf', title: 'IntervieweeFile'},

            {extend: 'print',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
            // {
            //     className: 'btn-create',
            //     text: '<i class="fa fa-plus mr-1"></i> Create',
            //     action: function ( e, dt, node, config ) {
            //         window.location.href = $('.ibox-title h5').attr('data-url');
            //     }
            // }
        ],
        ajax: {
            url: baseUrl + '/admin/interviewee_filter',
            type: 'POST',
            data: function(data){
                // Append to data
                data.position_id = $('#position_id').val();
                data.plan_id = $('#plan_id').val();


            }
        },
        createdRow: function (row, data, index) {
            $(row).attr('id', 'row_' + data[0]);
            var action_html = '';
            if(data[11] == 'open'){
                // action_html = '<a href="'+baseUrl+'/admin/candidate/short-list/'+data[0]+'" title="Short List" class="btn-short-list">Short List</a>'
            }

            if(data[0]>0){
                $('td', row).eq(0).html('').append(
                    '<input type="checkbox" prepared_approved ="'+data[15]+'"  offer="'+data[14]+'" name="row_id" id="checkbox_'+data[0]+'" value="'+data[0]+'">'
                );
						}

					var interview = data[11],
							offer = data[12],
							contract = data[13];

					var interview_status = ['Interview Pending', 'Interview Done'],
							offer_status = ['No offer.', 'Offer sent.'],
							contract_status = ['No contract.', 'Contract sent.'];

					var colors = ['danger', 'navy'];

					$('td', row).eq(1).addClass('text-nowrap d-flex align-items-center').html('').append(
						'<img src="' + baseUrl + '/img/interview' + (interview == 1 ? '-green' : '') + '.svg" width="28" title="' + interview_status[interview] + '" class="' + interview + '">' +
						'<img src="' + baseUrl + '/img/offer' + (offer == 1 ? '-green' : '') + '.svg" width="16" class="" title="' + offer_status[offer] + '">' +
						'<img src="' + baseUrl + '/img/contract' + (contract == 1 ? '-green' : '') + '.svg" width="16" class="ml-1" title="' + contract_status[contract] + '">'
					);

					$('td', row).eq(2).html('').append(
						'<a href="' + baseUrl + '/admin/candidate/detail/' + data[0] + '/1" info-modal="candidate" class="text-success">' + data[2] + '</a>'
					);

            //$('td', row).eq(12).addClass('text-right text-nowrap').html('').append(
                // '<a href="'+baseUrl+'/admin/candidate/detail/'+data[0]+'"  title="View"><i class="fa fa-eye text-info"></i>' +
                // '<a href="'+baseUrl+'/admin/candidate/update/'+data[0]+'"  title="Edit"><i class="fas fa-pen-square text-success"></i>' +
                // '<a href="javascript:void(0)" id="'+data[0]+'"  title="Delete"><i class="fa fa-trash text-danger delete-me"></i></a>'
                //action_html

            //);
        }

    });

    /*contract_onboarding_list listing*/
    $('#contract_onboarding_list').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        responsive: true,
        lengthChange: false,
        dom: '<"html5buttons"B>lTfgitp',
        "columnDefs": [
            { "orderable": false, "targets": 0 }
        ],
        buttons: [
            { extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', title: 'OnboardingFile'},
            {extend: 'pdf', title: 'OnboardingFile'},

            {extend: 'print',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
            // {
            //     className: 'btn-create',
            //     text: '<i class="fa fa-plus mr-1"></i> Create',
            //     action: function ( e, dt, node, config ) {
            //         window.location.href = $('.ibox-title h5').attr('data-url');
            //     }
            // }
        ],
        ajax: {
            url: baseUrl + '/admin/contract_onboarding_filter',
            type: 'POST',
            data: function(data){
                // Append to data
                data.position_id = $('#position_id').val();
                data.plan_id = $('#plan_id').val();


            }
        },
        createdRow: function (row, data, index) {
					var action_html = '';
					if(data[11] == 'open'){
							// action_html = '<a href="'+baseUrl+'/admin/candidate/short-list/'+data[0]+'" title="Short List" class="btn-short-list">Short List</a>'
					}

					if(data[0]>0){
							$('td', row).eq(0).html('').append(
									'<input type="checkbox" name="row_id" id="checkbox_'+data[0]+'" value="'+data[0]+'">'
							);
					}

					var interview = data[8],
						offer = data[9],
						contract = data[10];

					var interview_status = ['Interview Pending', 'Interview Done'],
						offer_status = ['No offer.', 'Offer sent.'],
						contract_status = ['No contract.', 'Contract sent.'];

					$('td', row).eq(1).addClass('text-nowrap d-flex align-items-center').html('').append(
						'<img src="' + baseUrl + '/img/interview' + (interview == 1 ? '-green' : '') + '.svg" width="28" title="' + interview_status[interview] + '">' +
						'<img src="' + baseUrl + '/img/offer' + (offer == 1 ? '-green' : '') + '.svg" width="16" class="" title="' + offer_status[offer] + '">' +
						'<img src="' + baseUrl + '/img/contract' + (contract == 1 ? '-green' : '') + '.svg" width="16" class="ml-1" title="' + contract_status[contract] + '">'
					);

					$('td', row).eq(2).html('').append(
						'<a href="' + baseUrl + '/admin/candidate/detail/' + data[0] + '/1" info-modal="candidate" class="text-success">' + data[2] + '</a>'
					);

					$('td', row).eq(8).addClass('text-right text-nowrap').html('').append(
						data[11] == 1 ? 'On Board' : '<a href="'+baseUrl+'/admin/employee/enrollment/' + data[0] + '"  title="Form" class="text-success">Enrollment Form</a>'
					);
        }

    });


    /*organization listing*/
    $('#division_list').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        responsive: true,
        lengthChange: false,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            { extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', title: 'DivisionFile'},
            {extend: 'pdf', title: 'DivisionFile'},

            {extend: 'print',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
            // {
            //     className: 'btn-create',
            //     text: '<i class="fa fa-plus mr-1"></i> Create',
            //     action: function ( e, dt, node, config ) {
            //         window.location.href = $('.ibox-title h5').attr('data-url');
            //     }
            // }
        ],
        ajax: {
            url: baseUrl + '/admin/division_filter',
            type: 'POST',
            data: function(data){
                // Append to data
                //data.search_by_name = $('#search_by_name').val();


            }
        },
        createdRow: function (row, data, index) {
					$('td', row).eq(1).addClass('text-nowrap');
					$('td', row).eq(7).addClass('text-right text-nowrap action-column').html('').append(
                '<a href="'+baseUrl+'/admin/division-management/detail/'+data[0]+'"  title="View"><i class="fa fa-eye text-info"></i>' +
                '<a href="'+baseUrl+'/admin/division-management/update/'+data[0]+'"  title="Edit"><i class="fas fa-pen-square text-success"></i>' +
                '<a href="' + baseUrl + '/admin/modal/delete" id="' + data[0] + '"  title="Delete" confirmation-modal="delete" data-view="table" data-url="' + baseUrl + '/admin/division-management/delete/' + data[0] + '"><i class="fa fa-trash text-danger"></i></a>'
            );
        }

    });


	/* shortlited candidates listing */
	$('#shortlisted_candidates_list').DataTable({
		processing: true,
		serverSide: true,
		pageLength: 10,
		responsive: true,
		lengthChange: false,
		dom: '<"html5buttons"B>lTfgitp',
        "columnDefs": [
            { "orderable": false, "targets": 0 }
        ],
		buttons: [
			{ extend: 'copy' },
			{ extend: 'csv' },
			{ extend: 'excel', title: 'CandidatesFile' },
			{ extend: 'pdf', title: 'CandidatesFile' },

			{
				extend: 'print',
				customize: function (win) {
					$(win.document.body).addClass('white-bg');
					$(win.document.body).css('font-size', '10px');

					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				}
			},
			{
				className: 'btn-create',
				text: '<i class="fa fa-plus mr-1"></i> Create',
				action: function (e, dt, node, config) {
					window.location.href = $('.ibox-title h5').attr('data-url');
				}
			}
		],
		ajax: {
			url: baseUrl + '/admin/shortlisted_filter',
			type: 'POST',
			data: function (data) {
				// Append to data
				//data.search_by_name = $('#search_by_name').val();

			}
		},
		createdRow: function (row, data, index) {
			// $('td', row).eq(1).addClass('text-nowrap');

			$('td', row).eq(7).addClass('text-right text-nowrap').html('').append(
                '<a href="' + baseUrl + '/admin/candidate/detail/' + data[0] + '" class="text-success"  title="View details"><i class="fa fa-phone text-success"></i> View Details'
			);

            if(data[0]>0){
                $('td', row).eq(0).html('').append(
                    '<input type="checkbox" name="row_id" id="checkbox_'+data[0]+'" value="'+data[0]+'">'
                );
            }
		}

	});


    /*department listing*/
    $('#department_list').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        responsive: true,
        lengthChange: false,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            { extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', title: 'DeptFile'},
            {extend: 'pdf', title: 'DeptFile'},

            {extend: 'print',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
            // {
            //     className: 'btn-create',
            //     text: '<i class="fa fa-plus mr-1"></i> Create',
            //     action: function ( e, dt, node, config ) {
            //         window.location.href = $('.ibox-title h5').attr('data-url');
            //     }
            // }
        ],
        ajax: {
            url: baseUrl + '/admin/department_filter',
            type: 'POST',
            data: function(data){
                // Append to data
                //data.search_by_name = $('#search_by_name').val();


            }
        },
        createdRow: function (row, data, index) {
					$('td', row).eq(8).addClass('text-right text-nowrap action-column').html('').append(
                '<a href="'+baseUrl+'/admin/department-management/detail/'+data[0]+'"  title="View"><i class="fa fa-eye text-info"></i>' +
                '<a href="'+baseUrl+'/admin/department-management/update/'+data[0]+'"  title="Edit"><i class="fas fa-pen-square text-success"></i>' +
                '<a href="' + baseUrl + '/admin/modal/delete" id="' + data[0] + '"  title="Delete" confirmation-modal="delete" data-view="table" data-url="' + baseUrl + '/admin/department-management/delete/' + data[0] + '"><i class="fa fa-trash text-danger"></i></a>'
            );
        }

    });


    /*section listing*/
    $('#section_list').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        responsive: true,
        lengthChange: false,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            { extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', title: 'SectionFile'},
            {extend: 'pdf', title: 'SectionFile'},

            {extend: 'print',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
            // {
            //     className: 'btn-create',
            //     text: '<i class="fa fa-plus mr-1"></i> Create',
            //     action: function ( e, dt, node, config ) {
            //         window.location.href = $('.ibox-title h5').attr('data-url');
            //     }
            // }
        ],
        ajax: {
            url: baseUrl + '/admin/section_filter',
            type: 'POST',
            data: function(data){
                // Append to data
                //data.search_by_name = $('#search_by_name').val();


            }
        },
        createdRow: function (row, data, index) {
					$('td', row).eq(9).addClass('text-right text-nowrap action-column').html('').append(
                '<a href="'+baseUrl+'/admin/section-management/detail/'+data[0]+'"  title="View"><i class="fa fa-eye text-info"></i>' +
                '<a href="'+baseUrl+'/admin/section-management/update/'+data[0]+'"  title="Edit"><i class="fas fa-pen-square text-success"></i>' +
                '<a href="' + baseUrl + '/admin/modal/delete" id="' + data[0] + '"  title="Delete" confirmation-modal="delete" data-view="table" data-url="' + baseUrl + '/admin/section-management/delete/' + data[0] + '"><i class="fa fa-trash text-danger"></i></a>'
            );
        }

    });



    /* interviewed candidates listing */
    $('#interviewed_candidates_list').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        responsive: true,
        lengthChange: false,
        dom: '<"html5buttons"B>lTfgitp',
        "columnDefs": [
            { "orderable": false, "targets": 0 }
        ],
        buttons: [
            { extend: 'copy' },
            { extend: 'csv' },
            { extend: 'excel', title: 'CandidatesFile' },
            { extend: 'pdf', title: 'CandidatesFile' },

            {
                extend: 'print',
                customize: function (win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
            {
                className: 'btn-create',
                text: '<i class="fa fa-plus mr-1"></i> Create',
                action: function (e, dt, node, config) {
                    window.location.href = $('.ibox-title h5').attr('data-url');
                }
            }
        ],
        ajax: {
            url: baseUrl + '/admin/offers_filter',
            type: 'POST',
            data: function (data) {
                // Append to data
                //data.search_by_name = $('#search_by_name').val();

            }
        },
        createdRow: function (row, data, index) {
            // $('td', row).eq(1).addClass('text-nowrap');

					$('td', row).eq(8).addClass('text-right text-nowrap action-column').html('').append(
                '<a href="' + baseUrl + '/admin/candidate/detail/' + data[0] + '" class="text-success"  title="View details"><i class="fa fa-phone text-success"></i> View Details'
            );

            if(data[0]>0){
                $('td', row).eq(0).html('').append(
                    '<input type="checkbox" name="row_id" id="checkbox_'+data[0]+'" value="'+data[0]+'">'
                );
            }
        }

    });



    /*matching candidates listing*/
    $('#online_candidates_list').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        responsive: true,
        lengthChange: false,
        dom: '<"html5buttons"B>lTfgitp',
        "columnDefs": [
            { "orderable": false, "targets": 0 }
        ],
        buttons: [
            { extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', title: 'OnlineCandidatesFile'},
            {extend: 'pdf', title: 'OnlineCandidatesFile'},

            {extend: 'print',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
            {
                className: 'btn-create',
                text: '<i class="fa fa-plus mr-1"></i> Create',
                action: function ( e, dt, node, config ) {
                    window.location.href = $('.ibox-title h5').attr('data-url');
                }
            }
        ],
        ajax: {
            url: baseUrl + '/admin/online_candidate_filter',
            type: 'POST',
            data: function(data){
                // Append to data
                data.position_id = $('#position_id').val();


            }
        },
        createdRow: function (row, data, index) {
            var action_html = '';
            if(data[11] == 'open'){
                // action_html = '<a href="'+baseUrl+'/admin/candidate/short-list/'+data[0]+'" title="Short List" class="btn-short-list">Short List</a>'
            }

            if(data[0]>0){
                $('td', row).eq(0).html('').append(
                    '<input type="checkbox" name="row_id" id="checkbox_'+data[0]+'" value="'+data[0]+'">'
                );
            }
					$('td', row).eq(12).addClass('text-right text-nowrap action-column').html('').append(
                // '<a href="'+baseUrl+'/admin/candidate/detail/'+data[0]+'"  title="View"><i class="fa fa-eye text-info"></i>' +
                // '<a href="'+baseUrl+'/admin/candidate/update/'+data[0]+'"  title="Edit"><i class="fas fa-pen-square text-success"></i>' +
                // '<a href="javascript:void(0)" id="'+data[0]+'"  title="Delete"><i class="fa fa-trash text-danger delete-me"></i></a>'
                action_html

            );
        }

    });


    /* shortlited candidates listing by position */
    $('#shortlisted_position_candidates_list').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        responsive: true,
        lengthChange: false,
        dom: '<"html5buttons"B>lTfgitp',
        "columnDefs": [
            { "orderable": false, "targets": 0 }
        ],
        buttons: [
            { extend: 'copy' },
            { extend: 'csv' },
            { extend: 'excel', title: 'CandidatesFile' },
            { extend: 'pdf', title: 'CandidatesFile' },

            {
                extend: 'print',
                customize: function (win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
            {
                className: 'btn-create',
                text: '<i class="fa fa-plus mr-1"></i> Create',
                action: function (e, dt, node, config) {
                    window.location.href = $('.ibox-title h5').attr('data-url');
                }
            }
        ],
        ajax: {
            url: baseUrl + '/admin/shortlisted_filter_by_position',
            type: 'POST',
            data: function (data) {
                // Append to data
                data.position_id = $('#position_id').val();
                data.plan_id = $('#plan_id').val();

            }
        },
        createdRow: function (row, data, index) {
						// $('td', row).eq(1).addClass('text-nowrap');
					$('td', row).eq(2).html('').append(
                '<i class="fas fa-' + (data[2] == 1 ? 'check' : 'times') + ' text-' + (data[2] == 1 ? 'navy' : 'muted') + '"></i>'
            );
					$('td', row).eq(3).html('').append(
						'<a href="' + baseUrl + '/admin/candidate/detail/' + data[0] + '/1" info-modal="candidate" class="text-success">' + data[3] + '</a>'
					);

					$('td', row).eq(9).addClass('text-right text-nowrap action-column').html('').append(
               // '<a href="' + baseUrl + '/admin/candidate/detail/' + data[0] + '" class="text-success"  title="View details"><i class="fa fa-phone text-success"></i> View Details'
                '<a href="'+baseUrl+'/admin/candidate/detail/'+data[0]+'"  title="View"><i class="fa fa-eye text-info"></i>' +
                '</a>'
            );

            if(data[0]>0){
                $('td', row).eq(0).html('').append(
                    '<input type="checkbox" name="row_id" id="checkbox_'+data[0]+'" value="'+data[0]+'">'
                );
            }
        }

		});


	/*template listing*/
	$('#template_list').DataTable({
		processing: true,
		serverSide: true,
		pageLength: 10,
		responsive: true,
		lengthChange: false,
		dom: '<"html5buttons"B>lTfgitp',
		buttons: [
			{ extend: 'copy' },
			{ extend: 'csv' },
			{ extend: 'excel', title: 'SectionFile' },
			{ extend: 'pdf', title: 'SectionFile' },

			{
				extend: 'print',
				customize: function (win) {
					$(win.document.body).addClass('white-bg');
					$(win.document.body).css('font-size', '10px');

					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				}
			},
			{
				className: 'btn-create',
				text: '<i class="fa fa-plus mr-1"></i> Create',
				action: function (e, dt, node, config) {
					window.location.href = $('.ibox-title h5').attr('data-url');
				}
			}
		],
		ajax: {
			url: baseUrl + '/admin/template_filter',
			type: 'POST',
			data: function (data) {
				// Append to data
				//data.search_by_name = $('#search_by_name').val();


			}
		},
		createdRow: function (row, data, index) {
			$('td', row).eq(5).addClass('text-right text-nowrap action-column').html('').append(
				'<a href="' + baseUrl + '/admin/template/detail/' + data[0] + '"  title="View"><i class="fa fa-eye text-info"></i>' +
				'<a href="' + baseUrl + '/admin/template/update/' + data[0] + '"  title="Edit"><i class="fas fa-pen-square text-success"></i>' +
				'<a href="' + baseUrl + '/admin/modal/delete" id="' + data[0] + '"  title="Delete" confirmation-modal="delete" data-view="table" data-url="' + baseUrl + '/admin/template/delete/' + data[0] + '"><i class="fa fa-trash text-danger"></i></a>'
			);
		}

	});


	/*meeting listing*/
	$('#meeting_list').DataTable({
		processing: true,
		serverSide: true,
		pageLength: 10,
		responsive: true,
		lengthChange: false,
		dom: '<"html5buttons"B>lTfgitp',
		buttons: [
			{ extend: 'copy' },
			{ extend: 'csv' },
			{ extend: 'excel', title: 'SectionFile' },
			{ extend: 'pdf', title: 'SectionFile' },

			{
				extend: 'print',
				customize: function (win) {
					$(win.document.body).addClass('white-bg');
					$(win.document.body).css('font-size', '10px');

					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				}
			},
			{
				className: 'btn-create',
				text: '<i class="fa fa-plus mr-1"></i> Create',
				action: function (e, dt, node, config) {
					window.location.href = $('.ibox-title h5').attr('data-url');
				}
			}
		],
		ajax: {
			url: baseUrl + '/admin/meeting_filter',
			type: 'POST',
			data: function (data) {
				// Append to data
				//data.search_by_name = $('#search_by_name').val();


			}
		},
		createdRow: function (row, data, index) {
			$('td', row).eq(7).addClass('text-right text-nowrap action-column').html('').append(
				'<a href="' + baseUrl + '/admin/meeting/detail/' + data[0] + '"  title="View"><i class="fa fa-eye text-info"></i>' +
				'<a href="' + baseUrl + '/admin/meeting/update/' + data[0] + '"  title="Edit"><i class="fas fa-pen-square text-success"></i>' +
				'<a href="' + baseUrl + '/admin/modal/delete" id="' + data[0] + '"  title="Delete" confirmation-modal="delete" data-view="table" data-url="' + baseUrl + '/admin/meeting/delete/' + data[0] + '"><i class="fa fa-trash text-danger"></i></a>'
			);
		}

	});

	/*minutes of meeting listing*/
	$('#mom_list').DataTable({
		processing: true,
		serverSide: true,
		pageLength: 10,
		responsive: true,
		lengthChange: false,
		searching: false,
		dom: 'lTfgtp',
		buttons: [
			{ extend: 'copy' },
			{ extend: 'csv' },
			{ extend: 'excel', title: 'SectionFile' },
			{ extend: 'pdf', title: 'SectionFile' },

			{
				extend: 'print',
				customize: function (win) {
					$(win.document.body).addClass('white-bg');
					$(win.document.body).css('font-size', '10px');

					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				}
			},
			{
				className: 'btn-create',
				text: '<i class="fa fa-plus mr-1"></i> Create',
				action: function (e, dt, node, config) {
					window.location.href = $('.ibox-title h5').attr('data-url');
				}
			}
		],
		ajax: {
			url: baseUrl + '/admin/mom_filter',
			type: 'POST',
			data: function (data) {
				// Append to data
                data.topics = $('#hdn_topiccs').val();



			}
		},
		createdRow: function (row, data, index) {
			$('td', row).eq(1).addClass('ellipsis').html('').append(
				'<a href="' + baseUrl + '/admin/minutes-of-meeting/detail/' + data[4] + '" class="text-success">' +
					data[1] +
				'</a>'
			);

			$('td', row).eq(2).addClass('text-nowrap');
			$('td', row).eq(3).addClass('text-nowrap');
			$('td', row).eq(4).addClass('text-right text-nowrap action-column').html('').append(
				'<a href="' + baseUrl + '/admin/minutes-of-meeting/detail/' + data[4] + '"  title="View"><i class="far fa-file-alt text-info"></i></a>'
			);
		}

	});

	/*plan listing*/
	$('#plan_list').DataTable({
		processing: true,
		serverSide: true,
		pageLength: 10,
		responsive: true,
		lengthChange: false,
		dom: '<"html5buttons"B>lTfgitp',
		buttons: [
			{ extend: 'copy' },
			{ extend: 'csv' },
			{ extend: 'excel', title: 'PlanFile' },
			{ extend: 'pdf', title: 'PlanFile' },

			{
				extend: 'print',
				customize: function (win) {
					$(win.document.body).addClass('white-bg');
					$(win.document.body).css('font-size', '10px');

					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				}
			},
			{
				className: 'btn-create',
				text: '<i class="fa fa-plus mr-1"></i> Create',
				action: function (e, dt, node, config) {
					window.location.href = $('.ibox-title h5').attr('data-url');
				}
			}
		],
		ajax: {
			url: baseUrl + '/admin/plans_filter',
			type: 'POST',
			data: function (data) {
				// Append to data
                data.pending = $('#pending').val();
                data.ur = $('#ur').val();


			}
		},
		createdRow: function (row, data, index) {
			$('td', row).eq(1).addClass('text-left').html('').append(
				'<a href="' + baseUrl + '/admin/hr-plan/detail/' + data[0] + '"  title="View" class="text-success">'+data[1]+'</a>'
			);

			$('td', row).eq(6).addClass('text-left').html('').append(
				'<span class="badge ' + (data[6] == 1 ? 'badge-primary' : '') + '">' + (data[6] == 1 ? 'Open' : 'Closed') + '</span>'
			);

			$('td', row).eq(7).addClass('text-right text-nowrap action-column').html('').append(
				'<a href="' + baseUrl + '/admin/hr-plan/detail/' + data[0] + '"  title="View"><i class="fa fa-eye text-info"></i></a>' +
				'<a href="' + baseUrl + '/admin/plans/export_plans_pdf/' + data[0] + '" target="_blank" title="PDF" class="ml-2"><i class="fas fa-file-pdf text-danger"></i></a>' +
				'<a href="' + baseUrl + '/admin/plans/export_plans/' + data[0] + '" target="_blank" title="EXCEL" class="ml-2"><i class="fas fa-file-excel text-navy"></i></a>'
				// '<a href="' + baseUrl + '/admin/hr-plan/update/' + data[0] + '"  title="Edit"><i class="fas fa-pen-square text-success"></i>' +
				// '<a href="' + baseUrl + '/admin/modal/delete" id="' + data[0] + '"  title="Delete" confirmation-modal="delete" data-view="table" data-url="' + baseUrl + '/admin/hr-plan/delete/' + data[0] + '"><i class="fa fa-trash text-danger"></i></a>'
			);
		}

	});

	/*employee listing*/
	$('#employee_list').DataTable({
		processing: true,
		serverSide: true,
		pageLength: 10,
		responsive: true,
		lengthChange: false,
		dom: '<"html5buttons"B>lTfgitp',
		buttons: [
			{ extend: 'copy' },
			{ extend: 'csv' },
			{ extend: 'excel', title: 'EmployeeFile' },
			{ extend: 'pdf', title: 'EmployeeFile' },

			{
				// className: 'btn-create',
				text: 'LDIF',
				action: function (e, dt, node, config) {

				}
			},
			{
				extend: 'print',
				customize: function (win) {
					$(win.document.body).addClass('white-bg');
					$(win.document.body).css('font-size', '10px');

					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				}
			},
			{
				className: 'btn-create',
				text: '<i class="fa fa-plus mr-1"></i> Create',
				action: function (e, dt, node, config) {
					window.location.href = $('.ibox-title h5').attr('data-url');
				}
			}
		],
		ajax: {
			url: baseUrl + '/admin/employees_filter',
			type: 'POST',
			data: function (data) {
				// Append to data
				//data.search_by_name = $('#search_by_name').val();


			}
		},
		createdRow: function (row, data, index) {
			$('td', row).eq(13).addClass('text-right text-nowrap action-column').html('').append(
				'<a href="' + baseUrl + '/admin/employee/detail/' + data[0] + '"  title="View"><i class="fa fa-eye text-info"></i>'
				// '<a href="' + baseUrl + '/admin/employee/update/' + data[0] + '"  title="Edit"><i class="fas fa-pen-square text-success"></i>' +
				// '<a href="' + baseUrl + '/admin/modal/delete" id="' + data[0] + '"  title="Delete" confirmation-modal="delete" data-view="table" data-url="' + baseUrl + '/admin/employee/delete/' + data[0] + '"><i class="fa fa-trash text-danger"></i></a>'
			);
		}

	});

	/*recruitment plan listing*/
	$('#recruitment_plan_list').DataTable({
		processing: true,
		serverSide: true,
		pageLength: 10,
		responsive: true,
		lengthChange: false,
		dom: 'flTgit',
		language: {
			'info': 'Showing _MAX_ plans.',
		},
		buttons: [
			{ extend: 'copy' },
			{ extend: 'csv' },
			{ extend: 'excel', title: 'PlanFile' },
			{ extend: 'pdf', title: 'PlanFile' },

			{
				extend: 'print',
				customize: function (win) {
					$(win.document.body).addClass('white-bg');
					$(win.document.body).css('font-size', '10px');

					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				}
			},
		],
		'drawCallback': function (settings) {
			$('span.pie').peity('pie', {
				fill: ['#1ab394', '#d7d7d7', '#ffffff']
			}),
                $('span.pie1').peity('pie', {
                    fill: ['#FF0000', '#FF0000', '#FF0000']
			})
		},
		ajax: {
			url: baseUrl + '/admin/recruitment_plans_filter',
			type: 'POST',
			data: function (data) {
				// Append to data
				//data.search_by_name = $('#search_by_name').val();


			}
		},
		createdRow: function (row, data, index) {
			var start = new Date(data[8]['start']),
					end = new Date(data[8]['end']),
					today = new Date(),
					diffTime = Math.abs(end.getTime() - start.getTime()),
					diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)),
					diffTimeToday = Math.abs(end.getTime() - today.getTime()),
					diffDaysToday = Math.ceil(diffTimeToday / (1000 * 60 * 60 * 24));

			//console.log('row='+data[5]+' days='+diffDaysToday+' ftn='+Date.daysBetween(end,today));

			let d_dif = Date.daysBetween(end,today);

			$('td', row).eq(0).html('').append(
				'<span class="label label-' + (data[7] == 1 ? 'primary' : 'danger') + '">' + (data[7] == 1 ? 'Active' : 'Closed') + '</span>'
			);

			$('td', row).eq(1).addClass('issue-info').html('').append(
				'<a href="' + baseUrl + '/admin/hr-plan/detail/' + data[6] + '">' + data[1]['subject'] +'</a>' +
				'<small>' + data[1]['details'] + '</small>'
			);

			$('td', row).eq(4).addClass('text-nowrap')
			$('td', row).eq(3).addClass('text-navy')

            if(d_dif<0)
            {
                $('td', row).eq(5).addClass('text-nowrap').html('').append(
				'<span class="pie">' + diffDaysToday + '/' + diffDays + '</span> ' + diffDaysToday + 'd'
			);
            }else{
                $('td', row).eq(5).addClass('text-nowrap').html('').append(
                    '<span class="pie1">' + diffDaysToday + '/' + diffDays + '</span> ' + diffDaysToday + 'd'
                );
            }

		}

	});
    Date.daysBetween = function( date1, date2 ) {
        //Get 1 day in milliseconds
        var one_day=1000*60*60*24;

        // Convert both dates to milliseconds
        var date1_ms = date1.getTime();
        var date2_ms = date2.getTime();

        // Calculate the difference in milliseconds
        var difference_ms = date2_ms - date1_ms;

        // Convert back to days and return
        return Math.round(difference_ms/one_day);
    }

	/*travel listing*/
	$('#travel_list').DataTable({
		processing: true,
		serverSide: true,
		pageLength: 10,
		responsive: true,
		lengthChange: false,
		dom: '<"html5buttons"B>lTfgitp',
		buttons: [
			{ extend: 'copy' },
			{ extend: 'csv' },
			{ extend: 'excel', title: 'travelFile' },
			{ extend: 'pdf', title: 'travelFile' },

			{
				extend: 'print',
				customize: function (win) {
					$(win.document.body).addClass('white-bg');
					$(win.document.body).css('font-size', '10px');

					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				}
			},
			{
				className: 'btn-create',
				text: '<i class="fa fa-plus mr-1"></i> Create',
				action: function (e, dt, node, config) {
					window.location.href = $('.ibox-title h5').attr('data-url');
				}
			}
		],
		ajax: {
			url: baseUrl + '/admin/travel_filter',
			type: 'POST',
			data: function (data) {
				// Append to data
				//data.search_by_name = $('#search_by_name').val();


			}
		},
		createdRow: function (row, data, index) {

		}

	});

	/*interview listing*/
	var groupColumn = 1;
	$('#interview_list').DataTable({
		processing: true,
		serverSide: true,
		pageLength: 10,
		responsive: true,
		lengthChange: false,
		dom: '<"html5buttons"B>lTfgitp',
		// columnDefs: [
		// 	{ "visible": true, "targets": groupColumn }
		// ],
		buttons: [
			{ extend: 'copy' },
			{ extend: 'csv' },
			{ extend: 'excel', title: 'interviewFile' },
			{ extend: 'pdf', title: 'interviewFile' },

			{
				extend: 'print',
				customize: function (win) {
					$(win.document.body).addClass('white-bg');
					$(win.document.body).css('font-size', '10px');

					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				}
			},
			/*{
				className: 'btn-create',
				text: '<i class="fa fa-plus mr-1"></i> Create',
				action: function (e, dt, node, config) {
					window.location.href = $('.ibox-title h5').attr('data-url');
				}
			}*/
		],
		ajax: {
			url: baseUrl + '/admin/interview_filter',
			type: 'POST',
			data: function (data) {
				// Append to data
				//data.search_by_name = $('#search_by_name').val();


			}
		},
		order: [[1, 'asc']],
		rowGroup: {
			dataSrc: 1
		},
		createdRow: function (row, data, index) {
			if (data[0] > 0) {
				$('td', row).eq(0).html('').append(
					'<input type="checkbox" name="row_id" id="checkbox_' + data[0] + '" value="' + data[0] + '">'
				);
			}

			$('td', row).eq(2).html('').append(
				'<a href="' + baseUrl + '/admin/candidate/detail/' + data[9] + '/1" info-modal="candidate" class="text-success">' + data[2] + '</a>'
			);

			var status_class = ['success', 'navy', 'warning', 'danger'],
					status = ['Scheduled', 'Confirmed', 'Requested to reschedule', 'Declined'];;

			$('td', row).eq(6).addClass('text-' + status_class[data[6]]).html('').append(
                '<i class="mr-1 far fa-calendar-'+ (data[6] == 1 ? 'check' : 'alt') +'"></i>  '+
			    status[data[6]]);
            $('td', row).eq(7).html('').append(
                '<i class="mr-1 fas fa-' + (data[7] == 1 ? 'check' : '') + ' text-' + (data[7] == 1 ? 'navy' : 'muted') + '"></i>'
            );
			$('td', row).eq(8).addClass('text-right text-nowrap action-column').html('').append(
				'<a href="' + baseUrl + '/admin/interview/detail/' + data[0] + '"  title="View"><i class="fa fa-eye text-info"></i></a>' +
				'<a href="' + baseUrl + '/admin/interview/pdf/' + data[0] + '"  title="PDF"><i class="fas fa-file-pdf text-danger"></i></a>'
				// '<a href="' + baseUrl + '/admin/employee/update/' + data[0] + '"  title="Edit"><i class="fas fa-pen-square text-success"></i>' +
				// '<a href="' + baseUrl + '/admin/modal/delete" id="' + data[0] + '"  title="Delete" confirmation-modal="delete" data-view="table" data-url="' + baseUrl + '/admin/employee/delete/' + data[0] + '"><i class="fa fa-trash text-danger"></i></a>'
			);
		}

	});

	$('#question_list').DataTable({
		processing: true,
		serverSide: true,
		pageLength: 10,
		responsive: true,
		lengthChange: false,
		dom: '<"html5buttons"B>lTfgitp',
		buttons: [
			{ extend: 'copy' },
			{ extend: 'csv' },
			{ extend: 'excel', title: 'QuestionFile' },
			{ extend: 'pdf', title: 'QuestionFile' },

			{
				extend: 'print',
				customize: function (win) {
					$(win.document.body).addClass('white-bg');
					$(win.document.body).css('font-size', '10px');

					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				}
			},
			{
				className: 'btn-create',
				text: '<i class="fa fa-plus mr-1"></i> Create',
				action: function (e, dt, node, config) {
					window.location.href = $('.ibox-title h5').attr('data-url');
				}
			}
		],
		ajax: {
			url: baseUrl + '/admin/questions_filter',
			type: 'POST',
			data: function (data) {
				// Append to data
				//data.search_by_name = $('#search_by_name').val();


			}
		},
		createdRow: function (row, data, index) {
			$('td', row).eq(2).addClass('text-left').html('').append(
				'<a href="' + baseUrl + '/admin/question/detail/' + data[1] + '"  title="View" class="text-success">' + data[2] + '</a>'
			);
			$('td', row).eq(6).addClass('text-right text-nowrap action-column').html('').append(
				'<a href="' + baseUrl + '/admin/question/detail/' + data[1] + '"  title="View"><i class="fa fa-eye text-info"></i></a>' +
				'<a href="' + baseUrl + '/admin/question/update/' + data[1] + '"  title="Edit" class="ml-1"><i class="fas fa-pen-square text-success"></i></a>'
				// '<a href="' + baseUrl + '/admin/modal/delete" id="' + data[0] + '"  title="Delete" confirmation-modal="delete" data-view="table" data-url="' + baseUrl + '/admin/hr-plan/delete/' + data[0] + '"><i class="fa fa-trash text-danger"></i></a>'
			);
		}

	});

	$('#offer_list').DataTable({
		processing: true,
		serverSide: true,
		pageLength: 10,
		responsive: true,
		lengthChange: false,
		dom: '<"html5buttons"B>lTfgitp',
        "columnDefs": [
            { "bSortable": false, "targets": 0 }
        ],
		buttons: [
			{ extend: 'copy' },
			{ extend: 'csv' },
			{ extend: 'excel', title: 'OfferFile' },
			{ extend: 'pdf', title: 'OfferFile' },

			{
				extend: 'print',
				customize: function (win) {
					$(win.document.body).addClass('white-bg');
					$(win.document.body).css('font-size', '10px');

					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				}
			}
		],
		ajax: {
			url: baseUrl + '/admin/offer_list_filter',
			type: 'POST',
			data: function (data) {
				// Append to data
				data.pending = $('#pending').val();
                data.ur = $('#ur').val();
                data.gm_app = $('#gm_app').val();


			}
		},
		createdRow: function (row, data, index) {
			if (data[0] > 0) {
				$('td', row).eq(0).html('').append(
					'<input type="checkbox" name="row_id" id="checkbox_' + data[0] + '" value="' + data[0] + '">'
				);
			}

			let fa = ['times', 'check'],
					color = ['muted', 'navy'],
					status = ['Pending', 'Accepted','Declined'];

			$('td', row).eq(3).html('').append(
				'<span>' + status[data[3]] + '</span>'
			);

			$('td', row).eq(4).html('').append(
				'<a href="' + baseUrl + '/admin/candidate/detail/' + data[4].id + '/1" info-modal="candidate" class="text-success">' + data[4].name + ' ' + (data[4].last_name ? data[4].last_name : '') + '</a>'
			);

			$('td', row).eq(2).html('').append(
				'<i class="fas fa-' + (data[2] == 1 ? 'check' : 'times') + ' text-' + (data[2] == 1 ? 'navy' : 'muted') + '"></i>'
			);

			$('td', row).eq(9).addClass('text-right text-nowrap action-column').html('').append(
				'<a href="' + baseUrl + '/admin/offer/detail/' + data[0] + '"  title="View"><i class="fa fa-eye text-info"></i>'+
				'<a href="' + baseUrl + '/admin/pdf-template/generate/?ids=' + data[0] + '"  title="Download PDF"><i class="fas fa-file-pdf"></i></a>'
			);
		}

	});


	$('#offer_list_pending').DataTable({
		processing: true,
		serverSide: true,
		pageLength: 10,
		responsive: true,
		lengthChange: false,
		dom: '<"html5buttons"B>lTfgitp',
		"columnDefs": [
			{ "bSortable": false, "targets": 0 }
		],
		buttons: [
			{ extend: 'copy' },
			{ extend: 'csv' },
			{ extend: 'excel', title: 'OfferFile' },
			{ extend: 'pdf', title: 'OfferFile' },

			{
				extend: 'print',
				customize: function (win) {
					$(win.document.body).addClass('white-bg');
					$(win.document.body).css('font-size', '10px');

					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				}
			}
		],
		ajax: {
			url: baseUrl + '/admin/offer_list_filter_pending',
			type: 'POST',
			data: function (data) {
				// Append to data
				data.pending = $('#pending').val();
				data.ur = $('#ur').val();


			}
		},
		createdRow: function (row, data, index) {
            $(row).attr('id', 'row_' + data[0]);
			if (data[0] > 0) {
				$('td', row).eq(0).html('').append(
                    '<input type="checkbox" dm="' + data[10] + '" hrm="' + data[11] + '" gm="' + data[12] + '" name="row_id" id="checkbox_' + data[0] + '" value="' + data[0] + '">'
				);
			}

			let fa = ['times', 'check'],
				color = ['muted', 'navy'],
				status = ['Pending', 'Accepted'];

			$('td', row).eq(3).html('').append(
				'<span>' + status[data[2]] + '</span>'
			);

			$('td', row).eq(4).html('').append(
				'<a href="' + baseUrl + '/admin/candidate/detail/' + data[4].id + '/1" info-modal="candidate" class="text-success">' + data[4].name + ' ' + (data[4].last_name ? data[4].last_name : '') + '</a>'
			);

			$('td', row).eq(2).html('').append(
				'<i class="fas fa-' + (data[2] == 1 ? 'check' : 'times') + ' text-' + (data[2] == 1 ? 'navy' : 'muted') + '"></i>'
			);

			$('td', row).eq(9).addClass('text-right text-nowrap action-column').html('').append(
				'<a href="' + baseUrl + '/admin/offer/detail/' + data[0] + '"  title="View"><i class="fa fa-eye text-info"></i>' +
				'<a href="' + baseUrl + '/admin/pdf-template/generate/?ids=' + data[0] + '"  title="Download PDF"><i class="fas fa-file-pdf"></i></a>'
			);
		}

	});

	/*recruitment plan listing*/
	$('#companies_list').DataTable({
		processing: true,
		serverSide: true,
		pageLength: 10,
		responsive: true,
		lengthChange: false,
		dom: '<"html5buttons"B>lTfgitp',
		// language: {
		// 	'info': 'Showing _MAX_ plans.',
		// },
		buttons: [
			{ extend: 'copy' },
			{ extend: 'csv' },
			{ extend: 'excel', title: 'PlanFile' },
			{ extend: 'pdf', title: 'PlanFile' },

			{
				extend: 'print',
				customize: function (win) {
					$(win.document.body).addClass('white-bg');
					$(win.document.body).css('font-size', '10px');

					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				}
			},
			// {
			// 	className: 'btn-create',
			// 	text: '<i class="fa fa-plus mr-1"></i> Create',
			// 	action: function (e, dt, node, config) {
			// 		window.location.href = $('.ibox-title h5').attr('data-url');
			// 	}
			// }
		],
		'drawCallback': function (settings) {
			$('span.pie').peity('pie', {
				fill: ['#1ab394', '#d7d7d7', '#ffffff']
			}),
				$('span.pie1').peity('pie', {
					fill: ['#FF0000', '#FF0000', '#FF0000']
				})
		},
		ajax: {
			url: baseUrl + '/admin/companies_list',
			type: 'POST',
			data: function (data) {
				// Append to data
				//data.search_by_name = $('#search_by_name').val();


			}
		},
		createdRow: function (row, data, index) {
			$('td', row).eq(1).html('').append(
				'<a href="' + baseUrl + '/admin/enterprise/detail/' + data[0] + '" class="text-success">' + data[1] + '</a>'
			);

			// $('td', row).eq(3).html('').append(
			// 	'<a href="' + data[3] + '" class="text-success" target="_blank">' + data[3] + '</a>'
			// );

			var website = data[8];

			$('td', row).eq(7).addClass('text-right text-nowrap action-column').html('').append(
				'<a href="' + baseUrl + '/admin/enterprise/detail/' + data[0] + '"  title="View"><i class="fa fa-eye text-info"></i></a>' +
				'<a href="' + baseUrl + '/admin/enterprise/update/' + data[0] + '"  title="Update" class="ml-1"><i class="fas fa-pen-square text-success"></i></a>' +
				'<a href="' + (website && (website.includes('http://') || website.includes('https://')) ? '' : 'http://') + website + '"  title="Visit website" target="_blank" class="ml-1"><i class="fa fa-globe text-muted"></i></a>'
			);
		}

	});

	// budget list
	$('#budget_list').DataTable({
		processing: true,
		serverSide: true,
		pageLength: 10,
		responsive: true,
		lengthChange: false,
		dom: '<"html5buttons"B>lTfgitp',
		buttons: [
			{ extend: 'copy' },
			{ extend: 'csv' },
			{ extend: 'excel', title: 'PlanFile' },
			{ extend: 'pdf', title: 'PlanFile' },

			{
				extend: 'print',
				customize: function (win) {
					$(win.document.body).addClass('white-bg');
					$(win.document.body).css('font-size', '10px');

					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				}
			},
			{
				className: 'btn-create',
				text: '<i class="fa fa-plus mr-1"></i> Create',
				action: function (e, dt, node, config) {
					window.location.href = baseUrl + '/admin/budget/create';
				}
			}
		],
		ajax: {
			url: baseUrl + '/admin/budget_filter',
			type: 'POST',
			data: function (data) {
				// Append to data
				data.pending = $('#pending').val();
				data.ur = $('#ur').val();


			}
		},
		createdRow: function (row, data, index) {
			// $('td', row).eq(1).addClass('text-left').html('').append(
			// 	'<a href="' + baseUrl + '/admin/hr-plan/detail/' + data[0] + '"  title="View" class="text-success">' + data[1] + '</a>'
			// );

			// $('td', row).eq(6).addClass('text-left').html('').append(
			// 	'<span class="badge ' + (data[6] == 1 ? 'badge-primary' : '') + '">' + (data[6] == 1 ? 'Open' : 'Closed') + '</span>'
			// );

			// $('td', row).eq(7).addClass('text-right text-nowrap').html('').append(
			// 	'<a href="' + baseUrl + '/admin/hr-plan/detail/' + data[0] + '"  title="View"><i class="fa fa-eye text-info"></i>'
			// 	// '<a href="' + baseUrl + '/admin/hr-plan/update/' + data[0] + '"  title="Edit"><i class="fas fa-pen-square text-success"></i>' +
			// 	// '<a href="' + baseUrl + '/admin/modal/delete" id="' + data[0] + '"  title="Delete" confirmation-modal="delete" data-view="table" data-url="' + baseUrl + '/admin/hr-plan/delete/' + data[0] + '"><i class="fa fa-trash text-danger"></i></a>'
			// );
		}

	});

	// pdf templates
	$('#pdf_list').DataTable({
		processing: true,
		serverSide: true,
		pageLength: 10,
		responsive: true,
		lengthChange: false,
		dom: '<"html5buttons"B>lTfgitp',
		buttons: [
			{ extend: 'copy' },
			{ extend: 'csv' },
			{ extend: 'excel', title: 'PDFTemplateFile' },
			{ extend: 'pdf', title: 'PDFTemplateFile' },

			{
				extend: 'print',
				customize: function (win) {
					$(win.document.body).addClass('white-bg');
					$(win.document.body).css('font-size', '10px');

					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				}
			},
			{
				className: 'btn-create',
				text: '<i class="fa fa-plus mr-1"></i> Create',
				action: function (e, dt, node, config) {
					window.location.href = $('.ibox-title h5').attr('data-url');
				}
			}
		],
		ajax: {
			url: baseUrl + '/admin/pdf_filter',
			type: 'POST',
			data: function (data) {
				// Append to data
				//data.search_by_name = $('#search_by_name').val();


			}
		},
		createdRow: function (row, data, index) {
			$('td', row).eq(4).addClass('text-right text-nowrap action-column').html('').append(
				// '<a href="' + baseUrl + '/admin/pdf-template/detail/' + data[0] + '"  title="View"><i class="fa fa-eye text-info"></i>' +
				'<a href="' + baseUrl + '/admin/pdf-template/update/' + data[0] + '"  title="Edit" class="ml-1"><i class="fas fa-pen-square text-success"></i>' +
				'<a href="' + baseUrl + '/admin/modal/delete" id="' + data[0] + '"  title="Delete" class="ml-1" confirmation-modal="delete" data-view="table" data-url="' + baseUrl + '/admin/pdf-template/delete/' + data[0] + '"><i class="fa fa-trash text-danger"></i></a>'
			);
		}

	});

	// rotation types
	$('#rotation_list').DataTable({
		processing: true,
		serverSide: true,
		pageLength: 10,
		responsive: true,
		lengthChange: false,
		dom: '<"html5buttons"B>lTfgitp',
		buttons: [
			{ extend: 'copy' },
			{ extend: 'csv' },
			{ extend: 'excel', title: 'PDFTemplateFile' },
			{ extend: 'pdf', title: 'PDFTemplateFile' },

			{
				extend: 'print',
				customize: function (win) {
					$(win.document.body).addClass('white-bg');
					$(win.document.body).css('font-size', '10px');

					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				}
			},
			{
				className: 'btn-create',
				text: '<i class="fa fa-plus mr-1"></i> Create',
				action: function (e, dt, node, config) {
					window.location.href = baseUrl + '/admin/rotation-type/create';
				}
			}
		],
		ajax: {
			url: baseUrl + '/admin/rotations_filter',
			type: 'POST',
			data: function (data) {
				// Append to data
				//data.search_by_name = $('#search_by_name').val();


			}
		},
		createdRow: function (row, data, index) {
			$('td', row).eq(1).html('').append(
				'<a href="' + baseUrl + '/admin/rotation-type/update/' + data[0] + '" class="text-success">' + data[1] + '</a>'
			);

			$('td', row).eq(5).addClass('text-right text-nowrap action-column').html('').append(
				'<a href="' + baseUrl + '/admin/rotation-type/update/' + data[0] + '"  title="Edit" class="ml-1"><i class="fas fa-pen-square text-success"></i></a>' +
				'<a href="' + baseUrl + '/admin/modal/delete" id="' + data[0] + '"  title="Delete" class="ml-1" confirmation-modal="delete" data-view="table" data-url="' + baseUrl + '/admin/rotation-type/delete/' + data[0] + '"><i class="fa fa-trash text-danger"></i></a>'
			);
		}

	});

	// address book employees list
	$('#address_book_employees_list').DataTable({
		processing: true,
		serverSide: true,
		pageLength: 10,
		responsive: true,
		lengthChange: false,
		dom: 'lTgtp',
		buttons: [
			{ extend: 'copy' },
			{ extend: 'csv' },
			{ extend: 'excel', title: 'CandidatesFile' },
			{ extend: 'pdf', title: 'CandidatesFile' },

			{
				extend: 'print',
				customize: function (win) {
					$(win.document.body).addClass('white-bg');
					$(win.document.body).css('font-size', '10px');

					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				}
			},
		],
		ajax: {
			url: baseUrl + '/admin/address_book_filter',
			type: 'POST',
			data: function (data) {
				// Append to data
				//data.search_by_name = $('#search_by_name').val();


			}
		},
		createdRow: function (row, data, index) {
			$('td', row).eq(2).html('').append(
				'<a href="' + baseUrl + '/admin/user/address-book/detail/' + data[8] + '/1" info-modal="address-book" modal-size="modal-lg" title="Address Book" class="text-success">' + data[2] + '</a>'
			);

			$('td', row).eq(8).addClass('text-center text-nowrap action-column').html('').append(
				'<a href="' + baseUrl + '/admin/user/address-book/detail/' + data[8] + '/1" info-modal="address-book" modal-size="modal-lg" title="Address Book"><i class="far fa-address-card text-navy"></i></a>'
			);
		}

	});

	// passport list
	$('#passport_list').DataTable({
		processing: true,
		serverSide: true,
		pageLength: 10,
		responsive: true,
		lengthChange: false,
		dom: 'lTgtp',
		buttons: [
			{ extend: 'copy' },
			{ extend: 'csv' },
			{ extend: 'excel', title: 'CandidatesFile' },
			{ extend: 'pdf', title: 'CandidatesFile' },

			{
				extend: 'print',
				customize: function (win) {
					$(win.document.body).addClass('white-bg');
					$(win.document.body).css('font-size', '10px');

					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				}
			},
		],
		ajax: {
			url: baseUrl + '/admin/passport_filter',
			type: 'POST',
			data: function (data) {
				// Append to data
				//data.search_by_name = $('#search_by_name').val();


			}
		},
		createdRow: function (row, data, index) {
			$('td', row).eq(0).html('').append(
				'<a href="' + baseUrl + '/admin/passport-management/update/' + data[5] + '" class="text-success" title="Edit">' + data[0] + '</a>'
			);

			$('td', row).eq(1).html('').append(
				// '<a href="' + baseUrl + '/admin/candidate/detail/' + data[1].id + '/1" info-modal="candidate" class="text-success">' + data[1].name + ' ' + (data[1].last_name ? data[1].last_name : '') + '</a>'
				data[1].name + ' ' + (data[1].last_name ? data[1].last_name : '')
			);

			$('td', row).eq(2).addClass('text-center').html('').append(
				'<i class="fas fa-' + (data[2] == 1 ? 'check' : 'times') + ' text-' + (data[2] == 1 ? 'navy' : 'muted') + '"></i>'
			);

			$('td', row).eq(5).addClass('text-center text-nowrap action-column').html('').append(
				'<a href="' + baseUrl + '/admin/passport-management/update/' + data[5] + '"  title="Edit"><i class="fas fa-pen-square text-success"></i></a>' +
				'<a href="' + baseUrl + '/admin/modal/delete" id="' + data[5] + '" title="Delete" confirmation-modal="delete" data-view="table" data-url="' + baseUrl + '/admin/passport-management/delete/' + data[5] + '"><i class="fa fa-trash text-danger"></i></a>'
			);
		}

	});

	$('#topics_list').DataTable({
		processing: true,
		serverSide: true,
		pageLength: 10,
		responsive: true,
		lengthChange: false,
		dom: '<"html5buttons"B>lTfgitp',
		buttons: [
			{ extend: 'copy' },
			{ extend: 'csv' },
			{ extend: 'excel', title: 'TopicsFile' },
			{ extend: 'pdf', title: 'TopicsFile' },

			{
				extend: 'print',
				customize: function (win) {
					$(win.document.body).addClass('white-bg');
					$(win.document.body).css('font-size', '10px');

					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				}
			},
			{
				className: 'btn-create',
				text: '<i class="fa fa-plus mr-1"></i> Create',
				action: function (e, dt, node, config) {
					window.location.href = baseUrl + '/admin/topic/create';
				}
			}
		],
		ajax: {
			url: baseUrl + '/admin/topics_filter',
			type: 'POST',
			data: function (data) {

			}
		},
		createdRow: function (row, data, index) {
			let tasks = '';

			$.each(data[1], function (key, value) {
				tasks += '<a href="' + baseUrl + '/admin/task/detail/' + value.id + '" class="badge badge-secondary ellipsis mr-2 mb-2" style="max-width: 150px;" title="' + value.title + '">' + value.title + '</a>'
			});

			$('td', row).eq(0).addClass('ellipsis').html('').append(
				'<a href="' + baseUrl + '/admin/topic/detail/' + data[2] + '" class="text-success">' + data[0] + '</a>'
			);

			$('td', row).eq(1).addClass(tasks.length > 0 ? 'pb-0' : '').html('').append(
				tasks
			);

			$('td', row).eq(2).addClass('text-center text-nowrap action-column').html('').append(
				'<a href="' + baseUrl + '/admin/topic/detail/' + data[2] + '"  title="View"><i class="fas fa-eye text-info"></i></a>' +
				'<a href="' + baseUrl + '/admin/topic/update/' + data[2] + '"  title="Edit"><i class="fas fa-pen-square text-success"></i></a>' +
				'<a href="' + baseUrl + '/admin/modal/delete" id="' + data[2] + '" title="Delete" confirmation-modal="delete" data-view="table" data-url="' + baseUrl + '/admin/topic/delete/' + data[2] + '"><i class="fa fa-trash text-danger"></i></a>'
			);
		}

	});

	$('#tasks_list').DataTable({
		processing: true,
		serverSide: true,
		pageLength: 10,
		responsive: true,
		lengthChange: false,
		dom: '<"html5buttons"B>lTfgitp',
		buttons: [
			{ extend: 'copy' },
			{ extend: 'csv' },
			{ extend: 'excel', title: 'TasksFile' },
			{ extend: 'pdf', title: 'TasksFile' },

			{
				extend: 'print',
				customize: function (win) {
					$(win.document.body).addClass('white-bg');
					$(win.document.body).css('font-size', '10px');

					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				}
			},
			{
				className: 'btn-create',
				text: '<i class="fa fa-plus mr-1"></i> Create',
				action: function (e, dt, node, config) {
					window.location.href = baseUrl + '/admin/task/create';
				}
			}
		],
		ajax: {
			url: baseUrl + '/admin/tasks_filter',
			type: 'POST',
			data: function (data) {

			}
		},
		createdRow: function (row, data, index) {
			$('td', row).eq(0).addClass('ellipsis').html('').append(
				'<a href="' + baseUrl + '/admin/task/detail/' + data[3] + '" class="text-success">' + data[0] + '</a>'
			);

			// $('td', row).eq(1).addClass('ellipsis');

			$('td', row).eq(3).addClass('text-center text-nowrap action-column').html('').append(
				'<a href="' + baseUrl + '/admin/task/detail/' + data[3] + '"  title="View"><i class="fas fa-eye text-info"></i></a>' +
				'<a href="' + baseUrl + '/admin/task/update/' + data[3] + '"  title="Edit"><i class="fas fa-pen-square text-success"></i></a>' +
				'<a href="' + baseUrl + '/admin/modal/delete" id="' + data[3] + '" title="Delete" confirmation-modal="delete" data-view="table" data-url="' + baseUrl + '/admin/task/delete/' + data[3] + '"><i class="fa fa-trash text-danger"></i></a>'
			);
		}

	});

});