<section id="content" class="cms dashboard user_profile">
    <div class="page_holder">
        <div class="page_inner">
            <div class="page_head">
				<?php if($trade_type_method == 'sell-bitcoins-online') { ?>                	
					<h2><?php echo lang('sell_bitcoins_online_to');?> <?php echo $arr_user_data['user_name']; ?></h2>
					<div class="overflow-catch">
						<p> Cryptosi.com user <?php echo $arr_user_data['user_name']; ?> is <?php echo lang('buying_bitcoins');?>. Here you find public online sell trade advertisements of the user. </p>
					</div>             
				<?php } elseif($trade_type_method == 'buy-bitcoins-online') { ?>
					<h2><?php echo lang('buy_bitcoins_online_from');?> <?php echo $arr_user_data['user_name']; ?></h2>
					<div class="overflow-catch">
						<p> Cryptosi.com user <?php echo $arr_user_data['user_name']; ?> is <?php echo lang('selling_bitcoins');?>. Here you find public online sell trade advertisements of the user. </p>
					</div> 			
				<?php } elseif($trade_type_method == 'sell-bitcoins-with-cash') { ?>
					<h2><?php echo lang('sell_bitcoins_with_cash_to');?> <?php echo $arr_user_data['user_name']; ?></h2>
					<div class="overflow-catch">
						<p> Cryptosi.com user <?php echo $arr_user_data['user_name']; ?> is <?php echo lang('buying_bitcoins');?>. Here you find public online sell trade advertisements of the user. </p>
					</div>				
				<?php } elseif($trade_type_method == 'buy-bitcoins-with-cash') { ?>
					<h2><?php echo lang('buy_bitcoins_with_cash_from');?> <?php echo $arr_user_data['user_name']; ?></h2>
					<div class="overflow-catch">
						<p> Cryptosi.com user <?php echo $arr_user_data['user_name']; ?> is <?php echo lang('selling_bitcoins');?>. Here you find public online sell trade advertisements of the user. </p>
					</div>				
				<?php } ?>
            </div>	
			
			
			
			<?php if(($trade_type_method == 'sell-bitcoins-online') || ($trade_type_method == 'buy-bitcoins-online')) { ?>
			
			<?php if(isset($arrInfo_buy_or_sell)) { ?>			
			<?php if(count($arrInfo_buy_or_sell) > 0) { ?>
			<div class="bitcoins">
				<div class="bitcoins_head">
					<h1></h1>
					<a href="<?php echo base_url();?>profile/<?php echo $arr_user_data['user_name'];?>">View Cryptosi.com user <?php echo $arr_user_data['user_name']; ?>'s profile.</a>						
				</div>
				<div class="current_bitcoin">
					<table class="clickable">
						<tbody>
							<tr class="head">
								<th class="seller_name"><?php if($trade_type_method == 'sell-bitcoins-online') { echo lang('buyer'); } else { echo lang('seller'); } ?></th>
								<th class="describe"><?php echo lang('description'); ?></th>
								<th class="price_btc"><?php echo lang('price'); ?>/<?php echo lang('btc'); ?> </th>
								<th class="limits"><?php echo lang('limits'); ?></th>
								<th class="pay_methods"><?php echo lang('payment_method'); ?></th>
								<th class="button_buy"><?php echo lang('action'); ?></th>
							</tr>
							<?php
							for ($i = 0; $i < count($arrInfo_buy_or_sell); $i++) {
								
									?>
									<tr class="<?php
							if (($i % 2) == 0) {
								echo 'white_row';
							} else {
								echo 'greay_row';
							}
									?>">
										<td class="seller_name"><a href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_buy_or_sell[$i]['trade_id']; ?>"><strong><?php echo $arrInfo_buy_or_sell[$i]['user_name']; ?> (<?php echo $arrInfo_buy_or_sell[$i]['confirmed_trade_count'] ?>; 100%)</strong></a></td>
										<td class="describe"><?php echo $arrInfo_buy_or_sell[$i]['method_name']; ?></td>
										<td class="price_btc"><?php echo $arrInfo_buy_or_sell[$i]['local_currency_rate'] . '-' . $arrInfo_buy_or_sell[$i]['local_currency_code'] ?></td>
										<td class="limits"><?php echo $arrInfo_buy_or_sell[$i]['min_amount'] . '-' . $arrInfo_buy_or_sell[$i]['max_amount']; ?></td>
										<td class="pay_methods"><a href="<?php echo base_url().$trade_type_method.'/'.$arrInfo_buy_or_sell[$i]['method_url'];?>"><?php echo $arrInfo_buy_or_sell[$i]['method_name']; ?></a></td>
										<?php if($trade_type_method == 'sell-bitcoins-online') { ?>
											<td class="button_buy"><a class="actbuy" href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_buy_or_sell[$i]['trade_id']; ?>"><? echo lang('sell'); ?></a></td>
										<?php } else { ?>
											<td class="button_buy"><a class="actbuy" href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_buy_or_sell[$i]['trade_id'] ?>"><? echo lang('buy'); ?></a></td>
										<?php } ?>
									</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>				
			</div>
			<p><?php echo $links; ?></p>
			<?php } else { ?>
				<p class="well" id="payment-method-filter">
					<strong>Currently this user does not have active advertisements in this category.</strong>
				</p>			
			<?php } } ?>
			
			<?php } ?>
			
			<?php if(($trade_type_method == 'sell-bitcoins-with-cash') || ($trade_type_method == 'buy-bitcoins-with-cash')) { ?>
			
			<?php if (isset($arrInfo_buy_or_sell)) { ?>
            <?php if (count($arrInfo_buy_or_sell) > 0) { ?>
                <div class="bitcoins">
                    <div class="bitcoins_head">
                        <h1></h1>
                       <a href="<?php echo base_url();?>profile/<?php echo $arr_user_data['user_name'];?>">View Cryptosi.com user <?php echo $arr_user_data['user_name']; ?>'s profile.</a>
                    </div>
                    <div class="current_bitcoin">
                        <table class="clickable">
                            <tbody>
                                <tr class="head">
                                    <th class="seller_name"><?php if($trade_type_method == 'sell-bitcoins-with-cash') { echo lang('buyer'); } else { echo lang('seller'); } ?></th>
                                    <th class="describe"><?php echo lang('distance'); ?>Distance</th>
                                    <th class="location"><?php echo lang('location'); ?>Location</th>
                                    <th class="price_btc"><?php echo lang('price'); ?>/<?php echo lang('btc'); ?> </th>
                                    <th class="limits"><?php echo lang('limits'); ?></th>                                
                                    <th class="button_buy"><?php echo lang('action'); ?></th>
                                </tr>
                                <?php for ($i = 0; $i < count($arrInfo_buy_or_sell); $i++) { ?>
                                    <tr class="<?php
									if (($i % 2) == 0) {
										echo 'white_row';
									} else {
										echo 'greay_row';
									}
                                    ?>">
                                <div id="marker_<?php echo $arrInfo_buy_or_sell[$i]['trade_id']; ?>" style="display:none;text-align:left;">
                                    <?php echo $arrInfo_buy_or_sell[$i]['user_name']; ?><br />
                                    <?php echo number_format($arrInfo_buy_or_sell[$i]['distance'], 2, '.', ''); ?>km<br />
                                    <?php echo $arrInfo_buy_or_sell[$i]['location']; ?><br />
                                    <?php echo $arrInfo_buy_or_sell[$i]['local_currency_rate'] . '-' . $arrInfo_buy_or_sell[$i]['local_currency_code'] ?>
                                </div>

                                <td class="seller_name"><a href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_buy_or_sell[$i]['trade_id'] ?>"><strong><?php echo $arrInfo_buy_or_sell[$i]['user_name']; ?> (<?php echo $arrInfo_buy_or_sell[$i]['confirmed_trade_count'] ?>; 100%)</strong></a></td>
                                <td class="describe"><?php echo number_format($arrInfo_buy_or_sell[$i]['distance'], 2, '.', ''); ?>km</td>
                                <td class="location"><?php echo $arrInfo_buy_or_sell[$i]['location']; ?></td>
                                <td class="price_btc"><?php echo $arrInfo_buy_or_sell[$i]['local_currency_rate'] . '-' . $arrInfo_buy_or_sell[$i]['local_currency_code'] ?></td>
                                <td class="limits"><?php echo $arrInfo_buy_or_sell[$i]['min_amount'] . '-' . $arrInfo_buy_or_sell[$i]['max_amount']; ?></td>
								<?php if($trade_type_method == 'sell-bitcoins-with-cash') { ?>
									<td class="button_buy"><a class="actbuy" href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_buy_or_sell[$i]['trade_id']; ?>"><? echo lang('sell'); ?></a></td>
								<?php } else { ?>
									<td class="button_buy"><a class="actbuy" href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_buy_or_sell[$i]['trade_id'] ?>"><? echo lang('buy'); ?></a></td>
								<?php } ?>
                            <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } ?>                
        <?php } ?>	
			
			<?php } ?>
			
        </div>
    </div>
</section>