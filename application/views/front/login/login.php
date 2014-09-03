<section id="content">
    <div class="page_holder">
        <div class="page_inner">
            <div class="login_form">
                <div class="banner_right">
                    <div class="banner_form">
                        <div class="banner_form_top"></div>
                        <div class="banner_form_data">
                            <div class="formdata">
                                <div class="page_head"><h2><?php echo lang('login'); ?></h2></div>
                                <form id="frm_user_login" name="frm_user_login" method="post" action="<?php echo base_url(); ?>signin">                            	
                                    <fieldset>
                                        <label><?php echo lang('user_name'); ?>/<?php echo lang('email'); ?></label>
                                        <input type="text" id="user_name" name="user_name" autocomplete="off">
                                    </fieldset>
                                    <fieldset>
                                        <label><?php echo lang('password'); ?></label>
                                        <input type="password" name="user_password" id="user_password" autocomplete="off">                                    
                                    </fieldset>
                                    <fieldset>
                                        <label>&nbsp;</label>
                                        <img src="" id="captcha" class="captcha"/><a href="javascript:void(0)" onClick="refreshCaptha();" ><img src="<?php echo base_url(); ?>media/front/images/refresh.png" width="35px"></a>
                                    </fieldset>
                                    <fieldset>
                                        <label><?php echo lang('enter_the_security_code'); ?></label>
                                        <input type="text" name="input_captcha_value" id="input_captcha_value">                                    
                                    </fieldset> 
                                    <fieldset>
                                        <a class="form_link" href="<?php echo base_url(); ?>password-recovery"><?php echo lang('forgot_password'); ?>?</a>
                                    </fieldset>                                    
                                    <fieldset class="button">
                                        <input type="submit" name="btn_login" id="btn_login" value="<?php echo lang('login'); ?>">
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                        <div class="banner_form_shadow"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
