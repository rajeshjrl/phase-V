jQuery(document).ready(function(e) {        
    jQuery("#frm_forgot_password").validate({
        debug: true,
        errorClass: 'text-danger',
        rules: {
            user_email: {
                required: true,
                email: true,
                remote: {
                    url: javascript_site_path+"chk-email-exist",
                    method: 'post',
                    data: {
                        action: 'forgot_pass_email_chk'
                    }
                }
            }
        },
        messages: {
            user_email: {
                required: "Please enter email address.",
                email: "Please enter valid email address.",
                remote: "This email address is not registered with site."
            }
        },
        submitHandler: function(form) {
            jQuery("#btn_pass").hide();
            jQuery("#btn_loader").show();
            form.submit();
        }
    });
});