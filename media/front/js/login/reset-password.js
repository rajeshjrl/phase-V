jQuery(document).ready(function(e) {
    jQuery("#frm_reset_password").validate({
        debug: true,
        errorClass: 'text-danger',
        rules: {
            new_user_password: {
                required: true,
                password_strenth: true,
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
                equalTo: "Please enter confirm password same as above."
            }
        }, 
        submitHandler: function(form) {
            jQuery("#btn_frgt_pwd").hide();
            jQuery("#btn_loader").show();
            form.submit();
        }
    });
    jQuery.validator.addMethod("password_strenth", function(value, element) {
        return isPasswordStrong(value,element);
    }, "Password must be combination of atleast 1 number, 1 special character and 1 upper case letter with minimum 8 characters");
});