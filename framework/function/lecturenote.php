<?php
	class LectureNote
	{
		function getAllCourseName() {
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

		function getPageList($lecture_id)
		{
			$pdo = Database::getInstance();
			$stmt = $pdo->prepare("SELECT page FROM lecturenote WHERE lecture_id = :lecId");
			$stmt->execute(array(
				':lecId'=>$lecture_id
				));
			return $stmt->fetchAll();
		}

		function getQuestionNo($subjCode, $lecCode)
		{
			$pdo = Database::getInstance();
			$stmt = $pdo->preapare("SELECT no FROM question WHERE lecturecode = :lecCode");
			$stmt->execute(array(
				':lecCode'=>$lecCode));
			$temp = $stmt->fetch();

			return $temp['no'];
		}
		function getQuestion($subjCode, $lecCode, $no)
		{
			$pdo = Database::getInstance();
			$stmt = $pdo->prepare("SELECT * FROM question WHERE lecture_id = :lecCode AND course_id = :subjCode");
			$stmt->execute(array(
				':lecCode'=>$lecCode,
				':subjCode'=>$subjCode));

			return $stmt->fetchAll();
		}
		
		function getAnswer($questionNo)
		{
			$pdo = Database::getInstance();
			$stmt = $pdo->prepare("SELECT a.*
				FROM answer a
				JOIN user_answer ua ON a.answered_id = au.answered_id
				WHERE au.userid = :userid
				AND a.question_id = :questionNo");
			$stmt->execute(array(
				':userid'=>$_SESSION['id'],
				':questionNo'=>$questionNo
				));
			return $stmt->fetchAll();
		}

		function buyAnswer($answerId)
		{
			if ($_SESSION["point"] > 10) {
				$pdo = Database::getInstance();
				$stmt = $pdo->prepare("INSERT INTO user_answer
					VALUES(:uid, :ansid)");
				$stmt->execute(array(
					':uid'=>$_SESSION["id"],
					':ansid'=>$answerId
					));
				$stmt = $pdo->prepare("UPDATE user SET point = point - 10 WHERE id = :id");
				$stmt->extcute(array(
					':id'=>$_SESSION["id"]
					));
			}
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