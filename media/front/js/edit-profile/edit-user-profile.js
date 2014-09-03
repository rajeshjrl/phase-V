jQuery(document).ready(function(e) {
    jQuery("#frm_edit_account_setting").validate({
        debug: true,
        errorClass: 'text-danger',
        rules: {
            self_introduction: {
                maxlength:200
            }
        },
        messages: {
            self_introduction: {
                maxlength: "Please enter text up to 200 characters."
            }
        }, 
        submitHandler: function(form) {
            jQuery("#btn_login").hide();
            jQuery("#btn_loader").show();
            form.submit();
        }
    });
});
