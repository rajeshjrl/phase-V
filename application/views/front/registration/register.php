<section id="content">
    <div class="page_holder">
        <div class="page_inner">
            <div class="login_form">
                <div class="banner_right">
                    <div class="banner_form">
                        <div class="banner_form_top"></div>
                        <div class="banner_form_data">
                            <div class="formdata">
                                <div class="page_head">
                                    <h2><?php echo lang('sign_up_as_individual'); ?></h2>
                                </div>
                                <form id="frm_user_registration" name="frm_user_registration" method="post" action="<?php echo base_url(); ?>signup">                            	
                                    <fieldset>
                                        <label><?php echo lang('user_name'); ?></label>
                                        <input type="text" name="user_name" id="user_name" placeholder="<?php echo lang('user_name'); ?>">
                                    </fieldset>
                                    <fieldset>
                                        <label><?php echo lang('email_address'); ?></label>
                                        <input type="text" name="user_email" id="user_email" placeholder="<?php echo lang('your_email_address'); ?>">
                                    </fieldset>
                                    <fieldset>
                                        <label><?php echo lang('password'); ?></label>
                                        <input type="password" name="user_password" id="user_password" autocomplete="off">
                                        <label for="user_password" generated="true" class="text-danger"></label>
                                    </fieldset>
                                    <fieldset>
                                        <label><?php echo lang('confirm_password'); ?></label>
                                        <input type="password" name="cnf_user_password" id="cnf_user_password">                                    
                                    </fieldset>
                                    <fieldset>
                                        <label>&nbsp;</label>
                                        <img src="" id="captcha" class="captcha"/><a href="javascript:void(0)" onClick="refreshCaptha();" ><img src="<?php echo base_url(); ?>media/front/images/refresh.png" width="35px"></a>
                                    </fieldset>
                                    <fieldset>
                                        <label><?php echo lang('enter_the_security_code'); ?></label>
                                        <input type="text" name="input_captcha_value" id="input_captcha_value">                                    
                                    </fieldset>
                                    <fieldset class="check_error">
                                        <input type="checkbox" name="terms" id="terms"><a class="btn-link ajax cboxElement" href="<?php echo base_url(); ?>terms-and-conditions/17/terms-and-conditions"><?php echo lang('i_accept_terms_and_conditions'); ?></a>
                                        <label class="text-danger" for="terms" generated="true"></label>
                                    </fieldset>
                                    <fieldset>
                                        <span><?php echo lang('already_have_an_account'); ?>?</span>&nbsp;&nbsp;<a class="form_link" href="<?php echo base_url(); ?>signin"><?php echo lang('login'); ?></a>
                                    </fieldset>                                    
                                    <fieldset class="button">
                                        <input type="submit" name="btn_register" id="btn_register" value="<?php echo lang('sign_up'); ?>">
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
