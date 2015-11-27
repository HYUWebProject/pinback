<?php
	class Database {
		private static $instance = NULL;

		private $database;

		// 생성자
		private function __construct() {
			$this->database = new PDO("mysql:host=localhost;dbname=pinback", "root", "root");
			$this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$this->database->exec('set names utf8');
		}

		// 함수 받아오는거 - Database::getInstance()로 변수 입력 후 사용하면 됨
		public static function getInstance() {
			if (self::$instance === NULL) {
				self::$instance = new Database();
			}

			return self::$instance->database;
		}
	}
?>
