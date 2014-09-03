// REGISTRATION FORM VALIDATIOPN 
$(document).ready(function() {
    $("#frm_admin_forgot_password").validate({
        rules: {
            errorElement: "div",
            user_email: {
                required: true,
                email: true,
                remote:{
                    url: jQuery("#base_url").val()+"backend/forgot-password-email",
                    type: "post"
                }
            }
        }, //end rules
        messages: {
            user_email: {
                required: "Please enter email address.",
                email: "Please enter an valid email address.",
                remote: "This email is not registered with us."
            }
        } //end messages
    }); //end validate
}); //end document ready
