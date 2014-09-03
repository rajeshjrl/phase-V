<section id="content">
    <div class="page_holder">
        <div class="page_inner">
            <div class="login_form">
                <div class="banner_right">
                    <div class="banner_form">
                        <div class="banner_form_top"></div>
                        <div class="banner_form_data">
                            <div class="formdata">

                                <div class="page_head"><h2><?php echo lang('reset_password'); ?></h2></div>
                                <form id="frm_reset_password" name="frm_reset_password" method="post" action="<?php echo base_url(); ?>reset-password-action">                            	
                                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $arr_user_data['user_id']; ?>">
                                    <input type="hidden" name="activation_code" id="activation_code" value="<?php echo $arr_user_data['activation_code']; ?>">                                    
                                    <fieldset>
                                        <label><?php echo lang('new_password'); ?></label>
                                        <input type="password" name="new_user_password" id="new_user_password" placeholder="<?php echo lang('new_password'); ?>">                                                    
                                    </fieldset>
                                    <fieldset>
                                        <label><?php echo lang('confirm_password'); ?></label>
                                        <input type="password" name="cnf_user_password" id="cnf_user_password" placeholder="<?php echo lang('confirm_password'); ?>">                                                   
                                    </fieldset>
                                    <fieldset class="button">
                                        <input type="submit" name="btn_frgt_pwd" id="btn_frgt_pwd" value="<?php echo lang('save_changes'); ?>">                                       
                                        <input type="button" name="Cancel" id="Cancel" value="<?php echo lang('cancel'); ?>" onclick="window.location='<?php echo base_url(); ?>signin'">                                       
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