<?php //echo "<pre>";print_r($arr_currency_details); exit;                       ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo (isset($title)) ? $title : $global['site_title']; ?></title>
        <?php $this->load->view('backend/sections/header'); ?>
        <style>
            .error {
                color: #BD4247;
                margin-left: 120px;
                width: 210px;
            }
            .FETextInput{
                margin-left: 120px;
                margin-top: -28px;
            }
            .add-on {
                float: right;
                margin-top: -17px;
                position: absolute;
            }
            #target {
                width: 345px;
            }
        </style>
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>media/backend/js/jquery.validate.min.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>media/backend/js/post-trade/add-advertise.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
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
    </head>
    <body>
        <?php $this->load->view('backend/sections/top-nav.php'); ?>
        <?php $this->load->view('backend/sections/leftmenu.php'); ?>
        <div id="content" class="span10">
            <!--[breadcrumb]-->
            <div>
                <ul class="breadcrumb">
                    <li> <a href="<?php echo base_url(); ?>backend/dashboard">Dashboard</a> <span class="divider">/</span> </li>
                    <li> <a href="<?php echo base_url(); ?>backend/advertise">Post Trade</a> <span class="divider">/</span></li>
                    <li> Add Advertisement </li>
                </ul>
            </div>
            <!--[message box]-->
            <?php
            $msg = $this->session->userdata('msg');
            ?>
            <!--[message box]-->
            <?php if ($msg != '') { ?>
                <div class="msg_box alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" id="msg_close" name="msg_close">�</button>
                    <?php
                    echo $msg;
                    $this->session->unset_userdata('msg');
                    ?> 
                </div>
            <?php } ?>  
            <div class="row-fluid sortable">
                <!--[sortable header start]-->
                <div class="box span12">
                    <div class="box-header well">
                        <h2><i class=""></i>Add Advertisement</h2>
                        <div class="box-icon"> <a title="Post trade" class="btn btn-plus btn-round" href="<?php echo base_url(); ?>backend/advertise"><i class="icon-arrow-left"></i></a> </div>
                    </div>
                    <br >
                    <!--[sortable body]-->
                    <div class="box-content">
                        <form name="frm_ad_details" id="frm_ad_details" action="<?php echo base_url(); ?>backend/advertise/add-action" method="post" >
                            <legend>Trade type</legend>
                            <div class="control-group">
                                <label for="typeahead" class="control-label">I want to<sup class="mandatory">*</sup> </label>
                                <div class="controls" style="margin-top:-25px;margin-left:120px;">
                                    <label class="radio">
                                        <input type="radio" value="sell_o" id="id_sell_online" name="trade_type">
                                        Sell bitcoins online </label>
                                    <label class="radio">
                                        <input type="radio" value="buy_o" id="id_buy_online" name="trade_type">
                                        Buy bitcoins online </label>
                                    <label class="radio">
                                        <input type="radio" value="sell_c" id="id_sell_cash" name="trade_type">
                                        Sell bitcoins locally with cash </label>
                                    <label class="radio">
                                        <input type="radio" value="buy_c" id="id_buy_cash" name="trade_type">
                                        Buy bitcoins locally with cash </label>

                                </div>
                                <div for="trade_type" class="error" style=""></div>   
                            </div>
                            <div class="control-group">
                                <label for="typeahead" class="control-label">Location<sup class="mandatory">*</sup> </label>
                                <div class="controls">
                                    <input type="text" value="" name="location" id="pac-input" placeholder="Enter location" class="FETextInput">
                                    <input type='hidden' value='' name='latitude' id='latitude'/>
									<input type='hidden' value='' name='longitude' id='longitude'/>
									<input type='hidden' value='' name='city' id='administrative_area_level_2'/>
									<input type='hidden' value='' name='state' id='administrative_area_level_1'/>
									<input type='hidden' value='' name='country' id='country'/>
									
									
                                    <div id="map-canvas"></div>
                                </div>
                            </div>
                            <div class="control-group" id="row_id_online_provider" style="display:none;">
                                <label for="typeahead" class="control-label">Payment method<sup class="mandatory">*</sup> </label>
                                <div class="controls">
                                    <select name="payment_method" id="payment_method" class="FETextInput">
                                        <?php foreach ($arr_payment_method_details as $method) { ?>
                                            <option value="<?php echo $method['method_id']; ?>"><?php echo $method['method_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <legend>More information</legend>
                            <div class="control-group">
                                <label for="typeahead" class="control-label">Currency<sup class="mandatory">*</sup> </label>
                                <div class="controls">
                                    <select name="currency" id="currency" class="FETextInput" onChange="changeCurrency(this.value)">
                                        <?php foreach ($arr_currency_details as $currency) { ?>
                                            <option value="<?php echo $currency['currency_id']; ?>" <?php echo ($currency['currency_code'] == 'USD') ? 'selected' : ''; ?>  ><?php echo $currency['currency_code']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group" id="bank_name_field">
                                <label for="typeahead" class="control-label">Bank name</label>
                                <div class="controls">
                                    <input type="text" value="" name="bank_name" id="bank_name" class="FETextInput">
                                </div>
                            </div>
                            <div class="control-group" id="row_id_floating_price_chk">
                                <label for="typeahead" class="control-label">Floating price<sup class="mandatory">*</sup> </label>
                                <div class="controls" style="margin-top:-25px;margin-left:120px;">
                                    <input type="checkbox" value="" name="floating_price_chk" id="floating_price_chk" class="FETextInput">
                                </div>
                            </div>
                            <div class="control-group" id="row_id_floating_premium" style="display:none;">
                                <label for="typeahead" class="control-label"> Floating Margin<sup class="mandatory">*</sup> </label>
                                <div class="controls">
                                    <input type="text" value="" name="float_premium" id="float_premium" class="FETextInput">
                                </div>
                            </div>

                            <div class="control-group" id="row_id_premium" style="display:block;">
                                <label for="typeahead" class="control-label">Margin<sup class="mandatory">*</sup> </label>
                                <div class="controls">
                                    <input type="text" value="0" name="premium" id="premium" class="FETextInput" onkeyup ="changeCurrencyRateAsPerMargin(this.value)"><span class="add-on">%</span>
                                </div>
                            </div>
                            <div class="control-group" id="row_id_price_equation">
                                <label for="typeahead" class="control-label">Price equation<sup class="mandatory">*</sup> </label>
                                <div class="controls">
                                    <input type="text" name="price_eq" id="price_eq" class="FETextInput" value="bitstampusd*1">
                                </div><strong id="btc_loader"></strong><strong style="color: #43ac6a;margin-left: 119px;" id="btc_rate_of_selected_currency"><?php echo $btc_rate_in_usd; ?> USD / BTC</strong>
                            </div>
                            <div class="control-group">
                                <label for="typeahead" class="control-label">Min amount</label>
                                <div class="controls">
                                    <input type="text" value="" name="min_amt" id="min_amt" class="FETextInput">
                                    <button id="min_amt_btn" style="margin-top: -36px;">USD</button>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="typeahead" class="control-label">Max amount</label>
                                <div class="controls">
                                    <input type="text" value="" name="max_amt" id="max_amt" class="FETextInput">
                                    <button id="max_amt_btn" style="margin-top: -36px;">USD</button>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="typeahead" class="control-label">Contact hours<sup class="mandatory">*</sup> </label>
                                <div class="controls">
                                    <input type="text" value="" name="contact_hrs" id="contact_hrs" class="FETextInput">&nbsp;<span class="add-on">Example: Mon-Sun 08:00-22:00 </span>
                                    <div for="contact_hrs" class="error" style=""></div>   

                                </div>
                            </div>
                            <div class="control-group" id="meeting_place_field">
                                <label for="typeahead" class="control-label">Meeting places<sup class="mandatory">*</sup> </label>
                                <div class="controls">
                                    <input type="text" name="meeting_place" id="meeting_place" placeholder="E.g. local Internet cafe or restaurant" value="" class="FETextInput">
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="typeahead" class="control-label">Other information</label>
                                <div class="controls">
                                    <textarea name="other_info" id="other_info" class="FETextInput"></textarea>
                                </div>
                            </div>

                            <fieldset id="online_sell_fieldset">
                                <legend>Online selling options</legend>
                                <div class="control-group">
                                    <label for="typeahead" class="control-label">Bank transfer <br>details</label>
                                    <div class="controls">
                                        <textarea name="bank_detail" id="bank_detail" class="FETextInput"></textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="typeahead" class="control-label">Minimum volume<sup class="mandatory">*</sup> </label>
                                    <div class="controls">
                                        <input type="text" value="0" name="min_volume" id="min_volume" class="FETextInput">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="typeahead" class="control-label">Minimum feedback <br /> score<sup class="mandatory">*</sup> </label>
                                    <div class="controls">
                                        <input type="text" value="0" name="min_feedback" id="min_feedback" class="FETextInput">
                                    </div>
                                </div>
                                <div class="control-group">New buyer limit</label>
                                    <div class="controls">
                                        <input type="text" value="" name="buyer_limit" id="buyer_limit" class="FETextInput"><span class="add-on">BTC</span>
                                    </div>
                                </div>
                                <div class="control-group">Transaction volume <br />coefficient <sup class="mandatory">*</sup> </label>
                                    <div class="controls">
                                        <input type="text" value="1.5" name="volume_coefficient" id="volume_coefficient" class="FETextInput"><span class="add-on">X</span>
                                    </div>
                                </div>
                                <div class="control-group">Display reference<sup class="mandatory">*</sup> </label>
                                    <div class="controls" style="margin-top:-25px;margin-left:120px;">
                                        <input type="checkbox" checked="checked" value="Y" name="reference_chk" id="reference_chk" class="FETextInput">
                                    </div>
                                </div>
                                <div class="control-group">Reference type<sup class="mandatory">*</sup> </label>
                                    <div class="controls">
                                        <select name="reference_type" id="reference_type" class="FETextInput">
                                            <option value="LONG">Long form</option>
                                            <option selected="selected" value="SHORT">Short form</option>
                                            <option value="NUMERIC">Numbers only</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset id="online_buy_fieldset" style="display:none;">
                                <legend>Online buying options</legend>
                                <div class="control-group">Payment window<sup class="mandatory">*</sup> </label>
                                    <div class="controls">
                                        <input type="text" value="360" name="payment_window" id="payment_window" class="FETextInput"><span class="add-on">minutes</span>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset id="liquidity_options_fieldset" style="display:none;">
                                <legend>Liquidity options</legend>
                                <div class="control-group">Track liquidity<sup class="mandatory">*</sup> </label>
                                    <div class="controls" style="margin-top:-25px;margin-left:120px;">
                                        <input type="checkbox" value="Y" checked="checked" name="liquidity_chk" id="liquidity_chk" class="FETextInput">
                                    </div>
                                </div>
                            </fieldset>
                            <legend>Security options</legend>
                            <div class="control-group" id="row_id_real_name_chk" style="display:none;">Real name <br />required<sup class="mandatory">*</sup> </label>
                                <div class="controls" style="margin-top:-25px;margin-left:120px;">
                                    <input type="checkbox" value="Y" name="real_name_chk" id="real_name_chk" class="FETextInput">
                                </div>
                            </div>
                            <input type="hidden" value="N" name="sms_veri_chk" id="sms_veri_chk" class="FETextInput">
                            <?php /* <div class="control-group">SMS verification <br />required<sup class="mandatory">*</sup> </label>
                              <div class="controls" style="margin-top:-25px;margin-left:120px;">
                              <input type="checkbox" value="Y" name="sms_veri_chk" id="sms_veri_chk" class="FETextInput">
                              </div>
                              </div> */ ?>
                            <div class="control-group">Trusted people<br />only<sup class="mandatory">*</sup> </label>
                                <div class="controls" style="margin-top:-25px;margin-left:120px;">
                                    <input type="checkbox" value="Y" name="trusted_people_chk" id="trusted_people_chk" class="FETextInput">
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" name="btn_submit" class="btn btn-primary" value="Save changes">Publish advertisement</button>
                            </div>
                        </form>
                    </div>
                    <!--[sortable body]-->
                </div>
            </div>
            <!--[sortable table end]-->
            <!--[include footer]-->
        </div>
        <!--/#content.span10-->
    </div>
    <!--/fluid-row-->
    <?php $this->load->view('backend/sections/footer.php'); ?>
</div>

<style>
    /*    #btc_loader { 
            width: 13%;
            text-align: center;
            padding-top: 0px;
            position: absolute;
        }*/
</style>

<script type="text/javascript">

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
    /*
    function changeCurrency(currency_id){        
        displayLoad();
        
        $.ajax({                    
            url:"<?php echo base_url(); ?>ajax-change-currency",
            data:{"currency_id":currency_id},
            method:"post",
            
            /*send ajax call and load spinner
            
            success:function(response){
                
                var response  = response.split(',');                
                var response_o = (Math.round((response[0]*100))/100).toFixed(2)  
                  
                $("#max_amt_btn").replaceWith('<button id="max_amt_btn" style="margin-top: -36px;">'+response[1]+'</button>');
                $("#min_amt_btn").replaceWith('<button id="min_amt_btn" style="margin-top: -36px;">'+response[1]+'</button>');
                $("#btc_rate_of_selected_currency").replaceWith('<strong style="color: #43ac6a;margin-left: 119px;" id="btc_rate_of_selected_currency">'+response_o+' '+response[1]+'/ BTC</strong>');

                if(response[1] != 'USD'){
                    $("#price_eq").replaceWith('<input type="text" value="bitstampusd*USD_in_'+response[1]+'*1" name="price_eq" id="price_eq" class="FETextInput">');
                }else{
                    $("#price_eq").replaceWith('<input type="text" value="bitstampusd*1" name="price_eq" id="price_eq" class="FETextInput">');    
                }
                hideLoad();
            }           
        });
        
    }
     */
    
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
        if(margin < 0){
            margin=1+margin;
            price_eq=margin;
        }else{
            price_eq=1+margin;
        }
               
        console.log("===>"+premium);
        if(obj_currancy.code != 'USD'){
            $("#price_eq").val('bitstampusd*USD_in_'+obj_currancy.code+'*'+price_eq);
        }else{
            $("#price_eq").val('bitstampusd*'+price_eq);    
        }
        $("#max_amt_btn").html(''+obj_currancy.code+'');
        $("#min_amt_btn").html(''+obj_currancy.code+'');
        var response_o = (Math.round(( obj_currancy.rate*100)*price_eq)/100).toFixed(2)  
        $("#btc_rate_of_selected_currency").html(''+response_o+' '+obj_currancy.code+'/BTC');
              
    }
    
    
    /*calculate BTC price according to margin value*/
    
    function changeCurrencyRateAsPerMargin(margin_value){        
          
        //          alert(margin_value);
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
        if(margin < 0){
            margin=1+margin;
            price_eq=""+margin;
        }else{
            price_eq=1+ margin;
        }
               
        console.log('fggh'+premium+"==="+margin+"==="+price_eq);
        if(obj_currancy.code != 'USD'){
            $("#price_eq").val('bitstampusd*USD_in_'+obj_currancy.code+'*'+price_eq);
        }else{
            $("#price_eq").val('bitstampusd*'+price_eq);    
        }
                
        var response_o = (Math.round(( obj_currancy.rate*100)*price_eq)/100).toFixed(2)  
                  
        $("#max_amt_btn").html(''+obj_currancy.code+'');
        $("#min_amt_btn").html(''+obj_currancy.code+'');
        $("#btc_rate_of_selected_currency").html(''+response_o+' '+obj_currancy.code+'/BTC');
     
    }    
    
</script>
</body>
</html>