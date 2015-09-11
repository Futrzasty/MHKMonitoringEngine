<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="10" />
<link href="index.css" rel="stylesheet" type="text/css" />
<title>IT Monitoring System</title>
</head>
<body style="font-family: Tahoma,Helvetica;">

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
	include_once ("functions.php");

        mysql_connect('localhost', $db_user, $db_pass);
        @mysql_select_db($db_name) or die("Nie udało się wybrać bazy danych");

	mysql_query("SET CHARACTER SET utf8");
	mysql_query("SET NAMES utf8");
	mysql_query("SET COLLATION utf8");

	snmp_set_valueretrieval(SNMP_VALUE_PLAIN);	

	$sj_ups_temp = (double)snmp2_get("192.168.0.252", "public", ".1.3.6.1.2.1.99.1.1.1.4.1") / 10;
	$sj_ups_hum = (int)snmp2_get("192.168.0.252", "public", ".1.3.6.1.2.1.99.1.1.1.4.2");

	echo '<div style="border: 1px dashed gray; padding: 5px;">';
	echo '<div style="clear: left; text-align: center;"><b>Serwerownia Jagiellońska - UPS</b></div>';	
	echo '<div style="float: left;">Temperatura:';
	if ($sj_ups_temp < 18) $color = $cl_othr_bu;
	else if ($sj_ups_temp < 22) $color = $cl_othr_gr;
	else $color = $cl_othr_re;
	echo '<div class="ramka" style="background-color:'.$color.';"><b>'.$sj_ups_temp.'</b>&deg;C</div>';
        echo '</div>';

	echo '<div style="float: left;">Wilgotność:';
        if ($sj_ups_hum < 30) $color = $cl_othr_re;
        else if ($sj_ups_hum < 60) $color = $cl_othr_gr;
        else $color = $cl_othr_re;
	echo '<div class="ramka" style="background-color:'.$color.';"><b>'.$sj_ups_hum.'</b> %</div>';
	echo '</div>';
	echo '<img src="http://cacti-digi.mhk.local/cacti/graph_image.php?action=view&local_graph_id=13&rra_id=1" style="float: left; height: 124px; border: 0px;" />';
	echo '<img src="http://cacti-digi.mhk.local/cacti/graph_image.php?action=view&local_graph_id=13&rra_id=5" style="float: left; height: 124px; border: 0px;" />';


	echo '<div style="clear: both;"></div>';
	echo '</div>';
?>

