<?php
$record = geoip_record_by_name('188.7.55.109');
if ($record) {
    echo '<pre>';
    print_r($record);
}
?>