<?php
        include ('hosts_allowed.inc');
        if (!in_array($_SERVER["REMOTE_ADDR"], $hosts_allowed_board) &&
            !in_array($_SERVER["REMOTE_ADDR"], $hosts_allowed_all)) {
                header('Location: /index.html');
                exit;
        }
	$refresh = 20;
	if ($_SERVER["REMOTE_ADDR"] != '192.168.90.143') $refresh = 90;
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
        echo '<span class="data">'.$dnityg[$dzientyg].', '.$dzien.' '.$miesiace[$miesiac].' '.$rok.' WERSJA AWARYJNA</span>';
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

	echo '<div class="grupa">';
	echo '<div style="clear: left; text-align: center;"><b>Serwerownia Jagiellońska - UPS</b></div>';	
	echo '<div style="float: left;">Temperatura';
	if ($sj_ups_temp < $th_temp_lo) $color = $cl_othr_bu;
	else if ($sj_ups_temp < $th_temp_hi) $color = $cl_othr_gr;
	else $color = $cl_othr_re;
	echo '<div class="ramka" style="background-color:'.$color.';"><b>'.$sj_ups_temp.'</b>&deg;C</div>';
        echo '</div>';

	echo '<div style="float: left;">Wilgotność';
        $color = $cl_othr_re;
	if ($sj_ups_hum >= $th_hum_hi) $color = $cl_othr_re;
        if (($sj_ups_hum < $th_hum_hi) && ($sj_ups_hum >= $th_hum_me)) $color = $cl_othr_ye;
        if (($sj_ups_hum < $th_hum_me) && ($sj_ups_hum >= $th_hum_lo)) $color = $cl_othr_gr;
        if ($sj_ups_hum < $th_hum_lo) $color = $cl_othr_re;
	echo '<div class="ramka" style="background-color:'.$color.';"><b>'.$sj_ups_hum.'</b> %</div>';
	echo '</div>';
	echo '<img src="http://cacti-digi.mhk.local/cacti/graph_image.php?action=view&local_graph_id=13&rra_id=1" style="float: left; height: 124px; border: 0px;" />';
	echo '<img src="http://cacti-digi.mhk.local/cacti/graph_image.php?action=view&local_graph_id=13&rra_id=5" style="float: left; height: 124px; border: 0px;" />';


	echo '<div style="clear: both;"></div>';
	echo '</div>';
?>

