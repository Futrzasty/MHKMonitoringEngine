<?php
//	include ('../hosts_allowed.inc');
//	if (!in_array($_SERVER["REMOTE_ADDR"], $hosts_allowed_operator) &&
//        !in_array($_SERVER["REMOTE_ADDR"], $hosts_allowed_all)) {
//		header('Location: /index.html');
//		exit;
//	}

	$refresh = 30;
//	if ($_SERVER["REMOTE_ADDR"] != '192.168.90.143') $refresh = 40;
?>
<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<?php
	echo '<meta http-equiv="refresh" content="'.$refresh.'" />';
?>
<link href="../index.css" rel="stylesheet" type="text/css" />
<title>IT Monitoring System</title>
</head>
<body style="cursor: initial;">

<?php
	$dzien        = date('j');
        $miesiac      = date('n');
        $rok          = date('Y');
        $dzientyg     = date('w');
        $DoY          = date('z');
        $DoY++;
        $g_odzina     = date('G');
        $m_inuta      = date('i');
        $s_ekunda     = date('s');

        $miesiace = array(1 => 'stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca', 'lipca', 'sierpnia', 'września', 'października', 'listopada', 'grudnia');
        $dnityg = array(0 => 'Niedziela', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota');
        echo '<span class="data">'.$dnityg[$dzientyg].', '.$dzien.' '.$miesiace[$miesiac].' '.$rok.'</span>';
	echo '<span class="czas">'.$g_odzina.':'.$m_inuta.'</span>';        
?>


<?php
	include_once ("../functions.php");

        echo '<div class="grupa">';
        $dane = get_JSON_value('getEnvHostStatebyHost', '192.168.83.66;temp');

        if (is_numeric($dane->Value)) $text = "<b>$dane->Value</b>&deg;C"; else $text = "<b>$dane->Value</b>";
        draw_main_frame ("Temperatura", $text, $dane->Color);
        $dane = get_JSON_value('getEnvHostStatebyHost', '192.168.83.66;humi');
        if (is_numeric($dane->Value)) $text = "<b>$dane->Value</b> %"; else $text = "<b>$dane->Value</b>";
        draw_main_frame ("Wilgotność", $text, $dane->Color);

        $dane = get_JSON_value('getEnvHostStatebyHost', '192.168.83.68;temp');
        $dane2 = get_JSON_value('getEnvHostStatebyHost', '192.168.83.68;humi');
        draw_frame_twosmallbricks ("UPS Klim.", "<b>$dane->Value</b>", $dane->Color, "<b>$dane2->Value</b>%", $dane2->Color);
	
	echo '<a href="ups_detail.php"><img src="../rrd_graph.php?t4" style="float: left; border: 0px;" /></a>';
	echo '<a href="ups_detail.php"><img src="../rrd_graph.php?t12" style="float: left; border: 0px; padding-left: 1px;" /></a>';


	echo '<div style="clear: both;"></div>';
	echo '</div>';

?>
</body>
</html>
