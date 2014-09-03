<script>
    function initialize() {
        var markers = [];
        // Create the search box and link it to the UI element.
        var input = /** @type {HTMLInputElement} */(
        document.getElementById('pac-input'));
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
                $("input[name='lattitude']").val(location.latitude);
                $("input[name='longitude']").val(location.longitude);
            });
        });
 
    }
    google.maps.event.addDomListener(window, 'load', initialize);

</script>

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

<section id="banner">
    <div class="page_holder">
        <div class="page_inner">
            <div class="banner_left">
                <div class="banner_text_img">
                    <img src="<?php echo base_url(); ?>media/front/images/banner_text.png" alt="buy and sell bitcoins">
                </div>
                <div class="banner_text">
                    <h4><?php echo lang('instant'); ?>. <?php echo lang('secure'); ?>. <?php echo lang('private'); ?>. </h4>
                    <h5><?php echo lang('trade_bitcoins_in'); ?> 4974 <?php echo lang('cities_and'); ?> 212 <?php echo lang('countries_including_india'); ?>.</h5>
                </div>                
                <div class="banner_signup"><a href="<?php echo base_url(); ?>signup"><?php echo lang('sign_up_free'); ?></a></div>
            </div>
            <div class="banner_right">
                <div class="banner_form">
                    <div class="banner_form_top"></div>
                    <div class="banner_form_data">
                        <div class="formdata">
                            <form name="frm_search_ads" id="frm_search_ads" action="<?php echo base_url(); ?>instant-bitcoins" method="post">
                                <fieldset>
                                    <input type="radio" name="radio" value="1" checked="checked">
                                    <span><?php echo lang('i_want_to_buy_bitcoins'); ?></span>
                                </fieldset>
                                <fieldset>
                                    <input type="radio" name="radio" value="2">
                                    <span> <?php echo lang('i_want_to_sell_bitcoins'); ?></span>
                                </fieldset>
                                <fieldset>
                                    <label><?php echo lang('city'); ?>:</label>
                                    <?php $search_bitcoins['search'] = (isset($search_bitcoins['search'])) ? $search_bitcoins['search'] : $arr_geo_data['city']; ?>
                                    <input type="text" name="search" required id="pac-input" value="<?php echo $search_bitcoins['search'] ?>" placeholder="<?php echo $search_bitcoins['search'] ?>">         
                                    <?php $search_bitcoins['lattitude'] = (isset($search_bitcoins['lattitude'])) ? $search_bitcoins['lattitude'] : $arr_geo_data['latitude']; ?>
                                    <?php $search_bitcoins['longitude'] = (isset($search_bitcoins['longitude'])) ? $search_bitcoins['longitude'] : $arr_geo_data['longitude']; ?>								                                     <input type='hidden' value='<?php echo $search_bitcoins['lattitude']; ?>' name='lattitude'/>
                                    <input type='hidden' value='<?php echo $search_bitcoins['longitude']; ?>' name='longitude'/>
                                    <div id="map-canvas"></div>
                                </fieldset>
                                <fieldset>
                                    <label><?php echo lang('amount'); ?>:</label>
                                    <input class="amount" type="text" placeholder="150.00" name="amount" id="amount">
                                    <select class="curncy" name="currency" id="currency">

                                        <?php
                                        if ((is_array($currency_details)) && (count($currency_details) > 0)) {
                                            foreach ($currency_details as $currency) {
                                                ?>
                                                <option <?php if ($currency['currency_id'] == 1 ) echo 'selected'; ?> value="<?php echo $currency['currency_id']; ?>"><?php echo $currency['currency_code']; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </fieldset>
                                <fieldset>
                                    <label><?php echo lang('payment_method'); ?>:</label>
                                    <select name="payment_type">
										<optgroup label="Online">
                                        <?php foreach ($payment_details_online as $payment) { ?>
                                            <option value="Online-<?php echo $payment['method_id'] ?>"><?php echo $payment['method_name'] ?></option>
                                        <?php } ?>
										</optgroup>
										<optgroup label="In-person">
										<?php foreach ($payment_details_cash as $payment) { ?>
                                            <option value="Cash-<?php echo $payment['method_id'] ?>"><?php echo $payment['method_name'] ?></option>
                                        <?php } ?>
										</optgroup>
                                    </select>
                                </fieldset>
                                <fieldset class="button">
                                    <input type="submit" name="btn_search" value="<?php echo lang('find_offers'); ?>">
                                </fieldset>
                            </form>
                        </div>
                    </div>
                    <div class="banner_form_shadow"></div>
                </div>
            </div>
        </div>
    </div>
</section>


<section id="comInfo">
    <div class="page_holder">
        <div class="page_inner">
            <div class="company_guide">
                <div class="guide_sec">
                    <div class="guide_head">
                        <span>01</span>
                    </div>
                    <div class="guide_data">
                        <h4><a  title="" href="<?php echo base_url(); ?>cms/17/guides" ><?php echo lang('starter_guide'); ?></a></h4>
                        <p>Cryptosi.com<?php echo lang('is_a_marketplace_for_trading_bitcoins_locally_to_cash_or_online_payments_of_your_choice   '); ?>.</p>
                    </div>
                </div>
                <div class="guide_sec">
                    <div class="guide_head">
                        <span>02</span>
                    </div>
                    <div class="guide_data">
                        <h4><a  title="" href="<?php echo base_url(); ?>cms/17/selling-bitcoins-online-guide" ><?php echo lang('online_trader_guide'); ?></a></h4>
                        <p>Cryptosi.com is a marketplace for trading bitcoins locally to cash or online payments of your choice.</p>
                    </div>
                </div>
                <div class="guide_sec last">
                    <div class="guide_head">
                        <span>03</span>
                    </div>
                    <div class="guide_data">
                        <h4><a  title="" href="<?php echo base_url(); ?>cms/17/faq" ><?php echo lang('faqs'); ?></a></h4>
                        <p>Cryptosi.com is a marketplace for trading bitcoins locally to cash or online payments of your choice.</p>
                    </div>
                </div>
                <!-- <div class="guide_adv">
                    <div class="adv_sec">
                        <img src="<?php echo base_url(); ?>media/front/images/adv01.png" alt="adv01">
                    </div>
                    <div class="adv_sec last">
                        <img src="<?php echo base_url(); ?>media/front/images/adv02.png">
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</section>
<section id="change_location">
    <div class="page_holder">
        <div class="page_inner">
            <form class="chng_loctn" name="frm_change_location" id="frm_change_location" action="<?php echo base_url(); ?>country" method="post">
                <fieldset>
                    <label><?php echo lang('change_location'); ?></label>
                    <input type="text" name="change-location" id="change-location" value="">
                    <input type="hidden" name="change_lattitude" id="change_lattitude" value="" />
                    <input type="hidden" name="change_longitude" id="change_longitude" value="" />
                    <div id="maps"></div>
                </fieldset>
            </form>
        </div>
    </div>
</section>
<section id="content">
    <div class="page_holder">
        <div class="page_inner">