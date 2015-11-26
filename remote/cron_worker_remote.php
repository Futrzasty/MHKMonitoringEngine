<?php
    error_reporting(E_ALL & ~E_NOTICE);
    include_once ("functions.php");

    mysql_connect('localhost', $db_user, $db_pass);
    @mysql_select_db($db_name) or die("Nie udało się wybrać bazy danych");

    mysql_query("SET CHARACTER SET utf8");
    mysql_query("SET NAMES utf8");
    mysql_query("SET COLLATION utf8");


    $result = mysql_query("SELECT * FROM hosts ORDER BY `order`");
    while($row = mysql_fetch_assoc($result)) {
         $state = 0;
         $state_old = $row["state"];
         $id = $row["id"];
         if ($row["disabled"] == 1) continue;
         switch ($row["type"]) {
              case "ping":
                   $ping = check_ping($row["ip"], 200, 50, 500, 70);
                   list ($state, $value, $value2) = $ping;
                   if ($state != $state_old) mysql_query("UPDATE hosts SET last_change= CURRENT_TIMESTAMP WHERE id = $id");
                   mysql_query("UPDATE hosts SET `value_last` = `value`, `value` = $value, `value2_last` = `value2`, `value2` = $value2, `state` = $state, `last_check` = CURRENT_TIMESTAMP WHERE id = $id");
                   break;
              case "www":
                   $comm = explode("|", $row["probe_cmd"]);
                   $state = check_www($comm[0], $comm[1])[0];
                   if ($state != $state_old) mysql_query("UPDATE hosts SET last_change= CURRENT_TIMESTAMP WHERE id = $id");
                   mysql_query("UPDATE hosts SET `value_last` = `value`, `value` = $state, `state` = $state, `last_check` = CURRENT_TIMESTAMP WHERE id = $id");
                   break;
              case "smtp":
                   $state = nrpe_smtp($row["ip"])[0];
                   if ($state != $state_old) mysql_query("UPDATE hosts SET last_change= CURRENT_TIMESTAMP WHERE id = $id");
                   mysql_query("UPDATE hosts SET `value_last` = `value`, `value` = $state, `state` = $state, `last_check` = CURRENT_TIMESTAMP WHERE id = $id");
                   break;
        }
    }
