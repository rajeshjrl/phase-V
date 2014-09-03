jQuery(document).ready(function(e) {
    jQuery("#frm_edit_account_setting").validate({
        debug: true,
        errorClass: 'text-danger',
        rules: {
            user_email: {
                required: true,
                email: true,
                remote: {
                    url: javascript_site_path+'chk-email-duplicate',
                    method: 'post'
                }
            }
        },
        messages: {
            user_email: {
                required: "Please enter email.",
                email: "Please enter valid email.",
                remote: "This email address already registered with site."
            }
        }, 
        submitHandler: function(form) {
            jQuery("#frm_edit_account_setting").hide();
            jQuery("#btn_loader").show();
            form.submit();
        }
    });
});


