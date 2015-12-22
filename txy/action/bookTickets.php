<?php
ini_set("display_errors", "Off");
require_once 'connectVars.php';
$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
if (!$con) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db('txy', $con);
mysql_query("set names utf8");

$status = FALSE;

$stunum = $_GET["stunum"];
$tno = $_GET["tno"];
$amount = $_GET["amount"];

$if_exist = mysql_query("select * from booked_tickets where stunum='$stunum' and tno='$tno'", $con);
if (mysql_num_rows($if_exist) != 0) {
	$result = mysql_query("update booked_tickets set amount=amount+'$amount' where stunum='$stunum' and tno='$tno'", $con);
} else {
	$result = mysql_query("insert into booked_tickets(stunum,tno,amount,complete) values('$stunum','$tno','$amount',1)", $con);
}
if (mysql_affected_rows() != 0) {
	$status = TRUE;
}
$return_array = array('status' => $status);
$json_str = json_encode($return_array);
echo $json_str;
?>