jQuery(document).ready(function(e) {
    jQuery("#frm_reset_password").validate({
        debug: true,
        errorClass: 'text-danger',
        rules: {
            new_user_password: {
                required: true,
                minlength: 8
            },
            cnf_user_password: {
                required: true,
                minlength: 8,
                equalTo: "#new_user_password"
            }
        },
        messages: {
            new_user_password: {
                required: "Please enter new password.",
                minlength: jQuery.format("Please enter at least {0} characters.")
            },
            cnf_user_password: {
                required: "Please confirm password.",
                minlength: jQuery.format("Please enter at least {0} characters."),
                equalTo: "Both passwords are not matched."

            }
        }, 
        submitHandler: function(form) {
            jQuery("#btn_frgt_pwd").hide();
            jQuery("#btn_loader").show();
            form.submit();
        }
    });

});