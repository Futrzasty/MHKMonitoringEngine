<?php
include "functions.php";

$ret = get_printer_status("192.168.64.222", "public");

echo $ret[0]."<br />";
echo $ret[1]."<br />";
echo $ret[2]."<br />";

