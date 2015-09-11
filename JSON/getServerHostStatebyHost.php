<?php

        include_once "config.php";
	include_once "../functions.php";
	$dbi = 2;

        mysql_connect($dbhost[$dbi], $dbuser[$dbi], $dbpass[$dbi]);
        @mysql_select_db($dbname[$dbi]) or die("Nie udało się wybrać bazy danych");

        mysql_query("SET CHARACTER SET utf8");
        mysql_query("SET NAMES utf8");
        mysql_query("SET COLLATION utf8");
	
	$argc = explode(";", $_SERVER["QUERY_STRING"]);
	$argv = count($argc);
	$host = $argc[0];
	$param =$argc[1];

	$query="SELECT * FROM nrpe_serv WHERE `host` = '$host' AND probe_type = '$param'";
        $result = mysql_query($query);

	$num = mysql_fetch_assoc($result);
	
	if ($param == 'nrpe_load') {
		$result = array($num["value0"], $num["value1"], $num["value2"]);

	        $color = $cl_othr_gr;
        	if ($result[2] > $th_load_lo) $color = $cl_othr_ye;
        	if ($result[2] > $th_load_hi) $color = $cl_othr_re;
        	if ($result[0] == "") {$color = $cl_othr_re; $result="&nbsp;";}
        	if (!is_numeric($result[2])) $color = $cl_othr_re;
		$value = $result[2];
	}

	if ($param == 'nsclient_load') {
	        $result = array($num["value0"], $num["value1"], $num["value2"]);

        	$color = $cl_othr_gr;
       		if ($result[0] > $th_cpu_lo) $color = $cl_othr_ye;
        	if ($result[0] > $th_cpu_hi) $color = $cl_othr_re;
        	$dresult = $result[0];
        	if (!is_numeric($result[0])) {
                	$color = $cl_othr_re;
                	$dresult = "ERROR";
        	}
		$value = $dresult;
	}

	$output = array('Name' => $num["alias"],
			'State' => null, 
			'Value' => $value,	
			'Color' => $color,
			'State_S1' => null,
                        'Value_S1' => null,
                        'Color_S1' => null,
	);
	

	mysql_close();
	//header('Content-Type: application/json');
	echo json_encode($output);
?>
