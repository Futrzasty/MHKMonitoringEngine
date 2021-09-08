<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link href="../index.css" rel="stylesheet" type="text/css" />
    <?php
    //$refresh = 20;
    //echo '<meta http-equiv="refresh" content="'.$refresh.'" />';
    ?>
    <title>IT Monitoring System</title>
</head>
<body style="color: white; cursor: initial;">
<?php
include_once ("../functions.php");
include_once ("../config.php");

$server = new mysqli("localhost", $db_user, $db_pass, $db_name);
if (mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}

$server->query("SET CHARACTER SET utf8");
$server->query("SET NAMES utf8");
$server->query("SET COLLATION utf8");


$ids = get_JSON_value('getPrinterList');
foreach ($ids as $id) {
    echo $id."<br/>";
    $medias = $server->query("SELECT * FROM printer_snmp_details WHERE host LIKE '$id'");
    while ($media = $medias->fetch_object()) {
//        var_dump($media);
        echo $media->name." --> ".$media->value;
        echo "<br/>";
    }
    echo "<br/><br/><br/>";
}

?>
</body>
</html>