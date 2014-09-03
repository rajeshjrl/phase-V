/* login admin Js */
jQuery(document).ready(function(){
    jQuery("#frm_admin_login").validate({
        errorElement:'div',
        rules: {
            user_name: {
                required: true
            },
            user_password:{
                required: true
            }
        },
        messages: {
            user_name:{
                required:"Please enter username."
            },
            user_password: {
                required:"Please enter password."
            }
        }
    });
});