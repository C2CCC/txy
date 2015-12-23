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

$result = mysql_query("select user.name,booked_tickets.tel,booked_tickets.amount,ticket.*,order_form.status from user,booked_tickets,ticket,order_form where ticket.tno = booked_tickets.tno and booked_tickets.stunum='$stunum' and user.stunum='$stunum'", $con);
$tickets = array();
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	$tickets[] = $row;
}
$json_str = json_encode($tickets);
echo $json_str;
?>