<section id="content" class="cms dashboard user_profile">
    <div class="page_holder">
        <div class="page_inner">
            <div class="page_head">
                <h2><?php echo $arr_user_data['user_name']; ?></h2>                
            </div>
            <div class="wallet_section">
                <div class="send_bitcoin">
                    <div class="send_bitcoin_in invite_friend_in">
                        <div class="page_head">
                            <h5><?php echo lang('information_of'); ?> <?php echo $arr_user_data['user_name']; ?></h5>
							<?php if(isset($arr_user_basic_info)) { ?>
							<div class="overflow-catch">
							<p><?php echo nl2br($arr_user_basic_info['self_introduction']); ?></p>
							</div>
							<?php } ?>
                        </div>
                        <div class="info_send user_info">
                            <div class="info_fieldset greay">
                                <div class="label"><strong><?php echo lang('trade_volume'); ?></strong></div>
                                <div class="label_data"><?php echo lang('less_than'); ?> 25 BTC </div>
                            </div>
                            <div class="info_fieldset white">
                                <div class="label"><strong><?php echo lang('number_of_confirmed_trades'); ?></strong></div>
                                <div class="label_data"><strong><?php echo $confirmed_trade_count;?></strong>…<?php echo lang('with'); ?> <strong>0</strong> <?php echo lang('different_partners'); ?>
                                </div>
                            </div>
                            <div class="info_fieldset greay">
                                <div class="label"><strong><?php echo lang('feedback_score'); ?> </strong></div>
                                <div class="label_data"><strong><?php echo $arr_feedback_count; ?> %</strong></div>
                            </div>
                            <div class="info_fieldset white">
                                <div class="label"><strong><?php echo lang('account_created'); ?></strong></div>
                                <div class="label_data">
                                    <?php echo $arr_date_diff_string; ?> <?php echo lang('ago'); ?>
                                </div>
                            </div>
                            <div class="info_fieldset greay">
                                <div class="label"><strong><?php echo lang('last_seen'); ?></strong></div>
                                <div class="label_data">
                                    <?php echo $arr_last_seen_diff_string; ?> 
                                </div>
                            </div>
                            <div class="info_fieldset white">
                                <div class="label"><strong><?php echo lang('language'); ?></strong></div>
                                <div class="label_data"><?php echo lang('english'); ?></div>
                            </div>
                            <div class="info_fieldset greay">
                                <div class="label"><strong><?php echo lang('email'); ?></strong></div>
                                <?php if ($arr_user_data['email_verified'] == '1') { ?>
                                    <div class="label_data"><span class="verify">&nbsp;</span><?php echo lang('verified'); ?></div>
                                <?php } else { ?>
                                    <div class="label_data"><span class="not_verify">&nbsp;</span><?php echo lang('not_verified'); ?></div>
                                <?php } ?>
                            </div> 
                            <div class="info_fieldset greay">
                                <div class="label"><strong><?php echo lang('trust'); ?></strong></div>
                                <div class="label_data"><?php echo lang('trusted_by'); ?> <strong><?php echo $trusted_count; ?></strong> <?php echo lang('people'); ?></div>
                            </div> 
                            <div class="info_fieldset white">
                                <div class="label"><strong><?php echo lang('block'); ?></strong></div>
                                <div class="label_data"><?php echo lang('blocked_by'); ?> <strong><?php echo $blocked_count; ?></strong> <?php echo lang('people'); ?></div>
                            </div>              	
                        </div>
                    </div>                	
                </div>
				
				
                <?php if ((count($current_user_trust_on_selected) > 0) && (count($selected_user_trust_on_current) > 0)) { ?>

                    <?php if ($current_user_trust_on_selected[0]['status'] == 'T' && $selected_user_trust_on_current[0]['status'] == 'T') { ?>
                        <div class="send_bitcoin right">
                            <div class="send_bitcoin_in">
                                <button class="user_trust">Already trusting <?php echo $arr_user_data['user_name']; ?></button>
                                <p>Already mutually trusting <?php echo $arr_user_data['user_name']; ?></p>
								<p>You can change your standing with the feedback form below.</p>								
								<p>Trust allows you to easily sell bitcoins to everyone you trust, as well as <a href="<?php echo base_url();?>trusted-bitcoins">buy bitcoins from those who trust you</a>. Look out for ads marked with <strong>Trusted only</strong> for special deals. </p>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($current_user_trust_on_selected[0]['status'] == 'T' && $selected_user_trust_on_current[0]['status'] != 'T') { ?>
                        <div class="send_bitcoin right">
                            <div class="send_bitcoin_in">
                                <button class="user_trust">Already trusting <?php echo $arr_user_data['user_name']; ?></button>
                                <p>Already trusting <?php echo $arr_user_data['user_name']; ?>, but <?php echo $arr_user_data['user_name']; ?> does not trust you yet.</p>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($current_user_trust_on_selected[0]['status'] != 'T' && $selected_user_trust_on_current[0]['status'] == 'T') { ?>
                        <form id="frm_update_feedback" name="frm_update_feedback" class="send_bitcoin right" method="post" action="<?php echo base_url(); ?>trusted/feedback/<?php echo $arr_user_list[0]['trust_id']; ?>">
                            <div class="">
                                <div class="send_bitcoin_in">
                                    <button type="submit" class="user_trust" name="rating" value="T" id="rating_5">Trust <?php echo $arr_user_data['user_name']; ?></button>
                                    <p>You do not currently trust <?php echo $arr_user_data['user_name']; ?></p>
                                </div>
                            </div>
                        </form>
                    <?php } ?>
					
					
					<div class="wrapper" style="margin-bottom:10px;">            	
					<div class="user_advertisement">
					<form id="frm_update_feedback" name="frm_update_feedback" method="post" action="<?php echo base_url(); ?>trusted/feedback/<?php echo $arr_user_list[0]['trust_id']; ?>">
						<table class="wallet_transaction" border="1px dotted">
							<tbody>
								<tr class="greay_row">
									<th style="width:100%" colspan="2"><h2>Update your feedback for <?php echo $arr_user_data['user_name']; ?></h2></th>                                
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
								<td><textarea name="feedback" id="feedback" rows="5" cols="182"><?php echo $arr_user_list[0]['feedback_comment']; ?></textarea></td>								
							</tr>
							<tr class="white_row">
								<td>
									<input type="hidden" name="type" id="type" value="U">
                                    <input type="submit" name="btn_register" id="btn_register" value="Update Feedback">
								</td>								
							</tr>							
							</tbody>
						</table>  
					</form>                 
					</div>                      	
				</div>
                    

                <?php } elseif (count($current_user_trust_on_selected) > 0) { ?>

                    <div class="send_bitcoin right">
                        <div class="send_bitcoin_in">
                            <button class="user_trust">Already trusting <?php echo $arr_user_data['user_name']; ?></button>
                            <p>Already trusting <?php echo $arr_user_data['user_name']; ?>, but <?php echo $arr_user_data['user_name']; ?> does not trust you yet.</p>
                        </div>
                    </div>

                <?php } elseif (count($selected_user_trust_on_current) > 0) { ?>

                    <form id="frm_update_feedback" name="frm_update_feedback" class="send_bitcoin right" method="post" action="<?php echo base_url(); ?>trusted/feedbackRequest/<?php echo $selected_user_trust_on_current[0]['trust_id']; ?>">			
                        <div class="">
                            <div class="send_bitcoin_in">
                                <button type="submit" class="user_trust" name="rating" value="T" id="">Trust <?php echo $arr_user_data['user_name']; ?></button>
                                <input type="hidden" name="user_id" id="user_id" value="<?php echo $arr_user_data['user_id']; ?>" />
                                <input type="hidden" name="user_email" id="user_email" value="<?php echo $arr_user_data['user_email']; ?>" />
                                <p>You do not currently trust <?php echo $arr_user_data['user_name']; ?></p>
                            </div>
                        </div>				
                    </form>

                <?php } else { ?>
					
					<?php if($arr_user_data['user_id'] != $user_session['user_id']) { ?>
					<div class="send_bitcoin right">
						<div class="send_bitcoin_in">
							<form id="frm_update_feedback" name="frm_update_feedback" class="" method="post" action="<?php echo base_url(); ?>trusted-contacts/invite-friend">	
								<button type="submit" class="user_trust" name="btn_invite" value="T" id="">Trust <?php echo $arr_user_data['user_name']; ?></button>
								<input type="hidden" name="user_id" id="user_id" value="<?php echo $arr_user_data['user_id']; ?>" />
								<input type="hidden" name="friends_email" id="friends_email" value="<?php echo $arr_user_data['user_email']; ?>" />
								<input type="hidden" name="friends_name" id="friends_name" value="<?php echo $arr_user_data['user_name']; ?>" />
								<p>You do not currently trust <?php echo $arr_user_data['user_name']; ?></p>									                       			
							</form>
						</div>
					</div>	
					<?php } else { ?>
						<div class="send_bitcoin right">
                        	<div class="send_bitcoin_in">
                            	<button class="user_trust">Already trusting <?php echo $arr_user_data['user_name']; ?></button>
                            	<p>It's You</p>
                        	</div>
                    	</div>						
					<?php } ?>
					
				<?php } ?>
				
				
            </div>
			
			<?php if(isset($arrInfo_sell_o)) { ?>			
			<?php if(count($arrInfo_sell_o) > 0) { ?>
			<div class="bitcoins">
				<div class="bitcoins_head">
					<h1>Buy bitcoins online from <?php echo $arr_user_data['user_name']; ?></h1>
					<a class="bitbuyer" href="<?php echo base_url(); ?>profile/<?php echo $arr_user_data['user_name'];?>/buy-bitcoins-online">Show all user's ads to buy bitcoins online </a>				
				</div>
				<div class="current_bitcoin">
					<table class="clickable">
						<tbody>
							<tr class="head">
								<th class="seller_name"><?php echo lang('seller'); ?></th>
								<th class="describe"><?php echo lang('description'); ?></th>
								<th class="price_btc"><?php echo lang('price'); ?>/<?php echo lang('btc'); ?> </th>
								<th class="limits"><?php echo lang('limits'); ?></th>
								<th class="pay_methods"><?php echo lang('payment_method'); ?></th>
								<th class="button_buy"><?php echo lang('action'); ?></th>
							</tr>
							<?php
							for ($i = 0; $i < count($arrInfo_sell_o); $i++) {
								
									?>
									<tr class="<?php
							if (($i % 2) == 0) {
								echo 'white_row';
							} else {
								echo 'greay_row';
							}
									?>">
										<td class="seller_name"><a href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_sell_o[$i]['trade_id']; ?>"><strong><?php echo $arrInfo_sell_o[$i]['user_name']; ?> (<?php echo $arrInfo_sell_o[$i]['confirmed_trade_count'] ?>; 100%)</strong></a></td>
										<td class="describe"><?php echo $arrInfo_sell_o[$i]['method_name']; ?></td>
										<td class="price_btc"><?php if($arrInfo_sell_o[$i]['local_currency_rate'] != '') { echo $arrInfo_sell_o[$i]['local_currency_rate'] . '-' . $arrInfo_sell_o[$i]['local_currency_code']; } ?></td>
										<td class="limits"><?php echo $arrInfo_sell_o[$i]['min_amount'] . '-' . $arrInfo_sell_o[$i]['max_amount']; ?></td>
										<td class="pay_methods"><a href="<?php echo base_url();?>sell-bitcoins-online/<?php echo $arrInfo_sell_o[$i]['method_url'];?>"><?php echo $arrInfo_sell_o[$i]['method_name']; ?></a></td>
										<td class="button_buy"><a class="actbuy" href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_sell_o[$i]['trade_id']; ?>"><? echo lang('buy'); ?></a></td>
									</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			<?php } ?>
			<?php } ?>
			
			<?php if (isset($arrInfo_sell_c)) { ?>
            <?php if (count($arrInfo_sell_c) > 0) { ?>
                <div class="bitcoins">
                    <div class="bitcoins_head">
                        <h1>Buy bitcoins with cash from <?php echo $arr_user_data['user_name']; ?></h1>
                       <a class="bitbuyer" href="<?php echo base_url(); ?>profile/<?php echo $arr_user_data['user_name'];?>/buy-bitcoins-with-cash">Show all user's ads to buy bitcoins with cash </a>
                    </div>
                    <div class="current_bitcoin">
                        <table class="clickable">
                            <tbody>
                                <tr class="head">
                                    <th class="seller_name"><?php echo lang('seller'); ?></th>
                                    <th class="describe"><?php echo lang('distance'); ?></th>
                                    <th class="location"><?php echo lang('location'); ?></th>
                                    <th class="price_btc"><?php echo lang('price'); ?>/<?php echo lang('btc'); ?> </th>
                                    <th class="limits"><?php echo lang('limits'); ?></th>                                
                                    <th class="button_buy"><?php echo lang('action'); ?></th>
                                </tr>
                                <?php for ($i = 0; $i < count($arrInfo_sell_c); $i++) { ?>
                                    <tr class="<?php
									if (($i % 2) == 0) {
										echo 'white_row';
									} else {
										echo 'greay_row';
									}
                                    ?>">                              

                                <td class="seller_name"><a href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_sell_c[$i]['trade_id'] ?>"><strong><?php echo $arrInfo_sell_c[$i]['user_name']; ?> (<?php echo $arrInfo_sell_c[$i]['confirmed_trade_count'] ?>; 100%)</strong></a></td>
                                <td class="describe"><?php echo number_format($arrInfo_sell_c[$i]['distance'], 2, '.', ''); ?>km</td>
                                <td class="location"><?php echo $arrInfo_sell_c[$i]['location']; ?></td>
                                <td class="price_btc"><?php echo $arrInfo_sell_c[$i]['local_currency_rate'] . '-' . $arrInfo_sell_c[$i]['local_currency_code'] ?></td>
                                <td class="limits"><?php echo $arrInfo_sell_c[$i]['min_amount'] . '-' . $arrInfo_sell_c[$i]['max_amount']; ?></td>
                                <td class="button_buy"><a class="actbuy" href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_sell_c[$i]['trade_id'] ?>"><span>&nbsp;</span><? echo lang('buy'); ?></a></td>
                                </tr>
                            <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } ?>                
        <?php } ?>

			
			<?php if(isset($arrInfo_buy_o)) { ?>
			<?php if(count($arrInfo_buy_o) > 0) { ?>
			<div class="bitcoins">
				<div class="bitcoins_head">
					<h1>Sell bitcoins online to <?php echo $arr_user_data['user_name']; ?></h1>
					<a class="bitbuyer" href="<?php echo base_url(); ?>profile/<?php echo $arr_user_data['user_name'];?>/sell-bitcoins-online">Show all user's ads to sell bitcoins online </a>				
				</div>
				<div class="current_bitcoin">
					<table class="clickable">
						<tbody>
							<tr class="head">
								<th class="seller_name"><?php echo lang('buyer'); ?></th>
								<th class="describe"><?php echo lang('description'); ?></th>
								<th class="price_btc"><?php echo lang('price'); ?>/<?php echo lang('btc'); ?> </th>
								<th class="limits"><?php echo lang('limits'); ?></th>
								<th class="pay_methods"><?php echo lang('payment_method'); ?></th>
								<th class="button_buy"><?php echo lang('action'); ?></th>
							</tr>
							<?php
							for ($i = 0; $i < count($arrInfo_buy_o); $i++) {					
									?>
									<tr class="<?php
							if (($i % 2) == 0) {
								echo 'white_row';
							} else {
								echo 'greay_row';
							}
									?>">
										<td class="seller_name"><a href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_buy_o[$i]['trade_id'] ?>"><strong><?php echo $arrInfo_buy_o[$i]['user_name']; ?> (<?php echo $arrInfo_buy_o[$i]['confirmed_trade_count'] ?>; 100%)</strong></a></td>
										<td class="describe"><?php echo $arrInfo_buy_o[$i]['method_name']; ?></td>
										<td class="price_btc"><?php echo $arrInfo_buy_o[$i]['local_currency_rate'] . '-' . $arrInfo_buy_o[$i]['local_currency_code'] ?></td>
										<td class="limits"><?php echo $arrInfo_buy_o[$i]['min_amount'] . '-' . $arrInfo_buy_o[$i]['max_amount']; ?></td>
										<td class="pay_methods"><a href="<?php echo base_url();?>buy-bitcoins-online/<?php echo $arrInfo_buy_o[$i]['method_url'];?>"><?php echo $arrInfo_buy_o[$i]['method_name']; ?></a></td>
										<td class="button_buy"><a class="actbuy" href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_buy_o[$i]['trade_id'] ?>"><? echo lang('sell'); ?></a></td>
									</tr>								
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			<?php } ?>
			<?php } ?>
			
			<?php if (isset($arrInfo_buy_c)) { ?>
            <?php if (count($arrInfo_buy_c) > 0) { ?>
                <div class="bitcoins">
                    <div class="bitcoins_head">
                        <h1>Sell bitcoins with cash to <?php echo $arr_user_data['user_name']; ?></h1>
                       <a class="bitbuyer" href="<?php echo base_url(); ?>profile/<?php echo $arr_user_data['user_name'];?>/sell-bitcoins-with-cash">Show all user's ads to sell bitcoins with cash </a>
                    </div>
                    <div class="current_bitcoin">
                        <table class="clickable">
                            <tbody>
                                <tr class="head">
                                    <th class="seller_name"><?php echo lang('buyer'); ?></th>
                                    <th class="describe"><?php echo lang('distance'); ?></th>
                                    <th class="location"><?php echo lang('location'); ?></th>
                                    <th class="price_btc"><?php echo lang('price'); ?>/<?php echo lang('btc'); ?> </th>
                                    <th class="limits"><?php echo lang('limits'); ?></th>                                
                                    <th class="button_buy"><?php echo lang('action'); ?></th>
                                </tr>
                                <?php for ($i = 0; $i < count($arrInfo_buy_c); $i++) { ?>
                                    <tr class="<?php
									if (($i % 2) == 0) {
										echo 'white_row';
									} else {
										echo 'greay_row';
									}
                                    ?>">

                                <td class="seller_name"><a href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_buy_c[$i]['trade_id'] ?>"><strong><?php echo $arrInfo_buy_c[$i]['user_name']; ?> (<?php echo $arrInfo_buy_c[$i]['confirmed_trade_count'] ?>; 100%)</strong></a></td>
                                <td class="describe"><?php echo number_format($arrInfo_buy_c[$i]['distance'], 2, '.', ''); ?>km</td>
                                <td class="location"><?php echo $arrInfo_buy_c[$i]['location']; ?></td>
                                <td class="price_btc"><?php echo $arrInfo_buy_c[$i]['local_currency_rate'] . '-' . $arrInfo_buy_c[$i]['local_currency_code'] ?></td>
                                <td class="limits"><?php echo $arrInfo_buy_c[$i]['min_amount'] . '-' . $arrInfo_buy_c[$i]['max_amount']; ?></td>
                                <td class="button_buy"><a class="actbuy" href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_buy_c[$i]['trade_id'] ?>"><span>&nbsp;</span><? echo lang('sell'); ?></a></td>
                                </tr>
                            <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } ?>                
        <?php } ?>		
			
            <div class="wallet_section">
                <div class="send_bitcoin">
                    <div class="send_bitcoin_in invite_friend_in">
                        <div class="page_head">
                            <h5><?php echo lang('confirmed_feedback'); ?></h5>
                        </div>
                        <div class="info_send user_info">
							<?php if(count($arr_confirmed_feedback_list) > 0) { ?>
								<?php  foreach($arr_confirmed_feedback_list as $conf_feedback) { ?>                        
									<div class="feedback-row">
										<small><?php echo date('d m,Y H:i:s', strtotime($conf_feedback['updated_on'])); ?></small>
										<p>+ <?php echo nl2br($conf_feedback['feedback_comment']);?></p>
									</div>
									<span><a class="comment" href="<?php echo base_url().'profile/'.$arr_user_data['user_name'].'/feedback/conf';?>"><?php echo lang('see_more_feedback_for'); ?> <?php echo $arr_user_data['user_name']; ?></a></span>
								<?php } ?>
							<?php } else { ?>
                            <span><?php echo $arr_user_data['user_name'].' '; ?><?php echo lang('has_not_yet_feedback_from_anyone_with_considerable_trade_volume'); ?> .</span>
							<?php } ?>
						</div>
                    </div>                	
                </div>
                <div class="send_bitcoin right">
                    <div class="send_bitcoin_in invite_friend_in">
                        <div class="page_head">
                            <h5><?php echo lang('unconfirmed_feedback'); ?></h5>
                        </div>
                        <div class="info_send user_info">
                            <span><?php echo lang('feedback_left_by_users_with_low_trade_volume'); ?>. <?php echo lang('unconfirmed_feedback_doesn_t_affect_the_feedback_score'); ?>.</span>              	
                            <span><a class="comment" href="<?php echo base_url().'profile/'.$arr_user_data['user_name'].'/feedback/unconf';?>"><span>&nbsp;</span><?php echo lang('show_unconfirmed_feedback'); ?> </a></span>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</section>