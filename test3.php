<?php

        snmp_set_valueretrieval(SNMP_VALUE_PLAIN);


                        $value = snmp2_get("192.168.0.252", "public", ".1.3.6.1.2.1.99.1.1.1.4.1");
	var_dump ($value);
	if (!$value) $value = null;
	var_dump ($value);


