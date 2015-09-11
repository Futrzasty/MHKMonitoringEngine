<?php

        include_once "config.php";
	include_once "../functions.php";

	$dbi = 2;

        mysql_connect($dbhost[$dbi], $dbuser[$dbi], $dbpass[$dbi]);
        @mysql_select_db($dbname[$dbi]) or die("Nie udało się wybrać bazy danych");

        mysql_query("SET CHARACTER SET utf8");
        mysql_query("SET NAMES utf8");
        mysql_query("SET COLLATION utf8");

	$query="SELECT MAX(`last_change`) FROM printer_snmp";
        $result = mysql_query($query);

	$row = mysql_fetch_assoc($result);
	$timedf = time()-strtotime($row["MAX(`last_change`)"]);

        $sm_color = $cl_ping_gr; //'none';
        if ($timedf < 24*60*60) $sm_color = $cl_ping_ye;
        if ($timedf < 60*60) $sm_color = $cl_ping_re;

	$output = array('State' => datedif($timedf),
			'Color' => $sm_color,
	);
        

	mysql_close();

//	var_dump($output);

	echo json_encode($output);
?>
