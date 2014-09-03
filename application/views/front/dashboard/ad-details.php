<div id="loader" style="display:none;"></div>

<section id="content" class="cms dashboard">
    <div class="user_dash">
        <div class="page_holder">
            <div class="page_inner">
                <div class="user_navi">
                    <ul>
                        <li <?php echo ($menu_active == "user-dashboard") ? 'class="active"' : ""; ?>><a href="<?php echo base_url(); ?>user-dashboard">Dashboard</a><span class="arrow"></span></li>
                        <li><a href="<?php echo base_url(); ?>wallet">Wallet:<span><?php echo exp_to_dec(abs($wallet_balance)); ?> BTC</span><span class="arrow"></span></a></li>
                        <li><a href="<?php echo base_url(); ?>trusted-contacts/invite-friend">Invite friends</a><span class="arrow"></span></li>
                    </ul>
                </div>
            </div>
        </div>    	
    </div>
    <div class="page_holder">
        <div class="page_inner">        	
            <div class="wallet_section post_trade_inner">
                <div class="page_head">
                    <h5>Contact number #<?php echo $arr_trade_request_details['transaction_id']; ?><span>advertisement #<?php echo $arr_trade_request_details['trade_id']; ?></span> <?php if ($arr_trade_request_details['advertiser_id'] == $user_session['user_id']) { ?><span><a href="<?php echo base_url(); ?>advertise-edit/<?php echo base64_encode($arr_trade_request_details['trade_id']); ?>">edit</a></span><?php } ?> </h5>
                </div>
				
				<?php if(($arr_trade_request_details['transaction_status'] == 'released') || ($arr_trade_request_details['transaction_status'] == 'cancelled')) { ?>
				<div class="wrapper" style="margin-bottom:10px;">            	
					<div class="user_advertisement">
					<form id="frm_update_feedback" name="frm_update_feedback">
						<table class="wallet_transaction" border="1px dotted">
							<tbody>
								<tr class="greay_row">
									<th style="width:100%" colspan="2"><h2>Update your feedback for <?php echo $update_for;?></h2></th>                                
							</tr>
							<tr class="green_row">
								<td>
									<label for="rating_1">
										<input type="radio" name="rating" value="T" id="rating_1" <?php if ($arr_user_list[0]['status'] == 'T') echo "checked"; ?> />
                                        Trustworthy
									</label>
									<small> Leave positive feedback, as described below, and also include the trader on your trusted traders list. This allows the person to access your <strong>Trusted only</strong> advertisements. </small>
								</td>								
							</tr>
							<tr class="green_row">
								<td>
									<label for="rating_2">
                                    	<input type="radio" name="rating" value="P" id="rating_2" <?php if ($arr_user_list[0]['status'] == 'P') echo "checked"; ?> />
                                        Positive
									</label>
									<small>The trade was satisfactory. The trader gets positive feedback on the profile page.</small>
								</td>                                                         
							</tr>
							<tr class="white_row">
								<td>
									<label for="rating_3">
                                    	<input type="radio" name="rating" value="N" id="rating_3" <?php if ($arr_user_list[0]['status'] == 'N') echo "checked"; ?> />
                                        Neutral
									</label>
									<small>The experience with this trader could be improved.</small>
								</td>								                                                         
							</tr>
							<tr class="red_row">
								<td>
									<label for="rating_4">
                                    	<input type="radio" name="rating" value="D" id="rating_4" <?php if ($arr_user_list[0]['status'] == 'D') echo "checked"; ?>/>
                                        Distrust and block
									</label>
									<small>The trader is blocked and cannot contact you anymore. Leave a message why you blocked the trader.</small>
								</td>								
							</tr>
							<tr class="red_row">
								<td>
									<label for="rating_5">
                                    	<input type="radio" name="rating" value="B" id="rating_5" <?php if ($arr_user_list[0]['status'] == 'B') echo "checked"; ?>/>
                                        Block without feedback
									</label>
									<small>The trader is blocked and cannot contact you anymore, score not affected.</small>
								</td>
							</tr>
							<tr class="greay_row">
								<td>Feedback message (optional):</td>
							</tr>
							<tr class="white_row">
								<td><textarea name="feedback" id="feedback" rows="5"><?php echo $arr_user_list[0]['feedback_comment']; ?></textarea></td>								
							</tr>
							<tr class="white_row">
								<td>
									<?php $type = ($arr_trade_request_details['btc_amount'] < '0.0001') ? 'U' : 'C'; ?>
									<?php $trade_volume = ($arr_trade_request_details['btc_amount'] < '0.0001') ? 'Low volume' : ''; ?>
									<input type="hidden" name="type" id="type" value="<?php echo $type;?>">
									<input type="hidden" name="trade_volume" id="trade_volume" value="<?php echo $trade_volume;?>">
									<input type="hidden" name="trust_id" id="trust_id" value="<?php echo $arr_user_list[0]['trust_id']; ?>">
									<?php $invitation_to_user_id = ($user_session['user_id'] == $arr_trade_request_details['buyer_id']) ? $arr_trade_request_details['seller_id'] : $arr_trade_request_details['buyer_id']; ?>
									<input type="hidden" name="invitaion_to" id="invitaion_to" value="<?php echo $invitation_to_user_id; ?>">
                                    <input type="submit" name="btn_register" id="btn_register" value="Update Feedback">
								</td>								
							</tr>							
							</tbody>
						</table>  
					</form>                 
					</div>                      	
				</div>
				<?php } ?>
				
                <div class="send_bitcoin">
                    <div class="send_bitcoin_in">
                        <div class="page_head">
                            <?php
                            $send_sms_to = ($user_session['user_id'] == $arr_trade_request_details['buyer_id']) ? $arr_seller_data['user_name'] : $arr_buyer_data['user_name'];
                            ?>
                            <h5>Send message to <span><?php echo $send_sms_to; ?></span></h5>
                        </div>

                        <div class="banner_form_data">
                            <div class="formdata">                        	
                                <form name="frm_trade_msg" id="frm_trade_msg"  method="post" action="">                            	
                                    <fieldset>                                	
                                        <textarea rows="5" onfocus="if(this.value=='Enter your message')this.value='';" onblur="if(this.value=='')this.value='Enter your message';" name="contact_message" id="contact_message">Enter your message</textarea>
                                    </fieldset>                                                             
                                    <fieldset class="button">
                                        <div class="bitadvertise">
                                            <input  class="bitbuyadd" type="submit" name="send_trade_msg" id="send_trade_msg" value="Send">
											
                                            <input  type="hidden" name="trade_id" id="trade_id" value="<?php echo $arr_trade_request_details['trade_id']; ?>">                                            
                                            <input  type="hidden" name="transaction_id" id="transaction_id" value="<?php echo $arr_trade_request_details['transaction_id']; ?>">                                            
                                            <input  type="hidden" name="msg_from_user_id" id="msg_from_user_id" value="<?php echo $user_session['user_id']; ?>">  
                                            <?php $msg_to_user_id = ($user_session['user_id'] == $arr_trade_request_details['buyer_id']) ? $arr_trade_request_details['seller_id'] : $arr_trade_request_details['buyer_id']; ?>
                                            <input type="hidden" name="msg_to_user_id" id="msg_to_user_id" value="<?php echo $msg_to_user_id; ?>">                                                                                                                                    
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
						
						<?php foreach($arr_trade_chat_details as $chat) { ?>
						<div class="info_send">
                            <div class="message_box" style="background:none repeat scroll 0 0 #FBFBD9;">
								<small><?php echo date('d M,Y H:i:s', strtotime($chat['created_on']));?></small>
                                <p><strong><?php echo $chat['user_name']; ?></strong> : <?php echo nl2br($chat['contact_message']); ?></p>
                            </div>
                        </div>
						<?php } ?>
						
                        <div class="info_send">
                            <div class="message_box">
                                <p><span class="info_blue">&nbsp;</span>myBitcoins.com cannot offer protection for direct bitcoin transfers; consider the risk and using <a href="<?php echo base_url();?>ads/detailed-info/<?php echo base64_encode($arr_trade_request_details['trade_id']); ?>/<?php echo base64_encode($arr_trade_request_details['transaction_id']);?>">myBitcoins.com escrow and transaction services</a> if someone is asking you to transfer bitcoins directly to a bitcoin address.</p>
                            </div>
                            <span><span class="info_blue">&nbsp;</span> Never give your email or phone number to an unknown trade partner. </span>                        <span>No links outside Cryptosi.com allowed. Please use Attach document to include images in the conversation.</span>
                            <span>myBitcoins.com retains the messages 90 days after closing the trade.</span>
                        </div>
                    </div>                	
                </div>
                <div class="send_bitcoin right">
				
				<?php $buy_or_sell = ($user_session['user_id'] == $arr_trade_request_details['buyer_id']) ? 'buying' : 'selling'; ?>
                <?php $form_or_to_username = ($user_session['user_id'] == $arr_trade_request_details['buyer_id']) ? $arr_seller_data['user_name'] : $arr_buyer_data['user_name']; ?>
                <?php $form_or_to = ($user_session['user_id'] == $arr_trade_request_details['buyer_id']) ? 'from' : 'to'; ?>
				<?php $escrow_status = ($arr_trade_request_details['escrow_status'] == 'E') ? 'enabled' : 'disabled'; ?>
				
				
				<?php 
					if($arr_trade_request_details['seller_funded'] == 'N')
					{
						$transaction_status = 'Not funded';	
					}
					elseif($arr_trade_request_details['seller_funded'] == 'F')
					{
						$transaction_status = 'funded';	
					}
					elseif($arr_trade_request_details['seller_funded'] == 'R')
					{
						$transaction_status = 'released';	
					}
				?>
				
				<?php
					/* Calculate escrow fee */
					if($arr_trade_request_details['escrow_status'] == 'E')
					{
						$escrow_fee = 0.0001;
					}
					else
					{
						$escrow_fee = 0.00;
					}		
				
					/* Calculate fee amount */
					if($user_session['user_id'] == $arr_trade_request_details['advertiser_id'])
					{
						$fee_amount = ($global['admin_fee_percent']/100)*$arr_trade_request_details['btc_amount'];									
					}
					else
					{
						$fee_amount = 0.00;
					}							
					
					/* Calculate btc amount */
					if($user_session['user_id'] == $arr_trade_request_details['buyer_id'])
					{
						$btc_amount = $arr_trade_request_details['btc_amount'];
						if($arr_trade_request_details['buyer_id'] == $arr_trade_request_details['advertiser_id']) {
							$final_btc_amount = $btc_amount - $fee_amount;
							$buyer_send_amount = exp_to_dec(abs($final_btc_amount));
						} else {
							$final_btc_amount = $btc_amount;
							$buyer_send_amount = exp_to_dec(abs($final_btc_amount));
						}
					}
					if($user_session['user_id'] == $arr_trade_request_details['seller_id'])
					{
						$btc_amount = $arr_trade_request_details['btc_amount'];
						if($arr_trade_request_details['seller_id'] == $arr_trade_request_details['advertiser_id']) {
							$final_btc_amount = $btc_amount + $fee_amount + $escrow_fee;
							$escrow_pay_amount = exp_to_dec(abs($final_btc_amount));
							$buyer_send_amount = exp_to_dec(abs($arr_trade_request_details['btc_amount']));
						} else {
							$final_btc_amount = $btc_amount + $fee_amount + $escrow_fee;
							$escrow_pay_amount = exp_to_dec(abs($final_btc_amount));
							$buyer_send_amount = exp_to_dec(abs($btc_amount - (($global['admin_fee_percent']/100)*$arr_trade_request_details['btc_amount'])));						
						}
					}
					
				
				?>
				

				<?php if(($arr_trade_request_details['transaction_status'] == 'closed') || ($arr_trade_request_details['transaction_status'] == 'cancelled')) { ?>
					<div class="send_bitcoin_in" id="alert_info">	
						<div class="info_send">
							<span>Escrow status : <strong><?php echo $arr_trade_request_details['transaction_status']; ?> by <?php echo $arr_trade_request_details['action_taken_user'];?>.</strong></span>
							
							<span style="font-size:28px;font-weight:bold;">Contact is no longer active</span>
							<span><strong><?php echo $arr_trade_request_details['action_taken_user'];?> have cancelled the contact.</strong></span>
							<span><a href="<?php echo base_url();?>wallet">The possible transaction funds have been returned to your Cryptosi.com wallet.</a></span>
							
						</div>
					</div>
				<?php } ?>
				
				<?php if($arr_trade_request_details['transaction_status'] == 'pending') { ?>
                    <?php if($buy_or_sell == 'buying') { ?>
						<div class="send_bitcoin_in">	
							<div class="info_send">
								<?php if($escrow_status == 'enabled') { ?>
								<span>Escrow status : <strong>Escrow <?php echo $escrow_status; ?> <?php if($transaction_status == 'funded'){echo 'and '.$transaction_status;} if($transaction_status == 'Not funded'){echo 'but '.$transaction_status.'. Waiting for bitcoins';} ?></strong></span>
								<?php } ?>
														
								<span>You are buying <?php echo $buyer_send_amount; ?> BTC with <?php echo $arr_trade_request_details['fiat_currency']; ?> <?php echo $arr_currency_details['currency_code']; ?> from <a href="<?php echo base_url();?>profile/<?php echo $arr_seller_data['user_name']?>"> <?php echo $arr_seller_data['user_name']; ?></a>.</span>
								<a class="bitbuyadd" target="_blank" href="<?php echo base_url();?>contact-receipt/<?php echo $arr_trade_request_details['transaction_id'];?>"><span class="print_icon">&nbsp;</span>Print receipt</a>
								
								<?php if($arr_trade_request_details['seller_funded'] == 'N') { ?>
									<span>Transaction status: <strong style="color:red;"><?php echo $transaction_status;?>. Seller should fund transaction.</strong></span>
								<?php } ?>
								<?php if($arr_trade_request_details['seller_funded'] == 'F') { ?>
									<span>Transaction status: <strong><?php echo $transaction_status;?>, not Released</strong></span>
								<?php } ?>								
								<?php if($arr_trade_request_details['seller_funded'] == 'R') { ?>
									<span>Transaction status: <strong><?php echo $transaction_status;?>.</strong></span>
								<?php } ?>
								
								<span>Transaction verify code: <strong><?php echo $arr_trade_request_details['verify_code']; ?></strong></span>
								<span>Memorize or write down your transaction verify code, and don't tell it to anybody else. After the seller shows you the verify code, you can be sure that the transaction funds have been irreversibly sent to you.</span>
								
								<?php if($arr_trade_request_details['seller_funded'] != 'R') { ?>
								<form name="frm_cancel_deal" id="frm_cancel_deal" method="post" action="<?php echo base_url(); ?>cancel-deal">
                                    <button type="submit" class="bitbuyadd cancel" name="btn_cancel" id="btn_cancel" value="cancel_deal">Cancel / Close deal</button>
                                    
									<input type="hidden" name="trade_id" id="trade_id" value="<?php echo $arr_trade_request_details['trade_id']; ?>" />
                                    <input type="hidden" name="transaction_id" id="transaction_id" value="<?php echo $arr_trade_request_details['transaction_id']; ?>" />
									<?php if($arr_trade_request_details['seller_funded'] == 'F') { ?>
									<input type="hidden" name="refundable_amount" id="refundable_amount" value="<?php echo $arr_trade_request_details['btc_amount']; ?>" />
									<input type="hidden" name="return_wallet_address" id="return_wallet_address" value="<?php echo $wallet_deatils['wallet_address']; ?>" />
									<?php } ?>
                                </form>
								<?php } ?>
								
								<?php if($escrow_status == 'enabled'){ ?>
									<?php if(($arr_trade_request_details['seller_funded'] == 'F') || ($arr_trade_request_details['seller_funded'] == 'R')) { ?>									
										<div class="message_box green">
                        				<p><span class="red_close_icon">&nbsp;</span> Escrow is enabled. Only the buyer or Cryptosi.com staff can cancel the transaction.
</p>
										</div>									
									<?php } else { ?>
										<div class="message_box red">
                        				<p><span class="red_close_icon">&nbsp;</span> Escrow is enabled. Only the buyer or Cryptosi.com staff can cancel the transaction.
</p>
										</div>
									<?php } ?>			
								<?php } ?>
								
								<?php if($escrow_status == 'disabled'){ ?>
									<div class="message_box red">
                        				<p><span class="red_close_icon">&nbsp;</span>Escrow is not enabled. Not recommended to use online payment. You can request the seller to enable the escrow.</p>
									</div>			
								<?php } ?>
								  
							</div>							
							<div class="info_send">
                            <div class="terms_info">
                                <div class="page_head">
                                    <h5>myBitcoins local cash transactions terms and info</h5>
                                </div>
                                <ul>
                                    <li>Buyer doesn't need a device at all - confirm successful transaction with verify code</li>
                                    <li>Seller can release the transaction using a message, a smartphone or a laptop</li>
                                    <li>Both parties can cancel the trade at any time before release, no fees in case of cancellation</li>
                                    <li>Released transaction is non-reversible</li>
                                    <li>No fees for the contacter.</li>
                                    <li>Build your reputation from succesful trades</li>
                                    <li>Using the transaction service is not compulsory.</li>
                                    <li>mybitcoins.com SMS numbers: +0123456789, +0215455454</li>
                                    <li>Please do not use with online transfers! Enable escrow for that.</li>
                                </ul>
                            </div>
                        </div>
                        	<div class="info_send">
                            <div class="terms_info">
                                <div class="page_head">
                                    <h5>myBitcoins escrow terms and info</h5>
                                </div>
                                <ul>
                                    <li>Safe to use when traders want to use online payment method instead of meeting.</li>
                                    <li>When enabled, only the buyer and mybitcoins staff can cancel the deal.</li>
                                    <li>mybitcoins staff can start researching cancellation requests 48 hours after funding.</li>
                                    <li>In dispute cases, mybitcoins.com staff will research the evidence supplied by the trade participants.</li>
                                </ul>
                            </div>
                        </div>
						
						</div>							
					<?php } ?>
					
					<?php if($buy_or_sell == 'selling') { ?>
					<div class="send_bitcoin_in">
						<div class="info_send">
							<?php if($escrow_status == 'enabled') { ?>
							<span>Escrow status : <strong>Escrow <?php echo $escrow_status; ?> <?php if($arr_trade_request_details['seller_funded'] == 'F'){echo 'and '.$transaction_status;} if($arr_trade_request_details['seller_funded'] == 'N'){echo 'but '.$transaction_status.'. Waiting for bitcoins';} ?></strong></span>
							<?php } ?>
							<br />
							<span><a href="<?php echo base_url();?>profile/<?php echo $arr_buyer_data['user_name']?>"> <?php echo $arr_buyer_data['user_name']; ?></a> wants to buy bitcoins with <?php echo $arr_trade_request_details['fiat_currency']; ?> <?php echo $arr_currency_details['currency_code']; ?>. </span>
							<a class="bitbuyadd" target="_blank" href="<?php echo base_url();?>contact-receipt/<?php echo $arr_trade_request_details['transaction_id'];?>"><span class="print_icon">&nbsp;</span>Print receipt</a>
							<br />				
							
							<?php if($arr_trade_request_details['seller_funded'] == 'R') { ?>
								<span>Transaction status: <strong><?php echo $transaction_status; ?>.</strong></span>
															
							<?php } elseif($arr_trade_request_details['seller_funded'] == 'F') { ?>
								<span>Transaction status: <strong><?php echo $transaction_status; ?>, not Released</strong></span>
								
								<div class="banner_form_data">
									<div class="formdata">                        	
										<form name="frm_escrow_release" id="frm_escrow_release"  method="post" action="">
											<fieldset class="button">
												<div class="bitadvertise">
													<input  class="bitbuyadd" type="submit" name="escrow_release" id="escrow_release" value="Release escrow">
													<input  type="hidden" name="transaction_id" id="transaction_id" value="<?php echo $arr_trade_request_details['transaction_id']; ?>">																
													<input type="hidden" name="escrow_wallet_address" id="escrow_wallet_address" value="<?php echo $arr_trade_request_details['escrow_wallet_address']; ?>" />													
													<input  type="hidden" name="escrow_transaction_id" id="escrow_transaction_id" value="<?php echo $arr_trade_request_details['escrow_transaction_id']; ?>">
													<input  type="hidden" name="btc_amount" id="btc_amount" value="<?php echo $buyer_send_amount;?>">								
													
													<input  type="hidden" name="buyer_user_id" id="buyer_user_id" value="<?php echo $arr_trade_request_details['buyer_id'];?>">											
												</div>
											</fieldset>
										</form>
									</div>
									<span>By clicking above link you can release escrow amount <strong><?php echo $buyer_send_amount; ?></strong> BTC</span>
								</div>
								
							<?php } elseif($arr_trade_request_details['seller_funded'] == 'N') { ?>
								<span>Transaction status: <strong style="color:red;"><?php echo $transaction_status; ?>. Seller should fund the transaction.</strong></span>
								
								<?php if(($user_account['user_wallet_balance']) < $escrow_pay_amount) { ?>
								<span> To fund the transaction, send at least <strong><?php echo exp_to_dec(abs($escrow_pay_amount - $wallet_balance)); ?></strong> BTC to your Cryptosi wallet address <strong><?php echo $wallet_deatils['wallet_address']; ?></strong></span>									
								<?php } else { ?>
								
								<div class="banner_form_data">
									<div class="formdata">                        	
										<form name="frm_escrow_payment" id="frm_escrow_payment"  method="post" action="">
											<fieldset class="button">
												<div class="bitadvertise">
													<input  class="bitbuyadd" type="submit" name="escrow_payment" id="escrow_payment" value="Make an escrow payment">
													<input  type="hidden" name="transaction_id" id="transaction_id" value="<?php echo $arr_trade_request_details['transaction_id']; ?>">																
													<input type="hidden" name="escrow_wallet_address" id="escrow_wallet_address" value="<?php echo $arr_trade_request_details['escrow_wallet_address']; ?>" />													
													<input  type="hidden" name="escrow_transaction_id" id="escrow_transaction_id" value="<?php echo $arr_trade_request_details['escrow_transaction_id']; ?>">
													<input  type="hidden" name="btc_amount" id="btc_amount" value="<?php echo $escrow_pay_amount;?>">											
												</div>
											</fieldset>
										</form>
									</div>
									<span>By clicking above link you can send <strong><?php echo $final_btc_amount; ?></strong> BTC for your current escrow transaction.<br /></span>
								</div>
								
								<?php } ?>
								
							<?php } else { ?>
								
									<span>Transaction status: <strong>Pending.</strong></span>
									<span> To fund the transaction, send at least <strong><?php echo exp_to_dec(abs($escrow_pay_amount - $wallet_balance)); ?></strong> BTC to your Cryptosi wallet address <strong><?php echo $wallet_deatils['wallet_address']; ?></strong></span>
								
							<?php } ?>
							
							
							<span>LocalBitcoins requires three confirmations from the bitcoin network for incoming transactions.</span>
							
							<?php if($arr_trade_request_details['seller_funded'] != 'R') { ?>
							<form name="frm_cancel_deal" id="frm_cancel_deal" method="post" action="<?php echo base_url(); ?>cancel-deal">
                            	<button type="submit" class="bitbuyadd cancel" name="btn_cancel" id="btn_cancel" value="cancel_deal">Cancel / Close deal</button>
                                
                                <input type="hidden" name="transaction_id" id="transaction_id" value="<?php echo $arr_trade_request_details['transaction_id']; ?>" />
								<input type="hidden" name="trade_id" id="trade_id" value="<?php echo $arr_trade_request_details['trade_id']; ?>" />
								<?php if($arr_trade_request_details['seller_funded'] == 'F') { ?>
								<input type="hidden" name="refundable_amount" id="refundable_amount" value="<?php echo $arr_trade_request_details['btc_amount']; ?>" />
								<input type="hidden" name="return_wallet_address" id="return_wallet_address" value="<?php echo $wallet_deatils['wallet_address']; ?>" />
								<?php } ?>
                            </form>
							<?php } ?>
							
							
							<?php if($escrow_status == 'enabled'){ ?>
								<?php if(($arr_trade_request_details['seller_funded'] == 'F') || ($arr_trade_request_details['seller_funded'] == 'R')) { ?>									
									<div class="message_box green">
									<p><span class="red_close_icon">&nbsp;</span> Escrow is enabled. Only the buyer or Cryptosi.com staff can cancel the transaction.
</p>
									</div>									
								<?php } else { ?>
									<div class="message_box red">
									<p><span class="red_close_icon">&nbsp;</span>Escrow is enabled. Only the buyer or Cryptosi.com staff can cancel the transaction.
</p>
									</div>
								<?php } ?>		
							<?php } ?>
								
							<?php if($escrow_status == 'disabled'){ ?>
								<div class="message_box red">
                        			<p><span class="red_close_icon">&nbsp;</span> Escrow is not enabled. You can turn it on with the button below. When enabled, only buyer or LocalBitcoins staff are able to cancel the transaction.</p>
									<a href="<?php echo base_url();?>contact-enable-escrow/<?php echo $arr_trade_request_details['transaction_id']; ?>" class="bitbuyadd cancel">Enable escrow</a>
								</div>			
							<?php } ?>
							
							
							<div class="info_send">
                            <div class="terms_info">
                                <div class="page_head">
                                    <h5>myBitcoins local cash transactions terms and info</h5>
                                </div>
                                <ul>
                                    <li>Buyer doesn't need a device at all - confirm successful transaction with verify code</li>
                                    <li>Seller can release the transaction using a message, a smartphone or a laptop</li>
                                    <li>Both parties can cancel the trade at any time before release, no fees in case of cancellation</li>
                                    <li>Released transaction is non-reversible</li>
                                    <li>No fees for the contacter.</li>
                                    <li>Build your reputation from succesful trades</li>
                                    <li>Using the transaction service is not compulsory.</li>
                                    <li>mybitcoins.com SMS numbers: +0123456789, +0215455454</li>
                                    <li>Please do not use with online transfers! Enable escrow for that.</li>
                                </ul>
                            </div>
                        </div>
                        	<div class="info_send">
                            <div class="terms_info">
                                <div class="page_head">
                                    <h5>myBitcoins escrow terms and info</h5>
                                </div>
                                <ul>
                                    <li>Safe to use when traders want to use online payment method instead of meeting.</li>
                                    <li>When enabled, only the buyer and mybitcoins staff can cancel the deal.</li>
                                    <li>mybitcoins staff can start researching cancellation requests 48 hours after funding.</li>
                                    <li>In dispute cases, mybitcoins.com staff will research the evidence supplied by the trade participants.</li>
                                </ul>
                            </div>
                        </div>
							
						</div>
					</div>
					<?php } ?>
				
				<?php } ?>
				
				<?php if($arr_trade_request_details['transaction_status'] == 'released') { ?>
				
					<div class="send_bitcoin_in">
						<div class="info_send">
							<?php if($user_session['user_id'] == $arr_trade_request_details['seller_id']) { ?>
								<span>Escrow status : <strong>Bitcoins released, trade finished</strong></span>
								<br />
								<span><a href="<?php echo base_url();?>profile/<?php echo $arr_trade_request_details['buyer_id']?>"> <?php echo $arr_buyer_data['user_name']; ?></a> wants to buy bitcoins with <?php echo $arr_trade_request_details['fiat_currency']; ?> <?php echo $arr_currency_details['currency_code']; ?>. </span>
								<a class="bitbuyadd" target="_blank" href="<?php echo base_url();?>contact-receipt/<?php echo $arr_trade_request_details['transaction_id'];?>"><span class="print_icon">&nbsp;</span>Print receipt</a>
								<br />
								<span>Transaction status : <strong>Bitcoins released to buyer.</strong></span>
								<span>The bitcoins have been sent to the customer. Please leave feedback with the form above.</span>
								<span>Transaction verify code: <strong><?php echo $arr_trade_request_details['verify_code']; ?></strong></span>
							<?php } ?>
							
							<?php if($user_session['user_id'] == $arr_trade_request_details['buyer_id']) { ?>
								<span>Escrow status : <strong>Bitcoins released, trade finished</strong></span>
								<br />
								<span>You are buying <?php echo $buyer_send_amount; ?> BTC with <?php echo $arr_trade_request_details['fiat_currency']; ?> <?php echo $arr_currency_details['currency_code']; ?> from <a href="<?php echo base_url();?>profile/<?php echo $arr_trade_request_details['seller_id']?>"> <?php echo $arr_seller_data['user_name']; ?></a>.</span>		
								<a class="bitbuyadd" target="_blank" href="<?php echo base_url();?>contact-receipt/<?php echo $arr_trade_request_details['transaction_id'];?>"><span class="print_icon">&nbsp;</span>Print receipt</a>
									
								<span>Transaction status: <strong>Funded & Released</strong></span>
								<span><a href="<?php echo base_url();?>wallet">The bitcoins are in your Cryptosi.com wallet.</a> Transaction verrify code: <strong><?php echo $arr_trade_request_details['verify_code']; ?></strong> </span>
								<br />
								<div class="message_box green">
									<p><span class="red_close_icon">&nbsp;</span> Contact is closed</p>
								</div>				
							<?php } ?>													
							
							<div class="info_send">
                            <div class="terms_info">
                                <div class="page_head">
                                    <h5>myBitcoins local cash transactions terms and info</h5>
                                </div>
                                <ul>
                                    <li>Buyer doesn't need a device at all - confirm successful transaction with verify code</li>
                                    <li>Seller can release the transaction using a message, a smartphone or a laptop</li>
                                    <li>Both parties can cancel the trade at any time before release, no fees in case of cancellation</li>
                                    <li>Released transaction is non-reversible</li>
                                    <li>No fees for the contacter.</li>
                                    <li>Build your reputation from succesful trades</li>
                                    <li>Using the transaction service is not compulsory.</li>
                                    <li>mybitcoins.com SMS numbers: +0123456789, +0215455454</li>
                                    <li>Please do not use with online transfers! Enable escrow for that.</li>
                                </ul>
                            </div>
                        </div>
                        	<div class="info_send">
                            <div class="terms_info">
                                <div class="page_head">
                                    <h5>myBitcoins escrow terms and info</h5>
                                </div>
                                <ul>
                                    <li>Safe to use when traders want to use online payment method instead of meeting.</li>
                                    <li>When enabled, only the buyer and mybitcoins staff can cancel the deal.</li>
                                    <li>mybitcoins staff can start researching cancellation requests 48 hours after funding.</li>
                                    <li>In dispute cases, mybitcoins.com staff will research the evidence supplied by the trade participants.</li>
                                </ul>
                            </div>
                        </div>
							
						</div>
					</div>
				
				<?php } ?>
					                	
                </div>
            </div>
            <div class="wrapper">            	
                <div class="user_advertisement">
                    <table class="wallet_transaction">
                        <tbody>
                            <tr class="greay_row">
                                <th style="width:100%" colspan="2"><h2>Detailed Info</h2></th>                                
                        </tr>
                        <tr class="white_row">
                            <td>Advertiser</td>
                            <?php
                            $advertiser_name = ($arr_buyer_data['user_id'] == $arr_trade_request_details['advertiser_id']) ? $arr_buyer_data['user_name'] : $arr_seller_data['user_name'];
                            ?>
                            <td><a href="<?php echo base_url(); ?>profile/<?php echo $advertiser_name; ?>"><?php echo $advertiser_name; ?></a></td>                                                            
                        </tr>
                        <tr class="greay_row">
                            <td>Contacted advertisement</td>
                            <td><a href="<?php echo base_url();?>buy-sell-bitcoin/<?php echo $arr_trade_request_details['trade_id']; ?>">Advertisement #<?php echo $arr_trade_request_details['trade_id']; ?></a></td>                                                              
                        </tr>
                        <tr class="white_row">
                            <td>Deal type</td>
                            <td>You are BUYING BTC for <?php echo $arr_currency_details['currency_code']; ?></td>                                                            
                        </tr>
                        <tr class="greay_row">
                            <td>Deal amount</td>
                            <td><?php echo $arr_trade_request_details['fiat_currency']; ?> <?php echo $arr_currency_details['currency_code']; ?> = <?php echo $arr_trade_request_details['btc_amount']; ?> BTC </td>                                                              
                        </tr>
                        <tr class="white_row">
                            <td>Price </td>
                            <td><?php echo $arr_trade_request_details['local_currency_rate']; ?> <?php echo $arr_currency_details['currency_code']; ?>/BTC </td>                                                            
                        </tr>
                        <tr class="greay_row">
                            <td>Transaction status</td>
                            <td><?php echo $arr_trade_request_details['transaction_status']; ?>.</td>                                                              
                        </tr>						
						<tr class="white_row">
							<?php if($arr_trade_request_details['transaction_status']=='released') { ?>
	                            <td colspan="2">**) When transaction is released, verify code will be sent to your email</td>
							<?php } else { ?>
								<td colspan="2">*) Cryptosi.com transaction use costs 1% of trade sum</td>
							<?php } ?>
                        </tr>                                                                           
                        </tbody>
                    </table>                    
                </div>                      	
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

