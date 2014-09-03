<?php

/*
  Create Wallet API Create blockchain wallets programmatically

  The create_wallet method can be used to create a new blockchain.info bitcoin wallet. It can be created containing a pre-generated private key or will otherwise generate a new private key.

  URL: https://blockchain.info/api/v2/create_wallet
  Method: POST or GET

  $password The password for the new wallet. Must be at least 10 characters in length.
  $api_code An API code with create wallets permission.
  $priv A private key to add to the wallet (Wallet import format preferred). (Optional)
  $label A label to set for the first address in the wallet. Alphanumeric only. (Optional)
  $email An email to associate with the new wallet i.e. the email address of the user you are creating this wallet on behalf of. (Optional)

  Response: 200 OK, application/json

  {
  "guid": "4b8cd8e9-9480-44cc-b7f2-527e98ee3287",
  "address": "12AaMuRnzw6vW6s2KPRAGeX53meTf8JbZS",
  "link": "https://blockchain.info/wallet/4b8cd8e9-9480-44cc-b7f2-527e98ee3287"
  }

  Error Response: Error 500, text/plain

  Missing Parameter Password

  Making transactions to/from the new wallet

  The address returned in a successful response message can be used to deposit funds into the wallet.

  It is possible to send payments from the wallet by providing the guid and password to the blockchain wallet api. However this is not recommended as if the wallet password is changed or two factor authentication is enabled you will no longer be to access the wallet.

  Instead the recommended way to send payments is to provide a private key to the create_wallet method. A copy of this private key can be stored in order to send and receive payments from that specific address in the wallet. You can pass the private key directly to the blockchain wallet api instead of using the identifier and password.

 * 
 * */



$password = "sandeep123456"; //The password for the new wallet. Must be at least 10 characters in length.
$api_code = "f6c53cbe-5d44-476f-83b1-1d2ed5b6951a"; //An API code with create wallets permission.
$priv = ""; //A private key to add to the wallet (Wallet import format preferred). (Optional)
$label = ""; //A label to set for the first address in the wallet. Alphanumeric only. (Optional)
$email = ""; // An email to associate with the new wallet i.e. the email address of the user you are creating this wallet on behalf of. (Optional)

$post_data = "https://blockchain.info/api/v2/create_wallet";
$post_data .= "?api_code=" . $api_code;
$post_data .= "&password=" . $password;

if ($priv != "") {
    $post_data .= "&priv=" . $priv;
}
if ($label != "") {
    $post_data .= "&label=" . $label;
}

if ($email != "") {
    $post_data .= "&email=" . $email;
}

//$info = '{"guid":"e8186c2c-54ae-430e-989b-96be65fb9f01","address":"1NZgmnVDc6nWiPVWzf4E6WwBM9fNg6LgET","link":"https:\/\/blockchain.info\/wallet\/e8186c2c-54ae-430e-989b-96be65fb9f01"}';
$info=file_get_contents($post_data);
$info = json_decode($info);

echo '<pre>';
print_r($info);



echo $info->guid;
echo "<br />";
echo $info->address;
echo "<br />";
echo $info->link;
echo "<br />";
?>
