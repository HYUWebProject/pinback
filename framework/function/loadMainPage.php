<?php

if (isset($_GET["type"])){
	$type = $_GET["type"];
	if($type != "subject"){
		header("HTTP/1.1 400 Invalid Request");
		die("HTTP/1.1 400 Invalid Request - you passed in a wrong type parameter.");
	}
	subjectList();
} else {
	lectureList();
}

function subjectList() {
	$db = new Feedback();
	$subject = $db->getAllSubjectName();

	print_r($subject);
}

function lectureList() {

}

?>