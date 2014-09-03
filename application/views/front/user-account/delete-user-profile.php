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
                                    <a href="javascript:void(0);" class="toggle active"><span>&nbsp;</span><?php echo lang('account_deletion'); ?></a>
                                </div>
                                <div class="tabs_data change_pass active">
                                    <div class="info_send user_info">
                                        <span></span>
                                        <span></span>
                                        <div class="info_fieldset formarea">
                                            <div class="banner_form_data">
                                                <div class="formdata">
                                                    <form id="frm_delete_account" name="frm_delete_account" method="post" action="<?php echo base_url(); ?>profile/delete-request" class="bs-example form-horizontal">
                                                        <fieldset>
                                                            <label><?php echo lang('your_password'); ?></label>
                                                            <input type="password" class="form-control" name="old_user_password" id="old_user_password" placeholder="password">
                                                            <br />
                                                            <span class="helptext"><?php echo lang('please_confirm_account_deletion'); ?></span>
                                                        </fieldset>
                                                        <fieldset>
                                                            <label><?php echo lang('comment'); ?></label>
                                                            <textarea rows="5" name="comment" id="comment" placeholder="Comment"></textarea>
                                                        </fieldset>
                                                        <fieldset class="button">
                                                            <button type="submit" name="btn_account_setting" id="btn_account_setting" class="btn btn-success"><strong><?php echo lang('initiate_deletion_request'); ?></strong></button>
                                                            <input type="hidden" class="form-control" name="user_id" id="user_id" value="<?php echo $user_session['user_id']; ?>">
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