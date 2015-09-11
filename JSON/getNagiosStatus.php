<?php
	include "../functions.php";

	$host = '192.168.90.65';
	$adres = 'http://'.$host.'/cgi-bin/nagios3/status.cgi?host=all&servicestatustypes=28';

	$json = get_nagios_status($adres);

	echo json_encode($json);
?>
