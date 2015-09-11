<?php
	error_reporting(E_ALL & ~E_NOTICE);
	include_once ("functions.php");

        mysql_connect('localhost', $db_user, $db_pass);
        @mysql_select_db($db_name) or die("Nie udało się wybrać bazy danych");

	$result = mysql_query('SELECT hostname, ping_last, ping_avg, id FROM ping_ipsec ORDER BY `order`;');
	while ($row = mysql_fetch_assoc($result)) {
		$presult = ping($row["hostname"], 2)[2];		
		$presult_st = 'ONLINE';		

		$lastping = $row["ping_last"];
		$ping_avg = $row["ping_avg"];
		$id = $row["id"];

		if ($presult == "") {
			$presult = 'NULL';
			$presult_st = 'OFFLINE';
		}
		
		if (($ping_avg =='' && $presult != 'NULL') || ($ping_avg !='' && $presult == 'NULL') ) {
			mysql_query("UPDATE ping_ipsec SET last_change= CURRENT_TIMESTAMP WHERE hostname =\"".$row["hostname"]."\"");
			mysql_query("INSERT ping_ipsec_history (hostname, status) VALUES ('".$row["hostname"]."','".$presult_st."')");
		}
		
		if ($ping_avg == NULL) $ping_avg = 'NULL';

        	mysql_query("UPDATE ping_ipsec SET ping_last=".$ping_avg." WHERE hostname =\"".$row["hostname"]."\"");
                mysql_query("UPDATE ping_ipsec SET ping_avg=".$presult." WHERE hostname =\"".$row["hostname"]."\"");
		rrd_update("/var/www/rrd-data/ipsec_$id.rrd", array("N:$presult"));
	}
       


	$result = mysql_query('SELECT hostname, ping_last, ping_avg FROM ping_other ORDER BY `order`;');
	while ($row = mysql_fetch_assoc($result)) {
		$presult = ping($row["hostname"], 2)[2];		
		$presult_st = 'ONLINE';

		$lastping = $row["ping_last"];
		$ping_avg = $row["ping_avg"];

                if ($presult == "") {
                        $presult = 'NULL';
                        $presult_st = 'OFFLINE';
                }
	
		if (($ping_avg =='' && $presult != 'NULL') || ($ping_avg !='' && $presult == 'NULL') ) {
			mysql_query("UPDATE ping_other SET last_change= CURRENT_TIMESTAMP WHERE hostname =\"".$row["hostname"]."\"");
			mysql_query("INSERT ping_other_history (hostname, status) VALUES ('".$row["hostname"]."','".$presult_st."')");
		}
		
		if ($ping_avg == NULL) $ping_avg = 'NULL';

        	mysql_query("UPDATE ping_other SET ping_last=".$ping_avg." WHERE hostname =\"".$row["hostname"]."\"");
                mysql_query("UPDATE ping_other SET ping_avg=".$presult." WHERE hostname =\"".$row["hostname"]."\"");
	}



	$result = mysql_query('SELECT hostname, checked_text, state, value_cur FROM http_content ORDER BY `order`;');
	while ($row = mysql_fetch_assoc($result)) {
		$chresult = check_www($row["hostname"], $row["checked_text"], 15);		

		$state = $row["state"];
		$value_cur = $row["value_cur"];
	
		
		if ($chresult != FALSE && $state == 0) {
			echo date(DATE_RFC822).": host ".$row["hostname"]." still in NORMAL state.\n";
		}

		if ($chresult != FALSE && $state != 0) {
			mysql_query("UPDATE http_content SET state = 0 WHERE hostname =\"".$row["hostname"]."\"");
			echo date(DATE_RFC822).": host ".$row["hostname"]." entered NORMAL state.\n";
		}

		if ($chresult == FALSE && $state == 0) {
			mysql_query("UPDATE http_content SET state = 1 WHERE hostname =\"".$row["hostname"]."\"");
			echo date(DATE_RFC822).": host ".$row["hostname"]." entered WARNING state.\n";
			continue;
		}

		if ($chresult == FALSE && $state == 1) {
			mysql_query("UPDATE http_content SET state = 2 WHERE hostname =\"".$row["hostname"]."\"");
			echo date(DATE_RFC822).": host ".$row["hostname"]." entered CRITICAL state.\n";
		}

		if ($chresult == FALSE && $state == 2) {
			echo date(DATE_RFC822).": host ".$row["hostname"]." still in CRITICAL state.\n";
		}

		if ($chresult == FALSE) $chresult = 'NULL';
		if ($value_cur == NULL) $value_cur = 'NULL';		
	
		if (($value_cur == 'NULL' && $chresult != 'NULL') || ($value_cur != 'NULL' && $chresult == 'NULL') ) {
			mysql_query("UPDATE http_content SET last_change = CURRENT_TIMESTAMP WHERE hostname =\"".$row["hostname"]."\"");
		}
		
        	mysql_query("UPDATE http_content SET value_last=".$value_cur." WHERE hostname =\"".$row["hostname"]."\"");
                mysql_query("UPDATE http_content SET value_cur=".$chresult." WHERE hostname =\"".$row["hostname"]."\"");
	}

	$result = mysql_query('SELECT id, alias, link, token FROM link_bytoken ORDER BY `order`;');
	while ($row = mysql_fetch_assoc($result)) {
		$get_token = file_get_contents($row["link"]);
		if ($get_token == $row["token"]) 
			$value = 1;
		else 
			$value = 0;

		mysql_query("UPDATE link_bytoken SET `value` = ".$value." WHERE id =".$row["id"]);

	}

	mysql_close();

	echo date(DATE_RFC822).": DONE\n";
?>
