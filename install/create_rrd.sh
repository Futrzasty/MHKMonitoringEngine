#!/bin/bash
# czas wykonywania skryptu (co 30 sekund)
rrdtool create jag_upsT.rrd --step 30 DS:temp:GAUGE:60:0:50 RRA:AVERAGE:0.5:2:240 RRA:AVERAGE:0.5:10:288 RRA:AVERAGE:0.5:120:720 RRA:AVERAGE:0.5:1440:730
rrdtool create jag_upsH.rrd --step 30 DS:humi:GAUGE:60:0:100 RRA:AVERAGE:0.5:2:240 RRA:AVERAGE:0.5:10:288 RRA:AVERAGE:0.5:120:720 RRA:AVERAGE:0.5:1440:730

# czas wykonywania skryptu (co 60 sekund)
rrdtool create ipsec_1.rrd --step 60 DS:ping:GAUGE:70:0:U RRA:AVERAGE:0.5:1:240 RRA:AVERAGE:0.5:5:288 RRA:AVERAGE:0.5:60:720 RRA:AVERAGE:0.5:720:730