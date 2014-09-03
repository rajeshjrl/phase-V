<?php

//http://blockchain.info/tobtc?currency=GBP&value=100000 
/*
 * Rference URl http://blockchain.info/api/exchange_rates_api
 * 
 * 
 * */
//$info= (unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR'])));
$infoCurrency = (unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=182.72.122.106')));
$infoCurrency['geoplugin_currencyCode'];

$currency = "USD"; //Currency Only allowed Currencies CNY,JPY,SGD,HKD,CAD,AUD,NZD,GBP,DKK,SEK,BRL,CHF,EUR,RUB,SLL
$value = "10000";

//$post_data  = "http://blockchain.info/tobtc?";
$post_data = "https://bitpay.com/api/rates";
//$post_data .= "currency=".$currency;
//$post_data .= "&value=".$value;

$info = file_get_contents($post_data);
$info = json_decode($info);

//print_r($info);
foreach ($info as $k)
    if ($k->code == $infoCurrency['geoplugin_currencyCode']) {
        echo $k->code . "<br />";
        echo $k->name . "<br />";
        echo $k->rate . "<br />";
    }
//	echo $k->rate."<br />";

/*
  echo "Currency=".$currency;
  echo "\n Value=".$value."\n";
  echo "\n BTC=".$info."\n";
 */
?>
