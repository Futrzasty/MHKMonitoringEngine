<?php
	error_reporting(E_ALL & ~E_NOTICE);
	include_once ("functions.php");

	$server = new mysqli('localhost', $db_user, $db_pass, $db_name);
	if (mysqli_connect_error()) {
		die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
	}

	$server->query("SET CHARACTER SET utf8");
	$server->query("SET NAMES utf8");
	$server->query("SET COLLATION utf8");

	snmp_set_valueretrieval(SNMP_VALUE_PLAIN);

	for ($i = 0; $i <= 1; $i++) {   //główna pętla - dwa razy na minutę
		$time_start = microtime(true);

		$result = $server->query('SELECT host, community, oid, id, version, rrd_file, divider FROM snmp_env ORDER BY `order`;');
		while ($row = $result->fetch_assoc()) {
			if ($row["version"] == "1") {
				$value = snmpget($row["host"], $row["community"], $row["oid"], 1000000, 3);
			} else {
				$value = snmp2_get($row["host"], $row["community"], $row["oid"], 1000000, 3);
			}
			if (!$value) $value = 0;
			$server->query("UPDATE snmp_env SET `value`=".$value." WHERE id =".$row["id"]);
			// echo date(DATE_RFC822).": ".$row["host"]." ".$row["community"]." ".$row["oid"]." ".$value."\n";
			$rrd_val = $value * $row["divider"];
			$rrd_str = "N:$rrd_val";
			$rrd_file = NULL;
			if ($row["rrd_file"]) {
				$rrd_file = $rrd_path . $row["rrd_file"];
				rrd_update($rrd_file, array($rrd_str));
			}
			//echo date(DATE_RFC822).": ".$row["host"]." ".$row["community"]." ".$row["oid"]." ".$value." ".$rrd_val." ".$rrd_str." ".$rrd_file."\n";
		}

		$result = $server->query('SELECT host, probe_type, id FROM nrpe_serv ORDER BY `order`;');
		while ($row = $result->fetch_assoc()) {
		switch ($row["probe_type"]) {
			case "nrpe_load":
				$value = nrpe_load($row["host"]);
				$server->query("UPDATE nrpe_serv SET `value0`=\"".$value[0]."\" WHERE id =".$row["id"]);
				$server->query("UPDATE nrpe_serv SET `value1`=\"".$value[1]."\" WHERE id =".$row["id"]);
				$server->query("UPDATE nrpe_serv SET `value2`=\"".$value[2]."\" WHERE id =".$row["id"]);
				$server->query("UPDATE nrpe_serv SET `value3`=\"".$value[3]."\" WHERE id =".$row["id"]);
				break;
			case "nsclient_load":
				$value = nsclient_load($row["host"]);
				$server->query("UPDATE nrpe_serv SET `value0`=\"".$value[0]."\" WHERE id =".$row["id"]);
				break;
		}
		//echo date(DATE_RFC822).": ".$row["host"]." ".$row["probe_type"]." ".$value[0]." ".$value[1]." ".$value[2]." ".$value[3]."\n";
		}
		
		$time_end = microtime(true);
		$time = $time_end - $time_start;
		echo date(DATE_RFC822).": Execution time ".$time." sec.\n";
		if ($i == 0 && $time > 25) $i = 1000; //koniec pętli gdy wykonywało się za długo (> 25 sek.)
		if ($i == 0) sleep(30 - $time);
	} // koniec głównej pętli
	
	$server->close();
    echo date(DATE_RFC822).": DONE\n";
?>
