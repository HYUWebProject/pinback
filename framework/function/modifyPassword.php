<?php

require_once("../framework.php");

	//if it needs to include some php file then include
if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != "POST") {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid request - This service accepts only GET requests.");
}

header("Content-type: application/xml");
print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
print "<resultset>\n";

if(isset($_REQUEST["pw"]) && $_REQUEST["pw"]!=NULL) {
	
	$pw = $_REQUEST["pw"];

	print "<pw>$pw</pw>\n";

	//db를 통해 입력된 ID와 PW를 비교한다.
	$db = new Member();
	if($db->modifyPassword($pw)) {
		print "<result>success</result>";
	} else {
		print "<result>selectionFailed</result>";
	}
} else {
	//show some error detection page or popup
	print "<result>inputValidInformation</result>";
}
print "</resultset>\n";

?>
