jQuery(document).ready(function(e) {
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
            }
        },
        messages: {
            user_name: {
                required: "Please enter email/username."
            },
            user_password: {
                required: "Please enter password.",
                minlength: "Please enter atleast 8 characters."
            }
        }, 
        submitHandler: function(form) {
            jQuery("#btn_login").hide();
            jQuery("#btn_loader").show();
            form.submit();
        }
    });
});
