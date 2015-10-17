<?php
// zmianne, które można śmiało nazwać globalnymi
$cl_othr_bu = "#88ffff";
$cl_othr_gr = "#aaffaa";
$cl_othr_ye = "#ffff55";
$cl_othr_re = "red";
$cl_othr_bl = "#aaaaaa";

$cl_ping_gr = "#aaffaa";
$cl_ping_ye = "#ffff55";
$cl_ping_re = "red";
$cl_ping_gy = "#888888";

$th_ping_lo = 200;
$th_ping_hi = 700;

$th_cpu_lo = 20;
$th_cpu_hi = 50;

$th_load_lo = 1;
$th_load_hi = 2;

$th_hum_lo = 30;
$th_hum_me = 60;
$th_hum_hi = 70;

$th_temp_hi = 22;
$th_temp_lo = 18;

include_once ("config.php");

function ping($t,$p){
	$r = array();
	$st = "ping -W 1 -c ".$p." -w ".$p." ".$t;
	$cr = shell_exec($st);
	$r = explode(",",$cr);
	$so = $r[3];
	$st = 'max/mdev =';
	$so = substr($so,strpos($so,$st)+strlen($st));
	$st = '/';
	$min = substr($so,0,strpos($so,$st));
	$so = substr($so,strpos($so,$st)+strlen($st));
	$avg = substr($so,0,strpos($so,$st));
	$so = substr($so,strpos($so,$st)+strlen($st));
	$max = substr($so,0,strpos($so,$st));
	$so = substr($so,strpos($so,$st)+strlen($st));
	$st = 'ms';
	$mdev = substr($so,0,strpos($so,$st));
	$so = substr($so,strpos($so,$st)+strlen($st));
	return array($min, $avg, $max, $mdev);
}

function nrpe_load($host) {
	$st = "/usr/lib/nagios/plugins/check_nrpe -H ".$host." -c check_load";
	$st = shell_exec($st);
	$r = explode("|", $st);
	$r1 = str_ireplace("- load average: ", "", $r[0]);
	$r2 = explode(" ", $r1);
	foreach ($r2 as &$value) {
    		$value = str_ireplace(",","", $value);
	}

	return array($r2[0],$r2[1],$r2[2],$r2[3]);
}

function nsclient_load($host) {
	$st = "/usr/lib/nagios/plugins/check_nt -H ".$host." -p 12489 -v CPULOAD -l 5,80,90";
	$st = shell_exec($st);
	$r = explode("|", $st);
	//$r1 = str_ireplace("'5 min avg Load'= ", "", $r[1]);
	$r1 = explode("=", $r[1]);
	$r2 = explode(";", $r1[1]);
	foreach ($r2 as &$value) {
    		$value = str_ireplace("%","", $value);
	}

	return array($r2[0],$r2[1],$r2[2],$r2[3],$r2[4]);
}

function get_printer_status($host,$community) {
        $st = "/usr/lib/nagios/plugins/check_printer $host $community 10 5";
        $st = exec($st, $dummy, $cmd_state);
	$r = explode("|", $st);

	return array($cmd_state, $r[0], $r[1]);
}

function get_nagios_status($host) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$host);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($ch, CURLOPT_USERPWD, "$nagios_username:$nagios_password");
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
	$tresc=curl_exec ($ch);
	curl_close ($ch);

	$pocz = stripos($tresc, '<TABLE BORDER=0 width=100% CLASS=\'status\'>');
	$tresc = substr($tresc, $pocz);
	$pocz = stripos($tresc, 'Produced by Nagios (http://www.nagios.org)');
	$tresc = substr($tresc, 0, $pocz);
	
	$tresc = preg_replace("/<img[^>]+\>/i", " ", $tresc);
	$tresc = strip_tags($tresc, '<td>');

	$tresc = str_ireplace("<TD></TD>", "OLD HOST", $tresc);

	$pocz = stripos($tresc, 'Information');
	$tresc = substr($tresc, $pocz+11);
	$tresc = strip_tags($tresc);
	
	$tresc = preg_split("/(\r\n|\n|\r)/", $tresc);
	
	$tresc = array_map('trim', $tresc);
	$tresc = array_filter($tresc);
	$tresc = array_values($tresc);
	
	$opis = array_pop($tresc);

	return ($tresc);
}

