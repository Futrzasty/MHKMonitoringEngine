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

        $result = $server->query("SELECT id FROM printer_snmp_details WHERE host = \"$host\";");

		//$info = get_JSON_value("getSwitchInfobyHostMaster", $host);
        if ($result->num_rows == 0) {
			$names = snmp2_walk ($host , $community , ".1.3.6.1.2.1.43.11.1.1.6");
			//$values = snmp2_walk ($host , $community , ".1.3.6.1.2.1.43.11.1.1.9");
			$maxes = snmp2_walk ($host , $community , ".1.3.6.1.2.1.43.11.1.1.8");
			foreach ($names as $i => $name) {
                $server->query("INSERT INTO printer_snmp_details (host, name, value_max) VALUES (\"$host\", \"$name\", \"$maxes[$i]\");");
			}
                        //$result=mysql_query("SELECT host, id, value FROM switch_ping WHERE host = \"$host\";");
        }
        //$row = $result->fetch_assoc();
		//$server->query("UPDATE switch_ping SET `alias` = \"$info->Alias\", `name` = \"$info->Name\", `impact` = \"$info->Impact\" WHERE `host` = \"$host\";");
	}
