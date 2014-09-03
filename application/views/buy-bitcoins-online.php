<div class="bitcoins">
    <div class="bitcoins_head">
        <h1><?php echo lang('buy_bitcoins_online_in'); ?> <?php echo $arr_geo_data['country_name']; ?></h1>
        <a class="bitbuyer" href="javascript:void(0);">Show more<span>&nbsp;</span></a>
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
                for ($i = 0; $i < count($arrInfo); $i++) {
                    if ($arrInfo[$i]['trade_type'] == 'buy_o') {
                        ?>
                        <tr class="<?php
                        if (($i % 2) == 0) {
                            echo 'white_row';
                        } else {
                            echo 'greay_row';
                        }
                        ?>">
                            <td class="seller_name"><a href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo[$i]['trade_id']; ?>"><strong><?php echo $arrInfo[$i]['user_name']; ?> (1; 100%)</strong></a></td>
                            <td class="describe"><?php echo $arrInfo[$i]['method_name']; ?></td>
                            <td class="price_btc"><?php echo $arrInfo[$i]['local_currency_rate'] . '-' . $arrInfo[$i]['local_currency_code'] ?></td>
                            <td class="limits"><?php echo $arrInfo[$i]['min_amount'] . '-' . $arrInfo[$i]['max_amount']; ?></td>
                            <td class="pay_methods"><a href="<?php echo base_url();?>buy-bitcoins-online/<?php echo $arrInfo[$i]['method_url'];?>"><?php echo $arrInfo[$i]['method_name']; ?></a></td>
                            <td class="button_buy"><a class="actbuy" href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo[$i]['trade_id']; ?>"><span>&nbsp;</span>Buy</a></td>
                        </tr>
    <?php } ?>
<?php } ?>
            </tbody>
        </table>
    </div>
</div>


<div class="bitcoins">
    <div class="bitcoins_head">
        <h1><?php echo lang('buy_bitcoins_with_cash_near'); ?> <?php echo $arr_geo_data['city']; ?></h1>
        <a class="locatebuyer" href="javascript:void(0);"><?php echo lang('show_more_on_map_for_buy_bitcoins_with_cash')?><span>&nbsp;</span></a>
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
                <?php
                for ($i = 0; $i < count($arrInfo); $i++) {
                    if ($arrInfo[$i]['trade_type'] == 'buy_c') {
                        ?>
                        <tr class="<?php
                if (($i % 2) == 0) {
                    echo 'white_row';
                } else {
                    echo 'greay_row';
                }
                ?>">
                            <td class="seller_name"><a href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo[$i]['trade_id'] ?>"><strong><?php echo $arrInfo[$i]['user_name']; ?> (1; 100%)</strong></a></td>
                            <td class="describe"><?php echo number_format($arrInfo[$i]['distance'], 2, '.', ''); ?>km</td>
                            <td class="location"><?php echo $arrInfo[$i]['location']; ?></td>
                            <td class="price_btc"><?php echo $arrInfo[$i]['local_currency_rate'] . '-' . $arrInfo[$i]['local_currency_code'] ?></td>
                            <td class="limits"><?php echo $arrInfo[$i]['min_amount'] . '-' . $arrInfo[$i]['max_amount']; ?></td>
                            <td class="button_buy"><a class="actbuy" href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo[$i]['trade_id'] ?>"><span>&nbsp;</span>Buy</a></td>
                        </tr>
    <?php } ?>
<?php } ?>

            </tbody>
        </table>
    </div>
</div>

<div class="bitcoins">
    <div class="bitcoins_head">
        <h1><?php echo lang('buy_bitcoins_online_in'); ?> <?php echo $arr_geo_data['country_name']; ?></h1>
        <a class="bitbuyer" href="javascript:void(0);">Show more<span>&nbsp;</span></a>
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
                for ($i = 0; $i < count($arrInfo); $i++) {
                    if ($arrInfo[$i]['trade_type'] == 'sell_o') {
                        ?>
                        <tr class="<?php
                        if (($i % 2) == 0) {
                            echo 'white_row';
                        } else {
                            echo 'greay_row';
                        }
                        ?>">
                            <td class="seller_name"><a href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo[$i]['trade_id'] ?>"><strong><?php echo $arrInfo[$i]['user_name']; ?> (1; 100%)</strong></a></td>
                            <td class="describe"><?php echo $arrInfo[$i]['method_name']; ?></td>
                            <td class="price_btc"><?php echo $arrInfo[$i]['local_currency_rate'] . '-' . $arrInfo[$i]['local_currency_code'] ?></td>
                            <td class="limits"><?php echo $arrInfo[$i]['min_amount'] . '-' . $arrInfo[$i]['max_amount']; ?></td>
                            <td class="pay_methods"><a href="<?php echo base_url();?>sell-bitcoins-online/<?php echo $arrInfo[$i]['method_url'];?>"><?php echo $arrInfo[$i]['method_name']; ?></a></td>
                            <td class="button_buy"><a class="actbuy" href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo[$i]['trade_id'] ?>"><span>&nbsp;</span>Sell</a></td>
                        </tr>
    <?php } ?>
<?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="bitcoins">
    <div class="bitcoins_head">
        <h1><?php echo lang('sell_bitcoins_with_cash_near'); ?> <?php echo $arr_geo_data['city']; ?></h1>
        <a class="locatebuyer" href="javascript:void(0);"><?php echo lang('show_more_on_map_for_sell_bitcoins_with_cash');?><span>&nbsp;</span></a>
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
<?php
for ($i = 0; $i < count($arrInfo); $i++) {
    if ($arrInfo[$i]['trade_type'] == 'sell_c') {
        ?>
                        <tr class="<?php
        if (($i % 2) == 0) {
            echo 'white_row';
        } else {
            echo 'greay_row';
        }
        ?>">
                            <td class="seller_name"><a href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo[$i]['trade_id'] ?>"><strong><?php echo $arrInfo[$i]['user_name']; ?> (1; 100%)</strong></a></td>
                            <td class="describe"><?php echo number_format($arrInfo[$i]['distance'], 2, '.', ''); ?>km</td>
                            <td class="location"><?php echo $arrInfo[$i]['location']; ?></td>
                            <td class="price_btc"><?php echo $arrInfo[$i]['local_currency_rate'] . '-' . $arrInfo[$i]['local_currency_code'] ?></td>
                            <td class="limits"><?php echo $arrInfo[$i]['min_amount'] . '-' . $arrInfo[$i]['max_amount']; ?></td>
                            <td class="button_buy"><a class="actbuy" href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo[$i]['trade_id'] ?>"><span>&nbsp;</span>Sell</a></td>
                        </tr>
    <?php } ?>
<?php } ?>							
            </tbody>
        </table>
    </div>
</div>


</div>
</div>
</section>