<script type="text/javascript">
$(document).ready(function(){
	/* Online chat between buyer and seller for submission */
	$('#frm_trade_msg').submit(function() {  
	 // check to show that all form data is being submitted
		$.post("<?php echo base_url(); ?>send-reply-to-trade-request",$(this).serialize(),function(data){
			//alert(data); //check to show that the calculation was successful
			location.reload();
		});
		return false; // return false to stop the page submitting. You could have the form action set to the same PHP page so if people dont have JS on they can still use the form
	});
	
	/* Escrow payment transaction */
	$('#frm_escrow_payment').submit(function() { 
		$('#loader').show();
	 // check to show that all form data is being submitted
		$.post("<?php echo base_url(); ?>make-escrow-payment",$(this).serialize(),function(data){
			//alert(data); //check to show that the calculation was successful
			$('#loader').hide();
			location.reload();
		});
		return false; // return false to stop the page submitting. You could have the form action set to the same PHP page so if people dont have JS on they can still use the form
	});
	
	/* Escrow release transaction */
	$('#frm_escrow_release').submit(function() {
		$('#loader').show();
	 // check to show that all form data is being submitted
		$.post("<?php echo base_url(); ?>make-escrow-release",$(this).serialize(),function(data){
			//alert(data); //check to show that the calculation was successful
			$('#loader').hide();
			location.reload();
		});
		return false; // return false to stop the page submitting. You could have the form action set to the same PHP page so if people dont have JS on they can still use the form
	});
	
	
	/* Feedback updated for user */
	$('#frm_update_feedback').submit(function() {
		$('#loader').show();
	 // check to show that all form data is being submitted
		$.post("<?php echo base_url(); ?>trusted/feedback",$(this).serialize(),function(data){
			 //check to show that the calculation was successful
			$('#loader').hide();
			location.reload();
		});
		return false; // return false to stop the page submitting. You could have the form action set to the same PHP page so if people dont have JS on they can still use the form
	});
	
	
	
	
});
</script>

