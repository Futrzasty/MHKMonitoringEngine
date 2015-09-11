<?php


$opts4h = array( "--end", "now", "--start=end-4h", "--width=460", "--height=124", "--full-size-mode", "--border=0", "--color=BACK#444444", "--color=CANVAS#444444", "--color=FONT#cccccc", 
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

  $ret = rrd_graph("/var/www/rrd_graph/ups4h.gif", $opts4h);

  if( !is_array($ret) )
   {
     $err = rrd_error();
     echo "rrd_graph() ERROR: $err\n";
   }


$opts12h = array( "--end", "now", "--start=end-12h", "--width=460", "--height=124", "--full-size-mode", "--border=0", "--color=BACK#444444", "--color=CANVAS#444444", "--color=FONT#cccccc",
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

  $ret = rrd_graph("/var/www/rrd_graph/ups12h.gif", $opts12h);

  if( !is_array($ret) )
   {
     $err = rrd_error();
     echo "rrd_graph() ERROR: $err\n";
   }

echo '<img src="rrd_graph/ups4h.gif" alt="wykres" />';
echo '<img src="rrd_graph/ups12h.gif" alt="wykres" />';

?>