<?php

	echo '<div class="grupa">';
	echo '<div style="clear: left; text-align: center;"><b>Serwisy sieciowe</b></div>';	
	
        $query="SELECT * FROM http_content ORDER BY `order`";
        $result=mysql_query($query);

        while ($num = mysql_fetch_assoc($result))
        {
                $state = $num["state"];
                $timedf = time()-strtotime($num["last_change"]);

                echo '<div style="float: left;">'.$num["alias"];

                if ($state == 0) {
                        echo '<div class="ramka" style="background-color: '.$cl_othr_gr.';"><b>OK</b></div>';
                }
                else if ($state == 1) {
                        echo '<div class="ramka" style="background-color: '.$cl_othr_ye.';"><b>WARN</b></div>';
                }
                else
                        echo '<div class="ramka" style="background-color: '.$cl_othr_re.';"><b>ERROR</b></div>';

                $sm_color = $cl_ping_gr; //'none';
                if ($timedf < 24*60*60) $sm_color = $cl_ping_ye;
                if ($timedf < 60*60) $sm_color = $cl_ping_re;
                echo '<div class="low_r" style="background-color:'.$sm_color.';">'.datedif($timedf).'</div>';
                echo '</div>';
        }


	echo '<div style="float: left;">KASA - load (5 min)';
	$host = "172.30.31.35"; 
        $result = nrpe_load($host); 

	//if ($result[0] == "OK") $color = $cl_othr_gr;
        //else $color = $cl_othr_re;
        //if ($result[0] == "") {$color = $cl_othr_re; $result="&nbsp;";}
	$color = $cl_othr_gr;
	if ($result[2] > $th_load_lo) $color = $cl_othr_ye;
        if ($result[2] > $th_load_hi) $color = $cl_othr_re;
        if ($result[0] == "") {$color = $cl_othr_re; $result="&nbsp;";}
	if (!is_numeric($result[2])) $color = $cl_othr_re;
	echo '<div class="ramka" style="background-color:'.$color.';"><b>'.$result[2].'</b></div>';
	echo '</div>';

	echo '<div style="float: left;">POCZTA - load (5 min)';
	$host = "172.30.31.37"; 
        $result = nrpe_load($host); 

	//if ($result[0] == "OK") $color = $cl_othr_gr;
        //else $color = $cl_othr_re;
        //if ($result[0] == "") {$color = $cl_othr_re; $result="&nbsp;";}
	$color = $cl_othr_gr;
	if ($result[2] > $th_load_lo) $color = $cl_othr_ye;
        if ($result[2] > $th_load_hi) $color = $cl_othr_re;
        if ($result[0] == "") {$color = $cl_othr_re; $result="&nbsp;";}
	if (!is_numeric($result[2])) $color = $cl_othr_re;
	echo '<div class="ramka" style="background-color:'.$color.';"><b>'.$result[2].'</b></div>';
	echo '</div>';


	echo '<div style="float: left;">PODZIEMIA - CPU (5 min)';
	$host = "192.168.12.100"; 
        $result = nsclient_load($host); 

	$color = $cl_othr_gr;
	if ($result[0] > $th_cpu_lo) $color = $cl_othr_ye;
        if ($result[0] > $th_cpu_hi) $color = $cl_othr_re;
        //if ($result[0] == "") {$color = $cl_othr_re; $result="&nbsp;";}
	$dresult = $result[0].'</b> %';
	if (!is_numeric($result[0])) {
		$color = $cl_othr_re;
		$dresult = "ERROR</b>";
	}
	echo '<div class="ramka" style="background-color:'.$color.';"><b>'.$dresult.'</div>';
	echo '</div>';


	echo '<div style="float: left;">COGISOFT - CPU (5 min)';
	$host = "192.168.0.18";
        $result = nsclient_load($host); 

	$color = $cl_othr_gr;
	if ($result[0] > $th_cpu_lo) $color = $cl_othr_ye;
        if ($result[0] > $th_cpu_hi) $color = $cl_othr_re;
        //if ($result[0] == "") {$color = $cl_othr_re; $result="&nbsp;";}
	$dresult = $result[0].'</b> %';
	if (!is_numeric($result[0])) {
		$color = $cl_othr_re;
		$dresult = "ERROR</b>";
	}
	echo '<div class="ramka" style="background-color:'.$color.';"><b>'.$dresult.'</div>';
	echo '</div>';


	echo '<div style="float: left;">TERMINAL - CPU (5 min)';
	$host = "192.168.0.17"; 
        $result = nsclient_load($host); 

	$color = $cl_othr_gr;
	if ($result[0] > $th_cpu_lo) $color = $cl_othr_ye;
        if ($result[0] > $th_cpu_hi) $color = $cl_othr_re;
        //if ($result[0] == "") {$color = $cl_othr_re; $result="&nbsp;";}
	$dresult = $result[0].'</b> %';
	if (!is_numeric($result[0])) {
		$color = $cl_othr_re;
		$dresult = "ERROR</b>";
	}
	echo '<div class="ramka" style="background-color:'.$color.';"><b>'.$dresult.'</div>';
	echo '</div>';

	$query="SELECT * FROM ping_other ORDER BY `order`";
        $result=mysql_query($query);
	
	while ($num = mysql_fetch_assoc($result))
	{
		$ping = $num["ping_avg"];
		if ($ping < $th_ping_lo) $color = $cl_ping_gr;
        	else if ($ping < $th_ping_hi) $color = $cl_ping_ye;
        	else $color = $cl_ping_re;
        	if ($ping == "") {$color = "red"; $ping="&nbsp;";}
		if ($num["disabled"]) $color = $cl_ping_gy;

		$timedf = time()-strtotime($num["last_change"]);
		
		echo '<div style="float: left;">'.$num["alias"];
		echo '<div class="ramka" style="background-color: '.$color.';"><b>'.$ping.'</b></div>';
		$sm_color = $cl_ping_gr; //'none';
		if ($timedf < 24*60*60) $sm_color = $cl_ping_ye;
		if ($timedf < 60*60) $sm_color = $cl_ping_re;
		echo '<div class="low_r" style="background-color:'.$sm_color.';">'.datedif($timedf).'</div>';
		echo '</div>';
	}


	echo '<div style="float: left;">FIBERTECH';
	$html = file_get_contents('http://check-ip.eu:8092/get_token_mhk.php');
	$color = $cl_othr_re;
	$dresult = "ERROR";
	if ($html == "ft872362882") {
		$color = $cl_othr_gr;
		$dresult = "OK";
	}
	echo '<div class="ramka" style="background-color:'.$color.';"><b>'.$dresult.'</b></div>';
	echo '</div>';

	echo '<div style="float: left;">CYFRONET';
	$html = file_get_contents('http://check-ip.eu:8091/get_token_mhk.php');
	$color = $cl_othr_re;
	$dresult = "ERROR";
	if ($html == "ack823747236") {
		$color = $cl_othr_gr;
		$dresult = "OK";
	}
	echo '<div class="ramka" style="background-color:'.$color.';"><b>'.$dresult.'</b></div>';
	echo '</div>';


	echo '<div style="clear: both;"></div>';
	echo '</div>';
?>


<?php

	echo '<div class="grupa">';
	echo '<div style="clear: left; text-align: center;"><b>Tunele IPSec</b></div>';	

	$query="SELECT * FROM ping_ipsec ORDER BY `order`";
        $result=mysql_query($query);
	
	while ($num = mysql_fetch_assoc($result))
	{
		$ping = $num["ping_avg"];
		if ($ping < $th_ping_lo) $color = $cl_ping_gr;
        	else if ($ping < $th_ping_hi) $color = $cl_ping_ye;
        	else $color = $cl_ping_re;
        	if ($ping == "") {$color = "red"; $ping="&nbsp;";}
		if ($num["disabled"]) $color = $cl_ping_gy;

		$timedf = time()-strtotime($num["last_change"]);
		$third_octet=explode(".", $num["ip"])[2];
	
		echo '<div style="float: left;">'.$num["alias"]." (<b>".$third_octet."</b>)";
		echo '<div class="ramka" style="background-color: '.$color.';"><b>'.$ping.'</b></div>';
		$sm_color = $cl_ping_gr; //'none';
		if ($timedf < 24*60*60) $sm_color = $cl_ping_ye;
		if ($timedf < 60*60) $sm_color = $cl_ping_re; 
		echo '<div class="low_r" style="background-color:'.$sm_color.';">'.datedif($timedf).'</div>';
		echo '</div>';
	}

	echo '<div style="clear: both;"></div>';
	echo '</div>';

	//NAGIOS 2
	echo '<div class="grupa">';
	echo '<div style="clear: left; text-align: center;"><b>Problemy NAGIOS</b></div>';
	$host = '192.168.90.65';
        $port = 80;
	//$adres = 'http://nagios.mhk.local/cgi-bin/nagios3/status.cgi?host=all&servicestatustypes=28';
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


	mysql_close();
?>
</body>
</html>
