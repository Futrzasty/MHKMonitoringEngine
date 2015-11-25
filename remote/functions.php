<?php
    include_once ("config.php");

    function ping($t,$p){
        $r = array();
        $st = "ping -W 1 -c ".$p." -w ".$p." ".$t;
        $cr = shell_exec($st);
        $r = explode(",",$cr);
        $so = $r[3];
        $st = 'max/mdev =';
        $so = substr($so,strpos($so,$st)+strlen($st));
        $st = '/';
        $min = substr($so,0,strpos($so,$st));
        $so = substr($so,strpos($so,$st)+strlen($st));
        $avg = substr($so,0,strpos($so,$st));
        $so = substr($so,strpos($so,$st)+strlen($st));
        $max = substr($so,0,strpos($so,$st));
        $so = substr($so,strpos($so,$st)+strlen($st));
        $st = 'ms';
        $mdev = substr($so,0,strpos($so,$st));
        $so = substr($so,strpos($so,$st)+strlen($st));
        return array($min, $avg, $max, $mdev);
    }

    function check_www ($host, $content) {
        $cmd = "/usr/lib/nagios/plugins/check_http -H ".$host." -r ".$content;
        $last_line = exec($cmd, $full_output, $return_code);

        return array($return_code);
    }

    function nrpe_smtp ($host) {
        $cmd = "/usr/lib/nagios/plugins/check_smtp -H ".$host."";
        $last_line = exec($cmd, $full_output, $return_code);
        //$r = explode("|", $st);
        //$r1 = str_ireplace("'5 min avg Load'= ", "", $r[1]);
        //$r1 = explode("=", $r[1]);
        //$r2 = explode(";", $r1[1]);
        //foreach ($r2 as &$value) {
        //    $value = str_ireplace("%","", $value);
        //}

        return array($return_code);
    }