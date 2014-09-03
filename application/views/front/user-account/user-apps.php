<section id="content" class="cms dashboard edit_profile">
    <div class="page_holder">
        <div class="page_inner">        	
            <div class="wallet_section">
                <div class="send_bitcoin">
                    <div class="send_bitcoin_in">
                        <div class="page_head">
                            <h5>Apps Dashboard</h5>
                        </div>                                              
                        <div class="info_send">
                            <div class="info_data">

                                <div class="wrapper">
                                    <div class="page_head">
                                        <h5>Apps</h5>
                                    </div>
                                    <h6>These apps are allowed to do things on your behalf. <a href="<?php echo base_url(); ?>cms/17/api-scopes">Explanation of scopes</a></h6>
                                    <div class="user_advertisement">
                                        <table>
                                            <tbody>
                                                <tr class="head">
                                                    <th>App name</th>
                                                    <th>Scope</th>
                                                    <!--<th>Expires</th>-->
                                                    <th>Action</th>
                                                </tr>
                                                <?php
                                                if (count($arr_app) > 0) {
                                                    $i = 1;
                                                    foreach ($arr_app as $app) {
                                                        $bgcolor = ($i % 2 == 0) ? '#FDFDFF' : '#DCDCE1';
                                                        ?>
                                                        <tr style="background-color: <?php echo $bgcolor; ?>">
                                                            <td><a href="<?php echo $app['url_prefix']; ?>"><?php echo $app['app_name'] ?></a> by <a href="<?php echo base_url(); ?>profile"><?php echo $app['user_name'] ?></a></td>
                                                            <td><?php echo $app['scope']; ?></td>
                                                                                                                        <!--<td></td>-->
                                                            <td><a href="<?php echo base_url(); ?>api-token-revoke/<?php echo $app['app_id'] ?>/<?php echo $app['token'] ?>">Delete</a></td>
                                                        </tr>                                        
                                                        <?php
                                                        $i++;
                                                    }
                                                } else {
                                                    ?><tr><td>No API clients yet!<br />You can create a new API client using the link bellow the table.</td></tr>
                                                <?php } ?>

                                            </tbody>
                                        </table>
                                    </div>           	
                                </div>

                                <br /><br />

                                <div class="wrapper">
                                    <div class="clear_access">
                                        <a href="<?php echo base_url(); ?>api-token-revoke-all">Clear Api access</a>
                                    </div>
                                </div>

                                <br /><br />

                                <div class="wrapper">
                                    <div class="page_head">
                                        <h5>Applications owned by you</h5>
                                    </div>
                                    <h6>Applications owned by you can be managed here. Please refer to the <a href="<?php echo base_url() ?>cms/17/api-documentation">API documentation</a> for a longer explanation about developing and maintaining applications that use the cryptosi API.</h6>
                                    <div class="user_advertisement">
                                        <table>
                                            <tbody>
                                                <tr class="head">
                                                    <th>Api client name</th>
                                                    <th>Url prefix</th>
                                                    <th>Redirect URL</th>
                                                    <th>Access tokens (all time)</th>
                                                    <th>Income (all time)</th>
                                                </tr>
                                                <?php
                                                if (count($arr_client_api) > 0) {
                                                    $i = 1;
                                                    foreach ($arr_client_api as $api_client) {
                                                        $bgcolor = ($i % 2 == 0) ? '#FDFDFF' : '#DCDCE1';
                                                        ?>
                                                        <tr style="background-color: <?php echo $bgcolor; ?>">
                                                            <td><a href="<?php echo base_url(); ?>api-client/<?php echo $api_client['api_id']; ?>"><?php echo $api_client['api_client_name']; ?></a></td>
                                                            <td><?php echo $api_client['url_prefix']; ?></td>
                                                            <td><?php echo $api_client['redirect_url']; ?></td>
                                                            <td><?php echo $api_client['access_tokens']; ?></td>
                                                            <td><?php echo $api_client['income']; ?>BTC</td>
                                                        </tr>                                        
                                                        <?php
                                                        $i++;
                                                    }
                                                } else {
                                                    ?><tr><td>No API clients yet!<br />You can create a new API client using the link above the table.</td></tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <div class="bitadvertise">
                                            <a class="bitbuyadd" href="<?php echo base_url(); ?>api-client"><span>&nbsp;</span>Create an api client</a>
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
</section>