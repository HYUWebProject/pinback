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

$db = new LectureNote();

if(isset($_REQUEST["course"]) && $_REQUEST["course"]!=null && isset($_REQUEST["lecture"]) && $_REQUEST["lecture"]!=null &&
	isset($_REQUEST["page"]) && $_REQUEST["page"]!=null) {

	$result = $db->writeQuestion($_REQUEST["course"], $_REQUEST["lecture"], $_REQUEST["content"],
		$_REQUEST["page"], $_REQUEST["posX"], $_REQUEST["posY"]);

	if ($result instanceOf Exception) {
		$result_tag = $dom_xml->createElement("result");
		$result_tag->appendChild($dom_xml->createTextNode("SQLException"));
		$resultset->appendChild($result_tag);
	} else {
		$result_tag = $dom_xml->createElement("result");
		$result_tag->appendChild($dom_xml->createTextNode("success"));
		$resultset->appendChild($result_tag);
	}
} else {
	$result_tag = $dom_xml->createElement("result");
	$result_tag->appendChild($dom_xml->createTextNode("ValidationError"));
	$resultset->appendChild($result_tag);	
}
print $dom_xml->saveXML();

?>