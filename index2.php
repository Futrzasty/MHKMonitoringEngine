<?php
        include ('hosts_allowed.inc');
        if (!in_array($_SERVER["REMOTE_ADDR"], $hosts_allowed_board) &&
            !in_array($_SERVER["REMOTE_ADDR"], $hosts_allowed_all)) {
                header('Location: /index.html');
                exit;
        }

	include_once ("functions.php");
	$refresh = 15;
//	if ($_SERVER["REMOTE_ADDR"] != '192.168.90.143') $refresh = 60;

	$host = '192.168.90.65';
        $port = 80;
	$adres = 'http://'.$host.'/cgi-bin/nagios3/status.cgi?host=all&servicestatustypes=28';
        $waitTimeoutInSeconds = 0.5;
        $nagiosok = 0;
	if($fp = fsockopen($host,$port,$errCode,$errStr,$waitTimeoutInSeconds)) {
	
		$nagios = get_nagios_status($adres);
		$entries =  count($nagios)/7;
		$nagiosok = 1;
	}
?>
<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<?php
//echo '<meta http-equiv="refresh" content="'.$refresh.'" />';
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
           echo '<span class="data">'.$dnityg[$dzientyg].', '.$dzien.' '.$miesiace[$miesiac].' '.$rok.'</span>';
	echo '<span class="czas">'.$g_odzina.':'.$m_inuta.'</span>';        

	$nagios_th = 7;
	
	$page = isset($_GET["page"]) ? $_GET["page"] : 0;


	if ($entries < $nagios_th  || !$nagiosok) {
		include("index_main.inc");
		include("index_nagios.inc");
		$next_page = 0;
	}

        if ($entries >= $nagios_th && $page == 0) {
                include("index_main.inc");
                include("index_nagios_er.inc");
                $next_page = 1;
        }
        
	if ($entries >= $nagios_th && $page == 1) {
//                include("index_main.inc");
                include("index_nagios.inc");
                $next_page = 0;
        }

	fclose($fp);
?>

<script type="text/javascript">

function przekieruj(page) {
  document.location.href = '/index2.php?page='+page;
};

window.setTimeout('przekieruj(<?php echo  $next_page; ?>)', <?php echo $refresh*1000; ?> );	


</script>

</body>
</html>
