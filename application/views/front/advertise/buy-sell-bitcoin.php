
<?php if ($arr_trade_bitcoin_details['status'] != 'A') { ?>
    <div class="user_dash">
        <h3><?php echo lang('the_advertisement_is_not_currently_running_because_visible'); ?>.</h3>
    </div>	
<?php } ?>
<?php 
if(($arr_trade_bitcoin_details['trade_type'] == 'buy_c') || ($arr_trade_bitcoin_details['trade_type'] == 'buy_o')) {
	$seller_id = $user_session['user_id'];
	$buyer_id =  $arr_trade_bitcoin_details['user_id'];
}
else
{
	$seller_id = $arr_trade_bitcoin_details['user_id'];
	$buyer_id =  $user_session['user_id'];	
}
?>
<section id="content" class="cms dashboard user_profile">
    <div class="page_holder">
        <div class="page_inner">
            <div class="page_head">
				<?php if($arr_trade_bitcoin_details['trade_type'] == 'sell_o') { ?>
					<h2><?php echo lang('buy_bitcoins_online_in');?> <?php echo $local_currency_name; ?> (<?php echo $local_currency_code; ?>)</h2>					
				<?php } elseif($arr_trade_bitcoin_details['trade_type'] == 'sell_c') { ?>
					<h2><?php echo lang('buy_bitcoins_with_cash');?> <?php echo $local_currency_name; ?> (<?php echo $local_currency_code; ?>)</h2>
				<?php } elseif($arr_trade_bitcoin_details['trade_type'] == 'buy_o') { ?>
					<h2><?php echo lang('sell_bitcoins_online');?>, receive <?php echo $local_currency_name; ?> (<?php echo $local_currency_code; ?>)</h2>
				<?php } elseif($arr_trade_bitcoin_details['trade_type'] == 'buy_c') { ?>
					<h2><?php echo lang('sell_bitcoins_with_cash');?>, receive <?php echo $local_currency_name; ?> (<?php echo $local_currency_code; ?>)</h2>
				<?php } ?>
            </div>
            <div class="wallet_section">
                <div class="send_bitcoin">
                    <div class="send_bitcoin_in invite_friend_in">
                        <div class="page_head">
                            <?php if (($arr_trade_bitcoin_details['trade_type'] == 'buy_c') || ($arr_trade_bitcoin_details['trade_type'] == 'buy_o')) { ?>
                                <h5>Cryptosi.com <?php echo lang('user'); ?> <?php echo $arr_trade_bitcoin_details['user_name']; ?> <?php echo lang('wishes_to_buy_bitcoins_from_you'); ?>.</h5>
                            <?php } else { ?>
								<h5>Cryptosi.com <?php echo lang('user'); ?> <?php echo $arr_trade_bitcoin_details['user_name']; ?> <?php echo lang('wishes_to_sell_bitcoins_to_you'); ?>.</h5>                                
                            <?php } ?>
                        </div>
                        <div class="info_send user_info">
                            <div class="info_fieldset greay">
                                <div class="label"><strong><?php echo lang('price'); ?>:</strong></div>
                                <div class="label_data" id="current_rate"><?php echo $local_currency_rate; ?> <?php echo $local_currency_code; ?> / BTC  </div>
                            </div>
                            <div class="info_fieldset white">
                                <div class="label"><strong><?php echo lang('user'); ?>:</strong></div>
                                <div class="label_data">
                                    <a href="<?php echo base_url(); ?>profile/<?php echo $arr_trade_bitcoin_details['user_name']; ?>"><?php echo $arr_trade_bitcoin_details['user_name']; ?>
										<label class="online-status online-status-<?php echo $last_seen['status'];?>" title="User <?php echo $arr_trade_bitcoin_details['user_name'];?> last seen online <?php echo $last_seen['last_seen'];?>" data-original-title="">
											<i class="icon icon-circle"></i>
										</label>
									
									</a>
									
                                    <div style="font-size: 12px;">(<?php echo lang('feedback_score'); ?> 100 %, <?php echo lang('see_feedback'); ?>) </div>
                                </div>
                            </div>
                            <div class="info_fieldset greay">
                                <div class="label"><strong><?php echo lang('trade_limits'); ?>:</strong></div>
                                <div class="label_data"><?php echo $arr_trade_bitcoin_details['min_amount']; ?> - <?php echo $arr_trade_bitcoin_details['max_amount']; ?> <?php echo $local_currency_code; ?></div>
                            </div>
                            <?php if (($arr_trade_bitcoin_details['trade_type'] == 'sell_o') || ($arr_trade_bitcoin_details['trade_type'] == 'buy_o')) { ?>
                                <div class="info_fieldset white">
                                    <div class="label"><strong><?php echo lang('payment_window'); ?>:</strong></div>
                                    <div class="label_data"><?php echo ($arr_trade_bitcoin_details['payment_window'] != '') ? $arr_trade_bitcoin_details['payment_window'] : '-'; ?> </div>
                                </div>
                            <?php } ?>
                            <div class="info_fieldset greay">
                                <div class="label"><strong><?php echo lang('location'); ?>:</strong></div>
                                <?php $lookup = "lookup-bitcoins/" . trim($arr_trade_bitcoin_details['country']); ?>
                                <div class="label_data"><?php echo $arr_trade_bitcoin_details['location']; ?></div>
                                <?php if ($arr_trade_bitcoin_details['country'] != '') { ?>                           
                                    <?php echo lang('or_look_up'); ?> <a href="<?php echo base_url() . $lookup; ?>"><?php echo lang('other_cities_in'); ?> <?php echo $arr_trade_bitcoin_details['country']; ?></a><?php } ?>
                                <?php if (($user_session['user_id'] != $arr_trade_bitcoin_details['user_id'])) { ?>
									<?php if (($arr_trade_bitcoin_details['trade_type'] == 'buy_c') || ($arr_trade_bitcoin_details['trade_type'] == 'buy_o')) { ?>
											<div class="label"><strong><?php echo lang('how_much_you_wish_to_sell'); ?>?</strong></div>
									<?php } ?>
									<?php if (($arr_trade_bitcoin_details['trade_type'] == 'sell_c') || ($arr_trade_bitcoin_details['trade_type'] == 'sell_o')) { ?>
										<div class="label"><strong><?php echo lang('how_much_you_wish_to_buy'); ?>?</strong></div>										
									<?php } ?>
                                <?php } ?>
                            </div>
							
                            <?php if (($user_session['user_id'] != $arr_trade_bitcoin_details['user_id'])) { ?>
								<?php if($blocked_status == 'N') { ?>
									<?php if($real_name_req == 'N') { ?>
                                <form name="send_trade_request" id="send_trade_request" action="<?php echo base_url(); ?>trade-request" method="post">                        
                                    <div class="info_fieldset white">                                                                        
                                        <div class="label"><?php echo $local_currency_code; ?><input type="text" name="txt_currency_rate" id="txt_currency_rate" min="<?php echo $arr_trade_bitcoin_details['min_amount']; ?>" max="<?php echo $arr_trade_bitcoin_details['max_amount']; ?>" required></div>                                
                                        <div class="label_data">BTC<input type="text"  name="txt_btc_amount" id="txt_btc_amount" value="" required></div>                                
										<input type="hidden" name="margin" id="margin" value="<?php echo $arr_trade_bitcoin_details['price_eq_val']; ?>" />  
                                        <input type="hidden" name="seller_id" id="seller_id" value="<?php echo $seller_id; ?>" />
										<input type="hidden" name="buyer_id" id="buyer_id" value="<?php echo $buyer_id; ?>" />
										<input type="hidden" name="trade_user_id" id="trade_user_id" value="<?php echo $arr_trade_bitcoin_details['user_id']; ?>" />
										<input type="hidden" name="session_user_id" id="session_user_id" value="<?php echo $user_session['user_id']; ?>" />										
                                        <input type="hidden" name="trade_id" id="trade_id" value="<?php echo $arr_trade_bitcoin_details['trade_id']; ?>" />
                                        <input type="hidden" name="transaction_type" id="transaction_type" value="<?php echo $arr_trade_bitcoin_details['trade_type']; ?>" />
                                        <input type="hidden" name="btc_rate_in_usd" id="btc_rate_in_usd" value="<?php echo $btc_rate_in_usd; ?>" />
                                        <input type="hidden" name="local_currency_rate" id="local_currency_rate" value="<?php echo $local_currency_rate; ?>" />
										<input type="hidden" name="currency" id="currency" value="<?php echo $local_currency_code; ?>" />
                                        <?php if ($user_session['user_id'] == '') { ?>
                                            <div class="info_fieldset white sign_up">
                                                <div class="label"><strong><?php echo lang('sign_up_and_buy_bitcoins_instantly'); ?>:</strong></div>
                                                <div class="label_btn">
                                                    <!--<button type="button" name="sign_up"  value="Sign up" id="sign_up" onclick="window.location.href='<?php echo base_url(); ?>signup';"></button>-->

                                                    <button type="button" id="sign_up" onclick="window.location.href='<?php echo base_url(); ?>signup';">Sign up now<?php echo lang(''); ?></button>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php if (($user_session['user_id'] != '')) { ?>
                                            <div class="label_txtarea">
                                                <textarea name="contact_message" id="contact_message" cols="60" rows="5" placeholder="Write your contact message and other information to the trader here...upto 200 characters only (optional)"></textarea>
                                            </div>
                                            <div class="label_btn">
                                                <button type="submit" name="btn_trade_request" id="btn_trade_request" value="Send trade request" ><?php echo lang('send_trade_request'); ?></button>                                    
                                            </div>                                            
                                        <?php } ?>
                                    </div>  

                                    <div class="info_data">
                                        <div class="tabs_slide"> <a class="toggle one" href="javascript:void(0);" id="how_long_sending_takes" onclick="showDiv('contact_trade','one')"><span>&nbsp;</span><?php echo lang('how_to_begin_and_contacting_the_trader'); ?></a>
                                            <div class="tabs_data active" id="contact_trade" style="display:none;">
                                                <p> Open trade requests and message inbox can be found under <a href="<?php echo base_url(); ?>user-dashboard">Dashboard</a> under your user profile page. You can send and receive messages with the trader there.</p>
                                            </div>
                                        </div>
                                        <div class="tabs_slide"> <a class="toggle two" href="javascript:void(0);" id="refund_notice" onclick="showDiv('pay_ol','two')"><span>&nbsp;</span> <?php echo lang('how_to_pay_online'); ?></a>
                                            <div class="tabs_data active" id="pay_ol" style="display:none;">
                                                <p>                                                                                    After sending the trade request you get the payment details.
                                                    Trader may not publish the payment details directly and asks you to contact to get the exact account name needed for the payment. In this case send a Cryptosi.com message to the the trader and ask for the furher details.
                                                    When buying bitcoins online, the payment window is 90 minutes, but this may vary depending on the payment method and the terms of the trade.
                                                    If you need help how to make the payment use Cryptosi.com messaging to discuss with the trader how to make the payment..</p>
                                            </div>
                                        </div>
                                        <div class="tabs_slide"> <a class="toggle three" href="javascript:void(0);" id="refund_notice" onclick="showDiv('cancel_trade','three')" ><span>&nbsp;</span><?php echo lang('cancelling_the_trade'); ?></a>
                                            <div class="tabs_data active" id="cancel_trade" style="display:none;">
                                                <p>You can cancel the trade before making the payment. You find open trades under <a href="<?php echo base_url(); ?>user-dashboard"> Dashboard</a> in your user profile..</p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="share_links">
                                    <div id="fb-root"></div>
                                    <?php echo lang('share_this_add'); ?>
                                    <div class="all_share_links">                                        
                                        <!--<div class="fb-share-button" data-href="<?php echo base_url() . $_SERVER['REQUEST_URI']; ?>" data-type="button_count"></div>-->                                        
                                        <div class="fb-share-button" data-href="<?php echo $_SERVER['REQUEST_URI']; ?>" data-type="button_count"></div>                                        
                                        <div class="g-plus" data-action="share" data-annotation="bubble"></div>
                                        <div class="twitter_s"><a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo base_url() . $_SERVER['REQUEST_URI']; ?>" data-lang="en"><?php echo lang('tweet'); ?></a></div>
                                    </div>
                                </div>
									<?php } else { ?>
										<div class="wallet_section">
											<div class="page_head">
											<h5><a href="<?php echo base_url();?>profile/change-real-name">Ser your real name first</a></h5>					
										</div>	
									<?php } ?>
								<?php } else { ?>
									<div class="wallet_section">
										<div class="page_head">
										<h5 style="color:red;">This user blocked you. You cannot contact him anymore.</h5>					
									</div>
								<?php } ?>							
                            <?php } ?>                            
                        </div>
                    </div>                	
                </div>
                <div class="send_bitcoin right">
                    <div class="send_bitcoin_in">
                        <?php if ((isset($user_session['user_id'])) && ($user_session['user_id'] == $arr_trade_bitcoin_details['user_id'])) { ?>
                            <button class="user_trust"><a href="<?php echo base_url(); ?>advertise-edit/<?php echo base64_encode($arr_trade_bitcoin_details['trade_id']) ?>"><?php echo lang('edit_your_advertisement'); ?></a></button>
                        <?php } else { ?>
                            <div>
                                <h1><?php echo lang('terms_of_trade_with'); ?> <?php echo $arr_trade_bitcoin_details['user_name']; ?></h1>
                                <p><?php echo lang('contact_hours'); ?>: <?php echo $arr_trade_bitcoin_details['contact_hours']; ?></p>
                                <?php if ($arr_trade_bitcoin_details['other_information'] != '') { ?>
                                    <p><?php echo lang('other_information'); ?>: <?php echo (isset($arr_trade_bitcoin_details['other_information'])) ? nl2br($arr_trade_bitcoin_details['other_information']) : ''; ?></p>
                                <?php } ?>
                            </div> 
                        <?php } ?>
                    </div>
                    <?php
                    $to = $global['site_email'];
                    $subject = 'Report advertisement, Trade Id: ' . $arr_trade_bitcoin_details['trade_id'];
                    $body = 'Hello Admin %0D%0A%0D%0ATrade Id:' . $arr_trade_bitcoin_details['trade_id'] . '%0D%0A%0D%0A%0D%0AThanks and Regards';
                    ?>					
                    <a href="mailto:<?php echo $to; ?>?subject=<?php echo $subject; ?>&body=<?php echo $body; ?>"><?php echo lang('report_this_advertisement'); ?></a>
                </div>
            </div>
            <div class="wallet_section">
                <div class="send_bitcoin">
                    <div class="send_bitcoin_in invite_friend_in">                        
                        <?php /* if (($arr_trade_bitcoin_details['sms_verification'] == 'Y') && ($user_session['user_id'] != $arr_trade_bitcoin_details['user_id'])) { ?>
                          <div class="info_send user_info">
                          <span>This seller requires SMS verification before you can make a purchase. <a href="javascript:void(0)">Proceed to phone number verification here.</a></span>
                          </div>
                          <?php } */ ?>
                    </div>                	
                </div>
                <div class="send_bitcoin">
                    <div class="send_bitcoin_in invite_friend_in">                        
                        <div class="info_send user_info">
                            <span></span>              	
                        </div>
                    </div>                	
                </div>
                <div class="send_bitcoin">
                    <div class="send_bitcoin_in invite_friend_in">                                                
                        <div class="info_send user_info">
                            <div class="page_head">
                                <h5><?php echo lang('how_to_proceed'); ?></h5>
                            </div>
                            <span>Submit a trade request using the form above if you want physical cash pickup or delivery or otherwise contact the trader. No hardware needed on your part, just bring the cash and request the verify code from the seller. Funds will be available in your Cryptosi.com wallet. </span>              	
                        </div>
                    </div>                	
                </div>
                <div class="send_bitcoin right">
                    <div class="send_bitcoin_in invite_friend_in">
                        <div class="page_head">
                            <h5><?php echo lang('tips'); ?></h5>
                        </div>
                        <div class="info_send user_info">
                            <span>
                                Read the ad, and check the terms.
                                Propose a meeting place and time when you contact, if physical cash is traded.
                                Watch for fraudsters! Check the profile feedback, and take extra caution with recently created accounts.
                                Note that rounding and price fluctuation might change the final bitcoin amount. The fiat amount you enter matters and bitcoin amount is calculated at the time of request.
                            </span>              	
                            <span></span>
                        </div>

                    </div>
                </div>                
            </div>
            <?php /* <div class="wallet_section">
              <button class="" onclick="showMap()">Show location on map</button>
              <div id="map_div">
              <?php echo 'test div for location map'; ?>
              </div>
              </div> */ ?>
            <!--Similar ads by <a href="<?php echo base_url(); ?>p/<?php echo $arr_trade_bitcoin_details['user_name']; ?>"> <?php echo $arr_trade_bitcoin_details['user_name']; ?></a>-->     
			<?php
				if ($arr_trade_bitcoin_details['trade_type'] == 'buy_o') { 
					$trade_type_method = "buy-bitcoins-online";
				} elseif($arr_trade_bitcoin_details['trade_type'] == 'buy_c') {
					$trade_type_method = "buy-bitcoins-with-cash";
				} elseif($arr_trade_bitcoin_details['trade_type'] == 'sell_0') {
					$trade_type_method = "sell-bitcoins-online";
				} elseif($arr_trade_bitcoin_details['trade_type'] == 'sell_c') {
					$trade_type_method = "sell-bitcoins-with-cash";
				}
			?>		
			
			<div class="wallet_section">
				<div class="page_head">
					<h5>Listing with this ad</h5>					
                </div>
				<p>Didn't find the deal you were looking for? These Cryptosi.com listings have more bitcoin trade deals similar to this one:</p>
				
				<div class="send_bitcoin">
                    <div class="send_bitcoin_in invite_friend_in">                        
                        <div class="info_send user_info">
							<ul>
							<?php
								if ($arr_trade_bitcoin_details['trade_type'] == 'buy_o') { ?>
									<li><a href="<?php echo base_url().$trade_type_method.'/'.$arr_trade_bitcoin_details['method_url'];?>">Buy bitcoins online with <?php echo $arr_trade_bitcoin_details['method_name'];?></a></li>
									<li><a href="<?php echo base_url().$trade_type_method.'/'.$arr_trade_bitcoin_details['method_url'].'/'.$arr_trade_bitcoin_details['currency_id'];?>">Buy bitcoins online with <?php echo $arr_trade_bitcoin_details['method_name'];?> in <?php echo $arr_trade_bitcoin_details['currency_code'];?></a></li>
									<li><a href="<?php echo base_url() . $lookup; ?>">Trade bitcoins in <?php echo $arr_trade_bitcoin_details['country']; ?></a></li> <?php
								} elseif($arr_trade_bitcoin_details['trade_type'] == 'buy_c') { ?>
									<li><a href="<?php echo base_url();?>buy-bitcoins-with-cash">Buy bitcoins with Cash</a></li>
									<li><a href="<?php echo base_url() . $lookup; ?>">Trade bitcoins in <?php echo $arr_trade_bitcoin_details['country']; ?></a></li> <?php
								} elseif($arr_trade_bitcoin_details['trade_type'] == 'sell_0') { ?>
									<li><a href="<?php echo base_url().$trade_type_method.'/'.$arr_trade_bitcoin_details['method_url'];?>">Sell bitcoins online with <?php echo $arr_trade_bitcoin_details['method_name'];?></a></li>
									<li><a href="<?php echo base_url().$trade_type_method.'/'.$arr_trade_bitcoin_details['method_url'].'/'.$arr_trade_bitcoin_details['currency_id'];?>">Buy bitcoins online with <?php echo $arr_trade_bitcoin_details['method_name'];?> in <?php echo $arr_trade_bitcoin_details['currency_code'];?></a></li>
									<li><a href="<?php echo base_url() . $lookup; ?>">Trade bitcoins in <?php echo $arr_trade_bitcoin_details['country']; ?></a></li> <?php
								} elseif($arr_trade_bitcoin_details['trade_type'] == 'sell_c') { ?>
									<li><a href="<?php echo base_url();?>sell-bitcoins-with-cash">Sell bitcoins with cash</a></li>
									<li><a href="<?php echo base_url() . $lookup; ?>">Trade bitcoins in <?php echo $arr_trade_bitcoin_details['country']; ?></a></li> <?php
								}
							?>
							</ul>
                        </div>
                    </div>                	
                </div>
				
			</div>
        </div>
    </div>
</section>
<script type="text/javascript">
    
    function showMap(){  $("#map_div").toggle();}
    
    var active_flag=1; 
    
    function showDiv(div_id,cls){ 

        if(active_flag){
            jQuery("#"+div_id).slideToggle("slow");
            jQuery('.'+cls).addClass("active");
            active_flag =0;
        }else{            
            jQuery("#"+div_id).slideToggle("slow");
            jQuery('.'+cls).removeClass("active");
            active_flag =1;
        }
    }
    
    /*function for bitcoin rate converter*/               
    jQuery(document).ready(function(){
            
        var current_local_currency="<?php echo $local_currency_rate; ?>";
              
        /*local currency TO BTC*/
        jQuery("#txt_currency_rate").keyup(function(){
            console.log('as');
            if(isNaN(jQuery(this).val())){
                alert('Please enter integer value only');
                jQuery(this).val('')
                jQuery(this).val('').focus();
                return false;
            }            
            var current_value=jQuery(this).val();
            var current_calculated_value=(current_value/current_local_currency);            
            current_calculated_value = (Math.round((current_calculated_value*100))/100).toFixed(5);             
            $("#txt_btc_amount").val(current_calculated_value);
        });
        
        /*local BTC TO  local currency*/
        jQuery("#txt_btc_amount").change(function(){

            if(isNaN(jQuery(this).val())){
                alert('Please enter integer value only');
                jQuery(this).val('')
                jQuery(this).val('').focus();
                return false;
            }
            var current_value=jQuery(this).val();
            var current_calculated_value=(current_value*current_local_currency);

            current_calculated_value = (Math.round((current_calculated_value*100))/100).toFixed(2);             
            $("#txt_currency_rate").val(current_calculated_value);
        });
    });
</script>
