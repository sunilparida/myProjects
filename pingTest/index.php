<?php
include('db.php');
$requestPortal	= $_REQUEST['portal'];
if($requestPortal == 'lms')
{
	$url = 'https://lms.auric.city';
}
else if($requestPortal == 'egov')
{
	$url = 'https://www.auric.city';
}
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$data = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
if($httpcode==200){
  $status	= "worked";
} else {
  $status	= "failed";
}
$sql	= "INSERT INTO t_sys_ping_report(portal, status) VALUES ('$requestPortal', '$status')";
dbConnect($sql);
?>