<section id="content" class="cms dashboard user_profile">
  <div class="page_holder">
    <div class="page_inner">
      <div class="page_head">
        <?php if($trade_type == 'sell-bitcoins-online') { ?>
        <h1><?php echo lang('sell_bitcoins_online_with');?> <?php echo $arr_payment_method_data['method_name'];?></h1>
        <?php } else { ?>
        <h1><?php echo lang('buy_bitcoins_online_with');?> <?php echo $arr_payment_method_data['method_name'];?></h1>
        <?php } ?>
      </div>
	  
	  <p class="well" id="payment-method-filter">
    	<strong><?php echo lang('show_by_payment_method');?>:</strong>    
		<?php foreach($payment_details_online as $payment_method) { ?>
        	<a href="<?php echo base_url().$trade_type.'/'.$payment_method['method_url'];?>"><?php echo strip_slashes($payment_method['method_name']);?></a>,
		<?php } ?>
	  </p>
	  
	  
      <?php if(isset($arrInfo_buySell_o_payment_method)) { ?>
      <?php if(count($arrInfo_buySell_o_payment_method) > 0) { ?>
      <div class="bitcoins">
        <div class="bitcoins_head"> </div>
        <div class="current_bitcoin">
          <table class="clickable">
            <tbody>
              <tr class="head">
                <th class="seller_name"><?php if($trade_type == 'sell-bitcoins-online') { echo lang('buyer');} else { echo lang('seller'); } ?></th>
                <th class="describe"><?php echo lang('description'); ?></th>
                <th class="price_btc"><?php echo lang('price'); ?>/<?php echo lang('btc'); ?> </th>
                <th class="limits"><?php echo lang('limits'); ?></th>
                <th class="pay_methods"><?php echo lang('payment_method'); ?></th>
                <th class="button_buy"><?php echo lang('action'); ?></th>
              </tr>
              <?php
                for ($i = 0; $i < count($arrInfo_buySell_o_payment_method); $i++) { ?>
              <tr class="<?php
                        if (($i % 2) == 0) {
                            echo 'white_row';
                        } else {
                            echo 'greay_row';
                        }
                        ?>">
                <td class="seller_name"><a href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_buySell_o_payment_method[$i]['trade_id']; ?>"><strong><?php echo $arrInfo_buySell_o_payment_method[$i]['user_name']; ?> (<?php echo $arrInfo_buySell_o_payment_method[$i]['confirmed_trade_count'] ?>; 100%)</strong></a></td>
                <td class="describe"><?php echo $arrInfo_buySell_o_payment_method[$i]['method_name']; ?></td>
                <td class="price_btc"><?php echo $arrInfo_buySell_o_payment_method[$i]['local_currency_rate'] . '-' . $arrInfo_buySell_o_payment_method[$i]['local_currency_code'] ?></td>
                <td class="limits"><?php echo $arrInfo_buySell_o_payment_method[$i]['min_amount'] . '-' . $arrInfo_buySell_o_payment_method[$i]['max_amount']; ?></td>
                <td class="pay_methods"><a href="<?php echo base_url().$trade_type.'/'.$arrInfo_buySell_o_payment_method[$i]['method_url'];?>"><?php echo $arrInfo_buySell_o_payment_method[$i]['method_name']; ?></a></td>
				<?php if($trade_type == 'sell-bitcoins-online') { ?>
				<td class="button_buy"><a class="actbuy" href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_buySell_o_payment_method[$i]['trade_id']; ?>"><span>&nbsp;</span><?php echo lang('sell');?></a></td>
				<?php } else { ?>
				<td class="button_buy"><a class="actbuy" href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_buySell_o_payment_method[$i]['trade_id']; ?>"><span>&nbsp;</span><?php echo lang('buy');?></a></td>
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
    	<strong> Cryptosi.com has no currently active trades for this listing. </strong><br />
		<a href="<?php echo base_url();?>" class="find_links"><span>Find bitcoin trades to buy and sell near your location</span></a> or 
		<a href="<?php echo base_url();?>advertise" class="find_links"><span>post your own trade request.</span></a>
			
	    </p>
      <?php } } ?>
    </div>
  </div>
</section>