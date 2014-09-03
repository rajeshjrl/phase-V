jQuery(document).ready(function(e) {
    jQuery("#send_trade_request").validate({
        debug: true,
        errorClass: 'text-danger',
        rules: {
            contact_message: {
                maxlength:200
            }
        },
        messages: {
            contact_message: {
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
