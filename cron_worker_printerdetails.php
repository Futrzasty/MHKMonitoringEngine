<?php
	error_reporting(E_ALL & ~E_NOTICE);
	include_once ("functions.php");

	$server = new mysqli('localhost', $db_user, $db_pass, $db_name);
	if (mysqli_connect_error()) {
		die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
	}

	$server->query("SET CHARACTER SET utf8");
	$server->query("SET NAMES utf8");
	$server->query("SET COLLATION utf8");

	snmp_set_valueretrieval(SNMP_VALUE_PLAIN);

    $hosts = get_JSON_value('getPrinterList');
	
	foreach ($hosts as $host) {
		$result = $server->query("SELECT community FROM printer_snmp WHERE host = \"$host\";");
		$row = $result->fetch_assoc();
		$community = $row["community"];

		$values = snmp2_walk ($host, $community, ".1.3.6.1.2.1.43.11.1.1.9");
		$names = snmp2_walk ($host, $community, ".1.3.6.1.2.1.43.11.1.1.6");
		foreach ($names as $i => $name) {
			$result = $server->query("SELECT value_max FROM printer_snmp_details WHERE host = \"$host\" AND name = \"$name\";");

			if ($result->num_rows != 0) {
				$row = $result->fetch_assoc();
				if (($values[$i] >= 0) && ($row["value_max"] > 0)) {
					$value = ($values[$i]/$row["value_max"]) * 100;
				}
				else if (($values[$i] >= 0) && ($row["value_max"] <= 0))
				{
					$value = $values[$i];
				}
				else
				{
					$value = -1;
				}

				$server->query("UPDATE printer_snmp_details SET `value` = \"$value\", `value_raw` = \"$values[$i]\", `last_change`= CURRENT_TIMESTAMP WHERE `host` = \"$host\" AND name = \"$name\";");

			}
		}
	}

