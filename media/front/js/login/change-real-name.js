jQuery(document).ready(function(e) {
    jQuery("#frm_real_name").validate({
        debug: true,
        errorClass: 'text-danger',
        rules: {
            user_name: {
                required: true,
                minlength: 5,
                remote: {
                    url: javascript_site_path+'chk-realname-duplicate',
                    data:{
                        'old_user_name':jQuery('#old_user_name').val()
                    },
                    method: 'post'                                
                }
            }
        },
        messages: {
            user_name: {
                required: "Please enter real name you wish to change.",
                minlength: jQuery.format("Please enter at least {0} charcters."),
                remote: "This username already registered with site."
            }
        }, 
        submitHandler: function(form) {
            jQuery("#frm_real_name").hide();
            jQuery("#btn_loader").show();
            form.submit();
        }
    });
});


