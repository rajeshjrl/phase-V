jQuery(document).ready(function(e) {    
    jQuery("#frm_edit_account_setting").validate({
        debug: true,
        errorClass: 'text-danger',
        rules: {
            old_user_password: {
                required: true,
                minlength: 8,
                remote: {
                    url: javascript_site_path+'edit-user-password-chk',
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
                minlength: 8
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
                minlength: jQuery.format("Please enter at least {0} characters.")
            },
            cnf_user_password: {
                required: "Please confirm password.",
                minlength: jQuery.format("Please enter at least {0} characters."),
                equalTo: "Both passwords are not matched."

            }
        }, 
        submitHandler: function(form) {
            jQuery("#btn_account_setting").hide();
            jQuery("#btn_loader").show();
            form.submit();
        }
    });

});
