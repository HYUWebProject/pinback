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

if(isset($_REQUEST["id"]) && isset($_REQUEST["pw"])
	&& $_REQUEST["id"]!=NULL && $_REQUEST["pw"]!=NULL) {
	
	$id = $_REQUEST["id"];
	$pw = $_REQUEST["pw"];

	$id_tag = $dom_xml->createElement("id");
	$id_tag->appendChild($dom_xml->createTextNode($id));
	$resultset->appendChild($id_tag);

	//db를 통해 입력된 ID와 PW를 비교한다.
	$db = new Member();
	$member = $db->login($id, $pw);
	if(!($member === false)) {
		$_SESSION["id"] = $member["id"];

		$_SESSION["name"] = $member["name"];
		$name_tag = $dom_xml->createElement("name");
		$name_tag->appendChild($dom_xml->createTextNode($member["name"]));
		$resultset->appendChild($name_tag);

		$_SESSION["level"] = $member["level"];
		$level_tag = $dom_xml->createElement("level");
		$level_tag->appendChild($dom_xml->createTextNode($member["level"]));
		$resultset->appendChild($level_tag);

		$_SESSION["point"] = $member["point"];
		$point_tag = $dom_xml->createElement("point");
		$point_tag->appendChild($dom_xml->createTextNode($member["point"]));
		$resultset->appendChild($point_tag);

		$result_tag = $dom_xml->createElement("result");
		$result_tag->appendChild($dom_xml->createTextNode("success"));
		$resultset->appendChild($result_tag);

	} else {
		$result_tag = $dom_xml->createElement("result");
		$result_tag->appendChild($dom_xml->createTextNode("selectionFailed"));
		$resultset->appendChild($result_tag);
	}
} else {
	//show some error detection page or popup
	$result_tag = $dom_xml->createElement("result");
	$result_tag->appendChild($dom_xml->createTextNode("inputValidInformation"));
	$resultset->appendChild($result_tag);
}
print $dom_xml->saveXML();

?>