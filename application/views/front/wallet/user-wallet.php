<div class="user_dash">
	<div class="page_holder">
		<div class="page_inner">
			<div class="user_navi">
				<ul>
					<li <?php echo ($menu_active == "user-dashboard") ? 'class="active"' : ""; ?>><a href="<?php echo base_url(); ?>user-dashboard"><?php echo lang('dashboard'); ?></a><span class="arrow"></span></li>
					<li <?php echo ($menu_active == "wallet") ? 'class="active"' : ""; ?>><a href="<?php echo base_url(); ?>wallet">Wallet:<span> <?php echo (($wallet_balance));?> BTC</span></a><span class="arrow"></span></li>
					<li <?php echo ($menu_active == "trusted") ? 'class="active"' : ""; ?>><a href="<?php echo base_url(); ?>trusted-contacts/invite-friend">Invite friends</a><span class="arrow"></span></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<section id="content" class="cms dashboard">
    <div class="page_holder">
        <div class="page_inner">
            <div class="wallet_section">
                <div class="send_bitcoin">
                    <div class="send_bitcoin_in">
                        <div class="page_head">
                            <h5><?php echo lang('send_bitcoins'); ?></h5>                            
                        </div>                       
                        <div class="info_send"> <span><?php echo lang('this_is_your'); ?> <?php echo $global['site_title']; ?> <?php echo lang('bitcoin_wallet'); ?>.</span>
                          <!--<p>Please note: myBitcoins.com outgoing transactions can have currently issues. Delays can happen when withdrawing bitcoins. We are trying to solve the issue. <a href="https://bitcoinfoundation.org/blog/?p=422" target="_blank">Read more here</a></p>-->
                            <p></p>
                            <span><?php echo lang('spendable_balance'); ?>: <strong><?php echo exp_to_dec(abs($wallet_balance)); ?></strong> BTC</span>
                            <input type="hidden" name="user_wallet_balance" id="user_wallet_balance" value="<?php echo $wallet_balance; ?>">
                        </div>
                        <div class="banner_form_data">
                            <div class="formdata">
                                <form name="frm_send_bitcoin" id="frm_send_bitcoin" action="<?php echo base_url(); ?>send-bitcoin" method="post">
                                    <fieldset>
                                        <label><?php echo lang('receiving_bitcoin_address'); ?>:</label>
                                        <input type="text" placeholder="Bitcoins address" name="rec_bitcoin_address" id="rec_bitcoin_address">
                                    </fieldset>
                                    <fieldset>
                                        <label><?php echo lang('amount_in_bitcoins'); ?>:</label>
                                        <input type="text" placeholder="0.00000" name="btc_amt" id="btc_amt" required>
                                    </fieldset>
                                    <fieldset>
                                        <label><?php echo lang('your_password'); ?></label>
                                        <input type="password" placeholder="Password" name="password" id="password" required>
                                    </fieldset>
									<fieldset>
                                        <label><?php echo lang('description'); ?></label>
                                        <input type="text" placeholder="Description" name="description" id="description" required>
                                    </fieldset>
                                    <fieldset>
                                        <span><?php echo lang('please_confirm_the_send_with_your_password'); ?></span>
                                    </fieldset>
									<fieldset>
                                        <div class="tabs_slide"> <a class="toggle" href="javascript:void(0);" id="refund_notice"><span>&nbsp;</span>More Options</a>
                                    		<div class="tabs_data active" id="refund_notice_toggle_box" style="display:none;">
                                        		<input type="text" placeholder="0.00" name="txt_currency_rate" id="txt_currency_rate" required><span>&nbsp;</span>
												<select id="currency" name="currency">
													<?php foreach($currency as $rate) { ?>
														<option value="<?php echo $rate['rate'];?>"><?php echo $rate['code'];?></option>
													<?php } ?>
												</select>
                                    		</div>
                                		</div>
										
                                    </fieldset>
                                    <fieldset class="button">
                                        <div class="bitadvertise"><button type="submit" class="bitbuyadd" name="btn_submit" id="btn_submit" value="Send from wallet"><span>&nbsp;</span><?php echo lang('send_from_wallet'); ?></button></div>
                                    </fieldset>

                                </form>
                            </div>
                        </div>
                        <div class="info_send"> <span><?php echo lang('after_you_have_sent_the_list_below'); ?></span>
                            <div class="info_data">
                                <div class="tabs_slide"> <a class="toggle" href="javascript:void(0);" id="how_long_sending_takes"><span>&nbsp;</span><?php echo lang('how_long_sending_confirm_the_transfer'); ?>?</a>
                                    <div class="tabs_data active" id="how_long_sending_takes_box" style="display:none;">
                                        <p>Please read our short guide about how bitcoin transactions works and how you can confirming when the bitcoin transaction has reached the receiving wallet.</p>
                                    </div>
                                </div>
                                <div class="tabs_slide"> <a class="toggle" href="javascript:void(0);" id="refund_notice"><span>&nbsp;</span><?php echo lang('refund_notice'); ?></a>
                                    <div class="tabs_data active" id="refund_notice_toggle_box" style="display:none;">
                                        <p>Your Cryptosi wallet is a web wallet - outgoing bitcoins transfers are not necessarily connected to receiving addresses for the users. If you are asking for a refund from a merchant, please provide the receiving bitcoin address separately.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="send_bitcoin right">
                    <div class="send_bitcoin_in">
                        <div class="page_head">
                            <h5><?php echo lang('receive_bitcoins'); ?></h5>
                        </div>
                        <div class="info_send"	> <span><?php echo lang('give_out_the_bitcoin_address_below_to_receive_bitcoins'); ?>. </span>
                            <?php
                            $i = 0;
                            foreach ($wallet_deatils as $wallet) {
                                if ($i == 0) {
                                    ?>			
                                    <p><a href="https://blockchain.info/address/<?php echo $wallet['wallet_address']; ?>?filter=2" target="_blank"><?php echo $wallet['wallet_address']; ?></a></p>			
                                    <?php
                                } $i++;
                            }
                            ?>
                        </div>
                        <div class="info_send">
                            <div class="info_data">
                                <div class="tabs_slide"> <a class="toggle" href="javascript:void(0);" id="new_address"><span>&nbsp;</span><?php echo lang('new_address'); ?></a>
                                    <div class="tabs_data active" id="new_address_toggle_box" style="display:none;">
                                        <p>Please read our short guide about how bitcoin transactions works and how you can confirming when the bitcoin transaction has reached the receiving wallet.
                                        <div class="bitadvertise"> <a class="bitbuyadd" href="<?php echo base_url(); ?>wallet/new"><span>&nbsp;</span><?php echo lang('request_a_new_wallet'); ?></a> </div>
                                        </p>
                                    </div>
                                </div>
                                <div class="tabs_slide"> <a class="toggle" href="javascript:void(0);"  id="old_address"><span>&nbsp;</span><?php echo lang('old_address'); ?></a> 
                                    <div class="tabs_data active" id="old_address_toggle_box" style="display:none;">
                                        <div style="width:100%; border-bottom: 1px solid; border-top: 1px solid;" >
                                            <div style="width:35%;display:inline-block;"><b><?php echo lang('created'); ?></b></div>
                                            <div style="width:60%;display:inline-block;"><b><?php echo lang('address'); ?></b></div>
                                        </div>
                                        <div style="width:100%;">
                                            <?php
                                            $i = 0;
                                            foreach ($wallet_deatils as $wallet) {
                                                ?>
                                                <div style="width:35%;display:inline-block;"><?php echo date($global['date_format'], strtotime($wallet['created_on'])); ?></div>
                                                <div style="width:60%;display:inline-block;"><p><a href="https://blockchain.info/address/<?php echo $wallet['wallet_address']; ?>?filter=2" target="_blank"><?php echo $wallet['wallet_address']; ?></a></p></div>				
                                            <?php }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="tabs_slide"> <a class="toggle" href="javascript:void(0);" id="incoming_transaction"><span>&nbsp;</span><?php echo lang('incoming_transaction'); ?><?php echo lang(''); ?></a> 
                                    <div class="tabs_data active" id="incoming_transaction_box" style="display:none;">
                                        <p><?php echo lang('you_can_also_check_the_status_of_your_incoming_transaction_on'); ?> <a href="https://blockchain.info" target="_blank" >blockchain.info</a>, <?php echo lang('a_third_party_website_to_show_bitcoin_network_status'); ?>.
                                        </p>
                                    </div>
                                </div>
                                <div class="tabs_slide"> <a class="toggle" href="javascript:void(0);" id="how_long_receiving_takes"><span>&nbsp;</span><?php echo lang('how_long_receiving_takes'); ?>?</a> 
                                    <div class="tabs_data active"  id="how_long_receiving_takes_box" style="display:none;">
                                        <p>Cryptosi considers transaction to be confirmed after three (3) <a href="https://en.bitcoin.it/wiki/Confirmation" target="_blank">confirmations </a> from bitcoin network. How fast the transaction is processed depends up on the paid transaction network fee. Usually this ranges from minutes up to one hour.</p>
                                    </div>
                                </div>
                                <!--<div class="tabs_slide"> <a class="toggle" href="javascript:void(0);"><span>&nbsp;</span>Mobile integration</a> </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrapper">
                <div class="page_head">
                    <h5><?php echo lang('wallet_transactions'); ?></h5>
                </div>
                <div class="user_advertisement">
                    <table class="wallet_transaction">
                        <tbody>
                            <tr class="head">
                                <th width="5%"></th>
                                <th width="20%"><?php echo lang('date'); ?></th>
                                <th width="20%"><?php echo lang('received_btc'); ?></th>
                                <th width="20%"><?php echo lang('sent_btc'); ?></th>
                                <th width="25%"><?php echo lang('description'); ?></th>
                            </tr>
							<?php
							if(count($wallet_transation_details['txs']) > 0) {
							$i = 0;
							foreach($wallet_transation_details['txs'] as $trans) { ?>
                            <tr class="<?php
								if (($i % 2) == 0) {
									echo 'white_row';
								} else {
									echo 'greay_row';
								}
								?>">
                                <td><?php echo $trans['tr_type'];?></td>
                                <td><?php echo date('d M,Y H:i:s',$trans['date'])?></td>
                                <td><?php if($trans['received'] != '') { echo exp_to_dec(abs($trans['received']/100000000)); } else { echo '';}?></td>
                                <td><?php if($trans['sent'] != '') { echo exp_to_dec(abs($trans['sent']/100000000)); } else { echo ''; }?></td>
                                <td><?php echo $trans['discription'];?></td>
                            </tr>
							<?php $i++; }
							} else { ?>
							<tr><td colspan="5">No transaction found</td></tr>
							<?php } ?>                         
                            <tr class="head">
                                <th></th>
                                <th></th>
                                <th><?php echo lang('total_received_btc'); ?></th>
                                <th><?php echo lang('total_sent_btc'); ?></th>
                                <th></th>
                            </tr>
                            <tr class="greay_row">
                                <td></td>
                                <td></td>
                                <td><?php echo exp_to_dec(abs($wallet_transation_details['total_received']/100000000)); ?></td>
                                <td><?php echo exp_to_dec(abs($wallet_transation_details['total_sent']/100000000)); ?></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="page_head">
                    <!--<h5><?php echo lang('earlier_months'); ?></h5>		-->			
                </div>
					<!--<?php 
						foreach(array_keys($montharr) as $year)
						{
							foreach($montharr[$year] as $month)
							{
								?>
									<span><a target="_blank" href="<?php base_url();?>wallet-transations-monthly/<?php echo $year;?>/<?php echo $month;?>"> <?php print "{$year}-{$month}";?> </a></span>
								<?php
						    }
						}					
					?>-->
            </div>
        </div>
    </div>
