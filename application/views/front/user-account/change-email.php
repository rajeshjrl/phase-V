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
                                    <a class="toggle active" href="javascript:void(0);"><span>&nbsp;</span><?php echo lang('change_email_id'); ?></a>
                                </div>                                    
                                <div class="tabs_data change_pass active">
                                    <div class="info_send user_info">
                                        <span>After changing your email address, you will have to verify it again. If you don't immediately receive a verification mail after the change, try the following:</span>
                                        <ul>
                                            <li>Wait for a bit more</li>
                                            <li>Check your spam folder</li>
                                            <li>Use another email address</li>
                                        </ul>
                                        <span>If you don't verify your email within 24 hours, we will send another verification mail. If no verification is made within 72 hours, the unverified email address is removed from your account. You can verify another email address then.</span>                                   	
                                        <span>Because account recovery is linked to your verified email address, you will need to confirm this action with your credentials.</span>
                                        <div class="info_fieldset formarea">
                                            <div class="banner_form_data">
                                                <div class="formdata">                        	
                                                    <form id="frm_edit_account_setting" name="frm_edit_account_setting" method="post" action="<?php echo base_url(); ?>profile/change-email">                            	
                                                        <!--<fieldset>
                                                            <label>Your password</label>
                                                            <input type="password" placeholder="Your password">
                                                        </fieldset>-->
                                                        <fieldset>
                                                            <label><?php echo lang('new_email_address'); ?></label>
                                                            <input type="text" class="form-control" name="user_email" id="user_email" placeholder="<?php echo lang('enter_new_email_address_here'); ?>">
                                                        </fieldset>                                                                                            
                                                        <fieldset class="button">
                                                            <button type="submit" name="btn_chg_email" id="btn_chg_email" value="btn_chg_email"><strong><?php echo lang('save_changes'); ?></strong></button>
                                                        </fieldset>
                                                    </form>
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
