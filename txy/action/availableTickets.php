<?php
ini_set("display_errors", "Off");
require_once 'connectVars.php';
$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
if (!$con) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db('txy', $con);
mysql_query("set names utf8");

$result = mysql_query("select * from ticket order by tno desc", $con);
$tickets = array();
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	$tickets[] = $row;
}
$json_str = json_encode($tickets);
echo $json_str;
?>