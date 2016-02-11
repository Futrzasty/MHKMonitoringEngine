<?php
$fid = uniqid('rrd_', true);
$file = "/tmp/$fid";

$argc = explode(";", $_SERVER["QUERY_STRING"]);
$argv = count($argc);
$wybor = $argc[0];
if ($argv > 1) $param = $argc[1]; else $param = "xxx";

$ipsec4h = array( "--end", "now", "--start=end-4h", "--width=690", "--height=124", "--full-size-mode", "--border=0", "--color=BACK#444444", "--color=CANVAS#444444", "--color=FONT#cccccc", "--color=ARROW#222222",
                "DEF:ping=/var/www/rrd-data/ipsec_$param.rrd:ping:AVERAGE",
                "LINE1:ping#ff0000:Ping (ms) ",
                "VDEF:pingcur=ping,LAST",
                "VDEF:pingmax=ping,MAXIMUM",
                "VDEF:pingmin=ping,MINIMUM",
                "VDEF:pingavg=ping,AVERAGE",
                "GPRINT:pingcur:⇒%2.2lf %S",
                "GPRINT:pingmin:↓%2.2lf %S",
                "GPRINT:pingavg: %2.2lf %S",
                "GPRINT:pingmax:↑%2.2lf %S\l",
);



$optst4h = array( "--end", "now", "--start=end-4h", "--width=650", "--height=124", "--full-size-mode", "--border=0", "--color=BACK#444444", "--color=CANVAS#444444", "--color=FONT#cccccc", "--color=ARROW#222222", "--lower-limit=15",
		"DEF:temp=/var/www/rrd-data/jag_ups.rrd:temp:AVERAGE",
		"DEF:humi=/var/www/rrd-data/jag_ups.rrd:humi:AVERAGE",
		"LINE1:temp#ff0000:Temperatura (°C) ",
		"VDEF:tempcur=temp,LAST",
		"VDEF:tempmax=temp,MAXIMUM",
		"VDEF:tempmin=temp,MINIMUM",
		"VDEF:tempavg=temp,AVERAGE",
		"GPRINT:tempcur:⇒%2.2lf %S",
		"GPRINT:tempmin:↓%2.2lf %S",
		"GPRINT:tempavg: %2.2lf %S",
		"GPRINT:tempmax:↑%2.2lf %S\l",
		"LINE1:humi#ffff00:Wilgotność (%)   ",
		"VDEF:humicur=humi,LAST",
		"VDEF:humimax=humi,MAXIMUM",
		"VDEF:humimin=humi,MINIMUM",
		"VDEF:humiavg=humi,AVERAGE",
		"GPRINT:humicur:⇒%2.2lf %S",
		"GPRINT:humimin:↓%2.2lf %S",
		"GPRINT:humiavg: %2.2lf %S",
		"GPRINT:humimax:↑%2.2lf %S\l",
);

$optst12h = array( "--end", "now", "--start=end-12h", "--width=650", "--height=124", "--full-size-mode", "--border=0", "--color=BACK#444444", "--color=CANVAS#444444", "--color=FONT#cccccc", "--color=ARROW#222222", "--lower-limit=15",
                "DEF:temp=/var/www/rrd-data/jag_ups.rrd:temp:AVERAGE",
                "DEF:humi=/var/www/rrd-data/jag_ups.rrd:humi:AVERAGE",
                "LINE1:temp#ff0000:Temperatura (°C) ",
                "VDEF:tempcur=temp,LAST",
                "VDEF:tempmax=temp,MAXIMUM",
                "VDEF:tempmin=temp,MINIMUM",
                "VDEF:tempavg=temp,AVERAGE",
                "GPRINT:tempcur:⇒%2.2lf %S",
                "GPRINT:tempmin:↓%2.2lf %S",
                "GPRINT:tempavg: %2.2lf %S",
                "GPRINT:tempmax:↑%2.2lf %S\l",
                "LINE1:humi#ffff00:Wilgotność (%)   ",
                "VDEF:humicur=humi,LAST",
                "VDEF:humimax=humi,MAXIMUM",
                "VDEF:humimin=humi,MINIMUM",
                "VDEF:humiavg=humi,AVERAGE",
                "GPRINT:humicur:⇒%2.2lf %S",
                "GPRINT:humimin:↓%2.2lf %S",
                "GPRINT:humiavg: %2.2lf %S",
                "GPRINT:humimax:↑%2.2lf %S\l",
);

$optsl4h = array( "--end", "now", "--start=end-4h", "--width=1500", "--height=124", "--lower-limit=0",
		"DEF:temp=/var/www/rrd-data/jag_ups.rrd:temp:AVERAGE",
		"DEF:humi=/var/www/rrd-data/jag_ups.rrd:humi:AVERAGE",
		"LINE1:temp#00ff00:Temperatura (°C) ",
		"VDEF:tempcur=temp,LAST",
		"VDEF:tempmax=temp,MAXIMUM",
		"VDEF:tempmin=temp,MINIMUM",
		"VDEF:tempavg=temp,AVERAGE",
		"GPRINT:tempcur:⇒%2.2lf %S",
		"GPRINT:tempmin:↓%2.2lf %S",
		"GPRINT:tempavg: %2.2lf %S",
		"GPRINT:tempmax:↑%2.2lf %S\l",
		"LINE1:humi#0000ff:Wilgotność (%)   ",
		"VDEF:humicur=humi,LAST",
		"VDEF:humimax=humi,MAXIMUM",
		"VDEF:humimin=humi,MINIMUM",
		"VDEF:humiavg=humi,AVERAGE",
		"GPRINT:humicur:⇒%2.2lf %S",
		"GPRINT:humimin:↓%2.2lf %S",
		"GPRINT:humiavg: %2.2lf %S",
		"GPRINT:humimax:↑%2.2lf %S\l",
);

