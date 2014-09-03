<section id="content" class="cms dashboard invite_friends post_trade">
    <div class="page_holder">
        <div class="page_inner">  
            <div class="page_head">
                <h2>Confirm client secret regeneration</h2>                
            </div>      	
            <div class="wallet_section">

                <form name="frm_regen_api_secret" id="frm_regen_api_secret" action="<?php echo base_url(); ?>api-client-regen/<?php echo $api_id; ?>" method="post" >
                    <div class="send_bitcoin">
                        <div class="send_bitcoin_in invite_friend_in">

                            <p>Proceeding with this action will not disable currently active access tokens, but will stop clients configured with the old secret key from creating new access tokens</p>                       
                            <div class="banner_form_data">
                                <div class="formdata">
                                    <fieldset>
                                        <label>Yes, regenerate the client secret<span style="">*</span></label>
                                        <div class="tex_data">
                                            <div class="inner_div"><input type="checkbox" value="Y" id="secret_confirm" name="secret_confirm"></div>
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