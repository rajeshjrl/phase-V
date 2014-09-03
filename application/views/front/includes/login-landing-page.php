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


<div class="page_holder">
    <div class="page_inner">        	
        <div class="bitcoin_form">
            <div class="banner_form_data">
                <div class="formdata">
                    <form name="frm_search_ads" id="frm_search_ads" action="<?php echo base_url(); ?>instant-bitcoins" method="post" >
                        <div class="selct_radio">
                            <?php $search_bitcoins['type'] = (isset($search_bitcoins['type'])) ? $search_bitcoins['type'] : '1'; ?>
                            <fieldset>
                                <input type="radio" name="radio" value="1" <?php if ($search_bitcoins['type'] == '1') echo 'checked' ?>>
                                <span><?php echo lang('i_want_to_buy_bitcoins'); ?></span>
                            </fieldset>
                            <fieldset>
                                <input type="radio" name="radio" value="2" <?php if ($search_bitcoins['type'] == '2') echo 'checked' ?>>
                                <span><?php echo lang('i_want_to_sell_bitcoins'); ?></span>
                            </fieldset>
                        </div>                             
                        <fieldset>
                            <label><?php echo lang('city'); ?>:</label>
                            <?php $search_bitcoins['search'] = (isset($search_bitcoins['search'])) ? $search_bitcoins['search'] : $arr_geo_data['city']; ?>
                            <input type="text" name="search" required id="pac-input" value="<?php echo $search_bitcoins['search']; ?>" placeholder="<?php echo $search_bitcoins['search']; ?>">
                            <?php $search_bitcoins['lattitude'] = (isset($search_bitcoins['lattitude'])) ? $search_bitcoins['lattitude'] : $arr_geo_data['latitude']; ?>
                            <?php $search_bitcoins['longitude'] = (isset($search_bitcoins['longitude'])) ? $search_bitcoins['longitude'] : $arr_geo_data['longitude']; ?>	
                            <input type='hidden' value='<?php echo $search_bitcoins['lattitude']; ?>' name='lattitude'/>
                            <input type='hidden' value='<?php echo $search_bitcoins['longitude']; ?>' name='longitude'/>
                            <div id="map-canvas"></div>
                        </fieldset>
                        <fieldset>
                            <label><?php echo lang('amount'); ?>:</label>
                            <input class="amount" type="text" name="amount" name="amount" id="amount" value="<?php echo (isset($search_bitcoins['amount'])) ? $search_bitcoins['amount'] : ""; ?>">
							<?php $search_bitcoins['currency'] = (isset($search_bitcoins['currency'])) ? $search_bitcoins['currency'] : ''; ?>
                            <select class="curncy" name="currency">
                                <?php foreach ($currency_details as $currency) { ?>
                                    <option value="<?php echo $currency['currency_id'] ?>" <?php if ($search_bitcoins['currency'] == $currency['currency_id']) echo "selected"; ?>><?php echo $currency['currency_code'] ?></option>
                                <?php } ?>
                            </select>
                        </fieldset>
                        <fieldset>
                            <label><?php echo lang('payment_method'); ?>:</label>
                            <?php $search_bitcoins['payment_type'] = (isset($search_bitcoins['payment_type'])) ? $search_bitcoins['payment_type'] : '1'; ?>
                            <select name="payment_type">
							<optgroup label="Online">
                                <?php foreach ($payment_details_online as $payment) { ?>
                                    <option value="Online-<?php echo $payment['method_id'] ?>" <?php if ($search_bitcoins['payment_type'] == $payment['method_id']) echo "selected"; ?>><?php echo $payment['method_name'] ?></option>
                                <?php } ?>
							</optgroup>
							<optgroup label="In-person">
								<?php foreach ($payment_details_cash as $payment) { ?>
                                    <option value="Cash-<?php echo $payment['method_id'] ?>" <?php if ($search_bitcoins['payment_type'] == $payment['method_id']) echo "selected"; ?>><?php echo $payment['method_name'] ?></option>
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
            <form class="chng_loctn" name="frm_change_location" id="frm_change_location" action="<?php echo base_url(); ?>country" method="post">
                <fieldset>
                    <label>Change Location:</label>
                    <input type="text" name="change-location" id="change-location" value="">
                    <input type="hidden" name="change_lattitude" id="change_lattitude" value="" />
                    <input type="hidden" name="change_longitude" id="change_longitude" value="" />
                    <div id="maps"></div>
                </fieldset>
            </form>
        </div>
