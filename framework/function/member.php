<?php
	class Member {
		function login($id, $pwd)
		{
			$pdo = Database::getInstance();
			$stmt = $pdo->prepare("SELECT * FROM user WHERE id = :id");
			$stmt->execute(array(':id'=>$id));
			$member = $stmt->fetch(PDO::FETCH_ASSOC);
			if($member == null) return false;
			$savedPassword = $member['password'];
			if (sha1($pwd) === $savedPassword)
				return $member;
			else 
				return false;
		}

		function register($id, $name, $password, $vocation)
		{
			if($vocation == "professor") $level = 1;
			else $level = 0;

			$pdo = Database::getInstance();
			$hashedPassword = sha1($password);
			$stmt = $pdo->prepare("INSERT INTO user (id, name, password, level) VALUES(:id, :name, :password, :level)");
			try {
				$stmt->execute(array(
					':id'=>$id,
					':name'=>$name,
					':password'=>$hashedPassword,
					':level'=>$level));
				return true;
			} catch (Exception $e) {
				return $e;
			}
		}

		function findID($id) {
			$pdo = Database::getInstance();
			$stmt = $pdo->prepare("SELECT * FROM user WHERE id = :id");
			$stmt->execute(array(':id'=>$id));
			$exist = $stmt->fetch(PDO::FETCH_ASSOC);
			if($exist == null) return false;
			else return true;
		}

		function resetPassword($id)
		{
			if($this->findID($id) == false) return false;

			$pdo = Database::getInstance();
		    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    		$charactersLength = strlen($characters);
    		$length = 8;
    		$randomString = '';
    		for ($i = 0; $i < $length; $i++) {
        		$randomString .= $characters[rand(0, $charactersLength - 1)];
    		}
    		$randomPassword = sha1($randomString);
    		$stmt = $pdo->prepare("UPDATE user SET password = :randomPassword WHERE id = :id");
    		try {
    			$stmt->execute(array(
    				':randomPassword'=>$randomPassword,
    				':id'=>$id));
    			return $randomString;
    		} catch (Exception $e) {
    			return $e;
    		}
		}

		function modifyPassword($pw) {
			$id = $_SESSION['id'];
			$pdo = Database::getInstance();
    		$newPassword = sha1($pw);
    		$stmt = $pdo->prepare("UPDATE user SET password = :newPassword WHERE id = :id");
    		try {
    			$stmt->execute(array(
    				':newPassword'=>$newPassword,
    				':id'=>$id));
    			return true;
    		} catch (Exception $e) {
    			return $e;
    		}
		}
	}
?>