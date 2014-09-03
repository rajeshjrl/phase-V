<section id="content" class="cms dashboard invite_friends post_trade">
    <div class="page_holder">
        <div class="page_inner">  
            <div class="page_head">
                <h2>Confirm token revocation</h2>                
            </div>      	
            <div class="wallet_section">

                <form name="frm_revoke_api_token_all" id="frm_revoke_api_token_all" action="<?php echo base_url(); ?>api-token-revoke-all" method="post" >
                    <div class="send_bitcoin">
                        <div class="send_bitcoin_in invite_friend_in">                  
                            <div class="banner_form_data">
                                <div class="formdata">
                                    <fieldset>
                                        <label>Yes, remove all app access from my account <span style="">*</span></label>
                                        <div class="tex_data">
                                            <div class="inner_div"><input type="checkbox" value="Y" id="revoke_all_confirm" name="revoke_all_confirm"></div>
                                        </div>
                                        <div class="info_data">
                                            <p><em></em> </p>
                                        </div>
                                    </fieldset>

                                    <fieldset class="button">
                                        <button type="submit" name="btn_submit" id="btn_submit" value=""><strong>Submit</strong></button>
                                    </fieldset>

                                </div>
                            </div>
                        </div>
                    </div>					
                </form>

            </div>
        </div>
    </div>
</section>