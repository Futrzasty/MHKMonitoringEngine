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
         switch ($row["type"]) {
             case "ping":
                 if ($row["disabled"] == 1) break;
                 $state = 0;
                 $state_old = $row["state"];
                 $id = $row["id"];
                 $value = ping($row["ip"], 2)[2];
                 if ($value == '') {$value = 'NULL'; $state = 2;}
                 if ($state != $state_old) mysql_query("UPDATE hosts SET last_change= CURRENT_TIMESTAMP WHERE id = $id");
                 mysql_query("UPDATE hosts SET `value_last` = `value`, `value` = $value, `state` = $state, `last_check` = CURRENT_TIMESTAMP WHERE id = $id");
                 break;
             case "www":
                 if ($row["disabled"] == 1) break;
                 $state = 0;
                 $state_old = $row["state"];
                 $id = $row["id"];
                 $comm = explode("|", $row["probe_cmd"]);
                 $state = check_www($comm[0], $comm[1])[0];
                 if ($state != $state_old) mysql_query("UPDATE hosts SET last_change= CURRENT_TIMESTAMP WHERE id = $id");
                 mysql_query("UPDATE hosts SET `value_last` = `value`, `value` = $state, `state` = $state, `last_check` = CURRENT_TIMESTAMP WHERE id = $id");
                 break;
             case "smtp":
                 if ($row["disabled"] == 1) break;
                 $state = 0;
                 $state_old = $row["state"];
                 $id = $row["id"];
                 $state = nrpe_smtp($row["ip"])[0];
                 if ($state != $state_old) mysql_query("UPDATE hosts SET last_change= CURRENT_TIMESTAMP WHERE id = $id");
                 mysql_query("UPDATE hosts SET `value_last` = `value`, `value` = $state, `state` = $state, `last_check` = CURRENT_TIMESTAMP WHERE id = $id");
                 break;
        }
    }
