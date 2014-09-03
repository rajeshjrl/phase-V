/* Funcaton to refresh captcha image*/
function refreshCaptha()
{    
    jQuery("#captcha").attr('src', javascript_site_path + 'generate-captcha/' + Math.random());
    jQuery("#input_captcha_value").val('');
    jQuery('#input_captcha_value').focus();
    jQuery('#input_captcha_value').next().remove();
    return;
}