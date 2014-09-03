<section id="content" class="cms dashboard invite_friends post_trade">
    <div class="page_holder">
        <div class="page_inner">  
            <div class="page_head">
                <h2>Create a new API client</h2>                
            </div>      	
            <div class="wallet_section">

                <form name="frm_create_api_client" id="frm_create_api_client" action="<?php echo base_url(); ?>api-client" method="post" >
                    <div class="send_bitcoin">
                        <div class="send_bitcoin_in invite_friend_in">
                            <div class="page_head">
                                <h5>Essential information</h5>
                            </div>                        
                            <div class="banner_form_data">
                                <div class="formdata">
                                    <fieldset>
                                        <label>Name</label>
                                        <div class="tex_data">
                                            <div class="inner_div"><input type="text" value="" id="api_name" name="api_name"></div>
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
                            <div class="page_head">
                                <h5>Advanced options</h5>
                            </div>                        
                            <div class="banner_form_data">
                                <div class="formdata">

                                    <fieldset>
                                        <label>Show advance options</label>
                                        <div class="tex_data">
                                            <div class="inner_div"><input type="checkbox" id="chk_advance_options" name="chk_advance_options" value="on"></div>
                                        </div>
                                        <div class="info_data">
                                            <p><em>Advanced options are only required if your client is a Web application. </em> </p>
                                        </div>
                                    </fieldset>                      	

                                    <div id="show_advance_options" style="display:none;">
                                        <fieldset>
                                            <label>Url</label>
                                            <div class="tex_data">
                                                <div class="inner_div"><input type="text" value="http://localhost/" id="url_prefix" name="url_prefix"></div>
                                            </div>
                                            <div class="info_data">
                                                <p><em>Your application's URL.</em> </p>
                                            </div>
                                        </fieldset>

                                        <fieldset>
                                            <label>Redirect Url</label>
                                            <div class="tex_data">
                                                <div class="inner_div"><input type="text" value="http://localhost/" id="redirect_url" name="redirect_url"></div>
                                            </div>
                                            <div class="info_data">
                                                <p><em>Your application's callback URL.</em> </p>
                                            </div>
                                        </fieldset>

                                        <fieldset>
                                            <label>Client type</label>
                                            <div class="tex_data">
                                                <div class="inner_div">
                                                    <select name="client_type" class="FETextInput" id="client_type">
                                                        <option value="0">---------</option>
                                                        <option value="1">Confidential (Web applications)</option>
                                                        <option selected="selected" value="2">Public (Native and JS applications)</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="info_data">
                                                <p><em></em> </p>
                                            </div>
                                        </fieldset>

                                        <fieldset>
                                            <label>Access permissions</label>
                                            <div class="tex_data">
                                                <div class="inner_div">
                                                    <select name="client_scope[]" class="FETextInput" id="client_scope" multiple style="height:20%;">
                                                        <option value="read" selected="selected">read</option>
                                                        <option value="write">write</option>
                                                        <option value="money">money</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="info_data">
                                                <p><em>You can limit your app to specific permissions. E.g. if you never use wallet functions, you can completely disable them from your app. Depress ctrl (cmd on Mac) to toggle multiple permissions.</em> </p>
                                            </div>
                                        </fieldset>

                                    </div>

                                    <fieldset class="button">
                                        <button type="submit" name="btn_submit" id="btn_submit" value=""><strong>Create API client</strong></button>
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