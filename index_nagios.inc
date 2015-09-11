<?php
	//NAGIOS 2
	echo '<div class="grupa">';
	echo '<div style="clear: left; text-align: center;"><b>Problemy NAGIOS</b></div>';
        if($nagiosok) {
		for ($i = 0; $i < $entries; $i++) {
			if ($nagios[2+$i*7] == "WARNING")
				$color = $cl_ping_ye;
			else if ($nagios[2+$i*7] == "CRITICAL") 
				$color = $cl_ping_re;
			else $color = $cl_othr_bl;
			if ($nagios[0+$i*7] != "OLD HOST") {
				$hostn = strtoupper(str_ireplace(".mhk.local","",$nagios[0+$i*7]));
				$hostn = strtoupper(str_ireplace(".local","",$hostn));	
			}
			//omijam drukarki (PRN *), bo mnie denerwują na tablicy
			//if (stripos($nagios[0+$i*7], "PRN ") === 0) continue;
			
			echo '<div class="ramka_nagios" style="width: 250px; background-color: '.$color.';"><b>'.$hostn.'</b></div>';
			echo '<div class="ramka_nagios" style="width: 500px; background-color: '.$color.';"><b>'.$nagios[1+$i*7].'</b></div>';
			echo '<div class="ramka_nagios" style="width: 1020px; background-color: '.$color.';"><b>'.$nagios[6+$i*7].'</b></div>';
		}
		if ($entries == 0) echo '<div class="ramka_nagios" style="width: 1838px; background-color: '.$cl_ping_gr.';"><b>Brak problemów</b></div>';
	}
	else
	{
		 echo '<div class="ramka_nagios" style="width: 1838px; background-color: '.$cl_ping_re.';"><b>AWARIA serwera NAGIOS.mhk.local</b></div>';
	}
	echo '<div style="clear: both;"></div>';
	echo '</div>';
