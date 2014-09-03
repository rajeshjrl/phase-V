<?php

/*
  $main_password Your Main My wallet password
  $second_password Your second My Wallet password if double encryption is enabled.
  $to Recipient Bitcoin Address.
  $amount Amount to send in satoshi.
  $from Send from a specific Bitcoin Address (Optional)
  shared "true" or "false" indicating whether the transaction should be sent through a shared wallet. Fees apply. (Optional)
  $fee Transaction fee value in satoshi (Must be greater than default fee) (Optional)
  $note A public note to include with the transaction (Optional)

 */

/* parameter and values */
/* $guid = '15d2371e-009a-4a01-9a9c-ab505a7c2e61';
  $main_password = 's@ndeep123pawar';
  $address = '1P6T99B56zfoYV9LQFVdxYPm6RKfCW7qPp';
  $amount = ceil(0.1);
  $from = '144VGNi6YVUvXPpDjixhCT6KBvGShz5YSZ';
  $post_data_arr = "https://blockchain.info/merchant/$guid/payment?password=$main_password&to=$address&amount=$amount&from=$from";
  $result_arr = file_get_contents($post_data_arr);
  $result_arr = json_decode($result_arr);
  print_r($result_arr);
 */



$guid = "59f300da-2e38-474c-92b7-062baa7bead7";
$firstpassword = "vijay@1234";
//$secondpassword = "PASSWORD_HERE";
$amounta = "10000000";
//$amountb = "400000";
$addressa = "1A8JiWcwvpY7tAopUkSnGuEYHmzGYfZPiq";
//$addressb = "1ExD2je6UNxL5oSu6iPUhn9Ta7UrN8bjBy";
$recipients = urlencode('{ "' . $addressa . '": ' . $amounta . ' }');

$json_url = "http://blockchain.info/merchant/$guid/sendmany?password=$firstpassword&recipients=$recipients";
$json_data = file_get_contents($json_url);
$json_feed = json_decode($json_data);
print_r($json_feed);

//$message = $json_feed->message;
//$txid = $json_feed->tx_hash;
?>
