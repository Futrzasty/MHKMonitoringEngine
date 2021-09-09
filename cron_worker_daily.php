<?php
    include_once "JSON/config.php";
	$dbi = 2;

    $server = new mysqli($dbhost[$dbi], $dbuser[$dbi], $dbpass[$dbi], $dbname[$dbi]);
    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }

    $server->query("SET CHARACTER SET utf8");
    $server->query("SET NAMES utf8");
    $server->query("SET COLLATION utf8");

    $server->query("TRUNCATE TABLE `router_ping`;");
    $server->query("TRUNCATE TABLE `switch_ping`;");
    $server->query("TRUNCATE TABLE `wireless_ping`;");
    $server->query("TRUNCATE TABLE `printer_snmp_details`;");
