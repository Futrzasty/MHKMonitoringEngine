<?php
        include_once ("config.php");

	require_once __DIR__.'/lib/YaLinqo/Linq.php'; 	// replace with your path
	use \YaLinqo\Enumerable; 			// optional, to shorten class name

	$uchwyt = fopen("http://$nagios_username:$nagios_password@nagios/nagios3/statusJson.php", "rb");
        $tresc = stream_get_contents($uchwyt);
        fclose($uchwyt);
	$nagios_full 	 = json_decode($tresc, true);
        $nagios_stat 	 = $nagios_full["programStatus"];
	$nagios_hosts	 = $nagios_full["hosts"];
	$nagios_services = $nagios_full["services"];


//	$result = from($nagios_services)
//		-> select ('$nag ==> $nag["current_state"]')
//		-> select ('$nag ==> $nag["host_name"]')
//		-> where ('$nag ==> $nag["current_state"] <> "0"');

	$data = from($nagios_services);

	//$result = $data->where('$nag ==> $nag["current_state"] <> "0"')->select('$nag ==> $nag["current_state"]');
	$result = $data->where('$nag ==> $nag["current_state"] <> "0"')->orderByDescending('$nag ==> $nag["current_state"]')->thenBy('$nag ==> $nag["host_name"]');
	var_dump($data->max('$nag ==> $nag["current_state"]'));
	var_dump($result->toArray());

	//var_dump ($result);

	echo '<br/><br/>';
	//var_dump ($nagios_services);




//	var_dump ($nagios_stat);
	echo '<br/><br/>';
	//var_dump ($nagios_hosts);
	foreach ($nagios_hosts as $host_name => $host_array) {
		echo $host_name.'<br/><br/>';
//		var_dump ($host_array);
		echo '<br/><br/>';
	} 
	echo '<br/><br/>';
	foreach ($nagios_services as $service_name => $service_array) {
                echo $service_name.'<br/><br/>';
//                var_dump ($service_array);
                echo '<br/><br/>';
        }
