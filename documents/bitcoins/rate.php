<?php

ob_clean();
ob_start();
$currency = $_REQUEST['currency'];
$value = $_REQUEST['value'];
echo file_get_contents("http://blockchain.info/tobtc?currency=" . $currency . "&value=" . $value);
?>
