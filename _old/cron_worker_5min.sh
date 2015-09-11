#!/bin/bash
rrdtool graph /var/www/rrd_graph/temp/`date +%s`-ups4h.png --end now --start end-4h --width 1500 --height 124 \
		DEF:temp=/var/www/rrd-data/jag_ups.rrd:temp:AVERAGE \
		DEF:humi=/var/www/rrd-data/jag_ups.rrd:humi:AVERAGE \
		LINE1:temp#00ff00:"Temperatura (°C) " \
		VDEF:tempcur=temp,LAST \
		VDEF:tempmax=temp,MAXIMUM \
		VDEF:tempmin=temp,MINIMUM \
		VDEF:tempavg=temp,AVERAGE \
		GPRINT:tempcur:"⇒%2.2lf %S" \
		GPRINT:tempmin:"↓%2.2lf %S" \
		GPRINT:tempavg:" %2.2lf %S" \
		GPRINT:tempmax:"↑%2.2lf %S\l" \
		LINE1:humi#0000ff:"Wilgotność  (%)  " \
		VDEF:humicur=humi,LAST \
		VDEF:humimax=humi,MAXIMUM \
		VDEF:humimin=humi,MINIMUM \
		VDEF:humiavg=humi,AVERAGE \
		GPRINT:humicur:"⇒%2.2lf %S" \
		GPRINT:humimin:"↓%2.2lf %S" \
		GPRINT:humiavg:" %2.2lf %S" \
		GPRINT:humimax:"↑%2.2lf %S\l" \
		1> /dev/null


rrdtool graph /var/www/rrd_graph/temp/`date +%s`-ups24h.png --end now --start end-24h --width 1500 --height 124 \
		DEF:temp=/var/www/rrd-data/jag_ups.rrd:temp:AVERAGE \
		DEF:humi=/var/www/rrd-data/jag_ups.rrd:humi:AVERAGE \
		LINE1:temp#00ff00:"Temperatura (°C) " \
		VDEF:tempcur=temp,LAST \
		VDEF:tempmax=temp,MAXIMUM \
		VDEF:tempmin=temp,MINIMUM \
		VDEF:tempavg=temp,AVERAGE \
		GPRINT:tempcur:"⇒%2.2lf %S" \
		GPRINT:tempmin:"↓%2.2lf %S" \
		GPRINT:tempavg:" %2.2lf %S" \
		GPRINT:tempmax:"↑%2.2lf %S\l" \
		LINE1:humi#0000ff:"Wilgotność  (%)  " \
		VDEF:humicur=humi,LAST \
		VDEF:humimax=humi,MAXIMUM \
		VDEF:humimin=humi,MINIMUM \
		VDEF:humiavg=humi,AVERAGE \
		GPRINT:humicur:"⇒%2.2lf %S" \
		GPRINT:humimin:"↓%2.2lf %S" \
		GPRINT:humiavg:" %2.2lf %S" \
		GPRINT:humimax:"↑%2.2lf %S\l" \
		1> /dev/null

rrdtool graph /var/www/rrd_graph/temp/`date +%s`-ups30d.png --end now --start end-30d --width 1500 --height 124 \
		DEF:temp=/var/www/rrd-data/jag_ups.rrd:temp:AVERAGE \
		DEF:humi=/var/www/rrd-data/jag_ups.rrd:humi:AVERAGE \
		LINE1:temp#00ff00:"Temperatura (°C) " \
		VDEF:tempcur=temp,LAST \
		VDEF:tempmax=temp,MAXIMUM \
		VDEF:tempmin=temp,MINIMUM \
		VDEF:tempavg=temp,AVERAGE \
		GPRINT:tempcur:"⇒%2.2lf %S" \
		GPRINT:tempmin:"↓%2.2lf %S" \
		GPRINT:tempavg:" %2.2lf %S" \
		GPRINT:tempmax:"↑%2.2lf %S\l" \
		LINE1:humi#0000ff:"Wilgotność  (%)  " \
		VDEF:humicur=humi,LAST \
		VDEF:humimax=humi,MAXIMUM \
		VDEF:humimin=humi,MINIMUM \
		VDEF:humiavg=humi,AVERAGE \
		GPRINT:humicur:"⇒%2.2lf %S" \
		GPRINT:humimin:"↓%2.2lf %S" \
		GPRINT:humiavg:" %2.2lf %S" \
		GPRINT:humimax:"↑%2.2lf %S\l" \
		1> /dev/null

rrdtool graph /var/www/rrd_graph/temp/`date +%s`-ups365d.png --end now --start end-365d --width 1500 --height 124 \
		DEF:temp=/var/www/rrd-data/jag_ups.rrd:temp:AVERAGE \
		DEF:humi=/var/www/rrd-data/jag_ups.rrd:humi:AVERAGE \
		LINE1:temp#00ff00:"Temperatura (°C) " \
		VDEF:tempcur=temp,LAST \
		VDEF:tempmax=temp,MAXIMUM \
		VDEF:tempmin=temp,MINIMUM \
		VDEF:tempavg=temp,AVERAGE \
		GPRINT:tempcur:"⇒%2.2lf %S" \
		GPRINT:tempmin:"↓%2.2lf %S" \
		GPRINT:tempavg:" %2.2lf %S" \
		GPRINT:tempmax:"↑%2.2lf %S\l" \
		LINE1:humi#0000ff:"Wilgotność  (%)  " \
		VDEF:humicur=humi,LAST \
		VDEF:humimax=humi,MAXIMUM \
		VDEF:humimin=humi,MINIMUM \
		VDEF:humiavg=humi,AVERAGE \
		GPRINT:humicur:"⇒%2.2lf %S" \
		GPRINT:humimin:"↓%2.2lf %S" \
		GPRINT:humiavg:" %2.2lf %S" \
		GPRINT:humimax:"↑%2.2lf %S\l" \
		1> /dev/null

find /var/www/rrd_graph/temp/* -maxdepth 0 -type f -mmin +30 -delete
