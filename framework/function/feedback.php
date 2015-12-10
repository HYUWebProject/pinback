<?php
	class Feedback
	{
		/* 임시로 받는값은 과목이름 / 강의날짜만 받는걸로 해뒀음
		 * 나중에 수정할땐 이 값들만 수정하면 됩니다 */
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

		//현재 렉처에 데이터가 없는 상황이므로 이 function은 잠시 수면
		function getLectureCode($course_id, $lecDate) // 과목코드와 해당 날짜를 입력받아서 과목코드 리턴
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
			$stmt = $pdo->prepare("SELECT no FROM feedback WHERE subjectcode = :subjCode AND lecturecode = :lecCode");
			$stmt->execute(array(
				':subjCode'=>$subjCode,
				':lecCode'=>$lecCode));
			$temp = $stmt->fetchAll();

			return $temp['no'];
		}

		function readContents($course_id, $lecture_id) // 과목코드와 렉쳐번호를 받아서 피드백 메모 리스트를 리턴
		{
			$pdo = Database::getInstance();
			$stmt = $pdo->prepare("SELECT feedback_no, content_text, div_no FROM feedback WHERE course_id = :course_id AND lecture_id = :lecture_id");
			$stmt->execute(array(
				':course_id'=>$course_id,
				':lecture_id'=>$lecture_id));
			return $stmt->fetchAll();
		}
		// 과목 이름하고 강의 날짜는 아마 게시판에서 받아오는 정보 입력하면 될거고
		// content는 폼에서 입력하는거 받아오면 될듯!
		function writeFeedback($course, $lecture_id, $contents, $div_no)
		{
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
				$course_id = $this->getCourseId($course);
				$stmt = $pdo->prepare("INSERT INTO feedback (written_id, course_id, lecture_id, content_text, written_date, confirm_flag, div_no)
					VALUES(:written_id, :course_id, :lecture_id, :written_date, :confirm_flag, :div_no)");
				$stmt->execute(array(
					':written_id'=>$userid,
					':course_id'=>$course_id,
					':lecture_id'=>$lecture_id,
					':written_date'=>date('Y-m-d H:i:s'),
					':confirm_flag'=>0,
					':div_no'=>$div_no
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