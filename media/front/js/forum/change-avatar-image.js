    jQuery(document).ready(function(e) {                
        jQuery("#frm_upload_avatar_img").validate({
            debug: true,
            errorClass: 'text-danger',
            rules: {
                new_avatar_img: {
                    required: true,
                    accept: "jpg|jpeg|png|gif"
                }
            },
            messages: {
                new_avatar_img: {
                    required: "<br>Please select image to upload.",
                    accept:'<br>Invalid image format (allowed only jpg| jpeg| png| gif format.)'
                }
            }, 
            submitHandler: function(form) {
                jQuery("#btn_login").hide();
                jQuery("#btn_loader").show();
                form.submit();
            }
        });
    });