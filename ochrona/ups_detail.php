<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="../index.css" rel="stylesheet" type="text/css" />
<title>IT Monitoring System</title>
</head>
<body style="color: white; cursor: initial;">
<?php
        include_once ("../functions.php");

	echo '<div class="branchname" style="float: left; width: 100%; font-size: 30pt; font-weight: bold; padding-bottom: 10px;">';
	echo 'UPS Jagiellońska - wykresy parametrów';
	echo '</div>';

	echo '<div class="branchinfo" style="float: left; clear: both; width: 50%;">';
	echo '<a href="index.php" class="op_button">Powrót</a>';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;<b>Odświeżanie wykresów co 5 minut!</b><br />';
	echo '<br />4 godziny<br />';
	$graphname = get_recent_file('/var/www/rrd_graph/temp', 'ups4h.png');
	echo '<img src="/rrd_graph/temp/'.$graphname.'" alt="Wykres" />';
	echo '<br />24 godziny<br />';
	$graphname = get_recent_file('/var/www/rrd_graph/temp', 'ups24h.png');
	echo '<img src="/rrd_graph/temp/'.$graphname.'" alt="Wykres" />';
	echo '<br />30 dni<br />';
	$graphname = get_recent_file('/var/www/rrd_graph/temp', 'ups30d.png');
	echo '<img src="/rrd_graph/temp/'.$graphname.'" alt="Wykres" />';
	echo '<br />365 dni<br />';
	$graphname = get_recent_file('/var/www/rrd_graph/temp', 'ups365d.png');
	echo '<img src="/rrd_graph/temp/'.$graphname.'" alt="Wykres" />';
	echo '</div>';

	
?>
</body>
</html>
