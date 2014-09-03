<section id="content" class="cms dashboard invite_friends post_trade">
    <div class="page_holder">
        <div class="page_inner">  
            <div class="page_head">
                <h2>Confirm token revocation</h2>                
            </div>      	
            <div class="wallet_section">

                <form name="frm_revoke_api_token" id="frm_revoke_api_token" action="<?php echo base_url(); ?>api-token-revoke/<?php echo $app_id; ?>/<?php echo $token; ?>" method="post" >
                    <div class="send_bitcoin">
                        <div class="send_bitcoin_in invite_friend_in">

                            <p>Proceeding will remove access from the app <a href="<?php echo $arr_app[0]['url_prefix']; ?>"><?php echo $arr_app[0]['app_name']; ?></a> created by <a href="<?php echo base_url(); ?>api-token-revoke/<?php echo $app_id; ?>/<?php echo $token; ?>"><?php echo $arr_app[0]['user_name']; ?></a>. If this app has multiple tokens, the others will still be available.</p>                       
                            <div class="banner_form_data">
                                <div class="formdata">
                                    <fieldset>
                                        <label>Yes, revoke this app access token<span style="">*</span></label>
                                        <div class="tex_data">
                                            <div class="inner_div"><input type="checkbox" value="Y" id="revoke_confirm" name="revoke_confirm"></div>
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