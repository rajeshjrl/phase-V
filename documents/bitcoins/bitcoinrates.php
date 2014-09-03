<?php

//http://blockchain.info/tobtc?currency=GBP&value=100000 
/** Rference URl http://blockchain.info/api/exchange_rates_api * */
$currency = "USD"; //Currency Only allowed Currencies CNY,JPY,SGD,HKD,CAD,AUD,NZD,GBP,DKK,SEK,BRL,CHF,EUR,RUB,SLL
$value = "1000";

$post_data = "http://blockchain.info/tobtc?";
$post_data .= "currency=" . $currency;
$post_data .= "&value=" . $value;

$info = file_get_contents("https://bitpay.com/api/rates");
//$info = json_decode($info);
$info = json_encode($info);


//echo "<pre>";
print_r($info)

/*
  echo "Currency=".$currency;
  echo "\n Value=".$value."\n";
  echo "\n BTC=".$info."\n";

 */
?>
