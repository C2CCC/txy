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

$stunum = $_POST["stunum"];
$tno = $_POST["tno"];
$tel = $_POST["tel"];
$amount = $_POST["amount"];
/*
$stunum = '031302305';
$tno = '1';
$tel = '18655557777';
$amount = '2';
*/
$if_exist = mysql_query("select amount from booked_tickets where stunum='$stunum' and tno='$tno' and tel='$tel'", $con);
$tickets = array();
while ($row = mysql_fetch_array($if_exist, MYSQL_ASSOC)) {
	$tickets[] = $row;
}
if ($tickets[0]['amount'] > $amount) {
	$result = mysql_query("update booked_tickets set amount=amount-'$amount' where stunum='$stunum' and tno='$tno'", $con);
} else {
	$result = mysql_query("delete from booked_tickets where stunum='$stunum' and tno='$tno'", $con);
}
if (mysql_affected_rows() != 0) {
	$status = TRUE;
}
if($status){
	$time = date('Y-m-d H:i:s');
	mysql_query("insert into order_form(stunum,tno,amount,status,time) values('$stunum','$tno','$amount','已退票','$time')", $con);
}
$return_array = array('status' => $status);
$json_str = json_encode($return_array);
echo $json_str;
?>