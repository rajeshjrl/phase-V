jQuery(document).ready(function(e) {
		
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
        }
        if($("input:radio[id='mobile']").is(":checked")) {
            $("#mobile-codes").show(300);
            $('#frm_two_factor_auth_mobile').show();
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
	
    //Validate paper code authentication form 
    jQuery("#frm_two_factor_auth_paper").validate({
        debug: true,
        errorClass: 'text-danger',
        rules: {
            key: {
                required: true,					
            },
            first_code: {
                required: true,
            },
            check: {
                required: true,
            },
        },
        messages: {
            key: {
                required: "Please enter your key."
            },
            first_code: {
                required: "Please enter code.",
            },
            check: {
                required: "Please slelect paper code checkbox",
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
                required: true,					
            },
            auth_code: {
                required: true,
                minlength: 6,
            },
            check_mobile_code: {
                required: true,
            },
        },
        messages: {
            auth_key: {
                required: "Please enter your key."
            },
            auth_code: {
                required: "Please enter code.",
            },
            check_mobile_code: {
                required: "Please slelect mobile code checkbox",
            }
        }, 
        submitHandler: function(form) {
            jQuery("#btn_account_setting").hide();
            jQuery("#btn_loader").show();
            form.submit();
        }
    });
		
    //form validation of user deletion request
    jQuery("#frm_edit_account_setting").validate({
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
                required: true,
            }
        },
        messages: {
            old_user_password: {
                required: "Please enter your password.",
                minlength: jQuery.format("Please enter at least {0} characters."),
                remote: "Incorrect password."
            },
            comment: {
                required: "Please enter your comment.",
            }
        }, 
        submitHandler: function(form) {
            jQuery("#btn_account_setting").hide();
            jQuery("#btn_loader").show();
            form.submit();
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