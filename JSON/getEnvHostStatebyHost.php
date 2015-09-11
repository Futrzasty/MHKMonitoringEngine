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

	$query="SELECT * FROM snmp_env WHERE `host` = '$host' AND param = '$param'";
        $result = mysql_query($query);

	$num = mysql_fetch_assoc($result);
	
	$value = $num["value"]*$num["divider"];

	if ($num["th_lo_crit"]) $th_lo_crit = $num["th_lo_crit"]; else $th_lo_crit = 0;
	if ($num["th_lo_warn"]) $th_lo_warn = $num["th_lo_warn"]; else $th_lo_warn = 0;
	if ($num["th_hi_warn"]) $th_hi_warn = $num["th_hi_warn"]; else $th_hi_warn = 0;
	if ($num["th_hi_crit"]) $th_hi_crit = $num["th_hi_crit"]; else $th_hi_crit = 0;

	$color = $cl_ping_gy;
	$state = 2;

	if ($param == 'temp') {
		if ($value <= $th_lo_crit) {$color = $cl_othr_bu; $state = 2;}
		else if (($value > $th_lo_crit) && ($value <= $th_lo_warn)) {$color = $cl_othr_bu; $state = 1;}
		else if (($value > $th_lo_warn) && ($value <= $th_hi_warn)) {$color = $cl_othr_gr; $state = 0;}
		else if (($value > $th_hi_warn) && ($value <= $th_hi_crit)) {$color = $cl_othr_ye; $state = 1;}
        	else if ($value > $th_hi_crit) {$color = $cl_othr_re; $state = 2;}
	}

        if ($param == 'humi') {
                if ($value <= $th_lo_crit) {$color = $cl_othr_re; $state = 2;}
                else if (($value > $th_lo_crit) && ($value <= $th_lo_warn)) {$color = $cl_othr_ye; $state = 1;}
                else if (($value > $th_lo_warn) && ($value <= $th_hi_warn)) {$color = $cl_othr_gr; $state = 0;}
                else if (($value > $th_hi_warn) && ($value <= $th_hi_crit)) {$color = $cl_othr_ye; $state = 1;}
                else if ($value > $th_hi_crit) {$color = $cl_othr_re; $state = 2;}
	}

	if ($value == 0) {
		$value = "ERROR";
		$color = $cl_othr_re;
		$state = 2;
	}

	$output = array('Name' => $num["alias"],
			'State' => $state, 
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
