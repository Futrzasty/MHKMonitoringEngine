#!/bin/bash
# czas wykonywania skryptu (co 120 sekund)
rrdtool create ../rrd_data/extime.rrd --step 120 DS:extime:GAUGE:240:0:U RRA:AVERAGE:0.5:1:720 RRA:AVERAGE:0.5:10:504 RRA:AVERAGE:0.5:30:720 RRA:AVERAGE:0.5:180:1460