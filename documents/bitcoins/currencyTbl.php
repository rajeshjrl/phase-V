<?php

$con = mysql_connect('localhost', 'root', 'root');
mysql_select_db('p784');


$post_data = "https://bitpay.com/api/rates";
$info = file_get_contents($post_data);
$info = json_decode($info);

$i = 1;
foreach ($info as $k) {

    $currency_name = $k->name;
    $currency_code = $k->code;
    $currency_exchange_code = 'USD_in_' . $currency_code;
    mysql_real_escape_string($currency_exchange_code);
    $query = 'INSERT INTO `p784_currency_management` VALUES ("","' . mysql_real_escape_string($currency_name) . '", "' . mysql_real_escape_string($currency_code) . '", "' . mysql_real_escape_string($currency_exchange_code) . '","A","' . date("Y-m-d H:i:s") . '","' . date("Y-m-d H:i:s") . '")';
    $result = mysql_query($query);
    echo $i . '=>' . $query . '<br>';
    $i++;
}
?>