function datedif ($time_diff) {
	//if time difference is less than 60,then its seconds
	if ($time_diff <= 60) {
    		return $time_diff . " sek.";
	}
	//if time difference is greater than 60 and lesser than 60*60*60 ,then its minutes
	if (($time_diff > (60)) && ($time_diff <= (60 * 60))) {
    		return floor($time_diff / (60)) . " min.";
	}
 	//if time difference is greater than 60*60*60 and lesser than 60*60*60*24,then its hours
	if (($time_diff > (60 * 60)) && ($time_diff <= (60 * 60 * 24))) {
    		$val1 = floor($time_diff / (60 * 60));
		$val2 = floor(($time_diff - $val1 * (60 * 60)) / (60));

		return $val1." h ".$val2. " m";
	}

	if ($time_diff > (60 * 60 * 24) && ($time_diff <= (2000 * 60 * 60 * 24))) {
		$val1 = floor($time_diff / (60 * 60 * 24));
                $val2 = floor(($time_diff - $val1 * (60 * 60 * 24)) / (60 * 60));
	
		return $val1." d ".$val2. " h";
	}

	if ($time_diff > (2000 * 60 * 60 * 24)) {
    		return '&nbsp;';
	}
}

function check_www ($host, $content, $timeout, $username='', $password='') {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$host);
	curl_setopt($ch, CURLOPT_TIMEOUT, $timeout); //timeout after 30 seconds
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
//	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
//	curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
	$tresc=curl_exec ($ch);
	curl_close ($ch);
	return stripos($tresc, $content);
}

function ipCIDRCheck ($IP, $CIDR) {
	list ($net, $mask) = split ("/", $CIDR);
	if ($mask == "") $mask = 32;
	$ip_net = ip2long ($net);
	$ip_mask = ~((1 << (32 - $mask)) - 1);
	$ip_ip = ip2long ($IP);
	$ip_ip_net = $ip_ip & $ip_mask;
	return ($ip_ip_net == $ip_net);
}

function get_recent_file ($dir, $mask)	{
	// $dir = "/home/wellho/public_html/demo";
	// $pattern = '\.(html|php|php4)$';
	$pattern = $mask.'$';

	$newstamp = 0;
	$newname = "";
	$dc = opendir($dir);
	while ($fn = readdir($dc)) {
		# Eliminate current directory, parent directory
		if (ereg('^\.{1,2}$',$fn)) continue;
		# Eliminate other pages not in pattern
		if (! ereg($pattern,$fn)) continue;
		$timedat = filemtime("$dir/$fn");
		if ($timedat > $newstamp) {
			$newstamp = $timedat;
			$newname = $fn;
		}
	}
	# $timedat is the time for the latest file
	# $newname is the name of the latest file
	return $newname;
}

function draw_main_frame ($title='', $main_v='', $main_c='', $lowr_v='&nbsp;', $lowr_c='') {
	echo '<div style="float: left;">'.$title;
        echo '<div class="ramka" style="background-color:'.$main_c.';">'.$main_v;
	$style = '';
	if ($lowr_c != '') {
		$style = 'style="background-color:'.$lowr_c.';"';
	}
        echo '<div class="low_r"'.$style.'>'.$lowr_v.'</div>';
        echo '</div></div>';
}

function draw_frame_twosmallbricks ($title='', $up_v='', $up_c='', $dw_v='', $dw_c='') {
	echo '<div style="float: left;">'.$title;
	echo '<div class="ramka_sm1" style="background-color:'.$up_c.';">'.$up_v.'</div>';
	echo '<div class="ramka_sm1" style="background-color:'.$dw_c.';">'.$dw_v.'</div>';
        echo '</div>';
}

function get_JSON_value ($func, $arg='') {
	if ($arg != '') $arg = "?$arg";
	$uchwyt = fopen("http://monitoring.mhk.local/JSON/$func.php$arg", "rb");
        $tresc = stream_get_contents($uchwyt);
        fclose($uchwyt);
        return json_decode($tresc);
}

function ageString($seconds)
{
    $age = "";
    if ($seconds > 86400) {
        $days = (int)($seconds / 86400);
        $seconds = $seconds - ($days * 86400);
        $age .= $days . "d";
    }
    if ($seconds > 3600) {
        $hours = (int)($seconds / 3600);
        $seconds = $seconds - ($hours * 3600);
        $age .= $hours . "h";
    }
    if ($seconds > 60) {
        $minutes = (int)($seconds / 60);
        $seconds = $seconds - ($minutes * 60);
        $age .= $minutes . "m";
    }
    $age .= $seconds . "s";
    return $age;
}

