#!/usr/bin/php
<?php

  $url = "https://api.ninja.is/rest/v0/device/4412BB000425_0102_0_31?user_access_token=fEvgT1OLjFBW6smIXLOxv0y0zxAHzvW0IMI6Z6HTHU";
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $r = curl_exec($curl);

  $obj = json_decode($r);
  // var_dump($obj);

  $temp = $obj->data->last_data->DA;
  $d = date(DATE_RFC822, (string)$obj->data->last_data->timestamp/1000);

  echo "{$temp} {$d}";
  echo exec("/usr/bin/rrdtool update /var/Silex/web/rrd/hometemp.rrd N:{$temp}:0");
  // echo "/usr/bin/rrdtool update /var/Silex/web/rrd/hometemp.rrd N:{$temp}:0";

?>


