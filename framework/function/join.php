<?php

include "/framework/function/member.php";
include "/framework/core/database.php";

if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != "POST") {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid request - This service accepts only GET requests.");
}

header("Content-type: application/xml");
print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

$db = new Member();
if(isset($_REQUEST["id"]) && isset($_REQUEST["name"]) && isset($_REQUEST["pw"])
	&& isset($_REQUEST["vocation"]) && $_REQUEST["id"]!=null && $_REQUEST["pw"]!=null
	&& $_REQUEST["name"]!=null && $_REQUEST["vocation"]!=null) {
	$db.register($_REQUEST["id"],
				$_REQUEST["name"],
				$_REQUEST["pw"],
				$_REQUEST["vocation"]);
	print "<id>";
	print $_REQUEST["id"];
	print "</id>";
	print "<name>";
	print $_REQUEST["name"];
	print "</name>";
	print "<pw>";
	print $_REQUEST["pw"];
	print "</pw>";
	print "<vocation>";
	print $_REQUEST["vocation"];
	print "</vocation>";
} else {
	print "<result>fail</result>";
}

?>