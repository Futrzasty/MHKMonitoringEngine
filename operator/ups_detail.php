<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="../index.css" rel="stylesheet" type="text/css" />
<?php
	$refresh = 20;
        echo '<meta http-equiv="refresh" content="'.$refresh.'" />';
?>
<title>IT Monitoring System</title>
</head>
<body style="color: white; cursor: initial;">
<?php
        include_once ("../functions.php");

	echo '<div class="branchname" style="float: left; width: 100%; font-size: 30pt; font-weight: bold; padding-bottom: 10px;">';
	echo 'UPS Jagiellońska - wykresy parametrów';
	echo '</div>';

	echo '<div class="branchinfo" style="float: left; clear: both; width: 50%;">';
	echo '<a href="/operator/index.php" class="op_button">Powrót</a>';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;<b>Odświeżanie wykresów co przeładowanie tej strony!</b><br />';
	echo '<br />4 godziny<br />';
	echo '<img src="../rrd_graph.php?l4" alt="Wykres" />';
	echo '<br />24 godziny<br />';
	echo '<img src="../rrd_graph.php?l24" alt="Wykres" />';
	echo '<br />30 dni<br />';
	echo '<img src="../rrd_graph.php?l30d" alt="Wykres" />';
	echo '<br />365 dni<br />';
	echo '<img src="../rrd_graph.php?l365d" alt="Wykres" />';
	echo '</div>';

	
?>
</body>
</html>
