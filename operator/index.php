<?php
//	include ('../hosts_allowed.inc');
//	if (!in_array($_SERVER["REMOTE_ADDR"], $hosts_allowed_operator) &&
//        !in_array($_SERVER["REMOTE_ADDR"], $hosts_allowed_all)) {
//		header('Location: /index.html');
//		exit;
//	}

	$refresh = 20;
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
	echo '<div style="clear: left; text-align: center;"><b>Serwerownia - Jagiellońska</b></div>';

	$dane = get_JSON_value('getEnvHostStatebyHost', '192.168.83.66;temp');	
        if (is_numeric($dane->Value)) $text = "<b>$dane->Value</b>&deg;C"; else $text = "<b>$dane->Value</b>";
        draw_main_frame ("Temperatura", $text, $dane->Color);
        $dane = get_JSON_value('getEnvHostStatebyHost', '192.168.83.66;humi');
        if (is_numeric($dane->Value)) $text = "<b>$dane->Value</b> %"; else $text = "<b>$dane->Value</b>";
        draw_main_frame ("Wilgotność", $text, $dane->Color);


	$dane = get_JSON_value('getEnvHostStatebyHost', '192.168.83.68;temp');
	$dane2 = get_JSON_value('getEnvHostStatebyHost', '192.168.83.68;humi');
	draw_frame_twosmallbricks ("UPS Klim.", "<b>$dane->Value</b>", $dane->Color, "<b>$dane2->Value</b>%", $dane2->Color);

	$dane = get_JSON_value('getEnvHostStatebyHost', '192.168.12.209;temp');
        $dane2 = get_JSON_value('getEnvHostStatebyHost', '192.168.12.209;humi');
        draw_frame_twosmallbricks ("Rynek (+1)", "<b>$dane->Value</b>", $dane->Color, "<b>$dane2->Value</b>%", $dane2->Color);

	echo '<a href="ups_detail.php"><img src="../rrd_graph.php?t4" style="float: left; border: 0;" /></a>';
	echo '<a href="ups_detail.php"><img src="../rrd_graph.php?t12" style="float: left; border: 0; padding-left: 1px;" /></a>';

	echo '<div style="clear: both;"></div>';
	echo '</div>';



	echo '<div class="grupa">';
	echo '<div style="clear: left; text-align: center;"><b>Serwisy sieciowe</b></div>';	
	
        $ids = get_JSON_value('getWwwHostIDs');
	foreach ($ids as $id) {
        	$dane = get_JSON_value('getWwwHostStatebyID', $id);
        	draw_main_frame ($dane->Name, "<b>$dane->Value</b>", $dane->Color, $dane->Value_S1, $dane->Color_S1);
        }


        $ids = get_JSON_value('getServerHostList');
        foreach ($ids as $host) {
                $idp = get_JSON_value('getServerHostParamsbyHost', $host);
                foreach ($idp as $parm) {
                        $dane = get_JSON_value('getServerHostStatebyHost', $host.";".$parm);
                        $parm == 'nsclient_load' && is_numeric($dane->Value) ? $unit = " %" : $unit = '';
                        draw_main_frame ($dane->Name, "<b>$dane->Value</b>".$unit, $dane->Color);
                }
        }
      

	$ids = get_JSON_value('getPingHostIDs');
        foreach ($ids as $id) {
                $dane = get_JSON_value('getPingHostStatebyID', $id);
                draw_main_frame ($dane->Name, "<b>$dane->Value</b>", $dane->Color, $dane->Value_S1, $dane->Color_S1);
        }


        //$ids = get_JSON_value('getNetLinkIDs');
        //foreach ($ids as $id) {
        //        $dane = get_JSON_value('getNetLinkStatebyID', $id);
        //        draw_main_frame ($dane->Name, "<b>$dane->Value</b>", $dane->Color);
        //}

        $dane = get_JSON_value('getPrinterGlobalState');
        $dane2 =get_JSON_value('getPrinterGlobalLastChange');
	$value = $dane->State;
        $text = "<span style=\"opacity: 0.2;\">PRN</span>";
	if ($value > 0) $text = "<strong>".$dane->count2."/".$dane->count1."</strong>";
	$color = $cl_othr_re;
        if ($value == 1) $color = $cl_othr_ye;
        if ($value == 0) $color = $cl_othr_gr;
	echo '<a href="printers_detail.php" style="color: white;">';
        draw_main_frame ("Drukarki", $text, $color, $dane2->State, $dane2->Color);
	echo '</a>';

        $dane = get_JSON_value('getSwitchGlobalState');
        $value = $dane->State;
        $color = $cl_othr_re;
        $text = "<span style=\"opacity: 0.2;\">SW</span>";
        if ($value > 0) $text = "<strong>".$dane->count2."/".$dane->count1."</strong>";
        if ($value == 1) $color = $cl_othr_ye;
        if ($value == 0) $color = $cl_othr_gr;
	echo '<a href="switch_detail.php" style="color: white;">';
        draw_main_frame ("Switche", $text, $color);
	echo '</a>';

        $dane = get_JSON_value('getWirelessGlobalState');
        $value = $dane->State;
        $color = $cl_othr_re;
        $text = "<span style=\"opacity: 0.2;\">AP</span>";
        if ($value > 0) $text = "<strong>".$dane->count2."/".$dane->count1."</strong>";
        if ($value == 1) $color = $cl_othr_ye;
        if ($value == 0) $color = $cl_othr_gr;
	echo '<a href="wireless_detail.php" style="color: white;">';
        draw_main_frame ("Access Point", $text, $color);
	echo '</a>';

        $dane = get_JSON_value('getRouterGlobalState');
        $value = $dane->State;
        $color = $cl_othr_re;
        $text = "<span style=\"opacity: 0.2;\">RT</span>";
        if ($value > 0) $text = "<strong>".$dane->count2."/".$dane->count1."</strong>";
        if ($value == 1) $color = $cl_othr_ye;
        if ($value == 0) $color = $cl_othr_gr;
	echo '<a href="router_detail.php" style="color: white;">';
        draw_main_frame ("Routery", $text, $color);
	echo '</a>';

	echo '<div style="clear: both;"></div>';
	echo '</div>';

	echo '<div class="grupa">';
        echo '<div style="clear: left; text-align: center;"><b>Tunele IPSec</b></div>';

        $ids = get_JSON_value('getIpsecHostIDs');

	foreach ($ids as $id) {
        	$dane = get_JSON_value('getIpsecHostStatebyID', $id);
		$third_octet = explode(".", get_JSON_value('getIpsecHostIPbyID', $id))[2];
	        echo '<a href="ipsec_host_detail.php?host='.$id.'" style="color: white;">';
        	draw_main_frame ($dane->Name." (<b>$third_octet</b>)", "<b>$dane->Value</b>", $dane->Color, $dane->Value_S1, $dane->Color_S1);
        	echo '</a>';
        }

        echo '<div style="clear: both;"></div>';
        echo '</div>';



	//NAGIOS
	echo '<div class="grupa">';
	echo '<div style="clear: left; text-align: center;"><b>Problemy NAGIOS</b></div>';
	$host = '192.168.90.65';
        $port = 80;
	$adres = 'http://'.$host.'/cgi-bin/nagios3/status.cgi?host=all&servicestatustypes=28';
        $waitTimeoutInSeconds = 0.5;
        if($fp = fsockopen($host,$port,$errCode,$errStr,$waitTimeoutInSeconds)) {
	
		$nagios = get_nagios_status($adres);
		$entries =  count($nagios)/7;
		for ($i = 0; $i < $entries; $i++) {
			if ($nagios[2+$i*7] == "WARNING")
				$color = $cl_ping_ye;
			else if ($nagios[2+$i*7] == "CRITICAL") 
				$color = $cl_ping_re;
			else $color = $cl_othr_bl;
			if ($nagios[0+$i*7] != "OLD HOST") {
				$hostn = strtoupper(str_ireplace(".mhk.local","",$nagios[0+$i*7]));
				$hostn = strtoupper(str_ireplace(".local","",$hostn));	
			}
			echo '<div class="ramka_nagios" style="width: 250px; background-color: '.$color.';"><b>'.$hostn.'</b></div>';
			echo '<div class="ramka_nagios" style="width: 500px; background-color: '.$color.';"><b>'.$nagios[1+$i*7].'</b></div>';
			echo '<div class="ramka_nagios" style="width: 1020px; background-color: '.$color.';"><b>'.$nagios[6+$i*7].'</b></div>';
			echo '<div style="clear: both"></div>';
		}
		if ($entries == 0) echo '<div class="ramka_nagios" style="width: 1838px; background-color: '.$cl_ping_gr.';"><b>Brak problemów</b></div>';
	}
	else
	{
		 echo '<div class="ramka_nagios" style="width: 1838px; background-color: '.$cl_ping_re.';"><b>AWARIA serwera NAGIOS.mhk.local</b></div>';
	}
	fclose($fp);
	echo '<div style="clear: both;"></div>';
	echo '</div>';
?>
</body>
</html>
