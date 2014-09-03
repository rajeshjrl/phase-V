<style> .error { color: #BD4247;}
    #target {width: 345px;}
</style>
<script>
    var arr_currencay_rates =<?php echo $arr_currencay_rates; ?>;
    // This example adds a search box to a map, using the Google Place Autocomplete
    // feature. People can enter geographical searches. The search box will return a
    // pick list containing a mix of places and predicted search terms.
	
	var placeSearch, autocomplete;
	var componentForm = {		  
	  administrative_area_level_2: 'long_name',
	  administrative_area_level_1: 'long_name',
	  country: 'long_name',	    
	};
	
	// [START region_fillform]
	function fillInAddress() {
	  // Get the place details from the autocomplete object.
	  var place = autocomplete.getPlace();
	
	  for (var component in componentForm) {
		document.getElementById(component).value = '';
		document.getElementById(component).disabled = false;
	  }
	
	  // Get each component of the address from the place details
	  // and fill the corresponding field on the form.
	  for (var i = 0; i < place.address_components.length; i++) {
		var addressType = place.address_components[i].types[0];
		if (componentForm[addressType]) {
		  var val = place.address_components[i][componentForm[addressType]];
		  document.getElementById(addressType).value = val;
		}
	  }
	  
	  document.getElementById("latitude").value = place.geometry.location.lat();
	  document.getElementById("longitude").value = place.geometry.location.lng();
	  
	}
	// [END region_fillform]

	// [START region_geolocation]
	// Bias the autocomplete object to the user's geographical location,
	// as supplied by the browser's 'navigator.geolocation' object.
	function geolocate() {
	  if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
		  var geolocation = new google.maps.LatLng(
			  position.coords.latitude, position.coords.longitude);
		  autocomplete.setBounds(new google.maps.LatLngBounds(geolocation,
			  geolocation));
		});
	  }
	}
	// [END region_geolocation]


    function initialize() {
        var markers = [];
		
        // Create the search box and link it to the UI element.
        var input = /** @type {HTMLInputElement} */(
        document.getElementById('pac-input'));
		
		
		  autocomplete = new google.maps.places.Autocomplete(
			  /** @type {HTMLInputElement} */(document.getElementById('pac-input')),
			  { types: ['geocode'] });
		  // When the user selects an address from the dropdown,
		  // populate the address fields in the form.
		  google.maps.event.addListener(autocomplete, 'place_changed', function() {
			fillInAddress();
		  });
		
		
    }
    google.maps.event.addDomListener(window, 'load', initialize);

</script>

