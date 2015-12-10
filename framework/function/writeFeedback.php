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

if(isset($_REQUEST["course"]) && $_REQUEST["course"]!=null && isset($_REQUEST["lecture"]) && $_REQUEST["lecture"]!=null &&
	isset($_REQUEST["div_no"]) && $_REQUEST["div_no"]!=null) {

	$result = $db->writeFeedback($_REQUEST["course"], $_REQUEST["lecture"], $_REQUEST["content"],
		$_REQUEST["div_no"]);

	if($result === true) {
		$result_tag = $dom_xml->createElement("result");
		$result_tag->appendChild($dom_xml->createTextNode("success"));
		$resultset->appendChild($result_tag);

		$test_tag = $dom_xml->createElement("text");
		$test_tag->appendChild($dom_xml->createTextNode($_REQUEST['content']));
		$resultset->appendChild($test_tag);

		$div_tag = $dom_xml->createElement("div");
		$div_tag->appendChild($dom_xml->createTextNode($_REQUEST['div_no']));
		$resultset->appendChild($div_tag);
	}
	else if($result instanceOf Exception) {
		$result_tag = $dom_xml->createElement("result");
		$result_tag->appendChild($dom_xml->createTextNode("SQLException"));
		$resultset->appendChild($result_tag);

		$msg = $result->getMessage();
		$msg_tag = $dom_xml->createElement("exception");
		$msg_tag->appendChild($dom_xml->createTextNode($msg));
		$resultset->appendChild($msg_tag);
	} else {
		$result_tag = $dom_xml->createElement("result");
		$result_tag->appendChild($dom_xml->createTextNode("failure"));
		$resultset->appendChild($result_tag);	
	}
} else {
	$result_tag = $dom_xml->createElement("result");
	$result_tag->appendChild($dom_xml->createTextNode("ValidationError"));
	$resultset->appendChild($result_tag);	
}
print $dom_xml->saveXML();

?>