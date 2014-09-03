<section id="content" class="cms dashboard invite_friends post_trade">
    <div class="page_holder">
        <div class="page_inner">  
            <div class="page_head">
                <h2>Manage the API client</h2>                
            </div>
            <div class="links" style="text-align:left;margin:10px 0px;">
                <a href="<?php echo base_url(); ?>apps">Return to Apps Dashboard</a>  	
            </div>
            <div class="wallet_section">

                <div class="send_bitcoin">
                    <div class="send_bitcoin_in invite_friend_in">
                        <div class="page_head">
                            <h5>Client details</h5>
                        </div>                        
                        <div class="banner_form_data">
                            <div class="formdata">
                                <fieldset>
                                    <label>Client ID</label>
                                    <div class="tex_data">
                                        <div class="inner_div"><?php echo $arr_client_api[0]['client_id']; ?></div>
                                    </div>
                                    <div class="info_data">
                                        <p><em></em> </p>
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <label>Client Secret</label>
                                    <div class="tex_data">
                                        <div class="inner_div"><?php echo $arr_client_api[0]['client_secret']; ?></div>
                                    </div>
                                    <div class="info_data">
                                        <p><em></em> </p>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="send_bitcoin">
                    <div class="send_bitcoin_in invite_friend_in">
                        <h5>Client secret compromised? <a href="<?php echo base_url(); ?>api-client-regen/<?php echo $arr_client_api[0]['api_id']; ?>">Regenerate the secret</a> immediately</h5>
                    </div>
                </div>


                <div class="send_bitcoin">
                    <div class="send_bitcoin_in invite_friend_in">
                        <div class="page_head">
                            <h5>Authorizing with the user</h5>															
                        </div>
                        <p style="font-size:14px;margin:10px 0;">Here's the first steps to get you started! Read about the rest about authorization at the <a href="<?php echo base_url(); ?>cms/17/api-documentation">API documentation.</a> For next steps you'll need to code the app (accessible for you at redirect uri) to catch the access token (browser/native) or catch the authorization code and redeem it for an access token (server). </p>

                        <div class="authorize">
                            <textarea rows="5" cols="115"><a href="<?php echo base_url(); ?>authorize/response_type=token&client_id=<?php echo $arr_client_api[0]['client_id'] ?>&redirect_uri=<?php echo $arr_client_api[0]['redirect_url']; ?>">Authorize with cryptosi</a></textarea>
                            <a href="<?php echo base_url(); ?>authorize/response_type=token&client_id=<?php echo $arr_client_api[0]['client_id'] ?>&redirect_uri=<?php echo $arr_client_api[0]['redirect_url']; ?>" style="position:absolute;">Authorize with cryptosi</a>
                        </div>

                    </div>
                </div>


                <form name="frm_edit_api_client" id="frm_edit_api_client" action="<?php echo base_url(); ?>api-client/<?php echo $arr_client_api[0]['api_id'] ?>" method="post" >					
                    <div class="send_bitcoin">
                        <div class="send_bitcoin_in invite_friend_in">
                            <div class="page_head">
                                <h5>Update client name and URLs</h5>
                            </div>                        
                            <div class="banner_form_data">
                                <div class="formdata">

                                    <fieldset>
                                        <label>Name</label>
                                        <div class="tex_data">
                                            <div class="inner_div"><input type="text" value="<?php echo $arr_client_api[0]['api_client_name'] ?>" id="api_name" name="api_name"></div>
                                        </div>
                                        <div class="info_data">
                                            <p><em></em> </p>
                                        </div>
                                    </fieldset>                     	

                                    <fieldset>
                                        <label>Url</label>
                                        <div class="tex_data">
                                            <div class="inner_div"><input type="text" value="<?php echo $arr_client_api[0]['url_prefix'] ?>" id="url_prefix" name="url_prefix"></div>
                                        </div>
                                        <div class="info_data">
                                            <p><em>Your application's URL.</em> </p>
                                        </div>
                                    </fieldset>

                                    <fieldset>
                                        <label>Redirect Url</label>
                                        <div class="tex_data">
                                            <div class="inner_div"><input type="text" value="<?php echo $arr_client_api[0]['redirect_url'] ?>" id="redirect_url" name="redirect_url"></div>
                                        </div>
                                        <div class="info_data">
                                            <p><em>Your application's callback URL.</em> </p>
                                        </div>
                                    </fieldset>

                                    <fieldset>
                                        <label>Access permissions</label>
                                        <div class="tex_data">
                                            <div class="inner_div">
                                                <select name="client_scope[]" class="FETextInput" id="client_scope" multiple style="height:20%;width:100%;">

                                                    <option value="read" <?php if (in_array('read', $arr_client_scope)) { ?> selected="selected"<?php } ?>>read</option>
                                                    <option value="write" <?php if (in_array('write', $arr_client_scope)) { ?> selected="selected"<?php } ?>>write</option>
                                                    <option value="money" <?php if (in_array('money', $arr_client_scope)) { ?> selected="selected"<?php } ?>>money</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="info_data">
                                            <p><em>You can limit your app to specific permissions. E.g. if you never use wallet functions, you can completely disable them from your app. Depress ctrl (cmd on Mac) to toggle multiple permissions.</em> </p>
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