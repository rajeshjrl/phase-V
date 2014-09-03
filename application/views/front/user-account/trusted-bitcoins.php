<script type="text/javascript">

    $(document).ready(function(e){        
        jQuery("#frm_invite_frnd").validate({     
            errorClass: "text-danger",               
            rules:{                
                friends_email:{
                    required:true,
                    email:true
                },                
                friends_name:{
                    required:true
                }                
            },
            messages:{
                friends_email:{
                    required:"Please enter your friends email address.",
                    email:"Please enter valid email address."
                },                   
                friends_name:{
                    required:"Please enter your friends name."
                }                   
            }        
        });
    });
</script>
<div class="page_holder">
    <div class="page_inner">
        <div class="page_head">
            <h2><?php echo lang('trusted_people'); ?></h2>
            <div class="dashbord_nav">
                <ul>
                    <li><a href="<?php echo base_url(); ?>trusted-contacts/invite-friend"><?php echo lang('your_trusted_people'); ?></a></li>
                    <li <?php echo ($menu_active == "trusted-ads") ? 'class="active"' : ""; ?>><a href="<?php echo base_url(); ?>trusted-bitcoins"><?php echo lang('your_trusted_advertisements'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>cms/17/faq"><?php echo lang('more_about_the_trust_system'); ?> </a></li>
                </ul>
            </div>
            <br /><br />
            <h6 style="font-size: 14px;margin-top: 5px;">
                <?php echo lang('these_advertisements_marked_as_trusted_only'); ?>. <?php echo lang('to_see_your_own_advertisements_visit'); ?> <a href="<?php echo base_url(); ?>user-dashboard"><?php echo lang('dashboard'); ?></a>. 
            </h6>
        </div>
        <div class="wrapper">
            <div class="page_head">
                <h5><?php echo lang('buy_bitcoins_from_people_who_trust_you'); ?></h5>
            </div>
            <div class="user_advertisement">
                <table>
                    <tbody>
                        <tr class="head">
                            <th><?php echo lang('seller'); ?></th>
                            <th><?php echo lang('description'); ?> (<?php echo lang('location'); ?>)</th>
                            <th><?php echo lang('price'); ?>/BTC</th>   
                            <th><?php echo lang('amount'); ?></th>
                            <th><?php echo lang('payment_method'); ?></th>                          
                        </tr>
                        <?php if (count($arr_trade_trusted_sell) > 0) { ?>
                            <?php
                            foreach ($arr_trade_trusted_sell as $trade) {

                                /* API used to get the current market price of BTC */
                                $post_data = "https://bitpay.com/api/rates";
                                $currencyRateArr = file_get_contents($post_data);
                                $currencyRateArr = json_decode($currencyRateArr);
                                if ($trade['currency_code'] != '') {
                                    foreach ($currencyRateArr as $rateArr)
                                        if ($rateArr->code == $trade['currency_code']) {
                                            $trade['local_currency_rate'] = $rateArr->rate;
                                            $trade['local_currency_code'] = $rateArr->code;
                                        }
                                }
                                ?>
                                <tr>
                                    <td><a href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $trade['trade_id']; ?>"><?php echo $trade['user_name']; ?></a></td>
                                    <td><?php echo $trade['location']; ?></td>
                                    <td><?php echo $trade['local_currency_rate'] . '-' . $trade['local_currency_code'] ?></td> 
                                    <td><?php echo $trade['min_amount'] . '-' . $trade['max_amount']; ?></td>
                                    <td><?php
                        if ($trade['trade_type'] == 'sell_o') {
                            echo 'Sell online';
                        } else {
                            echo 'Sell local';
                        }
                                ?></td>                            
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td><?php echo lang('no_trusted_ads_available'); ?>.<br/><?php echo lang('the_people_that_trust_you_have_no_ads_available_for_selling_bitcoin_right_now'); ?>.</td>
                            </tr>
                        <?php } ?>                           
                    </tbody>
                </table>                   
            </div>
            <div class="page_head">
                <h5><?php echo lang('sell_bitcoins_to_people_you_trust'); ?></h5>
            </div>
            <div class="user_advertisement">
                <table>
                    <tbody>
                        <tr class="head">
                            <th><?php echo lang('buyer'); ?></th>
                            <th><?php echo lang('description'); ?> (<?php echo lang('location'); ?>)</th>
                            <th><?php echo lang('price'); ?>/BTC</th>   
                            <th><?php echo lang('amount'); ?></th>
                            <th><?php echo lang('payment_method'); ?></th>                          
                        </tr>
                        <?php if (count($arr_trade_trusted_buy) > 0) { ?>
                            <?php
                            foreach ($arr_trade_trusted_buy as $trade) {

                                /* API used to get the current market price of BTC */
                                $post_data = "https://bitpay.com/api/rates";
                                $currencyRateArr = file_get_contents($post_data);
                                $currencyRateArr = json_decode($currencyRateArr);

                                if ($trade['currency_code'] != '') {
                                    foreach ($currencyRateArr as $rateArr)
                                        if ($rateArr->code == $trade['currency_code']) {
                                            $trade['local_currency_rate'] = $rateArr->rate;
                                            $trade['local_currency_code'] = $rateArr->code;
                                        }
                                }
                                ?>
                                <tr>
                                    <td><a href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $trade['trade_id']; ?>"><?php echo $trade['user_name']; ?></a></td>
                                    <td><?php echo $trade['location']; ?></td>
                                    <td><?php echo $trade['local_currency_rate'] . '-' . $trade['local_currency_code'] ?></td> 
                                    <td><?php echo $trade['min_amount'] . '-' . $trade['max_amount']; ?></td>
                                    <td><?php
                        if ($trade['trade_type'] == 'buy_o') {
                            echo 'Buy online';
                        } else {
                            echo 'Buy local';
                        }
                                ?></td>                            
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td><?php echo lang('no_trusted_ads_available'); ?>.<br /><?php echo lang('the_people_you_trust_don_t_have_any_advertisements_to_buy_bitcoins_right_now'); ?>.</td>
                            </tr>
                        <?php } ?>          
                    </tbody>
                </table>                   
            </div>            	
        </div>
    </div>
</div>
</section>