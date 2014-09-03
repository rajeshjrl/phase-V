// JavaScript Document
$(document).ready(function(e) {        
    $("#frm_user_details").validate({
        errorElement: "div",
        errorPlacement: function(label, element) {
            if(element[0].name=="admin_privileges[]")
            {
                label.insertAfter("#pre_div");
            }else
            {
                label.insertAfter(element);
            }
        },
        rules: {

            user_name:{
                required:true,
                minlength:5,
                chk_username_field:true,
                remote:{
                    url: jQuery("#base_url").val()+"backend/user/check-user-username",
                    type: "post",
                    data:{
                        type:"edit",
                        old_username:jQuery('#old_username').val()
                    }
                }
            },
            user_email:{
                required:true,
                email:true,
                remote:{
                    url: jQuery("#base_url").val()+"backend/user/check-user-email",
                    type: "post",
                    data:{
                        type:"edit",
                        old_email:jQuery('#old_email').val()
                    }
                }
            },
            user_password:{
                required:true,
                minlength:8,
                password_strenth: true
            },
            confirm_password:{
                required:true,
                equalTo:'#user_password'	
            },
            role_id:{
                required:true	
            }
        },
        messages:{

            user_name:{
                required:"Please enter username.",
                minlength:"Please enter a valid username. It must contain 5-20 characters. Characters other than <b>0-9, A-Z , a-z , _ , . , - </b>  are not allowed.",
                chk_username_field:"Please enter a valid username. It must contain 5-20 characters. Characters other than <b>0-9, A-Z , a-z , _ , . , - </b>  are not allowed.",
                remote:"Username already exists."
            },
            user_email:{
                required:"Please enter an email address.",
                email:"Please enter a valid email address.",
                remote:"Email address already exists."
            },
            user_password:{
                required:"Please enter password.",
                minlength:"Please enter atleast 8 characters."
            },
            confirm_password:{
                required:"Please enter the confirm password.",
                equalTo:"Password and confirm password do not match."
            },
            role_id:{
                required:"Please select admin user role."
            }
        }
    });
	
    jQuery.validator.addMethod('chk_username_field', function(value, element, param) {
        if ( value.match('^[a-zA-Z0-9-._-]{5,20}$') ) {
            return true;
        } else {
            return false;
        }
		
    },"");
	
    jQuery.validator.addMethod("password_strenth", function(value, element) {
        return isPasswordStrong(value, element);
    }, "Password must be strong");
		
    $("#check_box").css({
        display:"block",
        opacity:"0",
        height:"0",
        width:"0",
        "float":"right"
    });
	
    jQuery("#change_password").bind("click",function(){
        if(jQuery(this).attr('checked')=='checked') 
        {	
            jQuery('#change_password_div').css('display','block');
        }
        else
        {
            jQuery('#change_password_div').css('display','none');
        }
    });
        
    if (jQuery("#change_password").attr('checked') == 'checked') {
        jQuery('#change_password_div').css('display', 'block');
    } else {
        jQuery('#change_password_div').css('display', 'none');
    }
});
