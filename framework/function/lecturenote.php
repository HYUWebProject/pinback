<?php
	class LectureNote
	{
		function getCourseName() {
			$pdo = Database::getInstance();
			$stmt = $pdo->prepare("SELECT title FROM course");
			$stmt->execute();
			
			return $stmt->fetchAll();
		}
		function getCourseId($title) // 과목 이름을 받아서 과목 코드를 리턴
		{
			$pdo = Database::getInstance();
			$stmt = $pdo->prepare("SELECT course_id FROM course WHERE title = :title");
			$stmt->execute(array(':title'=>$title));
			$temp = $stmt->fetch();
			
			return $temp['course_id'];
		}
		function getLectureList($course_id) {
			$pdo = Database::getInstance();
			$stmt = $pdo->prepare("SELECT lecture_id FROM lecture WHERE course_id = :course_id");
			$stmt->execute(array(':course_id'=>$course_id));
			
			return $stmt->fetchAll();
		}
		function getLectureCode($subjCode, $lecDate) // 과목코드와 해당 날짜를 입력받아서 과목코드 리턴
		{
			$pdo = Database::getInstance();
			$stmt = $pdo->prepare("SELECT lecturecode FROM lecture WHERE subjectcode = :subjCode AND lecturedate = :lecDate");
			$stmt->execute(array(
				':subjCode'=>$subjCode,
				':lecDate'=>$lecDate));
			$temp = $stmt->fetch();

			return $temp['lecturecode'];
		}
		// function getQuestionNo($subjCode, $lecCode)
		// {
		// 	$pdo = Database::getInstance();
		// 	$stmt = $pdo->preapare("SELECT no FROM question WHERE lecturecode = :lecCode");
		// 	$stmt->execute(array(
		// 		':lecCode'=>$lecCode));
		// 	$temp = $stmt->fetch();
		// 	foreach()

		// 	return $temp['no'];
		// }
		function getContent($subjCode, $lecCode, $no)
		{
			$
			$pdo = Database::getInstance();

		}
		function getCoordinate($no)
		{
			$pdo = Database::getInstance();
			$stmt = $pdo->prepare("SELECT positionX, positionY FROM question WHERE no = :no");
			$stmt->execute(array(
				':no'=>$no));
			$temp = $stmt->fetchAll();

			return $temp;
		}
	}