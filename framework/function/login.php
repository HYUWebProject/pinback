<?php

require_once("../framework.php");

	//if it needs to include some php file then include
if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != "POST") {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid request - This service accepts only GET requests.");
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
	$pw_tag = $dom_xml->createElement("pw");
	$pw_tag->appendChild($dom_xml->createTextNode($pw));
	$resultset->appendChild($pw_tag);

	//db를 통해 입력된 ID와 PW를 비교한다.
	$db = new Member();
	if($db->login($id, $pw)) {
		$_SESSION["pin_id"] = $id;
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
