<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>


<?php
// $info=file_get_contents("http://rate-exchange.appspot.com/currency?from=USD&to=INR&q=1");
$info = file_get_contents("http://rate-exchange.appspot.com/currency?from=INR&to=USD&q=1");
$info = json_decode($info);

echo "<pre>";
print_r($info);
echo "</pre>";
?>


<script type="text/javascript">
    jQuery(document).ready(function(){
	
        var current_USD_rate_to_local_currency='<?php echo $info->rate; ?>';
        alert(current_USD_rate_to_local_currency);
        /*USD TO BTC*/
        jQuery("#txtcurencyrate").change(function(){
            var current_value=jQuery(this).val();
            var current_calculated_value=jQuery(this).val()/current_USD_rate_to_local_currency;
            jQuery.get("rate.php",{currency:"USD",value:current_calculated_value},function(data){
                console.log(current_calculated_value);
                console.log(data);
            },'json');
        });
	
        
        jQuery("#txtbtcrate").change(function(){
            var current_value=jQuery(this).val();
            var current_calculated_value=jQuery(this).val()/current_USD_rate_to_local_currency;
            jQuery.get("btc.php",{currency:"USD",value:current_calculated_value},function(data){
                console.log(current_calculated_value);
                console.log(data);
            });
        });
    });

</script>


<input type="text" name="txtcurencyrate" id="txtcurencyrate" />

<input type="text" name="txtbtcrate" id="txtbtcrate" />




<?php
/*
  $info=file_get_contents("http://rate-exchange.appspot.com/currency?from=USD&to=INR&q=1");
  $info=json_decode($info);

  echo "<pre>";
  print_r($info); */

//http://blockchain.info/tobtc?currency=GBP&value=100000 
/*
 * Rference URl http://blockchain.info/api/exchange_rates_api
 * 
 * 
 * */

$currency = "USD"; //Currency Only allowed Currencies CNY,JPY,SGD,HKD,CAD,AUD,NZD,GBP,DKK,SEK,BRL,CHF,EUR,RUB,SLL
$value = "1000";




$post_data = "http://blockchain.info/tobtc?";
$post_data .= "currency=" . $currency;
$post_data .= "&value=" . $value;

//$info=file_get_contents("https://bitpay.com/api/rates");
//$info=json_decode($info);

echo "<pre>";
//print_r($info)

/*
  echo "Currency=".$currency;
  echo "\n Value=".$value."\n";
  echo "\n BTC=".$info."\n";

 */
?>
