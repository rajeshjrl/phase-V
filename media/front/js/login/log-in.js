jQuery(document).ready(function(e) {
    
    // Call captcha function to load the security code
    refreshCaptha();    
    
    
    
    jQuery("#frm_user_login").validate({
        debug: true,
        errorClass: 'text-danger',
        rules: {
            user_name: {
                required: true
            },
            user_password: {
                required: true,
                minlength: 8
            },
            input_captcha_value: {
                required: true,
                remote: {
                    url: javascript_site_path+'check-captcha',
                    method: 'post'
                }
            }
        },
        messages: {
            user_name: {
                required: "Please enter email/username."
            },
            user_password: {
                required: "Please enter password.",
                minlength: "Please enter atleast 8 characters."
            },
            input_captcha_value: {
                required: "Please enter security code.",
                remote:"Please enter valid security code."
            }
        }, 
        submitHandler: function(form) {
            jQuery("#btn_login").hide();
            jQuery("#btn_loader").show();
            form.submit();
        }
    });
});
