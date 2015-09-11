<?php

        include_once "config.php";

	$dbi = 2;

        mysql_connect($dbhost[$dbi], $dbuser[$dbi], $dbpass[$dbi]);
        @mysql_select_db($dbname[$dbi]) or die("Nie udało się wybrać bazy danych");

        mysql_query("SET CHARACTER SET utf8");
        mysql_query("SET NAMES utf8");
        mysql_query("SET COLLATION utf8");

	$query="SELECT id FROM http_content ORDER BY `order`";
        $result = mysql_query($query);

	while ($row = mysql_fetch_assoc($result)) {
		$output[] = $row["id"];
	}


	//$numRows = mssql_num_rows($result);
        //while($row = mssql_fetch_array($result)) {
	//	$output[] = array ('Name' => $row["Name"], 'Room' => $row["DetailedRoomDescription"], 'IP' => $row["FirstIpAddress"]);
        //}
        

	mysql_close();

//	var_dump($output);

	echo json_encode($output);
?>
