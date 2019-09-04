<?php
function dbConnect($sql)
{
	$db 	= new mysqli('127.0.0.1','root','','test','3307');
	$result	= $db->query($sql);
	$db->close();
	return $result;
}
?>