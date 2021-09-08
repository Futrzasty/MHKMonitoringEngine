<?php
        error_reporting(E_ALL & ~E_NOTICE);
        include_once ("functions.php");

        mysql_connect('localhost', $db_user, $db_pass);
        @mysql_select_db($db_name) or die("Nie udało się wybrać bazy danych");

        mysql_query("SET CHARACTER SET utf8");
        mysql_query("SET NAMES utf8");
        mysql_query("SET COLLATION utf8");

	
	$hosts = get_JSON_value('getSwitchListMaster');
        foreach ($hosts as $host) {
                $result = mysql_query("SELECT host, id, value, impact, state FROM switch_ping WHERE host = \"$host\";");
		if (mysql_num_rows($result) == 0) {
	   		$info = get_JSON_value("getSwitchInfobyHostMaster", $host);
			mysql_query("INSERT INTO switch_ping (host, alias, name, impact) VALUES (\"$host\", \"$info->Alias\", \"$info->Name\", \"$info->Impact\");");
	   		$result=mysql_query("SELECT host, id, value, impact, state FROM switch_ping WHERE host = \"$host\";");
		}
		$row = mysql_fetch_assoc($result);
        
		$switch_value = ping($host, 2)[2];
		$switch_state = 0;
		$switch_state_old = $row["state"];

		if ($switch_value == "") {
        	$switch_value = "NULL";
            if ($row["impact"] == 3) $switch_state = 1; else $switch_state = 2;
		}

		if ($switch_state != $switch_state_old) {
			mysql_query("UPDATE switch_ping SET `value` = $switch_value, `state` = \"$switch_state\", `last_change` = current_timestamp WHERE `host` = \"$host\";");
		} else {
			mysql_query("UPDATE switch_ping SET `value` = $switch_value, `state` = \"$switch_state\" WHERE `host` = \"$host\";");
		}

	}


	$hosts = get_JSON_value('getWirelessListMaster');
        foreach ($hosts as $host) {
                $result = mysql_query("SELECT host, id, value, impact, state FROM wireless_ping WHERE host = \"$host\";");
		if (mysql_num_rows($result) == 0) {
	   		$info = get_JSON_value("getWirelessInfobyHostMaster", $host);
			mysql_query("INSERT INTO wireless_ping (host, alias, name, impact) VALUES (\"$host\", \"$info->Alias\", \"$info->Name\", \"$info->Impact\");");
	   		$result=mysql_query("SELECT host, id, value, impact, state FROM wireless_ping WHERE host = \"$host\";");
		}
		$row = mysql_fetch_assoc($result);
        
		$wireless_value = ping($host, 2)[2];
		$wireless_state = 0;
		$wireless_state_old = $row["state"];
	
		if ($wireless_value == "") {
            $wireless_value = "NULL";
        	if ($row["impact"] == 3) $wireless_state = 1; else $wireless_state = 2;
        }

		if ($wireless_state != $wireless_state_old) {
			mysql_query("UPDATE wireless_ping SET `value` = $wireless_value, `state` = \"$wireless_state\", `last_change` = current_timestamp WHERE `host` = \"$host\";");
		} else {
			mysql_query("UPDATE wireless_ping SET `value` = $wireless_value, `state` = \"$wireless_state\" WHERE `host` = \"$host\";");
		}

	}


	$hosts = get_JSON_value('getRouterListMaster');
        foreach ($hosts as $host) {
                $result = mysql_query("SELECT host, id, value, impact, state FROM router_ping WHERE host = \"$host\";");
		if (mysql_num_rows($result) == 0) {
	   		$info = get_JSON_value("getRouterInfobyHostMaster", $host);
			mysql_query("INSERT INTO router_ping (host, alias, name, impact) VALUES (\"$host\", \"$info->Alias\", \"$info->Name\", \"$info->Impact\");");
	   		$result=mysql_query("SELECT host, id, value, impact, state FROM router_ping WHERE host = \"$host\";");
		}
		$row = mysql_fetch_assoc($result);
        
		$router_value = ping($host, 2)[2];
		$router_state = 0;
		$router_state_old = $row["state"];
	
		if ($router_value == "") {
        	$router_value = "NULL";
            if ($row["impact"] == 3) $router_state = 1; else $router_state = 2;
		}

		if ($router_state != $router_state_old) {
			mysql_query("UPDATE router_ping SET `value` = $router_value, `state` = \"$router_state\", `last_change` = current_timestamp WHERE `host` = \"$host\";");
		} else {
			mysql_query("UPDATE router_ping SET `value` = $router_value, `state` = \"$router_state\" WHERE `host` = \"$host\";");
		}

	}

        mysql_close();
?>
