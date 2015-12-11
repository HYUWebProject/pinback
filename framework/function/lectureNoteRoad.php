<?php

require_once("../framework.php");

if (isset($_POST["type"])){
	$type = $_POST["type"];
	if($type != "lecturecourse"){
		header("HTTP/1.1 400 Invalid Request");
		die("HTTP/1.1 400 Invalid Request - you passed in a wrong type parameter.");
	}
	subjectList();
} else if(isset($_POST["lecturecourse"])) {

	lectureList();
}
function subjectList() {
	$db = new LectureNote();
	$courses = $db->getCourseName();

	$jsonarray = array();

	for($i=0; $i<sizeof($courses); $i++) {
		$jsonarray[$i] = $courses[$i][0];
	}
	print json_encode($jsonarray);
}

function lectureList() {
	$db = new LectureNote();
	$course_id = $db->getCourseId($_POST["lecturecourse"]);
	$lecture_list = $db->getLectureList($course_id);


	$jsonarray = array();

	for($i=0; $i<sizeof($lecture_list); $i++) {
		$jsonarray[$i] = $lecture_list[$i][0];
	}

	print json_encode($jsonarray);
}

?>