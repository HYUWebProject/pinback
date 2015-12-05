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

$db = new Member();

if(isset($_REQUEST["id"]) && isset($_REQUEST["name"]) && isset($_REQUEST["pass"])
	&& isset($_REQUEST["vocation"]) && $_REQUEST["id"]!=null && $_REQUEST["pass"]!=null
	&& $_REQUEST["name"]!=null && $_REQUEST["vocation"]!=null &&
	preg_match("/[0-9]{10}/", $_REQUEST["id"]) && preg_match("/[a-zA-z]{:10}/", $_REQUEST["name"])) {
	$result = $db->register($_REQUEST["id"], $_REQUEST["name"], $_REQUEST["pass"], $_REQUEST["vocation"]);
	if($result === true)
		print "<result>success</result>";
	만lse if($result instanceOf Exception) {
		print "<result>SQLException</result>";
		$msg = $result->getMessage();
		print "<exception>$msg</exception>";
	}
} else {
	print "<result>fail</result>";
}
print "</resultset>\n";

?>