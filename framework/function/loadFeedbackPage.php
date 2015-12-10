<?php

require_once("../framework.php");

if (isset($_POST["type"])){
	$type = $_POST["type"];
	if($type != "course"){
		header("HTTP/1.1 400 Invalid Request");
		die("HTTP/1.1 400 Invalid Request - you passed in a wrong type parameter.");
	}
	subjectList();
} else if(isset($_POST["course"])) {
	if(isset($_POST["lecture"])) {
		readFeedbackList();
	} else {
		lectureList();
	}
}

function subjectList() {
	$db = new Feedback();
	$courses = $db->getAllCourseName();

	$jsonarray = array();

	for($i=0; $i<sizeof($courses); $i++) {
		$jsonarray[$i] = $courses[$i][0];
	}

	print json_encode($jsonarray);
}

function lectureList() {
	$db = new Feedback();
	$course_id = $db->getCourseID($_POST["course"]);
	$lecture_list = $db->getLectureList($course_id);

	$jsonarray = array();

	for($i=0; $i<sizeof($lecture_list); $i++) {
		$jsonarray[$i] = $lecture_list[$i][0];
	}

	print json_encode($jsonarray);
}

function readFeedbackList() {
	$db = new Feedback();
	$course_id = $db->getCourseID($_POST["course"]);
	$lecture_list = $db->readContents($course_id, $_POST["lecture"]);

	$jsonarray = array();

	for($i=0; $i<sizeof($lecture_list); $i++) {
		$jsonarray[$i] = array();
		$jsonarray[$i]["feedback_no"] = $lecture_list[$i][0];
		$jsonarray[$i]["content_text"] = $lecture_list[$i][1];
		$jsonarray[$i]["div_no"] = $lecture_list[$i][2];
	}

	print json_encode($jsonarray);
}

?>