<?php

        snmp_set_valueretrieval(SNMP_VALUE_PLAIN);


        $value = snmp2_walk ("192.168.0.216" , "public" , ".1.3.6.1.2.1.43.11.1.1.9"); //value_raw
	var_dump ($value);
	echo "<br/><br/>";



        $value = snmp2_walk ("192.168.0.216" , "public" , ".1.3.6.1.2.1.43.11.1.1.8"); //value_max
        var_dump ($value);
        echo "<br/><br/>";

        $value = snmp2_walk ("192.168.0.216" , "public" , ".1.3.6.1.2.1.43.11.1.1.6"); //NAME
        var_dump ($value);
        echo "<br/><br/>";


	//if (!$value) $value = null;
	//var_dump ($value);


