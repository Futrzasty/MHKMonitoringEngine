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
                $result = mysql_query("SELECT community FROM printer_snmp WHERE host = \"$host\";");
                $row = mysql_fetch_assoc($result);
                $community = $row["community"];

                $result = mysql_query("SELECT id FROM printer_snmp_details WHERE host = \"$host\";");

		//$info = get_JSON_value("getSwitchInfobyHostMaster", $host);
                if (mysql_num_rows($result) == 0) {
			$names = snmp2_walk ($host , $community , ".1.3.6.1.2.1.43.11.1.1.6");
			//$values = snmp2_walk ($host , $community , ".1.3.6.1.2.1.43.11.1.1.9");
			$maxes = snmp2_walk ($host , $community , ".1.3.6.1.2.1.43.11.1.1.8");
			foreach ($names as $i => $name) {
				mysql_query("INSERT INTO printer_snmp_details (host, name, value_max) VALUES (\"$host\", \"$name\", \"$maxes[$i]\");");
			}
                        //$result=mysql_query("SELECT host, id, value FROM switch_ping WHERE host = \"$host\";");
                }
                //$row = mysql_fetch_assoc($result);
		//mysql_query("UPDATE switch_ping SET `alias` = \"$info->Alias\", `name` = \"$info->Name\", `impact` = \"$info->Impact\" WHERE `host` = \"$host\";");
        }

?>
