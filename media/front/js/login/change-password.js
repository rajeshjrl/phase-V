jQuery(document).ready(function(e) {    
    jQuery("#frm_edit_account_setting").validate({
        debug: true,
        errorClass: 'text-danger',
        rules: {
            old_user_password: {
                required: true,
                minlength: 8,
                remote: {
                    url: javascript_site_path+'profile/edit-user-password-chk',
                    method: 'post',
                    cache: false,
                    sync: false,
                    data: {
                        action: 'edit_user_password_chk'
                    }
                }
            },
            new_user_password: {
                required: true,
                minlength: 8,
                password_strenth: true
            },
            cnf_user_password: {
                required: true,
                minlength: 8,
                equalTo: "#new_user_password"
            }
        },
        messages: {
            old_user_password: {
                required: "Please enter old password.",
                minlength: jQuery.format("Please enter at least {0} characters."),
                remote: "Incorrect old password."
            },
            new_user_password: {
                required: "Please enter new password.",
                minlength: jQuery.format("Password must be combination of atleast 1 number, 1 special character and 1 upper case letter with minimum 8 characters.")
            },
            cnf_user_password: {
                required: "Please confirm password.",
                minlength: jQuery.format("Password must be combination of atleast 1 number, 1 special character and 1 upper case letter with minimum 8 characters"),
                equalTo: "Please enter confirm password same as above."

            }
        }, 
        submitHandler: function(form) {
            jQuery("#btn_account_setting").hide();
            jQuery("#btn_loader").show();
            form.submit();
        }
    });
    jQuery.validator.addMethod("password_strenth", function(value, element) {
        return isPasswordStrong(value,element);
    }, "Password must be combination of atleast 1 number, 1 special character and 1 upper case letter with minimum 8 characters");

});
