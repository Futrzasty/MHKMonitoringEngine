<?php

        include_once "config.php";

	$dbi = 2;

        mysql_connect($dbhost[$dbi], $dbuser[$dbi], $dbpass[$dbi]);
        @mysql_select_db($dbname[$dbi]) or die("Nie udało się wybrać bazy danych");

        mysql_query("SET CHARACTER SET utf8");
        mysql_query("SET NAMES utf8");
        mysql_query("SET COLLATION utf8");

	$query="SELECT MAX(`state`) FROM router_ping";
        $result = mysql_query($query);

	$row = mysql_fetch_assoc($result);

	$output = array('State' => $row["MAX(`state`)"]);

        //liczymy countery
        $query="SELECT state, COUNT(*) AS count FROM router_ping GROUP BY `state` ORDER BY `state`;";
        $result = mysql_query($query);

        for ($i=0; $i <= $max_state; $i++) $counts[$i]=0;

        while ($row = mysql_fetch_assoc($result)) {
                $counts[$row["state"]] = $row["count"];
        }

        for ($i=0; $i <= $max_state; $i++) {
                $output["count".$i] = $counts[$i];
        }
        // koniec counterow
        

	mysql_close();

//	var_dump($output);

	echo json_encode($output);
?>
