function connectMe(path)
{
    FB.login(function(response) {
        if (response.authResponse) {
            jQuery("#btn_fb_connect").hide();
            jQuery("#btn_login").hide();
            jQuery("#btn_loader").show();
            FB.api('/me', function(response) {
                var params = "first_name=" + response.first_name + "&last_name=" + response.last_name + "&user_name=" + response.username + "&user_email=" + response.email + "&fb_id=" + response.id + "&action=facebook_connect";
                jQuery.ajax({
                    type: 'post',
                    url: path + 'fb-signup',
                    data: params,
                    success: function(msg) {
                        if (msg)
                        {                           
                            window.parent.location = path+"profile";
                        }
                    }
                });
            });
        } else {
            console.log('User cancelled login or did not fully authorize.');
        }
    }, {
        "scope": "email,read_stream,publish_stream"
    });
}