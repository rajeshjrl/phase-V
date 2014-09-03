jQuery(document).ready(function(e) {
    // Call captcha function to load the security code
    refreshCaptha();
                
    //Call check password strength function to display the message
    $('#user_password').keyup(function() {
        checkStrength($('#user_password').val());
    })
                
    //For terms and conditions page start
    jQuery(".ajax").colorbox();
                
    // For registration form validation start 
    jQuery("#frm_user_registration").validate({
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
            },
            user_name: {
                required: true,
                minlength: 5,
                chk_username_field:true,
                remote: {
                    url: javascript_site_path+'chk-username-duplicate',
                    method: 'post'                                
                }
            },
            user_password: {
                required: true,
                minlength: 8,
                password_strenth: true
            },
            password_clear: {
                required: true,
                minlength: 8,
                password_chk: true
            },
            cnf_user_password: {
                required: true,
                equalTo: "#user_password"
            },
            terms: {
                required: true
            },
            input_captcha_value: {
                required: true,
                remote: {
                    url: javascript_site_path+'check-captcha',
                    method: 'post'
                }
            }
        },
        messages: {
            user_email: {
                required: "Please enter email.",
                email: "Please enter valid email.",
                remote: "This email address already registered with site."
            },
            user_name: {
                required: "Please enter username.",
                minlength: jQuery.format("Please enter at least {0} charcters."),
                chk_username_field:"Please enter a valid username. It must contain 5-20 characters. Characters other than <b>0-9, A-Z , a-z , _ , . , - </b>  are not allowed.",
                remote: "This username already registered with site."
            },
            user_password: {
                required: "Please enter password.",
                minlength: jQuery.format("Password must be combination of atleast 1 number, 1 special character and 1 upper case letter with minimum 8 characters.")
            },
            password_clear: {
                required: "Please enter password.",
                minlength: jQuery.format("Please enter at least {0} characters.")
            },
            cnf_user_password: {
                required: "Please re-enter password.",
                equalTo: "Please enter confirm password same as above."
            },
            terms: {
                required: "Please accept terms and conditions."
            },
            input_captcha_value: {
                required: "Please enter security code.",
                remote:"Please enter valid security code."
            }
        }, 
        submitHandler: function(form) {
            jQuery("#btn_register").hide();
            jQuery("#btn_loader").show();
            form.submit();
        }/*,
        // set this class to error-labels to indicate valid fields
        success: function(label) {
            // set &nbsp; as text for IE
            label.html("&nbsp;").addClass("checked");
        }*/
    });
    // For registration form validation end
    jQuery.validator.addMethod('chk_username_field', function(value, element, param) {
        if ( value.match('^[a-zA-Z0-9-._-]{5,20}$') ) {
            return true;
        } else {
            return false;
        }
		
    },"");

    jQuery.validator.addMethod("password_strenth", function(value, element) {
        return isPasswordStrong(value,element);
    }, "Password must be combination of atleast 1 number, 1 special character and 1 upper case letter with minimum 8 characters.");
    jQuery.validator.addMethod("password_chk", function(value, element) {
        if(value=='Password'){
            return false;
        }
    }, "Please enter password");                              
});            
