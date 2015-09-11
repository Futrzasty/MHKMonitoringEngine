<?php
	error_reporting(E_ALL & ~E_NOTICE);
        include_once ("functions.php");

        mysql_connect('localhost', $db_user, $db_pass);
        @mysql_select_db($db_name) or die("Nie udało się wybrać bazy danych");

        mysql_query("SET CHARACTER SET utf8");
        mysql_query("SET NAMES utf8");
        mysql_query("SET COLLATION utf8");

        snmp_set_valueretrieval(SNMP_VALUE_PLAIN);

        for ($i = 0; $i <= 1; $i++) {
		$time_start = microtime(true);

		$result = mysql_query('SELECT host, community, oid, id FROM snmp_env ORDER BY `order`;');
        	while ($row = mysql_fetch_assoc($result)) {
			$value = snmp2_get($row["host"], $row["community"], $row["oid"]);
			if (!$value) $value = 0;
                	mysql_query("UPDATE snmp_env SET `value`=".$value." WHERE id =".$row["id"]);
        	//	echo date(DATE_RFC822).": ".$row["host"]." ".$row["community"]." ".$row["oid"]." ".$value."\n";
			if ($row["host"] == "192.168.83.66" && $row["oid"] == ".1.3.6.1.2.1.99.1.1.1.4.1") $rrdval[0] = $value / 10;
			if ($row["host"] == "192.168.83.66" && $row["oid"] == ".1.3.6.1.2.1.99.1.1.1.4.2") $rrdval[1] = $value;
			if ($row["host"] == "192.168.83.68" && $row["oid"] == ".1.3.6.1.2.1.99.1.1.1.4.1") $rrdval[2] = $value / 10;
			if ($row["host"] == "192.168.83.68" && $row["oid"] == ".1.3.6.1.2.1.99.1.1.1.4.2") $rrdval[3] = $value;
		}
		rrd_update("/var/www/rrd-data/jag_ups.rrd", array("N:$rrdval[0]:$rrdval[1]"));
		//$rrdval[0] = 0;
		//$rrdval[1] = 0;
		
		$result = mysql_query('SELECT host, probe_type, id FROM nrpe_serv ORDER BY `order`;');
        	while ($row = mysql_fetch_assoc($result)) {
			switch ($row["probe_type"]) {
				case "nrpe_load":
					$value = nrpe_load($row["host"]);
		                        mysql_query("UPDATE nrpe_serv SET `value0`=\"".$value[0]."\" WHERE id =".$row["id"]);
		                        mysql_query("UPDATE nrpe_serv SET `value1`=\"".$value[1]."\" WHERE id =".$row["id"]);
                		        mysql_query("UPDATE nrpe_serv SET `value2`=\"".$value[2]."\" WHERE id =".$row["id"]);
					mysql_query("UPDATE nrpe_serv SET `value3`=\"".$value[3]."\" WHERE id =".$row["id"]);
					break;
				case "nsclient_load":
                                        $value = nsclient_load($row["host"]);
					mysql_query("UPDATE nrpe_serv SET `value0`=\"".$value[0]."\" WHERE id =".$row["id"]);
                                        break;
			}
        	//	echo date(DATE_RFC822).": ".$row["host"]." ".$row["probe_type"]." ".$value[0]." ".$value[1]." ".$value[2]." ".$value[3]."\n";
		}
		
		$time_end = microtime(true);
		$time = $time_end - $time_start;
		echo date(DATE_RFC822).": Execution time ".$time." sec.\n";
		if ($i == 0 && $time > 25) $i = 1000;
		if ($i == 0) sleep(30 - $time);
	}	
	
	mysql_close();
        echo date(DATE_RFC822).": DONE\n";
?>
