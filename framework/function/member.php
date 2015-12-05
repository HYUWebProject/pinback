<?php
	class Member {
		function login($id, $pwd)
		{
			$pdo = Database::getInstance();
			$stmt = $pdo->prepare("SELECT password FROM user WHERE id = :id");
			$stmt->execute(array(':id'=>$id));
			$member = $stmt->fetch(PDO::FETCH_ASSOC);
			if($member == null) return false;
			$savedPassword = $member['password'];
			if (sha1($pwd) === $savedPassword)
				return true;
			else
				return false;
		}

		function register($id, $name, $password, $vocation)
		{
			if($vocation == "professor") $level = 1;
			else $level = 0;

			$pdo = Database::getInstance();
			$hashedPassword = sha1($password);
			$stmt = $pdo->prepare("INSERT INTO user VALUES(:id, :name, :password, :level, 0)");
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

		function resetPassword($id)
		{
			$pdo1 = Database::getInstance();
			$stmt1 = $pdo1->prepare("SELECT * FROM user WHERE id = :id");
			$stmt1->execute(array(':id'=>$id));
			$exist = $stmt1->fetch(PDO::FETCH_ASSOC);
			if($exist == null) return false;

			$pdo2 = Database::getInstance();
		    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    		$charactersLength = strlen($characters);
    		$length = 8;
    		$randomString = '';
    		for ($i = 0; $i < $length; $i++) {
        		$randomString .= $characters[rand(0, $charactersLength - 1)];
    		}
    		$randomPassword = sha1($randomString);
    		$stmt2 = $pdo2->prepare("UPDATE user SET password = :randomPassword WHERE id = :id");
    		try {
    			$stmt2->execute(array(
    				':randomPassword'=>$randomPassword,
    				':id'=>$id));
    			return $randomString;
    		} catch (Exception $e) {
    			return $e;
    		}
		}
	}
?>