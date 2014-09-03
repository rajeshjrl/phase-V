<style>
    .error {
        color: #BD4247;
    }
    #target {
        width: 345px;
    }
</style>
<script>
    // This example adds a search box to a map, using the Google Place Autocomplete
    // feature. People can enter geographical searches. The search box will return a
    // pick list containing a mix of places and predicted search terms.

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
            location.latitude=places[0].geometry.location.d;
            location.longitude=places[0].geometry.location.e;
            location.address_id=places[0].id;
            location.address_name=places[0].name;

            /*
                console.log(places[0].formatted_address);
                console.log(places[0].geometry.location.d);
                console.log(places[0].geometry.location.e);
                console.log(places[0].id);
                console.log(places[0].name);*/

            console.log(location);
            //return location;
            //alert(places.formatted_address);
            //dorument.write(places);
        });
 
    }
    google.maps.event.addDomListener(window, 'load', initialize);

</script>
<section id="content">
    <div class="page_holder">
        <div class="page_inner">
            <div class="login_form">
                <div class="banner_right">
                    <div class="banner_form">
                        <div class="banner_form_top"></div>
                        <div class="banner_form_data">
                            <div class="formdata">
                                <div class="page_head">
                                    <h2>Create a bitcoin trade advertisement</h2>
                                </div>
                                <form name="frm_ad_details" id="frm_ad_details" action="<?php echo base_url(); ?>advertise/add" method="post" >
                                    <legend>Trade type</legend>

                                    <fieldset>
                                        <label>I want to<sup class="mandatory">*</sup> </label>
                                    </fieldset>
                                    <fieldset>                
                                        <label class="radio">
                                            <input type="radio" value="sell_o" id="id_sell_online" name="trade_type">
                                            Sell bitcoins online </label>
                                    </fieldset>
                                    <fieldset>
                                        <label class="radio">
                                            <input type="radio" value="buy_o" id="id_buy_online" name="trade_type">
                                            Buy bitcoins online </label>
                                    </fieldset>
                                    <fieldset>
                                        <label class="radio">
                                            <input type="radio" value="sell_c" id="id_sell_cash" name="trade_type">
                                            Sell bitcoins locally with cash </label>
                                    </fieldset>
                                    <fieldset>
                                        <label class="radio">
                                            <input type="radio" value="buy_c" id="id_buy_cash" name="trade_type">
                                            Buy bitcoins locally with cash </label>
                                    </fieldset>

                                    <fieldset>
                                        <label>Location<sup class="mandatory">*</sup> </label>
                                        <input type="text" value="" name="location" id="pac-input" placeholder="Enter location" class="FETextInput">
                                        <div id="map-canvas"></div>
                                    </fieldset>

                                    <fieldset id="row_id_online_provider" style="display:none;">				
                                        <label>Payment method<sup class="mandatory">*</sup> </label>
                                        <select name="payment_method" id="payment_method">
                                            <?php foreach ($arr_payment_method_details as $method) { ?>
                                                <option value="<?php echo $method['method_id']; ?>"><?php echo $method['method_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </fieldset>

                                    <fieldset>
                                        <legend>More information</legend>
                                        <label>Currency<sup class="mandatory">*</sup> </label>
                                        <select name="currency" id="currency" class="FETextInput">
                                            <?php foreach ($arr_currency_details as $currency) { ?>
                                                <option value="<?php echo $currency['currency_id']; ?>"><?php echo $currency['currency_code']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </fieldset>

                                    <fieldset>
                                        <label>Bank name</label>
                                        <input type="text" value="" name="bank_name" id="bank_name" class="FETextInput">
                                    </fieldset>

                                    <fieldset id="row_id_floating_price_chk" style="display:none;">
                                        <label>Floating price<sup class="mandatory">*</sup> </label>
                                        <input type="checkbox" value="" name="floating_price_chk" id="floating_price_chk" class="FETextInput">
                                    </fieldset>

                                    <fieldset id="row_id_floating_premium" style="display:none;">					
                                        <label> Floating premium<sup class="mandatory">*</sup> </label>
                                        <input type="text" value="" name="float_premium" id="float_premium" class="FETextInput">
                                    </fieldset>

                                    <fieldset id="row_id_premium" style="display:block;">
                                        <label>Premium<sup class="mandatory">*</sup> </label>
                                        <input type="text" value="0" name="premium" id="premium" class="FETextInput"><br />
                                        <span class="add-on">%</span>
                                    </fieldset>

                                    <fieldset id="row_id_price_equation" style="display:block;">
                                        <label>Price equation<sup class="mandatory">*</sup> </label>
                                        <input type="text" value="" name="price_eq" id="price_eq" class="FETextInput">
                                    </fieldset>

                                    <fieldset>
                                        <label>Min amount</label>
                                        <input type="text" value="" name="min_amt" id="min_amt" class="FETextInput">
                                    </fieldset>
                                    <fieldset>
                                        <label>Max amount</label>
                                        <input type="text" value="" name="max_amt" id="max_amt" class="FETextInput">
                                    </fieldset>

                                    <fieldset>
                                        <label>Contact hours<sup class="mandatory">*</sup> </label>
                                        <input type="text" value="" name="contact_hrs" id="contact_hrs" class="FETextInput"><br />
                                        <span class="add-on">Example: Mon-Sun 08:00-22:00 </span>
                                    </fieldset>

                                    <fieldset>
                                        <label>Other information</label>
                                        <textarea name="other_info" id="other_info" class="FETextInput"></textarea>
                                    </fieldset>

                                    <fieldset id="online_sell_fieldset" style="display:none;">
                                        <fieldset>
                                            <legend>Online selling options</legend>
                                            <label>Bank transfer details</label>
                                            <textarea name="bank_detail" id="bank_detail" class="FETextInput"></textarea>
                                        </fieldset>

                                        <fieldset>
                                            <label>Minimum volume<sup class="mandatory">*</sup> </label>
                                            <input type="text" value="0" name="min_volume" id="min_volume" class="FETextInput">
                                        </fieldset>

                                        <fieldset>
                                            <label>Minimum feedback score<sup class="mandatory">*</sup> </label>
                                            <input type="text" value="0" name="min_feedback" id="min_feedback" class="FETextInput">
                                        </fieldset>

                                        <fieldset>
                                            <label>New buyer limit</label>
                                            <input type="text" value="" name="buyer_limit" id="buyer_limit" class="FETextInput"><br />
                                            <span class="add-on">BTC</span>
                                        </fieldset>

                                        <fieldset>
                                            <label>Transaction volume coefficient <sup class="mandatory">*</sup></label>
                                            <input type="text" value="1.5" name="volume_coefficient" id="volume_coefficient" class="FETextInput"><br />
                                            <span class="add-on">X</span>
                                        </fieldset>

                                        <fieldset>
                                            <label>Display reference<sup class="mandatory">*</sup></label>
                                            <input type="checkbox" checked="checked" value="Y" name="reference_chk" id="reference_chk" class="FETextInput">
                                        </fieldset>

                                        <fieldset>
                                            <label>Reference type<sup class="mandatory">*</sup></label>
                                            <select name="reference_type" id="reference_type" class="FETextInput">
                                                <option value="LONG">Long form</option>
                                                <option selected="selected" value="SHORT">Short form</option>
                                                <option value="NUMERIC">Numbers only</option>
                                            </select>
                                        </fieldset>

                                    </fieldset>

                                    <fieldset id="online_buy_fieldset" style="display:none;">

                                        <fieldset>
                                            <legend>Online buying options</legend>
                                            <label>Payment window<sup class="mandatory">*</sup></label>
                                            <input type="text" value="360" name="payment_window" id="payment_window" class="FETextInput"><br />
                                            <span class="add-on">minutes</span>
                                        </fieldset>

                                    </fieldset>

                                    <fieldset id="liquidity_options_fieldset" style="display:none;">
                                        <legend>Liquidity options</legend>
                                        <label>Track liquidity<sup class="mandatory">*</sup></label>
                                        <input type="checkbox" value="Y" checked="checked" name="liquidity_chk" id="liquidity_chk" class="FETextInput">
                                    </fieldset>

                                    <fieldset id="row_id_real_name_chk" style="display:none;">
                                        <legend>Security options</legend>
                                        <label>Real name required<sup class="mandatory">*</sup></label>
                                        <input type="checkbox" value="Y" name="real_name_chk" id="real_name_chk" class="FETextInput">
                                    </fieldset>

                                    <fieldset>
                                        <label>SMS verification required<sup class="mandatory">*</sup></label>
                                        <input type="checkbox" value="Y" name="sms_veri_chk" id="sms_veri_chk" class="FETextInput">
                                    </fieldset>

                                    <fieldset>
                                        <label>Trusted people only<sup class="mandatory">*</sup></label>
                                        <input type="checkbox" value="Y" name="trusted_people_chk" id="trusted_people_chk" class="FETextInput">
                                        <span class="add-on">minutes</span>
                                    </fieldset>
                                    <fieldset class="button">
                                        <input type="submit" name="btn_submit" value="Publish advertisement">
                                    </fieldset>

                                </form>
                            </div>
                        </div>
                        <div class="banner_form_shadow"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>