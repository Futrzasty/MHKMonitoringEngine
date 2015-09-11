<?php
	include_once ("functions.php");

//	echo nrpe_load("172.30.31.35")[0]."<br>";
//	echo nrpe_load("172.30.31.35")[1]."<br>";
//	echo nrpe_load("172.30.31.35")[2]."<br>";
//	echo nrpe_load("172.30.31.35")[3]."<br>";

//	echo nsclient_load("192.168.12.100")[0]."<br>";
//	echo nsclient_load("192.168.12.100")[1]."<br>";
//	echo nsclient_load("192.168.12.100")[2]."<br>";
//	echo nsclient_load("192.168.12.100")[3]."<br>";

	echo ipCIDRCheck ("192.168.0.12", "192.168.0.0/24");

?>
