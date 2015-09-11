<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="_style/index.css" rel="stylesheet" type="text/css" />
<title>IT Monitoring System</title>
</head>
<body style="">
<?php

	$uchwyt = fopen("http://monitoring.mhk.local/JSON/getAllSwitchList.php", "rb");
	$tresc = stream_get_contents($uchwyt);
	fclose($uchwyt);
        
	$dane = json_decode($tresc);
	echo "<table border='1'>";
        for ($i = 0; $i < count($dane); $i++) {
        	//echo $i."".$dane[$i]->Name."\t\t".$dane[$i]->Room."\t\t".$dane[$i]->IP."<br />";
		echo "<tr><td>".$dane[$i]->Name."</td><td>".$dane[$i]->Room."</td><td>".$dane[$i]->IP."</td></tr>";
        }
	echo "</table>";
?>

</body>
</html>

