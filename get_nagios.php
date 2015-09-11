<?php

include_once ("config.php");

$host = "http://nagios.mhk.local/cgi-bin/nagios3/status.cgi?host=all&servicestatustypes=28";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$host);
curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_USERPWD, "$nagios_username:$nagios_password");
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
$tresc=curl_exec ($ch);
curl_close ($ch);


$pocz = stripos($tresc, '<TABLE BORDER=0 width=100% CLASS=\'status\'>');
$tresc = substr($tresc, $pocz);
$pocz = stripos($tresc, 'Produced by Nagios (http://www.nagios.org)');
$tresc = substr($tresc, 0, $pocz);

//$pocz = stripos($tresc, '<TABLE BORDER=0 cellpadding=0 cellspacing=0>');
//$tresc = substr($tresc, $pocz);
//$pocz = stripos($tresc, '<!--');
//$tresc = substr($tresc, 0, $pocz-2);

$tresc = preg_replace("/<img[^>]+\>/i", " ", $tresc); 
$tresc = strip_tags($tresc, '<td>');

$tresc = str_ireplace("<TD></TD>", "OLD HOST", $tresc);

$pocz = stripos($tresc, 'Information');
$tresc = substr($tresc, $pocz+11);
$tresc = strip_tags($tresc);

$tresc = preg_split("/(\r\n|\n|\r)/", $tresc);

$tresc = array_map('trim', $tresc);
$tresc = array_filter($tresc);
$tresc = array_values($tresc);

$opis = array_pop($tresc);


//echo $tresc;
var_dump ($tresc);
?>
