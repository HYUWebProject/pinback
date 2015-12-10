<?php

require_once("../framework.php");

if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != "POST") {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid request - This service accepts only GET requests.");
}

header("Content-type: application/xml");
$dom_xml = new DOMDocument();
$resultset = $dom_xml->createElement("resultset");
$dom_xml->appendChild($resultset);

$db = new Member();

if(isset($_REQUEST["id"]) && isset($_REQUEST["name"]) && isset($_REQUEST["pass"])
	&& isset($_REQUEST["vocation"]) && $_REQUEST["id"]!=null && $_REQUEST["pass"]!=null
	&& $_REQUEST["name"]!=null && $_REQUEST["vocation"]!=null &&
	preg_match("/[0-9]{10,10}/", $_REQUEST["id"]) && preg_match("/[a-zA-z]{1,10}/", $_REQUEST["name"])) {
	$result = $db->register($_REQUEST["id"], $_REQUEST["name"], $_REQUEST["pass"], $_REQUEST["vocation"]);
	if($result === true) {
		$result_tag = $dom_xml->createElement("result");
		$result_tag->appendChild($dom_xml->createTextNode("success"));
		$resultset->appendChild($result_tag);
	}
	else if($result instanceOf Exception) {
		$result_tag = $dom_xml->createElement("result");
		$result_tag->appendChild($dom_xml->createTextNode("SQLException"));
		$resultset->appendChild($result_tag);

		$msg = $result->getMessage();
		$msg_tag = $dom_xml->createElement("exception");
		$msg_tag->appendChild($dom_xml->createTextNode($msg));
		$resultset->appendChild($msg_tag);
	}
} else {
	$result_tag = $dom_xml->createElement("result");
	$result_tag->appendChild($dom_xml->createTextNode("fail"));
	$resultset->appendChild($result_tag);
}
print $dom_xml->saveXML();

?>