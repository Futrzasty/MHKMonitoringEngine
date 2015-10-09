<?php
        include_once ("config.php");

	$uchwyt = fopen("http://$nagios_username:$nagios_password@nagios/nagios3/statusJson.php", "rb");
        $tresc = stream_get_contents($uchwyt);
        fclose($uchwyt);
	$nagios_full 	 = json_decode($tresc, true);
        $nagios_stat 	 = $nagios_full["programStatus"];
	$nagios_hosts	 = $nagios_full["hosts"];
	$nagios_services = $nagios_full["services"];

	var_dump ($nagios_stat);
	echo '<br/><br/>';
	//var_dump ($nagios_hosts);
	foreach ($nagios_hosts as $host_name => $host_array) {
		echo $host_name.'<br/><br/>';
		var_dump ($host_array);
		echo '<br/><br/>';
	} 
	echo '<br/><br/>';
	foreach ($nagios_services as $service_name => $service_array) {
                echo $service_name.'<br/><br/>';
                var_dump ($service_array);
                echo '<br/><br/>';
        }
