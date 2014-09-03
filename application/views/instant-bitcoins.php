<?php if (isset($arrInfo_buy_o)) { ?>
    <?php if (count($arrInfo_buy_o) > 0) { ?>
        <div class="bitcoins">
            <div class="bitcoins_head">
                <h1><?php echo lang('results_for_sell_bitcoins_online'); ?></h1>
                <a class="bitbuyer" href="<?php echo base_url(); ?>sell-bitcoins-online"><?php echo lang('show_more');?><span>&nbsp;</span></a>
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
                        <?php for ($i = 0; $i < count($arrInfo_buy_o); $i++) { ?>
                            <tr class="<?php
							if (($i % 2) == 0) {
								echo 'white_row';
							} else {
								echo 'greay_row';
							}
                            ?>">
                                <td class="seller_name"><a href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_buy_o[$i]['trade_id']; ?>"><strong><?php echo $arrInfo_buy_o[$i]['user_name']; ?> (<?php echo $arrInfo_buy_o[$i]['confirmed_trade_count'] ?>; 100%)</strong></a></td>
                                <td class="describe"><?php echo $arrInfo_buy_o[$i]['method_name']; ?></td>
                                <td class="price_btc"><?php echo $arrInfo_buy_o[$i]['local_currency_rate'] . '-' . $arrInfo_buy_o[$i]['local_currency_code'] ?></td>
                                <td class="limits"><?php echo $arrInfo_buy_o[$i]['min_amount'] . '-' . $arrInfo_buy_o[$i]['max_amount']; ?></td>
                                <td class="pay_methods"><a href="<?php echo base_url();?>buy-bitcoins-online/<?php echo $arrInfo_buy_o[$i]['method_url'];?>"><?php echo $arrInfo_buy_o[$i]['method_name']; ?></a></td>
                                <td class="button_buy"><a class="actbuy" href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_buy_o[$i]['trade_id']; ?>"><?php echo lang('sell')?></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } else { ?>

        <div class="bitcoins">
            <div class="bitcoins_head">
                <h1><?php echo lang('results_for_sell_bitcoins_online'); ?></h1>
                <a class="bitbuyer" href="<?php echo base_url(); ?>sell-bitcoins-online"><?php echo lang('show_more');?></a>
            </div>
            <div class="current_bitcoin">
                <table>
                    <tbody>
                        <tr class="head">
                            <th class="seller_name"><?php echo lang('buyer'); ?></th>
                            <th class="describe"><?php echo lang('description'); ?></th>
                            <th class="price_btc"><?php echo lang('price'); ?>/<?php echo lang('btc'); ?> </th>
                            <th class="limits"><?php echo lang('limits'); ?></th>
                            <th class="pay_methods"><?php echo lang('payment_method'); ?></th>
                            <th class="button_buy"><?php echo lang('action'); ?></th>
                        </tr>
                    <td class="seller_name" colspan="6">
                        No results in <?php echo $arr_geo_data['city']; ?> with the selected criteria.
                    </td>
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
                <h1><?php echo lang('sell_bitcoins_with_cash_near');?> <?php echo $arr_geo_data['city']; ?></h1>
                <a class="locatebuyer" href="<?php echo base_url(); ?>sell-bitcoins-with-cash"><?php echo lang('show_more_on_map_for_sell_bitcoins_with_cash'); ?><span>&nbsp;</span></a>
            </div>
            <div class="current_bitcoin">
                <table class="clickable">
                    <tbody>
                        <tr class="head">
                            <th class="seller_name"><?php echo lang('buyer'); ?></th>
                            <th class="describe"><?php echo lang('distance'); ?>Distance</th>
                            <th class="location"><?php echo lang('location'); ?>Location</th>
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
                                <td class="button_buy"><a class="actbuy" href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_buy_c[$i]['trade_id'] ?>"><?php echo lang('sell')?></a></td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    <?php } else { ?>

        <div class="bitcoins">
            <div class="bitcoins_head">
                <h1><?php echo lang('sell_bitcoins_with_cash_near');?> <?php echo $arr_geo_data['city']; ?></h1>
                <a class="locatebuyer" href="<?php echo base_url(); ?>sell-bitcoins-with-cash"><?php echo lang('show_more_on_map_for_sell_bitcoins_with_cash'); ?></a>
            </div>
            <div class="current_bitcoin">
                <table>
                    <tbody>
                        <tr class="head">
                            <th class="seller_name"><?php echo lang('buyer'); ?></th>
                            <th class="describe"><?php echo lang('distance'); ?>Distance</th>
                            <th class="location"><?php echo lang('location'); ?>Location</th>
                            <th class="price_btc"><?php echo lang('price'); ?>/<?php echo lang('btc'); ?> </th>
                            <th class="limits"><?php echo lang('limits'); ?></th>                                
                            <th class="button_buy"><?php echo lang('action'); ?></th>
                        </tr>
                    <td class="seller_name" colspan="6">
                        No results in <?php echo $arr_geo_data['city']; ?> with the selected criteria.
                    </td>
                    </tbody>
                </table>
            </div>
        </div>        
    <?php } ?>
<?php } ?>


<?php if (isset($arrInfo_sell_o)) { ?>
    <?php if (count($arrInfo_sell_o) > 0) { ?>
        <div class="bitcoins">
            <div class="bitcoins_head">
                <h1><?php echo lang('results_for_buy_bitcoins_online'); ?></h1>
                <a class="bitbuyer" href="<?php echo base_url(); ?>buy-bitcoins-online"><?php echo lang('show_more');?><span>&nbsp;</span></a>
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
                        <?php for ($i = 0; $i < count($arrInfo_sell_o); $i++) { ?>
                            <tr class="<?php
							if (($i % 2) == 0) {
								echo 'white_row';
							} else {
								echo 'greay_row';
							}
                            ?>">
                                <td class="seller_name"><a href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_sell_o[$i]['trade_id'] ?>"><strong><?php echo $arrInfo_sell_o[$i]['user_name']; ?> (<?php echo $arrInfo_sell_o[$i]['confirmed_trade_count'] ?>; 100%)</strong></a></td>
                                <td class="describe"><?php echo $arrInfo_sell_o[$i]['method_name']; ?></td>
                                <td class="price_btc"><?php echo $arrInfo_sell_o[$i]['local_currency_rate'] . '-' . $arrInfo_sell_o[$i]['local_currency_code'] ?></td>
                                <td class="limits"><?php echo $arrInfo_sell_o[$i]['min_amount'] . '-' . $arrInfo_sell_o[$i]['max_amount']; ?></td>
                                <td class="pay_methods"><a href="<?php echo base_url();?>sell-bitcoins-online/<?php echo $arrInfo_sell_o[$i]['method_url'];?>"><?php echo $arrInfo_sell_o[$i]['method_name']; ?></a></td>
                                <td class="button_buy"><a class="actbuy" href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_sell_o[$i]['trade_id'] ?>"><?php echo lang('buy')?></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } else { ?>

        <div class="bitcoins">
            <div class="bitcoins_head">
                <h1><?php echo lang('results_for_buy_bitcoins_online'); ?></h1>
                <a class="bitbuyer" href="<?php echo base_url(); ?>buy-bitcoins-online"><?php echo lang('show_more');?><span>&nbsp;</span></a>
            </div>
            <div class="current_bitcoin">
                <table>
                    <tbody>
                        <tr class="head">
                            <th class="seller_name"><?php echo lang('seller'); ?></th>
                            <th class="describe"><?php echo lang('description'); ?></th>
                            <th class="price_btc"><?php echo lang('price'); ?>/<?php echo lang('btc'); ?> </th>
                            <th class="limits"><?php echo lang('limits'); ?></th>
                            <th class="pay_methods"><?php echo lang('payment_method'); ?></th>
                            <th class="button_buy"><?php echo lang('action'); ?></th>
                        </tr>
                    <td class="seller_name" colspan="6">
                        No results in <?php echo $arr_geo_data['city']; ?> with the selected criteria.  
                    </td>
                    </tr>
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
                <h1><?php echo lang('buy_bitcoins_with_cash_near'); ?> <?php echo $arr_geo_data['city']; ?></h1>
                <a class="locatebuyer" href="<?php echo base_url(); ?>sell-bitcoins-with-cash"><?php echo lang('show_more_on_map_for_buy_bitcoins_with_cash'); ?><span>&nbsp;</span></a>
            </div>
            <div class="current_bitcoin">
                <table class="clickable">
                    <tbody>
                        <tr class="head">
                            <th class="seller_name"><?php echo lang('seller'); ?></th>
                            <th class="describe"><?php echo lang('distance'); ?>Distance</th>
                            <th class="location"><?php echo lang('location'); ?>Location</th>
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
                                <td class="button_buy"><a class="actbuy" href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_sell_c[$i]['trade_id'] ?>"><?php echo lang('buy')?></a></td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    <?php } else { ?>
        <div class="bitcoins">
            <div class="bitcoins_head">
                <h1><?php echo lang('buy_bitcoins_with_cash_near'); ?> <?php echo $arr_geo_data['city']; ?></h1>
                <a class="locatebuyer" href="<?php echo base_url(); ?>buy-bitcoins-with-cash"><?php echo lang('show_more_on_map_for_buy_bitcoins_with_cash'); ?><span>&nbsp;</span></a>
            </div>
            <div class="current_bitcoin">
                <table>
                    <tbody>
                        <tr class="head">
                            <th class="seller_name"><?php echo lang('seller'); ?></th>
                            <th class="describe"><?php echo lang('distance'); ?>Distance</th>
                            <th class="location"><?php echo lang('location'); ?>Location</th>
                            <th class="price_btc"><?php echo lang('price'); ?>/<?php echo lang('btc'); ?> </th>
                            <th class="limits"><?php echo lang('limits'); ?></th>                                
                            <th class="button_buy"><?php echo lang('action'); ?></th>
                        </tr>
                    <td class="seller_name" colspan="6">
                        No results in <?php echo $arr_geo_data['city']; ?> with the selected criteria.
                    </td>
                    </tbody>
                </table>
            </div>
        </div>                
    <?php } ?>
<?php } ?>

</div>
</div>
</section>