<section id="content">
    <div class="page_holder">
        <div class="page_inner">
            <div class="login_form">
                <div class="banner_right">
                    <div class="banner_form">
                        <div class="banner_form_top"></div>
                        <div class="banner_form_data">
                            <div class="formdata">
                                <div class="page_head"><h2><?php echo lang('forgot_password'); ?></h2></div>
                                <form id="frm_forgot_password" name="frm_forgot_password" method="post" action="<?php echo base_url(); ?>password-recovery">                            	
                                    <fieldset>
                                        <label><?php echo lang('email_address'); ?></label>
                                        <input type="text" id="user_email" name="user_email" autocomplete="off" placeholder="<?php echo lang('please_enter_your_registered_email_id'); ?>">
                                    </fieldset>
                                    <fieldset class="button">
                                        <input type="submit" name="btn_pass" id="btn_pass" value="<?php echo lang('send'); ?>">                                       
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
