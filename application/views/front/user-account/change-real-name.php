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
                                    <a class="toggle active" href="javascript:void(0);"><span>&nbsp;</span><?php echo lang('real_name'); ?></a>
                                </div>                                    
                                <div class="tabs_data change_pass active">
                                    <div class="info_send user_info">                                      
                                        <div class="info_fieldset formarea">
                                            <div class="banner_form_data">
                                                <div class="formdata">                        	
                                                    <form id="frm_real_name" name="frm_real_name" method="post" action="<?php echo base_url(); ?>profile/change-real-name">                            	
                                                        <fieldset>
                                                            <label><?php echo lang('your_name'); ?></label>
                                                            <?php if ($arr_user_data['user_name_verified'] == '0') { ?>
                                                                <input type="text" class="form-control" name="user_name" id="user_name" value="<?php echo $arr_user_data['first_name']; ?>" placeholder="<?php echo lang('enter_real_name_here'); ?>">
                                                                <input type="hidden" class="form-control" name="old_user_name" id="old_user_name" value="<?php echo $arr_user_data['first_name']; ?>" placeholder="<?php echo lang('enter_real_name_here'); ?>">
                                                                (<strong><?php echo lang('you_can_set_your_real_name_only_once'); ?>.</strong> <?php echo lang('once_real_name_confirm'); ?>.)                                    
                                                            <?php } else { ?>                                                            
                                                                <input type="text" class="form-control" id="user_name" readonly="readonly" value="<?php echo $arr_user_data['first_name']; ?>">                                        
                                                                (<strong><?php echo lang('you_can_set_your_real_name_now'); ?>.</strong> <?php echo lang('real_name_conf_by_seller'); ?>.)                        
                                                            <?php } ?>
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
