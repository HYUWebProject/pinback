<?php

require_once("../framework.php");

if (isset($_POST["type"])){
	$type = $_POST["type"];
	if ($type == "order"){
		getLastNum();
	}
	else if($type != "lecturecourse"){
		header("HTTP/1.1 400 Invalid Request");
		die("HTTP/1.1 400 Invalid Request - you passed in a wrong type parameter.");
	}
	subjectList();
} else if(isset($_POST["lecturecourse"])) {
	if (isset($_POST["lecturenumber"])) {
		if(isset($_POST["page"]))
			loadimage();
		else
			pageList();
	} else {
		lectureList();
	}
}
function getLastNum()
{
	$db = new LectureNote();
	$order = $db->getLastNum();

	$jsonarray = array();
	$jsonarray[0] = "ffaf";

	print json_encode($jsonarray);
}
function subjectList() {
	$db = new LectureNote();
	$courses = $db->getAllCourseName();

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

function pageList()
{
	$db = new LectureNote();
	$course_id = $db->getCourseId($_POST["lecturecourse"]);
	$page_list = $db->getPageList($course_id, $_POST["lecturenumber"]);

	$jsonarray = array();

	for ($i = 0; $i < sizeof($page_list); $i++)
	{
		$jsonarray[$i] = $page_list[$i][0];
	}

	print json_encode($jsonarray);
}
function loadimage(){
	//print header('Content-Type: image/jpeg');
	//print json_encode("hello");
	$img = "./lecturenote/".$_POST["lecturecourse"]."_".$_POST["lecturenumber"]."_".$_POST["page"].".jpg";
	//print($img);
	# 이미지 실제경로 그리고 이미지 이름 
	//$url = "img/new/" . $_GET[img_name] .".jpg"; 

	

	print json_encode($img); 
}

?>