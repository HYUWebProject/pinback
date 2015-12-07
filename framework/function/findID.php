<?php

include "member.php";
include "../core/database.php";


if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != "POST") {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid request - This service accepts only GET requests.");
}

header("Content-type: application/xml");
print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
print "<resultset>\n";

if ( isset($_REQUEST["id"]) && $_REQUEST["id"]!=NULL &&
	preg_match("/[0-9]{10,10}/", $_REQUEST["id"]) ) {
	
	$id = $_REQUEST["id"];
	print "<id>$id</id>\n";


	$db = new Member();
	$result = $db->findID($id);
	if ($result instanceOf Exception) {
		print "<result>SQLException</result>";
		$msg = $result->getMessage();
		print "<exception>$msg</exception>";
	} else if($result) {
		print "<result>success</result>";
	} else {
		print "<result>NotExistingID</result>";
	}
} else {
	print "<result>inputValidID</result>";
}
print "</resultset>\n";


?>