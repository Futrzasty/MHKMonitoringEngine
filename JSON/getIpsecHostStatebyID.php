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

	$query="SELECT * FROM ping_ipsec WHERE id = $id";
        $result = mysql_query($query);

	$num = mysql_fetch_assoc($result);
	
	$ping = $num["ping_avg"];
	if ($ping < $th_ping_lo) $color = $cl_ping_gr;
	else if ($ping < $th_ping_hi) $color = $cl_ping_ye;
	else $color = $cl_ping_re;
	if ($ping == "") {$color = "red"; $ping="&nbsp;";}

	$timedf = time()-strtotime($num["last_change"]);
	$third_octet=explode(".", $num["ip"])[2];

	$sm_color = $cl_ping_gr; //'none';
	if ($timedf < 24*60*60) $sm_color = $cl_ping_ye;
	if ($timedf < 60*60) $sm_color = $cl_ping_re;
	if ($num["disabled"]) {
		$color = $cl_ping_gy;
		$sm_color = $cl_ping_gy;
	}


	$output = array('Name' => $num["alias"],
			'State' => null, 
			'Value' => $ping,	
			'Color' => $color,
			'State_S1' => null,
                        'Value_S1' => datedif($timedf),
                        'Color_S1' => $sm_color,
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
