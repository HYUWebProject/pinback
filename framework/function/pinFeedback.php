<?php
require_once("../framework.php");
//if it needs to include some php file then include
if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != "POST") {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid request - This service accepts only POST requests.");
}

header("Content-type: application/xml");
$dom_xml = new DOMDocument();
$resultset = $dom_xml->createElement("resultset");
$dom_xml->appendChild($resultset);

$db = new Feedback();

if(isset($_REQUEST["feedback_no"]) && $_REQUEST["feedback_no"]!=null) {

	$result = $db->pinFeedback($_REQUEST["feedback_no"]);

	if($result === true) {
		$result_tag = $dom_xml->createElement("result");
		$result_tag->appendChild($dom_xml->createTextNode("success"));
		$resultset->appendChild($result_tag);
	} else if($result instanceOf Exception) {
		$result_tag = $dom_xml->createElement("result");
		$result_tag->appendChild($dom_xml->createTextNode("SQLException"));
		$resultset->appendChild($result_tag);

		$msg = $result->getMessage();
		$msg_tag = $dom_xml->createElement("exception");
		$msg_tag->appendChild($dom_xml->createTextNode($msg));
		$resultset->appendChild($msg_tag);
	} else if($result === false) {
		$result_tag = $dom_xml->createElement("result");
		$result_tag->appendChild($dom_xml->createTextNode("PermissionDenied"));
		$resultset->appendChild($result_tag);
	}
} else {
	$result_tag = $dom_xml->createElement("result");
	$result_tag->appendChild($dom_xml->createTextNode("DataTransitionError"));
	$resultset->appendChild($result_tag);	
}
$div_tag = $dom_xml->createElement("div");
$div_tag->appendChild($dom_xml->createTextNode($_REQUEST["div_no"]));
$resultset->appendChild($div_tag);

print $dom_xml->saveXML();

?>