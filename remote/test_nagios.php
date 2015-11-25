<?php
/**
 * Created by PhpStorm.
 * User: gwozniak
 * Date: 2015-11-25
 * Time: 14:56
 */

    //$cmd = "/usr/lib/nagios/plugins/check_http -H bilety.mhk.pl -r adres";
    $cmd = "/usr/lib/nagios/plugins/check_ping -H 192.168.0.1 -w 200,50% -c 500,70%";
    $last_line = exec($cmd, $full_output, $return_code);
    echo $last_line."<br/>";
    var_dump($full_output);
    echo "<br/>";
    echo $return_code."<br/>";
    echo $full_output[0]."<br/>";
    $exp1 = explode("|", $full_output[0]);
    echo $exp1[0]."<br/>";
    echo $exp1[1]."<br/>";
    $exp2 = explode(" ", $exp1[1]);
    echo $exp2[0]."<br/>";
    echo $exp2[1]."<br/>";
    list($k, $v) = explode('=', $exp2[0]);
    $exp3[$k] = explode(";",$v)[0];
    list($k, $v) = explode('=', $exp2[1]);
    $exp3[$k] = explode(";",$v)[0];
    var_dump($exp3);