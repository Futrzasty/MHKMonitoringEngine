<?php
	$refresh = 20;
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
<link href="index.css" rel="stylesheet" type="text/css" />
<title>IT Monitoring System</title>
</head>
<body>

<?php
	$lorem = "&nbsp;";

	$dzien        = date('j');
        $miesiac      = date('n');
        $rok          = date('Y');
        $dzientyg     = date('w');
        $DoY          = date('z');
        $DoY++;
        $godzina     = date('G');
        $minuta      = date('i');
        $sekunda     = date('s');

        $miesiace = array(1 => 'stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca', 'lipca', 'sierpnia', 'września', 'października', 'listopada', 'grudnia');
        $dnityg = array(0 => 'Niedziela', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota');
        echo '<span class="data">'.$dnityg[$dzientyg].', '.$dzien.' '.$miesiace[$miesiac].' '.$rok.'</span>';
	echo '<span class="czas">'.$godzina.':'.$minuta.'</span>';        
	
	include_once ("../functions.php");
        require_once __DIR__.'/../lib/YaLinqo/Linq.php';   // replace with your path
        use \YaLinqo\Enumerable;                        // optional, to shorten class name

        $uchwyt = fopen("http://$nagios_username:$nagios_password@nagios/nagios3/statusJson.php", "rb");
        $tresc = stream_get_contents($uchwyt);
        fclose($uchwyt);
        $nagios_full     = json_decode($tresc, true);
//        $nagios_stat     = $nagios_full["programStatus"];
//        $nagios_hosts    = $nagios_full["hosts"];
        $nagios_services = $nagios_full["services"];


        $data = from($nagios_services);

        //$result = $data->where('$nag ==> $nag["current_state"] <> "0"')->select('$nag ==> $nag["current_state"]');
        //$nagios_fail_array = $data->where('$nag ==> $nag["current_state"] <> "0"')->orderByDescending('$nag ==> $nag["current_state"]')->thenBy('$nag ==> $nag["host_name"]')->thenBy('$nag ==> $nag["last_state_change"]');
        $nagios_fail_array = $data->where('$nag ==> $nag["current_state"] <> "0"')->orderByDescending('$nag ==> $nag["current_state"]')->thenBy('$nag ==> $nag["last_state_change"]');
        //var_dump($data->max('$nag ==> $nag["current_state"]'));
        //var_dump($result->toArray());
	$nagios_warn_count = (int)$data->count('$nag ==> $nag["current_state"] == "1"');
	$nagios_crit_count = (int)$data->count('$nag ==> $nag["current_state"] == "2"');
	$nagios_state = (int)$data->max('$nag ==> $nag["current_state"]');


	echo '<div style="clear: both;"></div>';

	echo '<div class="left_column">';
        $dane = get_JSON_value('getEnvHostStatebyHost', '192.168.83.66;temp');
        $dane2 = get_JSON_value('getEnvHostStatebyHost', '192.168.83.66;humi');
	draw_frame_twosmallbricks ("Serw. Jag.", "<b>$dane->Value</b>", $dane->Color, "<b>$dane2->Value</b>%", $dane2->Color);

        $dane = get_JSON_value('getEnvHostStatebyHost', '172.16.0.200;temp');
        $dane2 = get_JSON_value('getEnvHostStatebyHost', '172.16.0.200;humi');
        draw_frame_twosmallbricks ("Serw. Fabr.", "<b>$dane->Value</b>", $dane->Color, "<b>$dane2->Value</b>%", $dane2->Color);

        $dane = get_JSON_value('getEnvHostStatebyHost', '192.168.12.209;temp');
        $dane2 = get_JSON_value('getEnvHostStatebyHost', '192.168.12.209;humi');
        draw_frame_twosmallbricks ("Rynek (+1)", "<b>$dane->Value</b>", $dane->Color, "<b>$dane2->Value</b>%", $dane2->Color);

        $dane = get_JSON_value('getPrinterGlobalState');
        $dane2 =get_JSON_value('getPrinterGlobalLastChange');
        $value = $dane->State;
        $text = "<span style=\"opacity: 0.2;\">PRN</span>";
        if ($value > 0) $text = "<strong>".$dane->count2."/".$dane->count1."</strong>";
        $color = $cl_othr_re;
        if ($value == 1) $color = $cl_othr_ye;
        if ($value == 0) $color = $cl_othr_gr;
        draw_main_frame ("Drukarki", $text, $color, $dane2->State, $dane2->Color);

	//URZADZENIA SIECIOWE brick
	$SWState = get_JSON_value('getSwitchGlobalState');
	$WLState = get_JSON_value('getWirelessGlobalState');
	$RTState = get_JSON_value('getRouterGlobalState');
	$dane = max(array($SWState->State, $WLState->State, $RTState->State));
	
	$DevicesW = $SWState->count1 + $WLState->count1 + $RTState->count1;
	$DevicesC = $SWState->count2 + $WLState->count2 + $RTState->count2;	

        $color = $cl_othr_re;
        $text = "<span style=\"opacity: 0.2;\">&nbsp;</span>";
        if ($dane > 0) $text = "<strong>".$DevicesC."/".$DevicesW."</strong>";
        if ($dane == 1) $color = $cl_othr_ye;
        if ($dane == 0) $color = $cl_othr_gr;
        draw_main_frame ("Urządzenia sieciowe", $text, $color);

	//NAGIOS BRICK
        $color = $cl_othr_re;
        $text = "<span style=\"opacity: 0.2;\">&nbsp;</span>";
        if ($nagios_state > 0) $text = "<strong>".$nagios_crit_count."/".$nagios_warn_count."</strong>";
        if ($nagios_state == 1) $color = $cl_othr_ye;
        if ($nagios_state == 0) $color = $cl_othr_gr;
        draw_main_frame ("Usługi", $text, $color);


	//echo $lorem;
	echo '</div>';

	echo '<div class="right_column">';

	echo '<div class="left_in_column">';
        echo $lorem;
        echo '</div>';

        echo '<div class="right_in_column">';
        $ids = get_JSON_value('getSwitchIDs', "1");
	if ($ids) foreach ($ids as $id) {$dane = get_JSON_value('getSwitchStatebyID', $id);   $dane->host = get_JSON_value('getSwitchHostbyID', $id); $WCarray[] = $dane; }
	$ids = get_JSON_value('getWirelessIDs', "1");
	if ($ids) foreach ($ids as $id) {$dane = get_JSON_value('getWirelessStatebyID', $id); $dane->host = get_JSON_value('getWirelessHostbyID', $id); $WCarray[] = $dane; }
        $ids = get_JSON_value('getRouterIDs', "1");
	if ($ids) foreach ($ids as $id) {$dane = get_JSON_value('getRouterStatebyID', $id);   $dane->host = get_JSON_value('getRouterHostbyID', $id); $WCarray[] = $dane; }

        $ids = get_JSON_value('getSwitchIDs', "2");
	if ($ids) foreach ($ids as $id) {$dane = get_JSON_value('getSwitchStatebyID', $id);   $dane->host = get_JSON_value('getSwitchHostbyID', $id); $WCarray[] = $dane; }
        $ids = get_JSON_value('getWirelessIDs', "2");
	if ($ids) foreach ($ids as $id) {$dane = get_JSON_value('getWirelessStatebyID', $id);  $dane->host = get_JSON_value('getWirelessHostbyID', $id); $WCarray[] = $dane; }
        $ids = get_JSON_value('getRouterIDs', "2");
	if ($ids) foreach ($ids as $id) {$dane = get_JSON_value('getRouterStatebyID', $id);   $dane->host = get_JSON_value('getRouterHostbyID', $id); $WCarray[] = $dane; }

	if (isset($WCarray)) {
		uasort($WCarray, function($a, $b)
			{
				if ($a->State == $b->State) {
        				return 0;
    				}
    				return ($a->State > $b->State) ? -1 : 1;
			});

        	echo '<table style="width: 100%;">';
        	foreach ($WCarray as $dane) {
                	//$dane = get_JSON_value('getSwitchStatebyID', $id);
                	//$host = get_JSON_value('getSwitchHostbyID', $id);

                	$color = $cl_ping_gy;
                	if ($dane->State == 2) $color = $cl_othr_re;
                	if ($dane->State == 1) $color = $cl_othr_ye;
                	if ($dane->State == 0) $color = $cl_othr_gr;

                	if (!$dane->Value_S1) $time = "&nbsp;"; else $time = $dane->Value_S1;


                	//echo '<tr><td class="ramka_inne" style="background-color: '.$color.';"><a href="http://'.$host.'">'.$host.'</a></td><td class="ramka_inne" style="background-color: '.$color.';">'.$dane->Name.'</td><td class="ramka_inne" style="background-color: '.$color.';">'.$dane->Value.'</td></tr>';

                	echo '<tr><td class="ramka_inne" style="background-color: '.$color.';">'.$dane->host.'</td><td class="ramka_inne" style="background-color: '.$color.';">'.$dane->Name.'</td><td class="ramka_inne" style="background-color: '.$color.';">'.$dane->Value.'</td></tr>';
        	}
        	echo '</table>';
	}


        echo '</div>';

        echo '<div class="in_footer">';
        if (isset($nagios_fail_array)) {
                echo '<table style="width: 100%;">';
                foreach ($nagios_fail_array as $dane) {
                        $color = $cl_ping_gy;
                        if ($dane["current_state"] == "2") $color = $cl_othr_re;
                        if ($dane["current_state"] == "1") $color = $cl_othr_ye;
			$hostn = strtoupper(str_ireplace(".mhk.local","", $dane["host_name"]));
			$hostn = strtoupper(str_ireplace(".local","",$hostn));
			$timed = ageString(time()-$dane["last_state_change"]);
                        echo '<tr><td class="ramka_inne" style="background-color: '.$color.';">'.$hostn.'</td><td class="ramka_inne" style="background-color: '.$color.';">'.$dane["service_description"].'</td><td class="ramka_inne" style="background-color: '.$color.';">'.$dane["plugin_output"].'</td><td class="ramka_inne" style="background-color: '.$color.';">'.$timed.'</td></tr>';
                }
                echo '</table>';
        }

        echo '</div>'; // in_footer


	echo '</div>'; // right_column

	echo '<div style="clear: both;"></div>';
        
	echo '<div class="main_footer">';
        echo $lorem;
        echo '</div>';


?>
</body>
</html>
