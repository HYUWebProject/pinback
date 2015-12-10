<?php

if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != "POST") {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid request - This service accepts only GET requests.");
}

$feed = new Feedback();

$dom_xml = new DOMDocument();
$resultset = $dom_xml->createElement("resultset");
$dom_xml->appendChild($resultset);

?>