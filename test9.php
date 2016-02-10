<?php
error_reporting(E_ALL & ~E_NOTICE);
include_once ("functions.php");

mysql_connect('localhost', $db_user, $db_pass);
@mysql_select_db($db_name) or die("Nie udało się wybrać bazy danych");

mysql_query("SET CHARACTER SET utf8");
mysql_query("SET NAMES utf8");
mysql_query("SET COLLATION utf8");

snmp_set_valueretrieval(SNMP_VALUE_PLAIN);


    $time_start = microtime(true);

    $result = mysql_query('SELECT host, community, oid, id, version FROM snmp_env ORDER BY `order`;');
    while ($row = mysql_fetch_assoc($result)) {
        if ($row["version"] == "1") {
            $value = snmpget($row["host"], $row["community"], $row["oid"], 1000000, 3);
        } else {
            $value = snmp2_get($row["host"], $row["community"], $row["oid"], 1000000, 3);
        }
        var_dump($value);
        echo "<br/>";
        //if (!$value) $value = 0;
    }
echo "<br/>";
echo "<br/>";
$value = snmpget("192.168.16.9", "CIAWeb_Sens", ".1.3.6.1.4.1.22626.1.2.1.1.0", 1000000, 3);
var_dump($value);