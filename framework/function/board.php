<?php
	class Board
	{
		function getSubjectCode($subject) // 과목 이름을 받아서 과목 코드를 리턴
		{
			$pdo = Database::getInstance();
			$stmt = $pdo->prepare("SELECT subjectcode FROM subject WHERE subject = :subject");
			$stmt->execute(array(':board'=>$subject));
			$temp = $stmt->fetch();
			
			return $temp['no'];
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
		function getContentNo($subjCode, $lecCode)
		{
			$pdo = Database::getInstance();
			$stmt = $pdo->preapare("SELECT no FROM feedback WHERE subjectcode = :subjCode AND lecturecode = :lecCode");
			$stmt->execute(array(
				':subjCode'=>$subjCode,
				':lecCode'=>$lecCode));
			$temp = $stmt->fetchAll();

			return $temp['no'];
		}
		function readContents($no)
		{
			$pdo = Database::getInstance();
			$stmt = $pdo->preapare("SELECT contents, ")
		}
	}
?>