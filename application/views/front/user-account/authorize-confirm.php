<section id="content" class="cms dashboard invite_friends post_trade">
    <div class="page_holder">
        <div class="page_inner">  
            <div class="page_head">
                <h2>Connect with <?php echo $global['site_title'] ?></h2>                
            </div>      	
            <div class="wallet_section">

                <form name="frm_authorize_api_confirm" id="frm_authorize_api_confirm" action="<?php echo base_url(); ?>confirm/<?php echo $api_id; ?>" method="post" >
                    <div class="send_bitcoin">
                        <div class="send_bitcoin_in invite_friend_in">

                            <p>Do you trust <strong><?php echo $arr_client_api[0]['api_client_name'] ?></strong> and its creator <a href=""><?php echo $arr_client_api[0]['user_name'] ?></a> to access your cryptosi account? You take full responsibility that the app uses its permissions correctly. If you proceed, you are expected to know what you're doing.</p>  
                            <p>The app requests the following permissions:</p>

                            <ul class="unstyled">  
                                <li>								
                                    <h3>Read your data</h3>
                                    <p><i class="icon icon-eye-open"></i> Permission to read private information from ads and contacts</p>
                                </li>							  
                            </ul>

                            <p>If you wish to later revoke this authorization, you can do so at your <a href="<?php echo base_url(); ?>apps">App Dashboard</a>. You can later find the dashboard in the footer at "Apps".</p>

                            <div class="banner_form_data">
                                <div class="formdata">

                                    <fieldset class="button">
                                        <button type="submit" name="btn_submit" id="btn_submit" value=""><strong>Authorize</strong></button>
                                        <input type="hidden" name="api_id" id="api_id" value="<?php echo $arr_client_api[0]['api_id'] ?>" />
                                        <input type="hidden" name="app_name" id="app_name" value="<?php echo $arr_client_api[0]['api_client_name'] ?>" />
                                        <input type="hidden" name="scope" id="scope" value="<?php echo $arr_client_api[0]['client_scope'];?>" />
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