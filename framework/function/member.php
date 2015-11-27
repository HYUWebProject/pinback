<?php
	class Member {
		function login($id, $pwd)
		{
			$pdo = Database::getInstance();
			$stmt = $pdo->prepare("SELECT password FROM user WHERE id = :id");
			$stmt->execute(array(
				':id'=>$id));
			$member = $stmt->fetch();
			$savedPassword = $member['password'];
			if (password_hash($pwd) === $savedPassword)
				return true;
			else
				return false;
		}

		function register($id, $name, $password)
		{
			$pdo = Database::getInstance();

			$hashedPassword = password_hash($password);
			$stmt = $pdo->prepare("INSERT INTO user VALUES(:id, :name, :password, 0)");
			$stmt->execute(array(
				':id'=>$id,
				':name'=>$name,
				':password'=>$hashedPassword));
		}

		function resetPassword($id)
		{
			$pdo = Database::getInstance();
		    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    		$charactersLength = strlen($characters);
    		$randomString = '';
    		for ($i = 0; $i < $length; $i++) {
        		$randomString .= $characters[rand(0, $charactersLength - 1)];
    		}
    		$randomPassword = password_hash($randomString);
    		$stmt = $pdo->prepare("UPDATE user SET password = :randomPassword WHERE id = :id");
    		$stmt->execute(array(
    			':randomPassword'=>$randomPassword,
    			':id'=>$id));
		}
	}
?>