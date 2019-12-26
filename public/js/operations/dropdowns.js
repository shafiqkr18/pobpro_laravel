$(function() {
    $('#org_id').change(function() {
				let org = { 'org_id': $(this).val() ? $(this).val() : 1 };
        $.get(baseUrl +'/admin/org-divisions', org, function (data) {
            let divisions = $('#div_id');
            divisions.empty();
            divisions.append("<option value=''>Select Division</option>");
            $.each(data, function(key, value) {

                divisions.append("<option value='"+ value.id +"'>" + value.short_name + "</option>");
            });
        });
    });

    /*get departments based on division*/
    $('#div_id').change(function() {

        let division = { 'div_id': $(this).val() };
        $.get(baseUrl +'/admin/division-department', division, function (data) {
            let departments = $('#dept_id');
            departments.empty();
            departments.append("<option value=''>Select Department</option>");
            $.each(data, function(key, value) {
                departments.append("<option value='"+ value.id +"'>" + value.department_short_name + "</option>");
            });
        });
    });


    /*get section based on dept*/
    $('#dept_id,#department_id').change(function() {

        let dept = { 'dept_id': $(this).val() };
        $.get(baseUrl +'/admin/department-section', dept, function (data) {
            let sections = $('#sec_id');
            sections.empty();
            let sections_other = $('#section_id');
            sections_other.empty();
            sections.append("<option value=''>Select Section</option>");
            $.each(data, function(key, value) {
                sections.append("<option value='"+ value.id +"'>" + value.short_name + "</option>");
                sections_other.append("<option value='"+ value.id +"'>" + value.short_name + "</option>");
            });
        });
    });


});