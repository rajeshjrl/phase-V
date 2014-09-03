<section id="content" class="cms dashboard edit_profile">
    <div class="page_holder">
        <div class="page_inner">        	
            <div class="wallet_section">
                <div class="send_bitcoin">
                    <div class="send_bitcoin_in">
                        <div class="page_head">
                            <h5><?php echo lang('edit_your_profile'); ?></h5>
                        </div>                                              
                        <div class="info_send">
                            <div class="info_data">                  	
                                <div class="tabs_slide">
                                    <a class="toggle active" href="javascript:void(0);"><span>&nbsp;</span><?php echo lang('change_password'); ?></a>
                                    <div class="tabs_data change_pass active">
                                        <div class="info_send user_info">
                                            <div class="info_fieldset formarea">
                                                <div class="banner_form_data">
                                                    <div class="formdata">
                                                        <form id="frm_edit_account_setting" name="frm_edit_account_setting" method="post" action="<?php echo base_url(); ?>profile/account-setting">                            
                                                            <fieldset>
                                                                <label><?php echo lang('old_password'); ?></label>
                                                                <input type="password" name="old_user_password" id="old_user_password" placeholder="<?php echo lang('old_password'); ?>">
                                                            </fieldset>
                                                            <fieldset>
                                                                <label><?php echo lang('new_password'); ?></label>
                                                                <input type="password" name="new_user_password" id="new_user_password" placeholder="<?php echo lang('new_password'); ?>">
                                                            </fieldset>
                                                            <fieldset>
                                                                <label><?php echo lang('confirm_password'); ?></label>
                                                                <input type="password" name="cnf_user_password" id="cnf_user_password" placeholder="<?php echo lang('confirm_password'); ?>">                                    
                                                            </fieldset>                                                                                 
                                                            <fieldset class="button">
                                                                <button type="submit" name="btn_account_setting" id="btn_account_setting" value="btn_chg_pwd"><strong><?php echo lang('change'); ?></strong></button>
                                                                <button type="button" name="Cancel" id="Cancel" value="Cancel" onclick="window.location='<?php echo base_url(); ?>profile/edit'"><strong><?php echo lang('cancel'); ?></strong></button>                                                                                                     
                                                            </fieldset>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php include_once 'edit-profile-footer.php'; ?>
                            </div>
                        </div>
                    </div>                	
                </div>
            </div>                        
        </div>
    </div>
</section>