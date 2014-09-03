<?php

ob_clean();
ob_start();
$arr_current_rate = json_decode(file_get_contents("https://bitpay.com/api/rates"));

foreach ($arr_current_rate as $key => $value) {
    if ($value->code == 'USD') {
        echo $value->rate;
    }
}
?>
