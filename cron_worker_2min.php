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
                $result = mysql_query("SELECT host, id, value FROM switch_ping WHERE host = \"$host\";");
		if (mysql_num_rows($result) == 0) {
	   		$info = get_JSON_value("getSwitchInfobyHostMaster", $host);
			mysql_query("INSERT INTO switch_ping (host, alias, name) VALUES (\"$host\", \"$info->Alias\", \"$info->Name\");");
	   		$result=mysql_query("SELECT host, id, value FROM switch_ping WHERE host = \"$host\";");
		}
		$row = mysql_fetch_assoc($result);
        
		$switch_value = ping($host, 2)[2];
		$switch_state = 0;
	
		if ($switch_value == "") {
                        $switch_value = "NULL";
                        $switch_state = 2;
                }

		mysql_query("UPDATE switch_ping SET `value` = $switch_value, `state` = \"$switch_state\" WHERE `host` = \"$host\";");

	}


	$hosts = get_JSON_value('getWirelessListMaster');
        foreach ($hosts as $host) {
                $result = mysql_query("SELECT host, id, value FROM wireless_ping WHERE host = \"$host\";");
		if (mysql_num_rows($result) == 0) {
	   		$info = get_JSON_value("getWirelessInfobyHostMaster", $host);
			mysql_query("INSERT INTO wireless_ping (host, alias, name) VALUES (\"$host\", \"$info->Alias\", \"$info->Name\");");
	   		$result=mysql_query("SELECT host, id, value FROM wireless_ping WHERE host = \"$host\";");
		}
		$row = mysql_fetch_assoc($result);
        
		$wireless_value = ping($host, 2)[2];
		$wireless_state = 0;
	
		if ($wireless_value == "") {
                        $wireless_value = "NULL";
                        $wireless_state = 2;
                }

		mysql_query("UPDATE wireless_ping SET `value` = $wireless_value, `state` = \"$wireless_state\" WHERE `host` = \"$host\";");

	}


	$hosts = get_JSON_value('getRouterListMaster');
        foreach ($hosts as $host) {
                $result = mysql_query("SELECT host, id, value FROM router_ping WHERE host = \"$host\";");
		if (mysql_num_rows($result) == 0) {
	   		$info = get_JSON_value("getRouterInfobyHostMaster", $host);
			mysql_query("INSERT INTO router_ping (host, alias, name) VALUES (\"$host\", \"$info->Alias\", \"$info->Name\");");
	   		$result=mysql_query("SELECT host, id, value FROM router_ping WHERE host = \"$host\";");
		}
		$row = mysql_fetch_assoc($result);
        
		$router_value = ping($host, 2)[2];
		$router_state = 0;
	
		if ($router_value == "") {
                        $router_value = "NULL";
                        $router_state = 2;
                }

		mysql_query("UPDATE router_ping SET `value` = $router_value, `state` = \"$router_state\" WHERE `host` = \"$host\";");

	}

        mysql_close();
?>
