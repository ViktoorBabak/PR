<?php
	require_once "session.php";
	
	session_unset();// уничтожение данных сессии
	session_destroy();
	header("Location: /");// перенаправление на стартовую страницу
	exit;
?>