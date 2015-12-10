<?php
	class Feedback
	{
		/* 임시로 받는값은 과목이름 / 강의날짜만 받는걸로 해뒀음
		 * 나중에 수정할땐 이 값들만 수정하면 됩니다 */
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
			$stmt = $pdo->preapare("SELECT contents FROM feedback WHERE no = :no");
			$stmt->execute(array(
				':no'=>$no));
			$temp = $stmt->fetchAll();

			return $temp['contents'];
		}
	}
?>