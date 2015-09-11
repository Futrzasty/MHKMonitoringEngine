<?php

        include_once "config.php";

	$dbi = 2;

        mysql_connect($dbhost[$dbi], $dbuser[$dbi], $dbpass[$dbi]);
        @mysql_select_db($dbname[$dbi]) or die("Nie udało się wybrać bazy danych");

        mysql_query("SET CHARACTER SET utf8");
        mysql_query("SET NAMES utf8");
        mysql_query("SET COLLATION utf8");

	$id = (int)$_SERVER["QUERY_STRING"];
	
	if ($id == $api_pin) {
		mysql_query("TRUNCATE TABLE `router_ping`;");
		mysql_query("TRUNCATE TABLE `switch_ping`;");
		mysql_query("TRUNCATE TABLE `wireless_ping`;");
		echo "Tabele `router_ping`, `switch_ping`, `wireless_ping` wyczyszczone. Czekaj na odbudowę...";
	}
	else
	{
		echo "Błędny PIN";
	}
	mysql_close();
?>
