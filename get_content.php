<?php

//include <functions.php>

$host = 'http://ct.mhk.pl/wps/portal/';
$tekst = 'Eksponat tygodni5';
//check_www($host, $tekst, 20)

 $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$host);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
//      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
//      curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
        $tresc=curl_exec ($ch);
        curl_close ($ch);
echo stripos($tresc, $tekst);
?>
