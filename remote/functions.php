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

    function check_www ($host, $content, $timeout, $username='', $password='') {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$host);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout); //timeout after 30 seconds
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    //	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    //	curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
        $tresc=curl_exec ($ch);
        curl_close ($ch);
        return stripos($tresc, $content);
    }