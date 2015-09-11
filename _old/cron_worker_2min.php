<?php
	$opts4h = array("--end", "now", "--start=end-4h", "--width=700", "--height=124", "--full-size-mode", "--border=0", "--color=BACK#444444", "--color=CANVAS#444444", "--color=FONT#dddddd", "--color=ARROW#222222",
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

	$ret = rrd_graph("/var/www/rrd_graph/_ups4h.gif", $opts4h);

	$opts24h = array("--end", "now", "--start=end-24h", "--width=700", "--height=124", "--full-size-mode", "--border=0", "--color=BACK#444444", "--color=CANVAS#444444", "--color=FONT#dddddd", "--color=ARROW#222222",
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

	$ret = rrd_graph("/var/www/rrd_graph/_ups24h.gif", $opts24h);

	sleep(1);

	system("cp /var/www/rrd_graph/_ups4h.gif /var/www/rrd_graph/ups4h.gif");
	system("cp /var/www/rrd_graph/_ups24h.gif /var/www/rrd_graph/ups24h.gif");
?>
