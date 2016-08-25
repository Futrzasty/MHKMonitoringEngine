<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>IT Helper WEB-APP</title>
</head>
<body>
<?php
/**
 * Created by PhpStorm.
 * User: gwozniak
 * Date: 2016-08-23
 * Time: 13:13
 */

function win_filetime_to_timestamp ($filetime) {
    $win_secs = substr($filetime,0,strlen($filetime)-7); // divide by 10 000 000 to get seconds
    $unix_timestamp = ($win_secs - 11644473600); // 1.1.1600 -> 1.1.1970 difference in seconds
    return $unix_timestamp;
}

function win_filetime_to_timestamp_bad ($dateLargeInt) {
    $secsAfterADEpoch = $dateLargeInt / (10000000); // seconds since jan 1st 1601
    $ADToUnixConvertor = ((1970 - 1601) * 365.242190) * 86400; // unix epoch - AD epoch * number of tropical days * seconds in a day
    $unixTsLastLogon = intval($secsAfterADEpoch - $ADToUnixConvertor); // unix Timestamp version of AD timestamp
    return $unixTsLastLogon;
}

function win_timedate_to_format ($t) {
    return substr($t,0,4)."-".substr($t,4,2)."-".substr($t,6,2)." ".substr($t,8,2).":".substr($t,10,2).":".substr($t,12,2)." GMT";
}

$ds = ldap_connect("ldap://192.168.0.29");
if ($ds) {
    @ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
    @ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
    $r = @ldap_bind($ds, "it_helper", "is7285wp!>w-7z^#");
    //$sr = @ldap_search($ds, "DC=mhk,DC=local", "(&(sAMAccountName=" . $_POST['login'] . ")(objectCategory=User))");
    $sr = @ldap_search($ds, "DC=mhk,DC=local", "(&(sAMAccountName=wadamczyk))");
    if (@ldap_count_entries($ds, $sr) > 0) {
        $info = @ldap_get_entries($ds, $sr);
        //var_dump($info);
        echo "lastLogon = ".date("Y-m-d H:i:s", win_filetime_to_timestamp_bad($info[0]["lastlogon"][0]))." (może być błędna wartość!)</br>";
        echo "lastLogon = ".date("Y-m-d H:i:s", win_filetime_to_timestamp($info[0]["lastlogon"][0]))." (może być błędna wartość!)</br>";
        echo "CN = ".$info[0]["cn"][0]."</br>";
        echo "description = ".$info[0]["description"][0]."</br>";
        echo "mail = ".$info[0]["mail"][0]."</br>";
        echo "pwdLastSet = ".date("Y-m-d H:i:s", win_filetime_to_timestamp($info[0]["pwdlastset"][0]))."</br>";
        //echo "badPasswordTime = ".date("Y-m-d H:i:s", win_filetime_to_timestamp($info[0]["badpasswordtime"][0]))."</br>";
        echo "whenCreated = ".win_timedate_to_format($info[0]["whencreated"][0])."</br>";
        echo "whenChanged = ".win_timedate_to_format($info[0]["whenchanged"][0])."</br>";
        echo "objectclass = ";
        for ($i=0; $i < $info[0]["objectclass"]["count"]; $i++) {
            echo $info[0]["objectclass"][$i]." | ";
        }
    } else {
        echo "nie znalazłem :-(";
    }
}
?>
</body>
</html>
