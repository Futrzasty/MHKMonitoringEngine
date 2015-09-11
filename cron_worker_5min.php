<?php
        error_reporting(E_ALL & ~E_NOTICE);
        include_once ("functions.php");

        mysql_connect('localhost', $db_user, $db_pass);
        @mysql_select_db($db_name) or die("Nie udało się wybrać bazy danych");

        mysql_query("SET CHARACTER SET utf8");
        mysql_query("SET NAMES utf8");
        mysql_query("SET COLLATION utf8");


        $result = mysql_query('SELECT host, community, id, value FROM printer_snmp ORDER BY `order`;');
        while ($row = mysql_fetch_assoc($result)) {
        	$last_value = $row["value"];
		$id = $row["id"];

		$prn_state = get_printer_status($row["host"], $row["community"]);		

		mysql_query("UPDATE printer_snmp SET `state`=\"$prn_state[0]\", `value`= \"$prn_state[1]\", `full_info`= \"$prn_state[2]\" WHERE id = $id");
		
		if ($prn_state[1] != $last_value) 
			mysql_query("UPDATE printer_snmp SET `last_change`=CURRENT_TIMESTAMP WHERE id = $id");
        }

        mysql_close();
?>
