<?php
        echo '<div class="grupa">';
        echo '<div style="clear: left; text-align: center;"><b>Serwerownia - Jagiellońska</b></div>';
        $dane = get_JSON_value('getEnvHostStatebyHost', '192.168.83.66;temp');
//	$dane = get_JSON_value('getEnvHostStatebyHost', '192.168.201.6;temp');
        if (is_numeric($dane->Value)) $text = "<b>$dane->Value</b>&deg;C"; else $text = "<b>$dane->Value</b>";
	draw_main_frame ("Temperatura", $text, $dane->Color);
        $dane = get_JSON_value('getEnvHostStatebyHost', '192.168.83.66;humi');
        if (is_numeric($dane->Value)) $text = "<b>$dane->Value</b> %"; else $text = "<b>$dane->Value</b>";
	draw_main_frame ("Wilgotność", $text, $dane->Color);
        $dane = get_JSON_value('getEnvHostStatebyHost', '192.168.83.68;temp');
        $dane2 = get_JSON_value('getEnvHostStatebyHost', '192.168.83.68;humi');
        draw_frame_twosmallbricks ("UPS Klim.", "<b>$dane->Value</b>", $dane->Color, "<b>$dane2->Value</b>%", $dane2->Color);

        $dane = get_JSON_value('getEnvHostStatebyHost', '192.168.12.209;temp');
        $dane2 = get_JSON_value('getEnvHostStatebyHost', '192.168.12.209;humi');
        draw_frame_twosmallbricks ("Rynek (+1)", "<b>$dane->Value</b>", $dane->Color, "<b>$dane2->Value</b>%", $dane2->Color);

        echo '<img src="rrd_graph.php?t4" style="float: left; border: 0;" />';
        echo '<img src="rrd_graph.php?t12" style="float: left; border: 0; padding-left: 1px;" />';

	echo '<div style="clear: both;"></div>';
	echo '</div>';

	echo '<div class="grupa">';
	echo '<div style="clear: left; text-align: center;"><b>Serwisy sieciowe</b></div>';	
	
        $ids = get_JSON_value('getWwwHostIDs');
        foreach ($ids as $id) {
                $dane = get_JSON_value('getWwwHostStatebyID', $id);
                draw_main_frame ($dane->Name, "<b>$dane->Value</b>", $dane->Color, $dane->Value_S1, $dane->Color_S1);
        }

        $ids = get_JSON_value('getServerHostList');
        foreach ($ids as $host) {
                $idp = get_JSON_value('getServerHostParamsbyHost', $host);
                foreach ($idp as $parm) {
                        $dane = get_JSON_value('getServerHostStatebyHost', $host.";".$parm);
                        $parm == 'nsclient_load' && is_numeric($dane->Value) ? $unit = " %" : $unit = '';
                        draw_main_frame ($dane->Name, "<b>$dane->Value</b>".$unit, $dane->Color);
                }
        }

        $ids = get_JSON_value('getPingHostIDs');
        foreach ($ids as $id) {
                $dane = get_JSON_value('getPingHostStatebyID', $id);
                draw_main_frame ($dane->Name, "<b>$dane->Value</b>", $dane->Color, $dane->Value_S1, $dane->Color_S1);
        }

        //$ids = get_JSON_value('getNetLinkIDs');
        //foreach ($ids as $id) {
        //        $dane = get_JSON_value('getNetLinkStatebyID', $id);
        //        draw_main_frame ($dane->Name, "<b>$dane->Value</b>", $dane->Color);
        //}

        $dane = get_JSON_value('getPrinterGlobalState');
        $dane2 =get_JSON_value('getPrinterGlobalLastChange');
        $value = $dane->State;
        $text = "<span style=\"opacity: 0.2;\">PRN</span>";
        if ($value > 0) $text = "<strong>".$dane->count2."/".$dane->count1."</strong>";
        $color = $cl_othr_re;
        if ($value == 1) $color = $cl_othr_ye;
        if ($value == 0) $color = $cl_othr_gr;
        draw_main_frame ("Drukarki", $text, $color, $dane2->State, $dane2->Color);

        $dane = get_JSON_value('getSwitchGlobalState');
        $value = $dane->State;
        $color = $cl_othr_re;
        $text = "<span style=\"opacity: 0.2;\">SW</span>";
        if ($value > 0) $text = "<strong>".$dane->count2."/".$dane->count1."</strong>";
        if ($value == 1) $color = $cl_othr_ye;
        if ($value == 0) $color = $cl_othr_gr;
        draw_main_frame ("Switche", $text, $color);

        $dane = get_JSON_value('getWirelessGlobalState');
        $value = $dane->State;
        $color = $cl_othr_re;
        $text = "<span style=\"opacity: 0.2;\">AP</span>";
        if ($value > 0) $text = "<strong>".$dane->count2."/".$dane->count1."</strong>";
        if ($value == 1) $color = $cl_othr_ye;
        if ($value == 0) $color = $cl_othr_gr;
        draw_main_frame ("Access Point", $text, $color);

        $dane = get_JSON_value('getRouterGlobalState');
        $value = $dane->State;
        $color = $cl_othr_re;
        $text = "<span style=\"opacity: 0.2;\">RT</span>";
        if ($value > 0) $text = "<strong>".$dane->count2."/".$dane->count1."</strong>";
        if ($value == 1) $color = $cl_othr_ye;
        if ($value == 0) $color = $cl_othr_gr;
        draw_main_frame ("Routery", $text, $color);

	echo '<div style="clear: both;"></div>';
	echo '</div>';


	echo '<div class="grupa">';
	echo '<div style="clear: left; text-align: center;"><b>Tunele IPSec</b></div>';	

        $ids = get_JSON_value('getIpsecHostIDs');

        foreach ($ids as $id) {
                $dane = get_JSON_value('getIpsecHostStatebyID', $id);
                $third_octet = explode(".", get_JSON_value('getIpsecHostIPbyID', $id))[2];
                draw_main_frame ($dane->Name." (<b>$third_octet</b>)", "<b>$dane->Value</b>", $dane->Color, $dane->Value_S1, $dane->Color_S1);
	}

	echo '<div style="clear: both;"></div>';
	echo '</div>';
