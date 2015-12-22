<?php
ini_set("display_errors", "Off");
require_once 'connectVars.php';
$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
if (!$con) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db('txy', $con);
mysql_query("set names utf8");

header('Content-Type:text/html;charset=utf-8');

$post_url = "http://59.77.226.32/logincheck.asp";

//$muser = $_POST["stunum"];
//$passwd = $_POST["passwd"];

$muser = "031302305";
$passwd = "A123A123";

$header[0] = "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8";
$header[] = "Accept-Encoding:gzip, deflate";
$header[] = "Accept-Language:zh-CN,zh;q=0.8";
$header[] = "Cache-Control:max-age=0";
$header[] = "Connection:keep-alive";
$header[] = "Content-Type:application/x-www-form-urlencoded";
$header[] = "Host:59.77.226.32";
$header[] = "Origin:http://jwch.fzu.edu.cn";
$header[] = "Referer:http://jwch.fzu.edu.cn/";
$header[] = "Upgrade-Insecure-Requests:1";
$header[] = "User-Agent:Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36";

$post = array("muser" => $muser, "passwd" => $passwd);

$first_response_header[] = login_post($post_url, $header, $post);
$second_response_header = login_get($first_response_header[0][0]['redirect_url'], $header);
preg_match_all("{[a-zA-z]+://[^\s]*}", $second_response_header, $matches);
preg_match_all("{id=\d*}", $matches[0][0], $matches2);
$id = substr($matches2[0][0], 3);
preg_match_all("{Set-Cookie: .*?(?=;)}", $second_response_header, $matches3);
$sessionid = substr($matches3[0][0], 12);

$get_info_url = "http://59.77.226.35/jcxx/xsxx/StudentInformation.aspx?id=" . $id;
$header[] = "Cookie:" . $sessionid;
$info_html = login_get_content($get_info_url, $header);

preg_match_all("{<span id=\"ContentPlaceHolder1_LB_xm\">.*?(?=</span>)}", $info_html, $info_matches);
$name = substr($info_matches[0][0], 37);
preg_match_all("{<span id=\"ContentPlaceHolder1_LB_xymc\">.*?(?=</span>)}", $info_html, $info_matches2);
$dept = substr($info_matches2[0][0], 39);

$return_array = array('stunum' => $muser, 'name' => $name, 'dept' => $dept);
$json_str = json_encode($return_array);

//connect mysql
$result = mysql_query("select * from user where stunum = '$muser'", $con);
if (mysql_num_rows($result) == 0) {
	$insert_result = mysql_query("insert into user(stunum,name,dept,role) values('$muser','$name','$dept',0)");
}
echo $json_str;

//模拟登录
function login_post($url, $header, $post) {
	$ch = curl_init();
	//初始化curl模块
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, TRUE);
	curl_setopt($ch, CURLOPT_NOBODY, TRUE);
	curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
	$response_header = curl_exec($ch);
	$rinfo[] = curl_getinfo($ch);
	curl_close($ch);
	return $rinfo;
}

function login_get($url, $header) {
	$ch = curl_init();
	//初始化curl模块
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, TRUE);
	curl_setopt($ch, CURLOPT_NOBODY, TRUE);
	curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_HTTPGET, 1);
	$response_header = curl_exec($ch);
	$rinfo[] = curl_getinfo($ch);
	curl_close($ch);
	return $response_header;
}

function login_get_content($url, $header) {
	$ch = curl_init();
	//初始化curl模块
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_NOBODY, FALSE);
	curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_HTTPGET, 1);
	$response = curl_exec($ch);
	//$rinfo[] = curl_getinfo($ch);
	curl_close($ch);
	return $response;
}
?>