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
                                <form id="frm_edit_account_setting" name="frm_edit_account_setting" method="post" action="<?php echo base_url(); ?>profile/edit">                            
                                    <input type="hidden" name="user_id" name="user_id" value="<?php echo $user_session['user_id']; ?>">
                                    <div class="tabs_slide">
                                        <a class="toggle active" href="javascript:void(0);"><span>&nbsp;</span><?php echo lang('basic_user_information'); ?></a>
                                        <div class="tabs_data basic_info active">
                                            <div class="info_send user_info">
                                                <div class="info_fieldset">
                                                    <div class="label"><?php echo lang('email'); ?>: <label><?php echo $user_session['user_email']; ?></label></div>
                                                </div>
                                                <div class="info_fieldset">
                                                    <div class="label"><?php echo lang('timezone'); ?> :
                                                        <select name="timezone_id" id="timezone_id" title="select timezone">
                                                            <option value="">----------<?php echo lang('select_timezone'); ?>---------</option>
                                                            <?php
                                                            if (count($arr_timezones) > 0) {
                                                                foreach ($arr_timezones as $value) {
                                                                    ?>
                                                                    <option value = "<?php echo $value['timezone_id']; ?>" <?php echo $selected = ($value['timezone_id'] == $arr_user_data['timezone_id']) ? 'selected' : ''; ?> ><?php echo $value['gmt'] . '&nbsp' . $value['timezone_location']; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>                                       
                                                        </select>                                             
                                                    </div>
                                                    <div class="info_fieldset">
                                                        <div class="label"><input type="checkbox"  name="cash_txn_auto_funding" id="cash_txn_auto_funding"   value="y" title="cash_txn_auto_funding" <?php echo ($arr_user_data['cash_txn_auto_funding'] == 'y') ? "checked='checked'" : ''; ?>> <?php echo lang('cash_transactions_auto_fund'); ?></div>
                                                        <div class="label_data"><em>Select this, if you want to speed up processing cash trades. Your received cash trade offers will be funded automatically from your Cryptosi.com wallet.</em></div>
                                                    </div>
                                                    <div class="info_fieldset">
                                                        <div class="label"><input type="checkbox"  name="selling_vacation" id="selling_vacation"  <?php echo ($arr_user_data['selling_vacation'] == 'y') ? "checked" : ''; ?>   value="y"  title="selling_vacation"><?php echo lang('selling_vacation'); ?></div>
                                                        <div class="label_data"><em>Disable all your SELL ads temporarily</em></div>
                                                    </div>
                                                    <div class="info_fieldset">
                                                        <div class="label"><input type="checkbox"  name="buying_vacation" id="buying_vacation"  <?php echo $chkd = ($arr_user_data['buying_vacation'] == 'y') ? "checked" : ''; ?>   value="y"  title="buying_vacation"><?php echo lang('buying_vacation'); ?></div>
                                                        <div class="label_data"><em>Disable all your BUY ads temporarily.</em></div>
                                                    </div>
                                                    <div class="info_fieldset">
                                                        <div class="label"><input type="checkbox"  name="sms_for_new_trade_contact" id="sms_for_new_trade_contact"  <?php echo $chkd = ($arr_user_data['sms_for_new_trade_contact'] == 'y') ? "checked" : ''; ?>   value="y"  title="sms_for_new_trade_contact"><?php echo lang('send_sms_notifi_for_new_trade_contacts'); ?></div>
                                                        <div class="label_data"><em>Send SMS notifications from new contact requests (price: free).</em></div>
                                                    </div>
                                                    <div class="info_fieldset">
                                                        <div class="label"><input type="checkbox"  name="sms_for_new_ol_payment" id="sms_for_new_ol_payment"  <?php echo $chkd = ($arr_user_data['sms_for_new_ol_payment'] == 'y') ? "checked" : ''; ?>   value="y"  title="sms_for_new_ol_payment"><?php echo lang('send_sms_notifi_for_new_online_payments'); ?></div>
                                                        <div class="label_data"><em>Send SMS notifications from new online payments in your advertisements (price: free). </em></div>
                                                    </div>
                                                    <div class="info_fieldset">
                                                        <div class="label"><input type="checkbox"  name="sms_for_messages" id="sms_for_messages"  <?php echo $chkd = ($arr_user_data['sms_for_messages'] == 'y') ? "checked" : ''; ?>  value="y" title="sms_for_messages"><?php echo lang('send_sms_notifi_for_messages'); ?></div>
                                                        <div class="label_data"><em>Send SMS notifications from new messages (price: 0.00015 BTC/message).</em></div>
                                                    </div>
                                                    <div class="info_fieldset">
                                                        <div class="label"><input type="checkbox"  name="sms_for_escrow_release" id="sms_for_escrow_release"  <?php echo $chkd = ($arr_user_data['sms_for_escrow_release'] == 'y') ? "checked" : ''; ?>   value="y"  title="sms_for_escrow_release"><?php echo lang('send_sms_notifi_for_online_escrow'); ?></div>
                                                        <div class="label_data"><em>Send SMS notifications from new online escrow releases (price: free).</em></div>
                                                    </div>
                                                    <div class="info_fieldset">
                                                        <div class="label"><?php echo lang('introduction'); ?></div>
                                                        <div class="label_data"><em>Shown on your public profile. Plain text only, up to 200 characters.</em></div>
                                                    </div>
                                                    <div class="info_fieldset formarea">
                                                        <textarea rows="8" name="self_introduction" id="self_introduction"><?php echo $arr_user_data['self_introduction']; ?></textarea>
                                                        <button type="submit" name="btn_basic_info" id="btn_account_setting" class="btn btn-success" value="btn_basic_info"><strong><?php echo lang('save_profile'); ?></strong></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <?php include_once 'edit-profile-footer.php'; ?>                                                      
                            </div>
                        </div>                	
                    </div>
                </div>                        
            </div>
        </div>
</section>