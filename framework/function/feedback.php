<?php
	class Feedback
	{
		/* 임시로 받는값은 과목이름 / 강의날짜만 받는걸로 해뒀음
		 * 나중에 수정할땐 이 값들만 수정하면 됩니다 */
		function getAllSubjectName() {
			$pdo = Database::getInstance();
			$stmt = $pdo->prepare("SELECT subject FROM subject");
			$stmt->execute();
			
			return $stmt->fetchAll();
		}

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
		function getContentNo($subjCode, $lecCode) // 과목코드와 렉쳐번호를 받아서 글 번호를 리턴
		{
			$pdo = Database::getInstance();
			$stmt = $pdo->preapare("SELECT no FROM feedback WHERE subjectcode = :subjCode AND lecturecode = :lecCode");
			$stmt->execute(array(
				':subjCode'=>$subjCode,
				':lecCode'=>$lecCode));
			$temp = $stmt->fetchAll();

			return $temp['no'];
		}
		function readContents($no) // 글 번호를 받아서 컨텐츠를 리턴
		{
			$pdo = Database::getInstance();
			$stmt = $pdo->preapare("SELECT contents FROM feedback WHERE no = :no");
			$stmt->execute(array(
				':no'=>$no));
			$temp = $stmt->fetchAll();

			return $temp['contents'];
		}
		// 과목 이름하고 강의 날짜는 아마 게시판에서 받아오는 정보 입력하면 될거고
		// content는 폼에서 입력하는거 받아오면 될듯!
		function writeFeedback($subject, $lecDate, $contents)
		{
			$subjectcode = getSubjectCode($subject);
			$lecturecode = getLectureCode($subjectcode, $lecDate);
			$pdo = Database::getInstance();

			$stmt=$pdo->prepare("SELECT id FROM user WHERE name = :name");
			$stmt->execute(array(
				':name'=>$_SESSION['user']));
			$userid = $stmt->fetch();

			$stmt = $pdo->prepare("SELECT point FROM user WHERE id = :id");
			$stmt->execute(array(
				':id'=>$userid));
			$point = $stmt->fetch();
			if ($point >= 10)
			{
				$stmt = $pdo->prepare("INSERT INTO feedback
					VALUES(:subjectcode, :studentid, :content, :readflag, :lecturecode)");
				$stmt->execute(array(
					':subjectcode'=>$subjectcode,
					':studentid'=>$userid,
					':content'=>$contents,
					':readflag'=>0,
					':lecturecode'=>$lecturecode
				));	
				return true;
			}
			else
			{
				return false;
			}
			
		}
		function getPoint($id)
		{
			$pdo= Database::getInstance();
			$stmt=$pdo->prepare("SELECT point FROM user WHERE id = :id");
			$stmt->execute(array(
				':id'=>$id));
			$temp = $stmt->fetch();

			return $temp;
		}
	}
?>