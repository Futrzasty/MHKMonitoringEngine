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
	$lorem = "Mauris a mi rhoncus, viverra orci eget, tempor erat. Morbi gravida metus at dictum pretium. Aenean ultrices erat vel mauris tristique elementum. Sed vehicula quis augue quis posuere. Quisque suscipit mauris eget eros condimentum porttitor. Fusce ultrices est vel velit rutrum, id pharetra augue gravida. Sed ullamcorper erat id sem tristique commodo. Vestibulum mauris eros, commodo quis pulvinar sit amet, semper id ipsum. Sed sit amet lacus sagittis, dictum lacus et, volutpat arcu. Vestibulum aliquet pharetra maximus. Aenean rutrum, tellus a consectetur accumsan, sapien ante placerat lacus, eu feugiat nunc mi sed orci. Nulla facilisi. Nulla vitae ornare ligula. Phasellus non consectetur nisl, eu condimentum tortor.i <br />Mauris a mi rhoncus, viverra orci eget, tempor erat. Morbi gravida metus at dictum pretium. Aenean ultrices erat vel mauris tristique elementum. Sed vehicula quis augue quis posuere. Quisque suscipit mauris eget eros condimentum porttitor. Fusce ultrices est vel velit rutrum, id pharetra augue gravida. Sed ullamcorper erat id sem tristique commodo. Vestibulum mauris eros, commodo quis pulvinar sit amet, semper id ipsum. Sed sit amet lacus sagittis, dictum lacus et, volutpat arcu. Vestibulum aliquet pharetra maximus. Aenean rutrum, tellus a consectetur accumsan, sapien ante placerat lacus, eu feugiat nunc mi sed orci. Nulla facilisi. Nulla vitae ornare ligula. Phasellus non consectetur nisl, eu condimentum tortor. <br /> Mauris a mi rhoncus, viverra orci eget, tempor erat. Morbi gravida metus at dictum pretium. Aenean ultrices erat vel mauris tristique elementum. Sed vehicula quis augue quis posuere. Quisque suscipit mauris eget eros condimentum porttitor. Fusce ultrices est vel velit rutrum, id pharetra augue gravida. Sed ullamcorper erat id sem tristique commodo. Vestibulum mauris eros, commodo quis pulvinar sit amet, semper id ipsum. Sed sit amet lacus sagittis, dictum lacus et, volutpat arcu. Vestibulum aliquet pharetra maximus. Aenean rutrum, tellus a consectetur accumsan, sapien ante placerat lacus, eu feugiat nunc mi sed orci. Nulla facilisi. Nulla vitae ornare ligula. Phasellus non consectetur nisl, eu condimentum tortor.";

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
        echo '<a href="switch_detail.php" style="color: white;">';
        draw_main_frame ("Urządzenia sieciowe", $text, $color);
        echo '</a>';


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
	if ($ids) foreach ($ids as $id) {$dane = get_JSON_value('getWirelssStatebyID', $id);  $dane->host = get_JSON_value('getWirelessHostbyID', $id); $WCarray[] = $dane; }
        $ids = get_JSON_value('getRouterIDs', "2");
	if ($ids) foreach ($ids as $id) {$dane = get_JSON_value('getRouterStatebyID', $id);   $dane->host = get_JSON_value('getRouterHostbyID', $id); $WCarray[] = $dane; }

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




        echo '</div>';

        echo '<div class="in_footer">';
        echo "&nbsp;";
	//var_dump ($WCarray);
        echo '</div>';


	echo '</div>'; //of right_column

	echo '<div style="clear: both;"></div>';
        
	echo '<div class="main_footer">';
        echo $lorem;
        echo '</div>';


?>
</body>
</html>
