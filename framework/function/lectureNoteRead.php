<?php

require_once("../framework.php");


if (isset($_POST["type"])){
	$type = $_POST["type"];
	if ($type == "order"){
		getLastNum();
	} else if ($type == "getpin") {
		getPin();
	} else if ($type == "load") {
		loadNote();
	}
	else if($type != "lecturecourse"){
		header("HTTP/1.1 400 Invalid Request");
		die("HTTP/1.1 400 Invalid Request - you passed in a wrong type parameter.");
	}
} else if(isset($_POST["lecturecourse"])) {
	if (isset($_POST["lecturenumber"])) {
		if(isset($_POST["page"])){
			loadimage();			
		}
		else
			pageList();
	} else {
		lectureList();
	}
}
function getLastNum() {
	$db = new LectureNote();
	$order = $db->getLastNum();
	
	if ($order == NULL)
	{
		$order = 1;
	} else {
		$order++;
	}

	print $order;
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

function getPin() {
	$db = new LectureNote();
	$course_id = $db->getCourseId($_POST["lecturecourse"]);

	$contentArray = $db->getContent($course_id, $_POST["lecturenumber"], $_POST["pagenumber"]);
	$tmpArray = array();

	for ($i = 0; $i < sizeof($contentArray); $i++) {
		$tmpArray[$i] = array();
		$tmpArray[$i]["question_id"] = $contentArray[0];
		$tmpArray[$i]["content"] = $contentArray[5];
		$tmpArray[$i]["posX"] = $contentArray[7];
		$tmpArray[$i]["posY"] = $contentArray[8];
	}

	print json_encode($tmpArray);
}

function loadNote() {
	$db = new LectureNote();
	$course_id = $db->getCourseId($_POST["lecturecourse"]);
	$note = $db->getNote($_POST["order"]);

	$jsonarray = array();
	$jsonarray[0]["content"] = $contentArray[5];

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