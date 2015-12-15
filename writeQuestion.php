<?php
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

	function writeQuestion($subjectCode, $lectureCode, $contents, $page, $posX, $posY)
	{
		$pod = Database::getInstance();
		if ($_SESSION["point"] > 10)
		{
			$stmt = $pdo->prepare("INSERT INTO question(course_id, lecture_id, asked_id, written_date, content_text, page, pos_x, pos_y)
				VALUES(:subjCode, :lecCode, :userId, date('Y-m-d H:i:s'), :contents, :page, :X, :Y");
			$stmt->execute(array(
				':subjCode'=>$subjectCode,
				':lectureCode'=>$lectureCode,
				':userId'=>$_SESSION["id"],
				':contents'=>$contents,
				':page'=>$page,
				':X'=>$posX,
				':Y'=>$posY
			));
			$stmt = $pdo->prepare("UPDATE user SET `point` = `point` - 10 WHERE id = :id");
			$stmt->execute(array(
				':id'=>$_SESSION['id']
				));
			return true;
		}
		else
			return false;
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
?>