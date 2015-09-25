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
		$info = get_JSON_value("getSwitchInfobyHostMaster", $host);
                if (mysql_num_rows($result) == 0) {
                        mysql_query("INSERT INTO switch_ping (host) VALUES (\"$host\");");
                        $result=mysql_query("SELECT host, id, value FROM switch_ping WHERE host = \"$host\";");
                }
                $row = mysql_fetch_assoc($result);

		mysql_query("UPDATE switch_ping SET `alias` = \"$info->Alias\", `name` = \"$info->Name\", `impact` = \"$info->Impact\" WHERE `host` = \"$host\";");

        }



        $hosts = get_JSON_value('getWirelessListMaster');

	foreach ($hosts as $host) {
                $result = mysql_query("SELECT host, id, value FROM wireless_ping WHERE host = \"$host\";");
		$info = get_JSON_value("getWirelessInfobyHostMaster", $host);
                if (mysql_num_rows($result) == 0) {
                        mysql_query("INSERT INTO wireless_ping (host) VALUES (\"$host\");");
                        $result=mysql_query("SELECT host, id, value FROM wireless_ping WHERE host = \"$host\";");
                }
                $row = mysql_fetch_assoc($result);

		mysql_query("UPDATE wireless_ping SET `alias` = \"$info->Alias\", `name` = \"$info->Name\", `impact` = \"$info->Impact\" WHERE `host` = \"$host\";");

        }



        $hosts = get_JSON_value('getRouterListMaster');

	foreach ($hosts as $host) {
                $result = mysql_query("SELECT host, id, value FROM router_ping WHERE host = \"$host\";");
		$info = get_JSON_value("getRouterInfobyHostMaster", $host);
                if (mysql_num_rows($result) == 0) {
                        mysql_query("INSERT INTO router_ping (host) VALUES (\"$host\");");
                        $result=mysql_query("SELECT host, id, value FROM router_ping WHERE host = \"$host\";");
                }
                $row = mysql_fetch_assoc($result);

		mysql_query("UPDATE router_ping SET `alias` = \"$info->Alias\", `name` = \"$info->Name\", `impact` = \"$info->Impact\" WHERE `host` = \"$host\";");

        }





?>
