<?php
	require_once "include/session.php";
	require_once "include/mysqli.php";

	//проверка пользователя
	if(!empty($_POST))
		if( !db_connect() ) {
			
			$usr= htmlentities(mysqli_real_escape_string($conn,$_POST["login"]));
			$passwd = htmlentities(mysqli_real_escape_string($conn,$_POST["password"]));
			
			if (!empty($usr))
				if (!db_login($usr, $passwd)) {
						$ok = "Добро пожаловать!";
						
						$_SESSION["login"] = $usr; // имя пользователя
						$_SESSION["status"] = get_user_status($usr); //права пользователя

						header("Refresh: 2; url=index.php");
						
				} else {
					$error = "Не правильный логин или пароль";
				}
			else 
				$error = "Логин не может быть пустым";
			
			// закрываем соединение
			db_close();			
		} else 
			$error = "Ошибка подключения";
	
?>
<!DOCTYPE html>
<html>

<head>
	<?php require_once "block/head.php"; ?>
	
	<!-- -->
	<link rel="stylesheet" href="css/sign-up.css">
	<script src="js/sign-up.js"></script>
	
</head>

<body>

	<?php 
		require_once "block/header.php"; // шапка сайта
		require_once "block/nav.php"; // меню 
	?>
	
	<main>
		<h2>Вход на сайт</h2>
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
		
		<form id="sign-up" method="POST">
		<div>
			<img src="img/avatar.png" alt="" style="height: 200px;">
		</div>
			<input type="email" name="login" placeholder="Email" required>
			<input type="password" name="password" placeholder="Password" required>
			<input type="submit" name="sign-up-submit" value="Войти">
		</form>
		
	</main>
	

</body>
<footer>	
	<?php 
	require_once "block/footer.php"; // подвал
	?>
</footer>
</html>