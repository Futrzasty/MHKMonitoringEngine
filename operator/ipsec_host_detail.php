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
	
	$conv['POSTAL'] = 'Adres oddziału';
	$conv['LAN'] = 'LAN';
	$conv['WAN'] = 'WAN';
	$conv['PSTN'] = 'Identyfikator linii PSTN';
		
function difftocolor ($diff) {
	if ($diff > 60*60*2) return "red";
	if ($diff > 60*2) return "yellow";
	return "green";
}
	
        mysql_connect('localhost', $db_user, $db_pass);
        @mysql_select_db($db_name) or die("Nie udało się wybrać bazy danych");

        mysql_query("SET CHARACTER SET utf8");
        mysql_query("SET NAMES utf8");
        mysql_query("SET COLLATION utf8");

	$host=$_GET["host"];
	$long = isset($_GET["long"]) ? $_GET["long"] : 0;

        $query="SELECT alias, ip, hostname, isp FROM ping_ipsec WHERE `id`=".$host." LIMIT 1";
        $result=mysql_query($query);
	$row = mysql_fetch_row($result);

	echo '<div class="branchname" style="float: left; width: 100%; font-size: 30pt; font-weight: bold; padding-bottom: 10px;">';
	echo $row[0].' ('.$row[2].') '.$row[1].'';
	echo '</div>';

	echo '<div class="branchinfo" style="float: left; clear: both; width: 50%;">';
	echo '<a href="/operator/index.php" class="op_button">Powrót</a>';
	if (!$long)
		echo '<a href="/operator/ipsec_host_detail.php?host='.$host.'&long=1" class="op_button">Tylko długie przerwy</a>';
	else
		echo '<a href="/operator/ipsec_host_detail.php?host='.$host.'" class="op_button">Wszystkie przerwy</a>';
	echo '<br/><br/>';
	$isp = "nieznany";
	if ($row[3] != "") $isp = $row[3];
	echo '<span style="font-size:24pt;">Łącze dostarcza: <b>'.$isp.'</b><br/></span><br/>';
	
        $query="SELECT * FROM ping_ipsec_branches WHERE `host`=".$host." ORDER BY `order` ASC";
        $result=mysql_query($query);
	
	echo '<table class="ipsec_info">';
	while ($row = mysql_fetch_assoc($result)) {
		echo '<tr><td class="ipsec_info">'.$conv[$row["net_type"]].' '.$row["net_name"].'</td><td class="ipsec_info">'.$row["net_address"].'</td></tr>';
	}
	echo '</table><br/>';

	echo '<img src="/rrd_graph.php?ipsec4h;'.$host.'" alt="wykresik" /><br />';

	include '_include/'.$isp.'.html';
	echo '</div>';

	
	$query="SELECT status, change_time FROM ping_ipsec_history LEFT JOIN ping_ipsec ON (ping_ipsec.hostname = ping_ipsec_history.hostname) WHERE `ping_ipsec`.`id`=".$host." ORDER BY `change_time` DESC";
        $result=mysql_query($query);

        $ontime = "0000";
        $offtime = "0000";

	echo '<table style="float: left; width: 50%;">';
	if ($row = mysql_fetch_assoc($result)) {
		if ($row["status"] == "OFFLINE") {
                        $ontimetext = "&nbsp;";
			$ontime = date('Y-m-d H:i:s');
			$offtime = $row["change_time"];
		}
		else
		{
			$ontime = $row["change_time"];
			$ontimetext = $ontime;
			$row = mysql_fetch_assoc($result);
			$offtime = $row["change_time"];
		}
	}
	$diff = strtotime($ontime)-strtotime($offtime);	
	if ($long) {
		if ($diff > 120)
			echo '<tr><td class="op_ramka_off">'.$offtime.'</td><td class="op_ramka_on">'.$ontimetext.'</td><td class="op_ramka_diff" style="background-color: '.difftocolor($diff).'">'.datedif($diff).'</td></tr>';
	}
	else
		echo '<tr><td class="op_ramka_off">'.$offtime.'</td><td class="op_ramka_on">'.$ontimetext.'</td><td class="op_ramka_diff" style="background-color: '.difftocolor($diff).'">'.datedif($diff).'</td></tr>';
	while ($rowon = mysql_fetch_assoc($result)) {
		if ($rowon["status"] == "ONLINE") {
			if ($rowoff = mysql_fetch_assoc($result)) {
				$ontime = $rowon["change_time"];
				$offtime = $rowoff["change_time"];
				$diff = strtotime($ontime)-strtotime($offtime);
        			if ($long) {
                			if ($diff > 120)
                        			echo '<tr><td class="op_ramka_off">'.$offtime.'</td><td class="op_ramka_on">'.$ontime.'</td><td class="op_ramka_diff" style="background-color: '.difftocolor($diff).'">'.datedif($diff).'</td></tr>';
        			}
				else
                			echo '<tr><td class="op_ramka_off">'.$offtime.'</td><td class="op_ramka_on">'.$ontime.'</td><td class="op_ramka_diff" style="background-color: '.difftocolor($diff).'">'.datedif($diff).'</td></tr>';	
			}
		}
		else
		{
			continue;
		}
	}
	echo '</table>';
?>
</body>
</html>
