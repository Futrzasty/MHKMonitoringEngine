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

$ds = ldap_connect("ldap://192.168.0.29");
if ($ds) {
    @ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
    @ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
    $r = @ldap_bind($ds, "it_helper", "is7285wp!>w-7z^#");
    //$sr = @ldap_search($ds, "DC=mhk,DC=local", "(&(sAMAccountName=" . $_POST['login'] . ")(objectCategory=User))");
    $sr = @ldap_search($ds, "DC=mhk,DC=local", "(&(sAMAccountName=wwilusz))");
    if (@ldap_count_entries($ds, $sr) > 0) {
        $info = @ldap_get_entries($ds, $sr);
        var_dump($info);
        $dateLargeInt = $info[0]["lastlogon"][0];
        $secsAfterADEpoch = $dateLargeInt / (10000000); // seconds since jan 1st 1601
        $ADToUnixConvertor=((1970-1601) * 365.242190) * 86400; // unix epoch - AD epoch * number of tropical days * seconds in a day
        $unixTsLastLogon=intval($secsAfterADEpoch-$ADToUnixConvertor); // unix Timestamp version of AD timestamp
        $lastlogon = date("Y-m-d H:i:s", $unixTsLastLogon); // formatted date
        echo $lastlogon;
        echo date("Y-m-d H:i:s", win_filetime_to_timestamp($dateLargeInt));
    } else {
        echo "nie znalazłem :-)";
    }
}

