<script>
    function changeLocation() {
        var markers = [];
        // Create the search box and link it to the UI element.
        var input = /** @type {HTMLInputElement} */(
        document.getElementById('change-location'));
        var searchBox = new google.maps.places.SearchBox(
        /** @type {HTMLInputElement} */(input));
        // [START region_getplaces]
        // Listen for the event fired when the user selects an item from the
        // pick list. Retrieve the matching places for that item.
        google.maps.event.addListener(searchBox, 'places_changed', function() {
            var places = searchBox.getPlaces();

            var location=new Object();
            console.log(places[0]);
            location.full_address=places[0].formatted_address;
            location.latitude=places[0].geometry.location.lat();
            location.longitude=places[0].geometry.location.lng();
            location.address_id=places[0].id;
            location.address_name=places[0].name;
            
            $(function() {
                $("input[name='change_lattitude']").val(location.latitude);
                $("input[name='change_longitude']").val(location.longitude);
                jQuery("#frm_change_location").submit();
            });
        });
 
    }
    google.maps.event.addDomListener(window, 'load', changeLocation);

</script>

<div class="page_holder">
    <div class="page_inner">
        <div class="bitcoin_form">
            <form class="chng_loctn" name="frm_change_location" id="frm_change_location" action="<?php echo base_url(); ?>country" method="post">
                <fieldset>
                    <label><?php echo lang('change_location'); ?>:</label>
                    <input type="text" name="change-location" id="change-location" value="">
                    <input type="hidden" name="change_lattitude" id="change_lattitude" value="" />
                    <input type="hidden" name="change_longitude" id="change_longitude" value="" />
                    <input type="hidden" name="page" id="page" value="sell-bitcoins" />
                    <div id="maps"></div>
                </fieldset>
            </form>
        </div>

        <?php if (isset($arrInfo_sell_o)) { ?>
            <?php if (count($arrInfo_sell_o) > 0) { ?>
                <div class="bitcoins">
                    <div class="bitcoins_head">
                        <h1><?php echo lang('results_for_sell_bitcoins_online'); ?></h1>
                        <a class="bitbuyer" href="<?php echo base_url(); ?>sell-bitcoins-online"><?php echo lang('show_more'); ?><span>&nbsp;</span></a>
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
                                        <td class="button_buy"><a class="actbuy" href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_sell_o[$i]['trade_id'] ?>"><span>&nbsp;</span><?php echo lang('sell'); ?></a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } else { ?>
                <p><?php echo lang('no_results_in'); ?> <?php echo $arr_geo_data['city']; ?> <?php echo lang('with_the_selected_criteria'); ?>.</p>
            <?php } ?>
        <?php } ?>

        <?php if (isset($arrInfo_sell_c)) { ?>
            <?php if (count($arrInfo_sell_c) > 0) { ?>
                <div class="bitcoins">
                    <div class="bitcoins_head">
                        <h1><?php echo lang('sell_bitcoins_with_cash_near'); ?> <?php echo $arr_geo_data['city']; ?></h1>
                        <a class="locatebuyer" href="<?php echo base_url(); ?>sell-bitcoins-with-cash"><?php echo lang('show_more_on_map_for_buy_bitcoins_with_cash'); ?><span>&nbsp;</span></a>
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
                                        <td class="button_buy"><a class="actbuy" href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_sell_c[$i]['trade_id'] ?>"><span>&nbsp;</span><?php echo lang('sell'); ?></a></td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } else { ?>
                <p><?php echo lang('no_results_in'); ?> <?php echo $arr_geo_data['city']; ?> <?php echo lang('with_the_selected_criteria'); ?>.</p>
            <?php } ?>
        <?php } ?>

    </div>
</div>
</section>