<section id="content" class="cms dashboard invite_friends post_trade">
    <div class="page_holder">
        <div class="page_inner">
            <div class="page_head">
                <h2><?php echo lang('create_a_bitcoin_trade_advertisement'); ?></h2>                
            </div>
            <div class="wallet_section">
                <div class="send_bitcoin">
                    <div class="send_bitcoin_in invite_friend_in">                    	
                        <div class="info_send">
                            <p><?php echo lang('create_ur_own_bitcoin_trade_advertisement'); ?> <a href="<?php echo base_url(); ?>cms/17/bitcoins-question-answers" target="_blank"><?php echo lang('answer_to_mybitcoins_com_trade_advertisements_in_your_city'); ?>.</a></p>
                            <p><?php echo lang('creating_an_advertisement_is'); ?> <strong><?php echo lang('free'); ?>.</strong></p>
                            <p><?php echo lang('before_setting_up_your_advertisement_please_read'); ?> <a href="<?php echo base_url(); ?>cms/17/selling-bitcoins-online-guide" target="_blank"><span class="info_small_icn"></span><?php echo lang('online_sale_advertisement_guide'); ?></a> <?php echo lang('and'); ?> <a href="<?php echo base_url(); ?>cms/17/running-cash-exchange-guide" target="_blank"><span class="info_small_icn"></span><?php echo lang('cash_exchange_guide'); ?>.</a></p>
                        </div>
                    </div>                	
                </div>
                <form name="frm_ad_details" id="frm_ad_details" action="<?php echo base_url(); ?>advertise/add" method="post" >
                    <div class="send_bitcoin">
                        <div class="send_bitcoin_in invite_friend_in">
                            <div class="page_head">
                                <h5><?php echo lang('trade_type'); ?></h5>
                            </div>                        
                            <div class="banner_form_data">
                                <div class="formdata">                        	

                                    <fieldset>
                                        <label><?php echo lang('i_want_to'); ?></label>
                                        <div class="tex_data">
                                            <div class="inner_div"><input type="radio" value="sell_o" id="id_sell_online" name="trade_type"><span><?php echo lang('sell_bitcoins_online'); ?></span></div>
                                            <div class="inner_div"><input type="radio" value="buy_o" id="id_buy_online" name="trade_type"><span><?php echo lang('buy_bitcoins_online'); ?></span></div>
                                            <div class="inner_div"><input type="radio" value="sell_c" id="id_sell_cash" name="trade_type"><span><?php echo lang('sell_bitcoins_locally_for_cash'); ?></span></div>
                                            <div class="inner_div"><input type="radio" value="buy_c" id="id_buy_cash" name="trade_type"><span><?php echo lang('buy_bitcoins_locally_with_cash'); ?></span></div>
                                            <div for="trade_type" class="error"></div>
                                        </div>
                                        <div class="info_data">
                                            <p><em>What kind of trade advertisement you wish to create? If you wish to sell bitcoins make sure you have bitcoins on your myBitcoins.com wallet.</em> </p>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <label><?php echo lang('location'); ?></label>
                                        <div class="tex_data">
                                            <input type="text" value="" name="location" id="pac-input" placeholder="Enter location">                                      
                                            <input type='hidden' value='' name='latitude' id='latitude'/>
                                            <input type='hidden' value='' name='longitude' id='longitude'/>
                                            <input type='hidden' value='' name='city' id='administrative_area_level_2'/>
                                            <input type='hidden' value='' name='state' id='administrative_area_level_1'/>
                                            <input type='hidden' value='' name='country' id='country'/>						
											
											
                                            <div for="pac-input" class="error"></div>
                                        </div>
                                        <div class="info_data">
                                            <p><em>For online trade you need to specify the country. For local trade, please specify a city, postal code or street name.</em></p>
                                        </div>
                                    </fieldset>
                                    <fieldset style="display:none;" id="row_id_online_provider">
                                        <label><?php echo lang('payment_method'); ?></label>
                                        <select name="payment_method" id="payment_method" onchange="getDesc(this.value);">
                                            <?php foreach ($arr_payment_method_details as $method) { ?>
                                                <option value="<?php echo $method['method_id']; ?>"><?php echo $method['method_name']; ?></option>
                                            <?php } ?>                                            
                                        </select>
										<div class="info_data" id="payment_desc">                                            
											
                                        </div>
                                    </fieldset>                                                     
                                </div>
                            </div>                    
                        </div>                	
                    </div>
                    <div class="send_bitcoin">
                        <div class="send_bitcoin_in invite_friend_in">
                            <div class="page_head">
                                <h5><?php echo lang('more_information'); ?></h5>
                            </div>                        
                            <div class="banner_form_data">
                                <div class="formdata">                        	
                                    <fieldset>
                                        <label><?php echo lang('currency'); ?></label>
                                        <select name="currency" id="currency" class="FETextInput" onchange="changeCurrency(this.value)">
                                            <?php foreach ($arr_currency_details as $currency) { ?>
                                                <option  value="<?php echo $currency['currency_id']; ?>" <?php echo ($currency['currency_code'] == 'USD') ? 'selected' : ''; ?>><?php echo $currency['currency_code']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </fieldset>
                                    <fieldset id="bank_name_field">
                                        <label><?php echo lang('payment_service'); ?> / <?php echo lang('bank_name'); ?> </label>
                                        <input type="text" value="" name="bank_name" id="bank_name" class="FETextInput" placeholder="<?php echo lang('enter_bank_name'); ?>">
                                        <div class="info_data">
                                            <p><em>Optional. Bank/payment provider name/code. For international wire transfers, please specify bank SWIFT / BIC code</em></p>
                                        </div>
                                    </fieldset>
                                    <fieldset id="row_id_floating_price_chk" >
                                        <label><?php echo lang('floating_price'); ?></label>
                                        <div class="tex_data">
                                            <div class="inner_div">
                                                <input type="checkbox" value="Y" name="floating_price_chk" id="floating_price_chk">
                                            </div>
                                        </div>
                                        <div class="info_data">
                                            <p><em>Make the exchange rate float with market. Uses cryptosi_sell variable with defined margin. </a></em></p>
                                        </div>
                                    </fieldset>                                     

                                    <fieldset id="row_id_floating_premium" style="display:none;" >
                                        <label><?php echo lang('floating_margin'); ?></label>
                                        <div class="tex_data">
                                            <div class="inner_div">
                                                <input type="text" value="" name="float_premium" id="float_premium">
                                            </div>
                                        </div>
                                        <div class="info_data">
                                            <p><em>Make the exchange rate float with market. Uses cryptosi_sell variable with defined margin. </a></em></p>
                                        </div>
                                    </fieldset>                                     
                                    <fieldset id="row_id_premium" style="display:block;">
                                        <label><?php echo lang('margin'); ?></label>
                                        <div class="tex_data small_input">
                                            <div class="inner_div">
                                                <input type="text" value="" name="premium" id="premium" onkeyup="changeCurrencyRateAsPerMargin(this.value)">
                                                <div class="greay_btn" id="premium_btn">%</div>                                                                                     
                                                <div for="premium" class="error" style=""></div>
                                            </div>
                                        </div>
                                        <div class="info_data">
                                            <p><em>Make the exchange rate float with market. Uses cryptosi_sell variable with defined margin. </a></em></p>
                                        </div>
                                    </fieldset>                                                                 
                                    <fieldset id="row_id_price_equation">
                                        <label><?php echo lang('price_equation'); ?></label>
                                        <div class="tex_data">
                                            <input type="text"  name="price_eq" id="price_eq"   value="bitstampusd" />
											<input type="hidden"  name="price_eq_val" id="price_eq_val"  value="1.0" />
                                            <p><em>Trade price with current market value</em><br/><strong id="btc_loader"></strong><strong style="color: #43ac6a;" id="btc_rate_of_selected_currency"><?php echo $btc_rate_in_usd; ?> USD / BTC</strong></p>
                                        </div>
                                        <div class="info_data">
                                            <p><em>How the trade price is determined from the hourly market price.</em></p>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <label><?php echo lang('min_amount'); ?></label>
                                        <div class="tex_data small_input">
                                            <input type="text" value="" name="min_amt" id="min_amt"  placeholder="15.00">
                                            <div class="greay_btn" id="min_amt_btn">USD</div>
                                            <div for="min_amt" class="error" style=""></div>
                                        </div>
                                        <div class="info_data">
                                            <p><em>Optional. Minimum transaction limit in one trade.</em></p>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <label><?php echo lang('max_amount'); ?></label>
                                        <div class="tex_data small_input">
                                            <input type="text" value="" name="max_amt" id="max_amt" placeholder="20.00">
                                            <div class="greay_btn" id="max_amt_btn">USD</div>                                       
                                            <div for="max_amt" class="error" style=""></div>
                                        </div>
                                        <div class="info_data">
                                            <p><em>Optional. Maximum transaction limit in one trade. For online sells, your Cryptosi.com wallet balance may limit the maximum fundable trade also.</em></p>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <label><?php echo lang('contact_hours'); ?></label>
                                        <div class="tex_data">
                                            <input type="text" placeholder="" value="" name="contact_hrs" id="contact_hrs">                                        
                                        </div>
                                        <div class="info_data">
                                            <p><em>Days and hours when you are available to fulfill orders. Example: Mon-Sun 08:00-22:00</em></p>
                                        </div>
                                    </fieldset>
                                    <fieldset id="meeting_place_field">
                                        <label><?php echo lang('meeting_places'); ?></label>
                                        <div class="tex_data">
                                            <input type="text" name="meeting_place" id="meeting_place" placeholder="E.g. local Internet cafe or restaurant" value="">                                        
                                        </div>
                                        <div class="info_data">
                                            <p><em>Where would you prefer the cash exchange to take place. E.g. local Internet cafe or restaurant.</em></p>
                                        </div>
                                    </fieldset>                                    
                                    <fieldset>
                                        <label><?php echo lang('other_information'); ?> </label>
                                        <div class="tex_data">
                                            <textarea rows="8" name="other_info" id="other_info"></textarea>                                        
                                        </div>
                                        <div class="info_data">
                                            <p><em> Other information you wish to tell about your trading. Example 1: <strong>This advertisement is only for cash trades. If you want to pay online, contact Cryptosi.com/ad/1234.</strong> Example 2: <strong>Please make request only when you can complete the payment with cash within 12 hours</strong></em></p>
                                        </div>
                                    </fieldset>                                   
                                </div>
                            </div>                    
                        </div>                	
                    </div>
                    <div class="send_bitcoin" id="online_sell_fieldset">
                        <div class="send_bitcoin_in invite_friend_in">
                            <div class="page_head">
                                <h5><?php echo lang('online_selling_options'); ?></h5>
                            </div>                        
                            <div class="banner_form_data">
                                <div class="formdata">                        	
                                    <fieldset>
                                        <label><?php echo lang('payment_details'); ?></label>
                                        <div class="tex_data">
                                            <textarea rows="8" name="bank_detail" id="bank_detail"></textarea>                                        
                                        </div>
                                        <div class="info_data">
                                            <p><em>Optional. If necessary, please provide details how to transfer money. This is either bank account number for wire transfers or user account for money transfer websites.</em></p>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <label><?php echo lang('minimum_volume'); ?> </label>
                                        <input type="text" placeholder="0" value="0" name="min_volume" id="min_volume">
                                        <div class="info_data">
                                            <p><em>O How much previous trade volume the buyer is required to have in BTC. Set this value larger than zero to filter out the first time buyers who have no volume.</em></p>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <label><?php echo lang('minimum_feedback_score'); ?></label>
                                        <input type="text" placeholder="90" value="0" name="min_feedback" id="min_feedback" max="100">
                                        <div class="info_data">
                                            <p><em>The percentage of positive feedback score the buyer is required to have (0-100). This does not apply to first time buyers who do not yet have feedback score.</em></p>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <label><?php echo lang('new_buyer_limit'); ?></label>
                                        <div class="tex_data small_input">
                                            <input type="text" placeholder="0.7" value="" name="buyer_limit" id="buyer_limit">                                            
                                            <div class='greay_btn'>BTC</div>
                                            <div for="buyer_limit" class="error" style=""></div>
                                        </div>
                                        <div class="info_data">
                                            <p><em>Optional. If the contact has no earlier trading history, this is the bitcoin limit for the first transaction. Set to low value to limit your risk with fraud attempts.</em><br/><em>The limit can be at most 999.99 BTC. New buyers can only bid less than this limit, but reputable buyers can bid more.</em><br/><em>Only applies for online ads.</em></p>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <label><?php echo lang('transaction_volume_coefficient'); ?></label>
                                        <div class="tex_data small_input">
                                            <input type="text" placeholder="1.5" value="" name="volume_coefficient" id="volume_coefficient">
                                            <div class='greay_btn'>X</div>
                                            <div for="volume_coefficient" class="error" style=""></div>
                                        </div>
                                        <div class="info_data">
                                            <p><em>For repeat trades with a contact, limit purchase size maximum to this factor of total past trades with the contact.</em><em>Example: you have traded with contact A worth total 2 BTC. With a volume coefficient of 1.5, A can now create a new bid with you for at most 2 BTC * 1.5 = 3 BTC</em></p>
                                        </div>
                                    </fieldset>  
                                    <fieldset>
                                        <label><?php echo lang('display_reference'); ?></label>
                                        <div class="tex_data">
                                            <div class="inner_div">
                                                <input type="checkbox" checked="checked" value="Y" name="reference_chk" id="reference_chk">
                                            </div>
                                        </div>
                                        <div class="info_data">
                                            <p><em>Generate unique payment reference for each trade (e.g. for bank transfers).</em></p>
                                        </div>
                                    </fieldset>                                
                                    <fieldset>
                                        <label><?php echo lang('reference_type'); ?></label>
                                        <select name="reference_type" id="reference_type" class="FETextInput">
                                            <option value="LONG"><?php echo lang('long_form'); ?></option>
                                            <option selected="selected" value="SHORT"><?php echo lang('short_form'); ?></option>
                                            <option value="NUMERIC"><?php echo lang('numbers_only'); ?></option>
                                        </select>
                                        <div class="info_data">
                                            <p><em>The kind of a payment reference number is generated for transfer. Cryptosi.com generates a reference number for transfer which allows you to match money transfers to Cryptosi.com contacts.</em></p>
                                        </div>                                    
                                    </fieldset>
                                </div>
                            </div>                    
                        </div>                	
                    </div>
                    <div class="send_bitcoin">
                        <div class="send_bitcoin_in invite_friend_in" id="online_buy_fieldset" style="display:none;">
                            <div class="page_head">
                                <h5><?php echo lang('online_buying_options'); ?></h5>
                            </div>                        
                            <div class="banner_form_data">
                                <div class="formdata">                        	
                                    <fieldset>
                                        <label><?php echo lang('payment_window'); ?></label>
                                        <div class="tex_data">
                                            <input type="text" value="" name="payment_window" id="payment_window">
                                        </div>
                                        <div class="info_data">
                                            <p><em>minutes.</em></p>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>                    
                        </div>               	
                    </div>  
                    <div class="send_bitcoin">
                        <div class="send_bitcoin_in invite_friend_in" id="liquidity_options_fieldset" style="display:none;"> 
                            <div class="page_head">
                                <h5><?php echo lang('liquidity_options'); ?></h5>
                            </div>                        
                            <div class="banner_form_data">
                                <div class="formdata" >                        	
                                    <fieldset >
                                        <label><?php echo lang('track_liquidity'); ?></label>
                                        <div class="tex_data">
                                            <input type="checkbox" value="Y" checked="checked" name="liquidity_chk" id="liquidity_chk">
                                        </div>
                                        <!--<div class="info_data">
                                            <p><em>minutes.</em></p>
                                        </div>-->
                                    </fieldset>
                                </div>
                            </div>                    
                        </div>               	
                    </div>  
                    <div class="send_bitcoin">
                        <div class="send_bitcoin_in invite_friend_in">
                            <div class="page_head">
                                <h5><?php echo lang('security_options'); ?></h5>
                            </div>                        
                            <div class="banner_form_data">
                                <div class="formdata">                        	
                                    <fieldset id="row_id_real_name_chk" style="display:none;">
                                        <label><?php echo lang('real_name_required'); ?></label>
                                        <div class="tex_data">
                                            <input type="checkbox" value="Y" name="real_name_chk" id="real_name_chk">
                                        </div>
                                        <div class="info_data">
                                            <p><em>.</em></p>
                                        </div>
                                    </fieldset>
                                    <fieldset style="display: none;">
                                        <label><?php echo lang('sms_verification_required'); ?></label>
                                        <div class="tex_data">
                                            <input type="hidden" value="N" name="sms_veri_chk" id="sms_veri_chk">
                                        </div>
                                        <div class="info_data">
                                            <p><em>.</em></p>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <label><?php echo lang('trusted_people_only'); ?></label>
                                        <div class="tex_data">
                                            <input type="checkbox" value="Y" name="trusted_people_chk" id="trusted_people_chk">
                                        </div>
                                        <div class="info_data">
                                            <p><em>.</em></p>
                                        </div>
                                    </fieldset>
                                    <fieldset class="button">
                                        <button type="submit" name="btn_submit" id="btn_submit" value="Publish advertisement"><strong>Publish advertisement</strong></button>
                                    </fieldset>
                                </div>
                            </div>                    
                        </div>               	
                    </div>  
                </form>                
            </div>            
        </div>
    </div>
</section>
<style>
    #btc_loader { 
        width: 13%;
        text-align: center;
        padding-top: 0px;
        position: absolute;
    }
