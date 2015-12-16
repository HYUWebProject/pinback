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
		function getContent($subjectCode, $lectureCode, $pageNumber)
		{
			$pdo = Database::getInstance();
			$stmt = $pdo->prepare("SELECT * FROM question
				WHERE course_id = :subjectCode AND lecture_id = :lectureCode AND page = :pageNumber");
			$stmt->execute(array(
				':subjectCode'=>$subjectCode,
				':lectureCode'=>$lectureCode,
				':pageNumber'=>$pageNumber
				));

			return $stmt->fetchAll();
		}

		function writeQuestion($subject, $lectureCode, $contents, $page, $posX, $posY)
		{
			$subjectCode = $this->getCourseId($subject);
			$pod = Database::getInstance();
			$stmt = $pdo->prepare("INSERT INTO question(course_id, lecture_id, asked_id, written_date, content_text, page, pos_x, pos_y)
				VALUES(:subjCode, :lecCode, :userId, date('Y-m-d H:i:s'), :contents, :page, :X, :Y");
			try {
				$stmt->execute(array(
					':subjCode'=>$subjectCode,
					':lectureCode'=>$lectureCode,
					':userId'=>$_SESSION["id"],
					':contents'=>$contents,
					':page'=>$page,
					':X'=>$posX,
					':Y'=>$posY
				));
				return true;
			} catch (Exception $e)
			{
				return false;
			}
		}

		function deleteQuestion($questionNo)
		{
			$pdo = Database::getInstance();
			$stmt= $pdo->prepare("SELECT asked_id FROM question WHERE question_id = :qNo");
			$stmt->execute(array(
				':qno'=>$questionNo
				));
			$id = $stmt->fetch();
			if ($_SESSION['id'] != $id['asked_id'])
				return false;
			$stmt=$pdo->prepare("DELETE FROM question WHERE question_id = :qid");
			$stmt->execute(array(
				':qid'=>$questionNo
			));

			return true;
		}

		function writeAnswer($questionNo, $contents)
		{
			$pdo = Database::getInstance();
			$stmt = $pdo->prepare("INSERT INTO answer(question_id, answered_id, written_date, content_text) VALUES (:question_id, :answered_id, :written_date, :contents)");
			$stmt->execute(array(
				':question_id'=>$questionNo,
				':answered_id'=>$_SESSION['id'],
				':written_date'=>date('Y-m-d H:i:s'),
				':contents'=>$contents,
				));
			$stmt = $pdo->prepare("UPDATE user SET `point` = `point` + 10 WHERE id = :id");
			$stmt->execute(array(
				':id'=>$_SESSION['id']
				));
			return true;
		}

		// 이 위에까진 수정 완료했음
		// 여기서부턴 수정 안된부분
		
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
			$stmt = $pdo->prepare("SELECT * FROM answer
				WHERE question_id = :questionNo");
			$stmt->execute(array(
				':questionNo'=>$questionNo
				));
			return $stmt->fetchAll();
		}
	}
?>