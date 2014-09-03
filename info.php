<html>
  <head>
    <title>Untitled</title>
  </head>
  <body><?php
  if (getenv('HTTP_X_FORWARDED_FOR')) {
        $pipaddress = getenv('HTTP_X_FORWARDED_FOR');
        $ipaddress = getenv('REMOTE_ADDR');
echo "Your Proxy IP address is : ".$pipaddress. "(via $ipaddress)" ;
    } else {
        $ipaddress = getenv('REMOTE_ADDR');
        echo "Your IP address is : $ipaddress";
    }
$country = getenv('GEOIP_COUNTRY_NAME');
   echo "Your country : $country";
phpinfo();
//mail('rajeshjrl@gmail.com','test','testing');
//mail('nitin@panaceatek.com','test','testing');
?>
  </body>
</html>