</style>

<script type="text/javascript">
jQuery(document).ready(function(e) {
	var id = $("#payment_method").val();
	getDesc(id);
});

	function getDesc(sel)
	{
		id = sel;
		//alert(id);
		
		jQuery.ajax ({
			type: "POST",
			url: "<?php echo base_url(); ?>payment-desc",
			data: { id : id , action: 'payment_method_desc' },
			success: function( fdata ) {			
			  //alert(fdata);
			  jQuery("#payment_desc").html(fdata);
			  //jQuery("#balance").val(fdata);
			}
		});
	}
	
    //Display loading Image
    function displayLoad()
    {
        $("#btc_loader").fadeIn(900,0);
        $("#btc_rate_of_selected_currency").hide();        
        $("#btc_loader").html("<img src='<?php echo base_url(); ?>media/front/images/spinner.gif'/>");
    }
    //Hide loading Image
    function hideLoad()
    { $("#btc_loader").fadeOut('slow');}
    
    function changeCurrency(currency_id){  
        
        obj_currancy =new Object();
        
        jQuery.each(arr_currencay_rates,function(ind,ele){
         
            if($("#currency option[value='"+currency_id+"']").text().trim()==ele.code){
                obj_currancy.name=ele.name;
                obj_currancy.code=ele.code;
                obj_currancy.rate=ele.rate;
            }            
        });
        
        var premium=$("#premium").val();
        var margin=1;
        if(premium == '' || premium==0){
            margin=0;
        }
      
        if(premium > 0) {
            premium=premium/100;
            margin=margin*premium;
        }else if(premium<0){
            premium=premium/100;
            margin=margin*premium;
        }
        var price_eq="";
        //If trade for selling online
		if($("input:radio[id='id_sell_online']").is(":checked")) {
			if(margin < 0){
				margin=1+margin;
				price_eq=""+margin;
			}else{
				price_eq=1+ margin;
			}
			//alert(price_eq);
			//alert(margin);
			$("#price_eq_val").val(price_eq);
		}
		
		//If trade for buying online
		if($("input:radio[id='id_buy_online']").is(":checked")) {
			if(margin < 0){
				margin=1-margin;
				price_eq=""+margin;
			}else{
				price_eq=1-margin;
			}
			//alert(price_eq);
			//alert(margin);
			$("#price_eq_val").val(price_eq);
		}
		
		//If trade for selling cash
		if($("input:radio[id='id_sell_cash']").is(":checked")) {
			if(margin < 0){
				margin=1+margin;
				price_eq=""+margin;
			}else{
				price_eq=1+ margin;
			}
			//alert(price_eq);
			//alert(margin);
			$("#price_eq_val").val(price_eq);
		}
		
		//If trade for buying cash
		if($("input:radio[id='id_buy_cash']").is(":checked")) {
			if(margin < 0){
				margin=1-margin;
				price_eq=""+margin;
			}else{
				price_eq=1-margin;
			}
			//alert(price_eq);
			//alert(margin);
			$("#price_eq_val").val(price_eq);
		}

               
        console.log("===>"+premium);
        if(obj_currancy.code != 'USD'){
            $("#price_eq").val('bitstampusd*USD_in_'+obj_currancy.code+'*'+price_eq);
        }else{
            $("#price_eq").val('bitstampusd*'+price_eq);    
        }
        $("#max_amt_btn").html(''+obj_currancy.code+'');
        $("#min_amt_btn").html(''+obj_currancy.code+'');
        var response_o = (Math.round(( obj_currancy.rate*100)*price_eq)/100).toFixed(2);
        $("#btc_rate_of_selected_currency").html(''+response_o+' '+obj_currancy.code+'/BTC');
              
    }
    
    $("#premium").change(function() {
        //   alert( "Handler for .change() called." );
    });
    
    /*calculate BTC price according to margin value*/
    
    function changeCurrencyRateAsPerMargin(margin_value){        
        //        displayLoad();        
             
        obj_currancy =new Object();
        jQuery.each(arr_currencay_rates,function(ind,ele){
         
            if(jQuery("#currency option:selected").text().trim()==ele.code){
                obj_currancy.name=ele.name;
                obj_currancy.code=ele.code;
                obj_currancy.rate=ele.rate;
            }            
        });
        
        var premium=$("#premium").val();
        var margin=1;
        if((premium == '') || (premium==0)){
            margin=0;
        }
		 
        if(premium > 0) {
            premium=premium/100;
            margin=margin*premium;
        }else if(premium<0){
            premium=premium/100;
            margin=margin*premium;
        }    
        var price_eq="";
		
		//If trade for selling online
		if($("input:radio[id='id_sell_online']").is(":checked")) {
			if(margin < 0){
				margin=1+margin;
				price_eq=""+margin;
			}else{
				price_eq=1+ margin;
			}
			//alert(price_eq);
			//alert(margin);
			$("#price_eq_val").val(price_eq);
		}
		
		//If trade for buying online
		if($("input:radio[id='id_buy_online']").is(":checked")) {
			if(margin < 0){
				margin=1-margin;
				price_eq=""+margin;
			}else{
				price_eq=1-margin;
			}
			//alert(price_eq);
			//alert(margin);
			$("#price_eq_val").val(price_eq);
		}
		
		//If trade for selling cash
		if($("input:radio[id='id_sell_cash']").is(":checked")) {
			if(margin < 0){
				margin=1+margin;
				price_eq=""+margin;
			}else{
				price_eq=1+ margin;
			}
			//alert(price_eq);
			//alert(margin);
			$("#price_eq_val").val(price_eq);
		}
		
		//If trade for buying cash
		if($("input:radio[id='id_buy_cash']").is(":checked")) {
			if(margin < 0){
				margin=1-margin;
				price_eq=""+margin;
			}else{
				price_eq=1-margin;
			}
			//alert(price_eq);
			//alert(margin);
			$("#price_eq_val").val(price_eq);
		}
		
		
               
        //        console.log('fggh'+premium+"==="+margin+"==="+price_eq);
        if(obj_currancy.code != 'USD'){
            $("#price_eq").val('bitstampusd*USD_in_'+obj_currancy.code+'*'+price_eq);
        }else{
            $("#price_eq").val('bitstampusd*'+price_eq);    
        }
                
        var response_o = (Math.round(( obj_currancy.rate*100)*price_eq)/100).toFixed(2);
		                  
        $("#max_amt_btn").html(''+obj_currancy.code+'');
        $("#min_amt_btn").html(''+obj_currancy.code+'');
        $("#btc_rate_of_selected_currency").html(''+response_o+' '+obj_currancy.code+'/BTC');
     
    }
</script>