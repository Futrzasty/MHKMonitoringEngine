<?php

        include_once "config.php";

	$dbi = 2;

        mysql_connect($dbhost[$dbi], $dbuser[$dbi], $dbpass[$dbi]);
        @mysql_select_db($dbname[$dbi]) or die("Nie udało się wybrać bazy danych");

        mysql_query("SET CHARACTER SET utf8");
        mysql_query("SET NAMES utf8");
        mysql_query("SET COLLATION utf8");

        $id = (int)$_SERVER["QUERY_STRING"];

        $where = "";
        if ($id != 0) $where = "WHERE state = $id";

	$query="SELECT host FROM router_ping $where;";
        $result = mysql_query($query);

	while ($row = mysql_fetch_assoc($result)) {
		$output[] = $row["host"];
	}

        

	mysql_close();

//	var_dump($output);

	if (isset($output)) echo json_encode($output);
?>