<?php

	echo '<div style="border: 1px dashed gray; padding: 5px;">';
	echo '<div style="clear: left; text-align: center;"><b>Serwisy sieciowe</b></div>';	
	echo '<div style="float: left;">REZERWACJA - www:';
	
	$host = 'bilety.mhk.pl'; 
	$port = 80; 
	$waitTimeoutInSeconds = 1; 
	if($fp = fsockopen($host,$port,$errCode,$errStr,$waitTimeoutInSeconds)){   
		echo '<div class="ramka" style="background-color: '.$cl_othr_gr.';"><b>OK</b></div>';
   		// It worked 
	} else {
		echo '<div class="ramka" style="background-color: '.$cl_othr_re.';"><b>NOK</b></div>';
   		// It didn't work 
	} 
	fclose($fp);
        echo '</div>';

	
	echo '<div style="float: left;">KASA - load (5 min)';
        
	$host = "172.30.31.35"; 
        $result = nrpe_load($host); 

	if ($result[0] == "OK") $color = $cl_othr_gr;
        else $color = $cl_othr_re;
        if ($result[0] == "") {$color = $cl_othr_re; $result="&nbsp;";}
	echo '<div class="ramka" style="background-color:'.$color.';"><b>'.$result[2].'</b></div>';
	echo '</div>';



	$host_alias = "PING onet.pl"; 
        $result = mysql_query("SELECT ping_avg FROM ping_other WHERE alias = \"".$host_alias."\"");
	$result = mysql_fetch_assoc($result)["ping_avg"];
	echo '<div style="float: left;">'.$host_alias;
        

	if ($result < $th_ping_lo) $color = $cl_ping_gr;
        else if ($result < $th_ping_hi) $color = $cl_ping_ye;
        else $color = $cl_ping_re;
        if ($result == "") {$color = $cl_ping_re; $result="&nbsp;";}
	echo '<div class="ramka" style="background-color:'.$color.';"><b>'.$result.'</b></div>';
	echo '</div>';


	$host_alias = "SW Krzysztofory PD2"; 
        $result = mysql_query("SELECT ping_avg FROM ping_other WHERE alias = \"".$host_alias."\"");
	$result = mysql_fetch_assoc($result)["ping_avg"];
	echo '<div style="float: left;">'.$host_alias;
        

	if ($result < $th_ping_lo) $color = $cl_ping_gr;
        else if ($result < $th_ping_hi) $color = $cl_ping_ye;
        else $color = $cl_ping_re;
        if ($result == "") {$color = $cl_ping_re; $result="&nbsp;";}
	echo '<div class="ramka" style="background-color:'.$color.';"><b>'.$result.'</b></div>';
	echo '</div>';



	$host_alias = "SW Księgowość (PING)"; 
        $result = mysql_query("SELECT ping_avg FROM ping_other WHERE alias = \"".$host_alias."\"");
	$result = mysql_fetch_assoc($result)["ping_avg"];
	echo '<div style="float: left;">'.$host_alias;
        

	if ($result < $th_ping_lo) $color = $cl_ping_gr;
        else if ($result < $th_ping_hi) $color = $cl_ping_ye;
        else $color = $cl_ping_re;
        if ($result == "") {$color = $cl_ping_re; $result="&nbsp;";}
	echo '<div class="ramka" style="background-color:'.$color.';"><b>'.$result.'</b></div>';
	echo '</div>';

	echo '<div style="clear: both;"></div>';
	echo '</div>';
?>


<?php

	echo '<div style="border: 1px dashed gray; padding: 5px;">';
	echo '<div style="clear: left; text-align: center;"><b>Tunele IPSec</b></div>';	

	$query="SELECT * FROM pingtimes LEFT JOIN dict_ping ON(pingtimes.host_id = dict_ping.host_id) ORDER BY `order`";
        $result=mysql_query($query);
	
	while ($num = mysql_fetch_assoc($result))
	{
		$ping = $num["ping_avg"];
		if ($ping < $th_ping_lo) $color = $cl_ping_gr;
        	else if ($ping < $th_ping_hi) $color = $cl_ping_ye;
        	else $color = $cl_ping_re;
        	if ($ping == "") {$color = "red"; $ping="&nbsp;";}
		echo '<div style="float: left;">'.$num["alias"];
		echo '<div class="ramka" style="background-color: '.$color.';"><b>'.$ping.'</b></div>';
		echo '</div>';	
	}

	echo '<div style="clear: both;"></div>';
	echo '</div>';


	echo '<div style="border: 1px dashed gray; padding: 5px;">';
	echo '<div style="clear: left; text-align: center;"><b>Problemy NAGIOS</b></div>';	

	$nagios = get_nagios_status();
	//echo var_dump($nagios);
	$entries =  count($nagios)/7;
	for ($i = 0; $i < $entries; $i++) {
		if ($nagios[2+$i*7] == "WARNING")
			$color = $cl_ping_ye;
		else if ($nagios[2+$i*7] == "CRITICAL") 
			$color = $cl_ping_re;
		else $color = $cl_othr_bl;
		if ($nagios[0+$i*7] != "OLD HOST") 
			$hostn = strtoupper(str_ireplace(".mhk.local","",$nagios[0+$i*7]));
		echo '<div class="ramka_nagios" style="width: 250px; background-color: '.$color.';"><b>'.$hostn.'</b></div>';
		echo '<div class="ramka_nagios" style="width: 500px; background-color: '.$color.';"><b>'.$nagios[1+$i*7].'</b></div>';
		echo '<div class="ramka_nagios" style="width: 1020px; background-color: '.$color.';"><b>'.$nagios[6+$i*7].'</b></div>';
		echo '<div style="clear: both;"></div>';
	} 

	echo '</div>';



	mysql_close();
?>
</body>
</html>
