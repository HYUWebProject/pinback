<?php
	// error_reporting(E_ALL);
	// ini_set("display_errors", 1);
	require_once("../framework/framework.php");
	$pdo = Database::getInstance();
	$pdo->exec(file_get_contents("table.sql"));
	$pdo->exec(file_get_contents("insert.sql"));
?>
<a href="/index.php">go back</a>
