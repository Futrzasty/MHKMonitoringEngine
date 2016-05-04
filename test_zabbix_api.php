<?php
/**
 * Created by PhpStorm.
 * User: gwozniak
 * Date: 2016-05-04
 * Time: 10:47
 */


// load ZabbixApi
require_once 'lib/ZabbixApi.class.php';
use ZabbixApi\ZabbixApi;

try
{
    // connect to Zabbix API
    $api = new ZabbixApi('http://zabbix.mhk.local/zabbix/api_jsonrpc.php', 'api_user', 'api_password');

//    $cpuGraphs = $api->graphGet(array(
//        'output' => 'extend',
//        'search' => array('name' => 'CPU')
//    ));

    $triggers = $api->triggerGet(array(
        'output' => array ("trigerid", "description", "priority"),
        'filter' => array("value" => 1),
        'sortfield' => "priority",
        "sortorder" => "DESC",
        "expandDescription" => 1,
        "selectHosts" => 1,
    ));

    foreach($triggers as $trigger) {
        echo $trigger->description . "\n";
        echo $trigger->hosts[0]->hostid . "\n";
    }
}
catch(Exception $e)
{
    // Exception in ZabbixApi catched
    echo $e->getMessage();
}