$optsl24h = array( "--end", "now", "--start=end-24h", "--width=1500", "--height=124", "--lower-limit=0",
		"DEF:temp=/var/www/rrd-data/jag_ups.rrd:temp:AVERAGE",
		"DEF:humi=/var/www/rrd-data/jag_ups.rrd:humi:AVERAGE",
		"LINE1:temp#00ff00:Temperatura (°C) ",
		"VDEF:tempcur=temp,LAST",
		"VDEF:tempmax=temp,MAXIMUM",
		"VDEF:tempmin=temp,MINIMUM",
		"VDEF:tempavg=temp,AVERAGE",
		"GPRINT:tempcur:⇒%2.2lf %S",
		"GPRINT:tempmin:↓%2.2lf %S",
		"GPRINT:tempavg: %2.2lf %S",
		"GPRINT:tempmax:↑%2.2lf %S\l",
		"LINE1:humi#0000ff:Wilgotność (%)   ",
		"VDEF:humicur=humi,LAST",
		"VDEF:humimax=humi,MAXIMUM",
		"VDEF:humimin=humi,MINIMUM",
		"VDEF:humiavg=humi,AVERAGE",
		"GPRINT:humicur:⇒%2.2lf %S",
		"GPRINT:humimin:↓%2.2lf %S",
		"GPRINT:humiavg: %2.2lf %S",
		"GPRINT:humimax:↑%2.2lf %S\l",
);

$optsl30d = array( "--end", "now", "--start=end-30d", "--width=1500", "--height=124", "--lower-limit=0",
		"DEF:temp=/var/www/rrd-data/jag_ups.rrd:temp:AVERAGE",
		"DEF:humi=/var/www/rrd-data/jag_ups.rrd:humi:AVERAGE",
		"LINE1:temp#00ff00:Temperatura (°C) ",
		"VDEF:tempcur=temp,LAST",
		"VDEF:tempmax=temp,MAXIMUM",
		"VDEF:tempmin=temp,MINIMUM",
		"VDEF:tempavg=temp,AVERAGE",
		"GPRINT:tempcur:⇒%2.2lf %S",
		"GPRINT:tempmin:↓%2.2lf %S",
		"GPRINT:tempavg: %2.2lf %S",
		"GPRINT:tempmax:↑%2.2lf %S\l",
		"LINE1:humi#0000ff:Wilgotność (%)   ",
		"VDEF:humicur=humi,LAST",
		"VDEF:humimax=humi,MAXIMUM",
		"VDEF:humimin=humi,MINIMUM",
		"VDEF:humiavg=humi,AVERAGE",
		"GPRINT:humicur:⇒%2.2lf %S",
		"GPRINT:humimin:↓%2.2lf %S",
		"GPRINT:humiavg: %2.2lf %S",
		"GPRINT:humimax:↑%2.2lf %S\l",
);

$optsl365d = array( "--end", "now", "--start=end-365d", "--width=1500", "--height=124", "--lower-limit=0",
		"DEF:temp=/var/www/rrd-data/jag_ups.rrd:temp:AVERAGE",
		"DEF:humi=/var/www/rrd-data/jag_ups.rrd:humi:AVERAGE",
		"LINE1:temp#00ff00:Temperatura (°C) ",
		"VDEF:tempcur=temp,LAST",
		"VDEF:tempmax=temp,MAXIMUM",
		"VDEF:tempmin=temp,MINIMUM",
		"VDEF:tempavg=temp,AVERAGE",
		"GPRINT:tempcur:⇒%2.2lf %S",
		"GPRINT:tempmin:↓%2.2lf %S",
		"GPRINT:tempavg: %2.2lf %S",
		"GPRINT:tempmax:↑%2.2lf %S\l",
		"LINE1:humi#0000ff:Wilgotność (%)   ",
		"VDEF:humicur=humi,LAST",
		"VDEF:humimax=humi,MAXIMUM",
		"VDEF:humimin=humi,MINIMUM",
		"VDEF:humiavg=humi,AVERAGE",
		"GPRINT:humicur:⇒%2.2lf %S",
		"GPRINT:humimin:↓%2.2lf %S",
		"GPRINT:humiavg: %2.2lf %S",
		"GPRINT:humimax:↑%2.2lf %S\l",
);

switch ($wybor) {
    case "t4":
        $opcja = $optst4h;
        break;
    case "t12":
        $opcja = $optst12h;
        break;
    case "l4":
        $opcja = $optsl4h;
        break;
    case "l24":
        $opcja = $optsl24h;
        break;
    case "l30d":
        $opcja = $optsl30d;
        break;
    case "l365d":
        $opcja = $optsl365d;
        break;
    case "ipsec4h":
		$opcja = $ipsec4h;
		break;
    default:
        $opcja = $optst4h;
        break;
}  

	$ret = rrd_graph($file, $opcja);

	header("Content-Type: image/png");
	header("Content-Length: " . filesize($file));

	$hand = fopen($file, "rb");
	if ($hand) {
		fpassthru($hand);
		fclose($hand);
	}
	system("rm -f $file");
