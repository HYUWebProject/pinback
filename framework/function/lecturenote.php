<?php
	class LectureNote
	{
		function getSubjectCode($subject) // 과목 이름을 받아서 과목 코드를 리턴
		{
			$pdo = Database::getInstance();
			$stmt = $pdo->prepare("SELECT subjectcode FROM subject WHERE subject = :subject");
			$stmt->execute(array(':board'=>$subject));
			$temp = $stmt->fetch();
			
			return $temp['subjectcode'];
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
		function getQuestionNo($subjCode, $lecCode)
		{
			$pdo = Database::getInstance();
			$stmt = $pdo->preapare("SELECT no FROM question WHERE lecturecode = :lecCode");
			$stmt->execute(array(
				':lecCode'=>$lecCode));
			$temp = $stmt->fetchAll();

			return $temp['no'];
		}
		function getContent($no, $lecCode)
		{

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