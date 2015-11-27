<?php
	class Board
	{
		function readContents($no)
		{
			$pdo = Database::getInstance();
			$stmt = $pdo->preapare("SELECT contents, ")
		}
	}
?>