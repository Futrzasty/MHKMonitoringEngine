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

	$query="SELECT * FROM http_content WHERE id = $id";
        $result = mysql_query($query);

	$num = mysql_fetch_assoc($result);
	
        $state = $num["state"];
        $timedf = time()-strtotime($num["last_change"]);

        if ($state == 0) {
                $color = $cl_othr_gr;
                $mtext = "OK";
        }
        else if ($state == 1) {
                $color = $cl_othr_ye;
                $mtext = "WARN";
        }
        else {
                $color = $cl_othr_re;
                $mtext = "ERROR";
        }
        $sm_color = $cl_ping_gr; //'none';
        if ($timedf < 24*60*60) $sm_color = $cl_ping_ye;
        if ($timedf < 60*60) $sm_color = $cl_ping_re;

	$output = array('Name' => $num["alias"],
			'State' => null, 
			'Value' => $mtext,	
			'Color' => $color,
			'State_S1' => null,
                        'Value_S1' => datedif($timedf),
                        'Color_S1' => $sm_color,
	);
	

	mysql_close();
	//header('Content-Type: application/json');
	echo json_encode($output);
?>
