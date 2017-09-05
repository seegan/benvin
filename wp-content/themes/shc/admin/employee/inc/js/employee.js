jQuery(document).ready(function () {

    jQuery("#create_employee").bind('submit', function (e) {
        jQuery('#lightbox').css('display','block');
        jQuery.ajax({
            type: "POST",
            dataType : "json",
            url: frontendajax.ajaxurl,
            data: {
                action : jQuery('.employee_action').val(),
                data : jQuery('#create_employee :input').serialize()
            },
            success: function (data) {
                clearPopup();
                jQuery('#lightbox').css('display','none');

                if(data.redirect != 0) { 
                    setTimeout(function() {
                        managePopupContent(data);
                    }, 1000);
                }

                if(data.success == 0) {
                    popItUp('Error', data.msg);
                } else {
                    popItUp('Success', data.msg);
                }
            }
        });
        e.preventDefault();
        return false;
    });



    jQuery('.mark_attendance').live('change', function(){
        var current_sel = this;
        jQuery.ajax({
            type: "POST",
            url: frontendajax.ajaxurl,
            data: {
                attendance : jQuery(this).find(':selected').val(),
                action : 'mark_attendance',
                emp_id : jQuery(this).attr('data-empid'),
                attendance_date : jQuery(this).attr('data-attdate'),
            },
            success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    var att = '-';
                    if(obj.attendance == 1) { att = 'Present'; }
                    if(obj.attendance == 0) { att = 'Absent'; }

                    if(obj.success == 1) {
                        console.log(jQuery(current_sel).parent().parent());
                        jQuery(current_sel).parent().parent().find('.attendance_val').text(att);
                    } else {
                        alert_popup('<span class="error_msg">Can\'t Edit this data try again!</span>', 'Error');  
                    }
            }
        });
    });


});