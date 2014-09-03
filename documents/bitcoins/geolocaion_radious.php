<?php

//geoip_record_by_name

$location = geoip_record_by_name("182.72.122.106");
print_r(geoip_record_by_name("182.72.122.106"));

mysql_connect("localhost", "root", "root") or die("Not connected");
mysql_select_db("p784") or die("db not connected");


$lat = trim($_REQUEST['lat']);
$lng = trim($_REQUEST['lng']);

//SELECT *, ( 3959 * acos( cos( radians( 18.53330039978 ) ) * cos( radians( lattitude ) ) * cos( radians( longitude ) - radians( 73.86669921875 ) ) + sin( radians( 18.53330039978 ) ) * sin( radians( lattitude ) ) ) ) AS distance FROM p784_geo_location ORDER BY distance LIMIT 0,40
//			$miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));

$lat = trim($location['latitude']);
$lng = trim($location['longitude']);

$lat = (!empty($lat) ? $lat : 41.3423502);
$lng = (!empty($lng) ? $lng : -73.0774616);

//$HelpQuery = sprintf("SELECT *, ( 3959 * acos( cos( radians( %s ) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians( %s ) ) + sin( radians( %s ) ) * sin( radians( lat ) ) ) ) AS distance FROM databaseTable ORDER BY distance LIMIT 0,5",$lat,$lng,$lat);
//closet locations
//$HelpQuery = sprintf("SELECT *, ( 3959 * acos( cos( radians( %s ) ) * cos( radians( lattitude ) ) * cos( radians( 	longitude ) - radians( %s ) ) + sin( radians( %s ) ) * sin( radians( lattitude ) ) ) ) AS distance FROM p784_geo_location ORDER BY distance LIMIT 0,40",$lat,$lng,$lat);

echo $HelpQuery = sprintf("SELECT *, ( 3959 * acos( cos( radians( %s ) ) * cos( radians( lattitude ) ) * cos( radians( 	longitude ) - radians( %s ) ) + sin( radians( %s ) ) * sin( radians( lattitude ) ) ) ) AS distance FROM p784_geo_location ORDER BY distance LIMIT 0,40", $lat, $lng, $lat);




/* $HelpQuery = sprintf("
  SELECT *, (3959*acos((sin($lat/57.3) * sin(lattitude/57.3))+ (cos($lat/57.3) * cos(lattitude/57.3) * cos(($lng - longitude)/57.3))))*8/5 AS exactDistance

  FROM p784_geo_location

  WHERE 1=1

  ORDER BY (3959*acos((sin($lat/57.3) * sin(lattitude/57.3))+ (cos($lat/57.3) * cos(lattitude/57.3) * cos(($lng - longitude)/57.3))))*8/5
  ");
 */

$HelpResult = mysql_query($HelpQuery);

$result = array();
$result['info'] = "";

if ($HelpResult) {
    while ($Helprow = mysql_fetch_assoc($HelpResult)) {
        $Helprow['distance'] = round($Helprow['distance'], 2);

        //Demo use
        $Helprow['distance_array'] = getDistanceBetweenPointsNew($lat, $lng, $Helprow['lattitude'], $Helprow['longitude']);

        $result['info'][] = $Helprow;
    }
} else {
    $result['info'] = "Error";
}

function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2) {
    $theta = $longitude1 - $longitude2;
    $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $miles = $miles * 60 * 1.1515;
    $feet = $miles * 5280;
    $yards = $feet / 3;
    $kilometers = $miles * 1.609344;
    $meters = $kilometers * 1000;
    return compact('miles', 'feet', 'yards', 'kilometers', 'meters');
}

echo "<pre>";
print_r($result);
?>
