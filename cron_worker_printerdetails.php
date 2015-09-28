<?php
        error_reporting(E_ALL & ~E_NOTICE);
        include_once ("functions.php");

        mysql_connect('localhost', $db_user, $db_pass);
        @mysql_select_db($db_name) or die("Nie udało się wybrać bazy danych");

        mysql_query("SET CHARACTER SET utf8");
        mysql_query("SET NAMES utf8");
        mysql_query("SET COLLATION utf8");

	snmp_set_valueretrieval(SNMP_VALUE_PLAIN);

        $hosts = get_JSON_value('getPrinterList');
	
	foreach ($hosts as $host) {
		$values = snmp2_walk ($host, "public", ".1.3.6.1.2.1.43.11.1.1.9");
		$names = snmp2_walk ($host, "public", ".1.3.6.1.2.1.43.11.1.1.6");
		foreach ($names as $i => $name) {
			$result = mysql_query("SELECT value_max FROM printer_snmp_details WHERE host = \"$host\" AND name = \"$name\";");

			if (mysql_num_rows($result) != 0) {
				$row = mysql_fetch_assoc($result);	
				if (($values[$i] > 0) && ($row["value_max"] > 0)) {
					$value = ($values[$i]/$row["value_max"]) * 100;
				}
				else
					$value = -1;
				
				mysql_query("UPDATE printer_snmp_details SET `value` = \"$value\", `value_raw` = \"$values[$i]\" WHERE `host` = \"$host\" AND name = \"$name\";");

			}
		}
        }

?>
