<?php

include "functions.php";

$switch_value = ping("192.168.80.108", 2)[2];

var_dump($switch_value);

                if ($switch_value == "") {
                     echo "tu byłem";
                }

