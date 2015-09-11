<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="../index.css" rel="stylesheet" type="text/css" />
<?php
        $refresh = 20;
        echo '<meta http-equiv="refresh" content="'.$refresh.'" />';
?>
<title>IT Monitoring System</title>
</head>
<body style="color: white; cursor: initial;">
<?php
        include_once ("../functions.php");

//	$dane = get_JSON_value('getPrinterGlobalState');

        echo '<div class="branchname" style="float: left; width: 100%; font-size: 30pt; font-weight: bold; padding-bottom: 10px;">';
	$ids = get_JSON_value('getPrinterIDs');
        echo 'Status drukarek sieciowych - liczba urządzeń: '.count($ids);
        echo '</div>';

        echo '<a href="/operator/index.php" class="op_button">Powrót</a>';
	echo '<br/><br/>';

	echo '<table style="width: 100%;">';
        foreach ($ids as $id) {
                $dane = get_JSON_value('getPrinterStatebyID', $id);
		$host = get_JSON_value('getPrinterHostbyID', $id);

		$color = $cl_ping_gy;
		if ($dane->State == 2) $color = $cl_othr_re;
	        if ($dane->State == 1) $color = $cl_othr_ye;
        	if ($dane->State == 0) $color = $cl_othr_gr;

		echo '<tr><td class="ramka_inne" style="background-color: '.$color.';"><a href="http://'.$host.'">'.$dane->Name.'</a></td><td class="ramka_inne" style="background-color: '.$color.';"><a href="http://'.$host.'">'.$dane->Value.'</a></td><td class="ramka_inne" style="background-color: '.$color.';"><a href="http://'.$host.'">'.$dane->Value_S1.'</a></td></tr>';

        }
	echo '</table>';

?>
</body>
</html>
