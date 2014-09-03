<?php

$password = "sandeep123456"; //The password for the new wallet. Must be at least 10 characters in length.
$guid = "e8186c2c-54ae-430e-989b-96be65fb9f01";
$post_data = "https://blockchain.info/merchant/$guid/balance?password=$password";
$info = '{"guid":"e8186c2c-54ae-430e-989b-96be65fb9f01","address":"1NZgmnVDc6nWiPVWzf4E6WwBM9fNg6LgET","link":"https:\/\/blockchain.info\/wallet\/e8186c2c-54ae-430e-989b-96be65fb9f01"}';
$info = file_get_contents($post_data);
$info = json_decode($info);
echo 'Wallet balance => '.$info->balance;
?>
