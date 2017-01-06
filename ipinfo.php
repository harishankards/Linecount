<?php
$responseuri = "http://ipinfodb.com/ip_query.php";
$responseuri = (isset($_GET['ip']) && $_GET['ip'] != '') ? "http://ipinfodb.com/ip_query.php?ip=".$_GET['ip'] : "http://ipinfodb.com/ip_query.php";
$str_response_xml =  @file_get_contents($responseuri);
header('content-type : text/xml');
echo $str_response_xml;
?>