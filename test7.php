<?php
    require_once __DIR__.'/lib/Mikrotik-API/routeros_api.class.php';

    $API = new RouterosAPI();
    $API->debug = false;
    if ($API->connect('192.168.71.13', 'APIuser', 'zawszeCocaCola')) {

        $API->write('/system/resource/print');

        $READ = $API->read(false);
        $ARRAY = $API->parseResponse($READ);

        $res = $ARRAY[0];

        echo '<br/><br/><br/>'.$res["cpu-load"];

        $API->disconnect();
    }