jQuery(document).ready(function(e) {
								
    jQuery("#chk_advance_options").bind("click",function(){
        //console.log("ggggggggg= "+jQuery("#chk_advance_options").is(":checked"))
        if(jQuery("#chk_advance_options").is(":checked")) 
        {
            //alert();			
            jQuery("#show_advance_options").css("display","block");
        }
        else
        {
            jQuery("#show_advance_options").css("display","none");
        }
    });
		
    //Show paper code div or mobile app code div on radio button click
    if($("input:radio[id='paper']").is(":checked")) {
        $("#paper-codes").show(300);
    }
    if($("input:radio[id='mobile']").is(":checked")) {
        $("#mobile-codes").show(300);
    }
		
    $('input[type="radio"]').click(function(){
        $("#show-activation-key").removeAttr("disabled");
        if($(this).attr("id")=="paper"){
            $("#paper-codes").show(300);
            $("#mobile-codes").hide(100);
        }
        if($(this).attr("id")=="mobile"){
            $("#mobile-codes").show(300);
            $("#paper-codes").hide(100);
        }
    });
		
    //Proceed to activation and show form of which paper code or mobile code
    $('#show-activation-key').click(function() {
        if($("input:radio[id='paper']").is(":checked")) {
            $("#paper-codes").show(300);
            $('#frm_two_factor_auth_paper').show();
            $('.banner_form_data').show();
        }
        if($("input:radio[id='mobile']").is(":checked")) {
            $("#mobile-codes").show(300);
            $('#frm_two_factor_auth_mobile').show();
            $('.banner_form_data').show();
        }			
        $(".radiolable").hide();
        $("#show-activation-key").hide();
    });
		
    //open new popup window to print paper code
    $("#paper-codes-link").click(function(e) {
        e.preventDefault();
        var href = $(this).attr("href");
        window.open(href, "Paer codes",'height=500,width=640,location=no');
        return false;
    });
	
    //form validation of create api client
    jQuery("#frm_create_api_client").validate({
        debug: true,
        errorClass: 'text-danger',
        rules: {
            api_name: {
                required: true,
                minlength: 4					
            },
            url_prefix: {
                required: true
            },
            redirect_url: {
                required: true
            }
        },
        messages: {
            api_name: {
                required: "Please enter name.",
                minlength: jQuery.format("Please enter at least {0} characters.")
            },
            url_prefix: {
                required: "Please enter url prfix."
            },
            redirect_url: {
                required: "Please enter redirect url."
            }
        }, 
        submitHandler: function(form) {
            jQuery("#btn_submit").hide();
            jQuery("#btn_loader").show();
            form.submit();
        }
    });
	
	
    //form validation of edit api client
    jQuery("#frm_edit_api_client").validate({
        debug: true,
        errorClass: 'text-danger',
        rules: {
            api_name: {
                required: true,
                minlength: 4					
            },
            url_prefix: {
                required: true
            },
            redirect_url: {
                required: true
            }
        },
        messages: {
            api_name: {
                required: "Please enter name.",
                minlength: jQuery.format("Please enter at least {0} characters.")
            },
            url_prefix: {
                required: "Please enter url_prfix."
            },
            redirect_url: {
                required: "Please enter redirect_url."
            }
        }, 
        submitHandler: function(form) {
            jQuery("#btn_submit").hide();
            jQuery("#btn_loader").show();
            form.submit();
        }
    });
	
	
    //form validation of regenerate api client secret
    jQuery("#frm_regen_api_secret").validate({
        debug: true,
        errorClass: 'text-danger',
        rules: {
            secret_confirm: {
                required: true
            }
        },
        messages: {
            secret_confirm: {
                required: "This field is required."
            }
        }, 
        submitHandler: function(form) {
            jQuery("#btn_submit").hide();
            jQuery("#btn_loader").show();
            form.submit();
        }
    });
	
	
    //form validation of regenerate api client secret
    jQuery("#frm_revoke_api_token").validate({
        debug: true,
        errorClass: 'text-danger',
        rules: {
            revoke_confirm: {
                required: true
            }
        },
        messages: {
            revoke_confirm: {
                required: "This field is required."
            }
        }, 
        submitHandler: function(form) {
            jQuery("#btn_submit").hide();
            jQuery("#btn_loader").show();
            form.submit();
        }
    });
	
	
    //form validation of regenerate api client secret
    jQuery("#frm_revoke_api_token_all").validate({
        debug: true,
        errorClass: 'text-danger',
        rules: {
            revoke_all_confirm: {
                required: true
            }
        },
        messages: {
            revoke_all_confirm: {
                required: "This field is required." 
            }
        }, 
        submitHandler: function(form) {
            jQuery("#btn_submit").hide();
            jQuery("#btn_loader").show();
            form.submit();
        }
    });
	
	
    //Validate paper code authentication form 
    jQuery("#frm_two_factor_auth_paper").validate({
        debug: true,
        errorClass: 'text-danger',
        rules: {
            key: {
                required: true				
            },
            first_code: {
                required: true
            },
            check: {
                required: true
            }
        },
        messages: {
            key: {
                required: "Please enter your key."
            },
            first_code: {
                required: "Please enter code."
            },
            check: {
                required: "Please slelect paper code checkbox"
            }
        }, 
        submitHandler: function(form) {
            jQuery("#btn_account_setting").hide();
            jQuery("#btn_loader").show();
            form.submit();
        }
    });
		
    //Validate mobile code authentication form
    jQuery("#frm_two_factor_auth_mobile").validate({
        debug: true,
        errorClass: 'text-danger',
        rules: {
            auth_key: {
                required: true				
            },
            auth_code: {
                required: true,
                minlength: 6
            },
            check_mobile_code: {
                required: true
            }
        },
        messages: {
            auth_key: {
                required: "Please enter your key."
            },
            auth_code: {
                required: "Please enter code."
            },
            check_mobile_code: {
                required: "Please slelect mobile code checkbox"
            }
        }, 
        submitHandler: function(form) {
            jQuery("#btn_account_setting").hide();
            jQuery("#btn_loader").show();
            form.submit();
        }
    });
		
    //form validation of user deletion request
    jQuery("#frm_delete_account").validate({
        debug: true,
        errorClass: 'text-danger',
        rules: {
            old_user_password: {
                required: true,
                minlength: 8,
                remote: {
                    url: 'edit-user-password-chk',
                    method: 'post',
                    cache: false,
                    sync: false,
                    data: {
                        action: 'edit_user_password_chk'
                    }
                }					
            },
            comment: {
                required: true
            }
        },
        messages: {
            old_user_password: {
                required: "Please enter your password.",
                minlength: jQuery.format("Please enter at least {0} characters."),
                remote: "Incorrect password."
            },
            comment: {
                required: "Please enter your comment."
            }
        }, 
        submitHandler: function(form) {				
            var res = confirm('Are you sure you want to delete your account?');
            if(res == true){
                jQuery("#btn_account_setting").hide();
                jQuery("#btn_loader").show();
                form.submit();
            }else{
                return false;
            }
        }
    });
		
    //Form validate edit user profile
    jQuery("#frm_edit_profile").validate({
        debug: true,
        errorClass: 'text-danger',
        rules: {
            first_name: {
                required: true
            },
            user_email: {
                required: true,
                email: true,
                remote: {
                    url: '<?php echo base_url(); ?>chk-edit-email-duplicate',
                    method: 'post',
                    data: {
                        user_email_old: jQuery('#user_email_old').val()
                    }
                }
            },
            user_name: {
                required: true,
                minlength: 5,
                remote: {
                    url: '<?php echo base_url(); ?>chk-edit-username-duplicate',
                    method: 'post',
                    data: {
                        action: 'edit_user_name_chk', 
                        user_name_old: jQuery('#user_name_old').val()
                    }
                }
            }
        },
        messages: {
            first_name: {
                required: "Please enter first name."
            },
            user_email: {
                required: "Please enter email.",
                email: "Please enter valid email.",
                remote: "This email address already registered with site."
            },
            user_name: {
                required: "Please enter username.",
                minlength: "Please enter at least 5 charcters.",
                remote: "This username already registered with site."
            }
        }, 
        submitHandler: function(form) {
            jQuery("#btn_edit_profile").hide();
            jQuery("#btn_loader").show();
            form.submit();
        }
    });

});