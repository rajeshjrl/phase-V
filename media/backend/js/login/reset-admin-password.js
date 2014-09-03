/* reset admin password*/

jQuery(document).ready(function(){
    
    jQuery("#frm_admin_reset_password").validate({
        errorElement:'div',
        rules: {
            new_password: {
                required: true,
                password_strenth: true
            },
            cnf_password:{
                required: true,
                equalTo:$('#new_password')
            }
        },
        messages: {
            new_password:{
                required:"Please enter password."
            },
            cnf_password: {
                required:"Please enter password again.",
                equalTo :"Both password are not matching."              
            }
        }
    });
    jQuery.validator.addMethod("password_strenth", function(value, element) {
        return isPasswordStrong(value, element);
    }, "Password must be combination of atleast 1 number, 1 special character and 1 upper case letter with minimum 8 characters");
});


