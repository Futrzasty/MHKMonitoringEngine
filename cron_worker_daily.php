<?php

        include_once "JSON/config.php";

	$dbi = 2;

        mysql_connect($dbhost[$dbi], $dbuser[$dbi], $dbpass[$dbi]);
        @mysql_select_db($dbname[$dbi]) or die("Nie udało się wybrać bazy danych");

        mysql_query("SET CHARACTER SET utf8");
        mysql_query("SET NAMES utf8");
        mysql_query("SET COLLATION utf8");

	
	mysql_query("TRUNCATE TABLE `router_ping`;");
	mysql_query("TRUNCATE TABLE `switch_ping`;");
	mysql_query("TRUNCATE TABLE `wireless_ping`;");

	mysql_close();
?>
