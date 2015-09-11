<?php

        include_once "config.php";
	include_once "../functions.php";
	$dbi = 2;

        mysql_connect($dbhost[$dbi], $dbuser[$dbi], $dbpass[$dbi]);
        @mysql_select_db($dbname[$dbi]) or die("Nie udało się wybrać bazy danych");

        mysql_query("SET CHARACTER SET utf8");
        mysql_query("SET NAMES utf8");
        mysql_query("SET COLLATION utf8");

	$id = (int)$_SERVER["QUERY_STRING"];

	$query="SELECT * FROM printer_snmp WHERE id = $id";
        $result = mysql_query($query);

	$num = mysql_fetch_assoc($result);
	
	$timedf = time()-strtotime($num["last_change"]);

	$output = array('Name' => $num["alias"],
			'State' => $num["state"], 
			'Value' => $num["value"],	
			'Color' => null,
			'State_S1' => $num["full_info"],
                        'Value_S1' => datedif($timedf),
                        'Color_S1' => null,
	);
	

	//$numRows = mssql_num_rows($result);
        //while($row = mssql_fetch_array($result)) {
	//	$output[] = array ('Name' => $row["Name"], 'Room' => $row["DetailedRoomDescription"], 'IP' => $row["FirstIpAddress"]);
        //}
        

	mysql_close();

//	var_dump($output);
	//header('Content-Type: application/json');
	echo json_encode($output);
?>
