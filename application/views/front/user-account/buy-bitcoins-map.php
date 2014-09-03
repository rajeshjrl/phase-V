<script type="text/javascript" language="javascript" >
    function initi()
    {
        var geocoder;
        var map;
        var markersArray = [];
        var locationsArray = <?php echo $my_location_string; ?>;
        var lat = <?php echo $my_location['lat']; ?>;
        var long = <?php echo $my_location['long']; ?>;
        var cafe_locationsArray = <?php echo $bitcoins_location_string; ?>;
        geocoder = new google.maps.Geocoder();
        function plotMarkers()
        {
            //geocoder = new google.maps.Geocoder();
            /*for(var i = 0; i < locationsArray.length; i++)
                {
                        set_marker(locationsArray[i]);
                }*/
            for(var i = 0; i < cafe_locationsArray.length; i++)
            {
                codeAddresses(cafe_locationsArray[i]);
            }
            var myOptions = {
                center: new google.maps.LatLng(lat,long),
                zoom: 3,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                navigationControlOptions: {style: google.maps.NavigationControlStyle.LARGE}
            };
            map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
            window.setInterval(function(){google.maps.event.trigger(map, 'resize');}, 1000);
        }
	
        function codeAddresses(cafe_address)
        {
            var arrCafe=cafe_address.split('#');
            var address=arrCafe[0];
            var cafe_id=arrCafe[1];
            var marker_data=$('#marker_'+cafe_id).html();
		
            latlang = geocoder.geocode({'address': address}, function(results, status)
            {	
                var my_location=$('#my_location').html();
                if (status == google.maps.GeocoderStatus.OK)
                {
                    map.setCenter(results[0].geometry.location);
                    var marker1 = new google.maps.Marker({map: map,position: results[0].geometry.location});
				
                    var infowindow2 = new google.maps.InfoWindow({});
				
                    google.maps.event.addListener((new google.maps.Marker({map: map,position: results[0].geometry.location})), 'click', function()
                    {
                        infowindow2.setContent(marker_data);
                        infowindow2.open(map, marker1);
					
                    });
                }
            });
        }
	
        function set_marker(address)
        {
            var my_location=$('#my_location').html();
            var myArray = address.split('#');
            var latlong=myArray[0];
            var mylocation=myArray[1];
		
            latlang = geocoder.geocode({'address': latlong}, function(results, status)
            {	
                if (status == google.maps.GeocoderStatus.OK)
                {
                    map.setCenter(results[0].geometry.location);
                    var marker1 = new google.maps.Marker({map: map,position: results[0].geometry.location});
                    var infowindow2 = new google.maps.InfoWindow({});
                    google.maps.event.addListener((new google.maps.Marker({map: map,position: results[0].geometry.location})), 'click', function()
                    {
                        infowindow2.setContent(my_location);
                        infowindow2.open(map, marker1);
                    });
                }
            });
        }
        plotMarkers();
    }
</script>
<div class="page_holder">
    <div class="page_inner">
        <div class="bitcoin_form">
            <div id="map_canvas" style="width:100%;margin:0 auto;height:300px;border:1px solid;"></div>                
        </div>
        <div style="display:none" id="my_location">
            <p style="color: #050F45;font-size: 10px;width:200px">You are here:<br><?php echo $address_to_search; ?></p>
        </div>



        <?php if (isset($arrInfo_buy_c)) { ?>
            <?php if (count($arrInfo_buy_c) > 0) { ?>
                <div class="bitcoins">
                    <div class="bitcoins_head">
                        <h1><?php echo lang('buy_bitcoins_with_cash_near');?> <?php echo $arr_geo_data['city']; ?></h1>
                       <!-- <a class="locatebuyer" href="javascript:void(0);">Show more on map for buy bitcoins with cash<span>&nbsp;</span></a>--->
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
                                <?php for ($i = 0; $i < count($arrInfo_buy_c); $i++) { ?>
                                    <tr class="<?php
                        if (($i % 2) == 0) {
                            echo 'white_row';
                        } else {
                            echo 'greay_row';
                        }
                                    ?>">
                                <div id="marker_<?php echo $arrInfo_buy_c[$i]['trade_id']; ?>" style="display:none;text-align:left;">
                                    <?php echo $arrInfo_buy_c[$i]['user_name']; ?><br />
                                    <?php echo number_format($arrInfo_buy_c[$i]['distance'], 2, '.', ''); ?>km<br />
                                    <?php echo $arrInfo_buy_c[$i]['location']; ?><br />
                                    <?php echo $arrInfo_buy_c[$i]['local_currency_rate'] . '-' . $arrInfo_buy_c[$i]['local_currency_code'] ?>
                                </div>

                                <td class="seller_name"><a href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_buy_c[$i]['trade_id'] ?>"><strong><?php echo $arrInfo_buy_c[$i]['user_name']; ?> (<?php echo $arrInfo_buy_c[$i]['confirmed_trade_count'] ?>; 100%)</strong></a></td>
                                <td class="describe"><?php echo number_format($arrInfo_buy_c[$i]['distance'], 2, '.', ''); ?>km</td>
                                <td class="location"><?php echo $arrInfo_buy_c[$i]['location']; ?></td>
                                <td class="price_btc"><?php echo $arrInfo_buy_c[$i]['local_currency_rate'] . '-' . $arrInfo_buy_c[$i]['local_currency_code'] ?></td>
                                <td class="limits"><?php echo $arrInfo_buy_c[$i]['min_amount'] . '-' . $arrInfo_buy_c[$i]['max_amount']; ?></td>
                                <td class="button_buy"><a class="actbuy" href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arrInfo_buy_c[$i]['trade_id'] ?>"><span>&nbsp;</span>Buy</a></td>
                                </tr>
                            <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } else { ?>
                <p>No results in <?php echo $arr_geo_data['city']; ?> with the selected criteria.</p>
            <?php } ?>
        <?php } ?>

        <p><?php echo $links; ?></p>

    </div>
</div>
</section>

<script type="text/javascript">
    $(document).ready(function(e) {
        initi();
    });
</script>