</section>
<?php 
function exp_to_dec($float_str)
{
    // make sure its a standard php float string (i.e. change 0.2e+2 to 20)
    // php will automatically format floats decimally if they are within a certain range
    $float_str = (string)((float)($float_str));

    // if there is an E in the float string
    if(($pos = strpos(strtolower($float_str), 'e')) !== false)
    {
        // get either side of the E, e.g. 1.6E+6 => exp E+6, num 1.6
        $exp = substr($float_str, $pos+1);
        $num = substr($float_str, 0, $pos);
       
        // strip off num sign, if there is one, and leave it off if its + (not required)
        if((($num_sign = $num[0]) === '+') || ($num_sign === '-')) $num = substr($num, 1);
        else $num_sign = '';
        if($num_sign === '+') $num_sign = '';
       
        // strip off exponential sign ('+' or '-' as in 'E+6') if there is one, otherwise throw error, e.g. E+6 => '+'
        if((($exp_sign = $exp[0]) === '+') || ($exp_sign === '-')) $exp = substr($exp, 1);
        else trigger_error("Could not convert exponential notation to decimal notation: invalid float string '$float_str'", E_USER_ERROR);
       
        // get the number of decimal places to the right of the decimal point (or 0 if there is no dec point), e.g., 1.6 => 1
        $right_dec_places = (($dec_pos = strpos($num, '.')) === false) ? 0 : strlen(substr($num, $dec_pos+1));
        // get the number of decimal places to the left of the decimal point (or the length of the entire num if there is no dec point), e.g. 1.6 => 1
        $left_dec_places = ($dec_pos === false) ? strlen($num) : strlen(substr($num, 0, $dec_pos));
       
        // work out number of zeros from exp, exp sign and dec places, e.g. exp 6, exp sign +, dec places 1 => num zeros 5
        if($exp_sign === '+') $num_zeros = $exp - $right_dec_places;
        else $num_zeros = $exp - $left_dec_places;
       
        // build a string with $num_zeros zeros, e.g. '0' 5 times => '00000'
        $zeros = str_pad('', $num_zeros, '0');
       
        // strip decimal from num, e.g. 1.6 => 16
        if($dec_pos !== false) $num = str_replace('.', '', $num);
       
        // if positive exponent, return like 1600000
        if($exp_sign === '+') return $num_sign.$num.$zeros;
        // if negative exponent, return like 0.0000016
        else return $num_sign.'0.'.$zeros.$num;
    }
    // otherwise, assume already in decimal notation and return
    else return $float_str;
}
?>
<script>
    jQuery(document).ready(function(){	
        /*  New Address */
        var new_address=1;
        jQuery("#new_address").click(function(){
            if(new_address){
                jQuery(this).addClass("active");	
                new_address=0;
            }else{
                jQuery(this).removeClass("active");
                new_address=1;
            }		
            jQuery("#new_address_toggle_box").slideToggle("slow");		
        });
		
        /*  Old Address */
        var old_address=1;
        jQuery("#old_address").click(function(){
            if(old_address){
                jQuery(this).addClass("active");	
                old_address=0;
            }else{
                jQuery(this).removeClass("active");
                old_address=1;
            }
            jQuery("#old_address_toggle_box").slideToggle("slow");		
        });
		
        /* incoming transaction */
        var incoming_transaction=1;
        jQuery("#incoming_transaction").click(function(){
            if(incoming_transaction){
                jQuery(this).addClass("active");	
                incoming_transaction=0;
            }else{
                jQuery(this).removeClass("active");
                incoming_transaction=1;
            }
            jQuery("#incoming_transaction_box").slideToggle("slow");		
        });
		
		
        /* How Long receiving takes */
        var how_long_receiving_takes=1;
        jQuery("#how_long_receiving_takes").click(function(){
            if(how_long_receiving_takes){
                jQuery(this).addClass("active");	
                how_long_receiving_takes=0;
            }else{
                jQuery(this).removeClass("active");
                how_long_receiving_takes=1;
            }
            jQuery("#how_long_receiving_takes_box").slideToggle("slow");		
        });
		
        /* How Long sending takes */
        var how_long_sending_takes=1;
        jQuery("#how_long_sending_takes").click(function(){
            if(how_long_sending_takes){
                jQuery(this).addClass("active");	
                how_long_sending_takes=0;
            }else{
                jQuery(this).removeClass("active");
                how_long_sending_takes=1;
            }
            jQuery("#how_long_sending_takes_box").slideToggle("slow");		
        });
		
        /* Refund notice */
        var refund_notice=1;
        jQuery("#refund_notice").click(function(){
            if(refund_notice){
                jQuery(this).addClass("active");	
                refund_notice=0;
            }else{
                jQuery(this).removeClass("active");
                refund_notice=1;
            }
            jQuery("#refund_notice_toggle_box").slideToggle("slow");		
        });	
    });

		  
	/*local currency TO BTC*/
	jQuery("#txt_currency_rate").keyup(function(){
		var current_local_currency=jQuery("#currency").val();
		var current_value=jQuery(this).val();
		var current_calculated_value=(current_value/current_local_currency);            
		current_calculated_value = (Math.round((current_calculated_value*100))/100).toFixed(4);             
		$("#btc_amt").val(current_calculated_value);
	});
	
	/*local BTC TO  local currency*/
	jQuery("#btc_amt").keyup(function(){
		var current_local_currency=jQuery("#currency").val();
		var current_value=jQuery(this).val();
		var current_calculated_value=(current_value*current_local_currency);
		current_calculated_value = (Math.round((current_calculated_value*100))/100).toFixed(2);             
		$("#txt_currency_rate").val(current_calculated_value);
	});
	
	/*local BTC TO  local currency*/
	jQuery("#currency").change(function(){
		var current_local_currency=jQuery("#currency").val();
		var current_value=jQuery("#btc_amt").val();
		var current_calculated_value=(current_value*current_local_currency);
		current_calculated_value = (Math.round((current_calculated_value*100))/100).toFixed(2);             
		$("#txt_currency_rate").val(current_calculated_value);
	});
	
</script>

