<?php
	require_once "include/session.php";
	if($_SESSION["login"] != "") {
		header("Location: /");
	}
	
	require_once "include/mysqli.php";
	
	if(!empty($_POST)) {
		if( !db_connect() ) {
			
			$user = htmlentities(mysqli_real_escape_string($conn, $_POST["login"]));
			$password = htmlentities(mysqli_real_escape_string($conn, $_POST["password"]));
			$repeatpassword = htmlentities(mysqli_real_escape_string($conn, $_POST["repeatpassword"]));
			
			if (!empty($user))
				if (!db_check_usr($user)) // <- Проверка на повторяющиеся логины
					if (strcmp($password, $repeatpassword) === 0)
						if(!empty($password) || !empty($repeatpassword)){
							
							// добавление пользователя
							add_usr($user, $password);
							
							header("Refresh: 2; url=index.php");
							
						} else
							$error = "Пароль не может быть пустым";
					else
						$error = "Пароли не совпадают";
				else 
					$error = "Пользователь с таким именем уже существует";
			else
				$error = "Логин не может быть пустым";
			
			// закрываем соединение
			db_close();
			$ok = "Вы зарегистрировались";
		} else 
			$error = "Ошибка подключения";
	}

?>
<!DOCTYPE html>
<html>

<head>
	<?php require_once "block/head.php"; ?>
	
	<link rel="stylesheet" href="css/reg.css">
	<script src="js/reg.js"></script>
</head>

<body>

	<?php 
		require_once "block/header.php"; // шапка сайта
		require_once "block/nav.php"; // меню 
	?>
	
	<main>
	<?php

		if(isset($error))
			echo <<<_OUT
				<div id="msg-error" class="msg msg-error">
					<div>$error</div>
					<div class="closed" onclick="msgClose('msg-error')">&#10006;</div>
				</div>
_OUT;
		else if(isset($ok))
			echo <<<_OUT
				<div id="msg-ok" class="msg msg-ok">
					<div>$ok</div>
					<div class="closed" onclick="msgClose('msg-ok')">&#10006;</div>
				</div>
_OUT;
	?>
		
		<form id="reg" method="post">
			<fieldset>
			
			<legend><b><h1>Регистрация</h1></b></legend>
				<div>
					<img src="img/avatar.png" alt="" style="height: 200px;">
				</div>
				<div class="container">
					<p>Email</p>
					<input type="email" name="login" placeholder="Введите Ваш e-mail"><br>
					<p>Password</p>
					<input type="password" name="password" placeholder="Ваш пароль"><br>
					<input type="password" name="repeatpassword"  placeholder="Повторите пароль" required><br>					
					<input type="submit" value="Зарегистрироваться" >
				</div>
			</fieldset>
		</form>
		
	</main>
	

</body>
<footer>	
	<?php 
	require_once "block/footer.php"; // подвал
	?>
</footer>
</html>