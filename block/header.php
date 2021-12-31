<?php
	$status = $_SESSION["status"];
	$lenTrash = count($_SESSION["trash"]);
	$trash = $lenTrash != 0 ? "Корзина - $lenTrash товар" : "Корзина";
	//var_dump($status);
?>
<header>
	<h1><a href="/">Мир книг</a></h1>
	<!-- Панель управления -->
	<ul class="ctrl-panel">
	
		<?php switch($status): 
				 case "admin": ?>
				<li><a href="delete.php">Удаление</a></li>
				<li><a href="add.php">Добавление</a></li>
				<li><a href="edit.php">Редактирование</a></li>
			
			<?php case "user": ?>
				<li><a href="trash.php" id="trash-menu-txt"><?=$trash?></a></li>
				<li><a href="include/logout.php">Выход</a></li>
			<?php break; ?>
			
			<?php default: ?>
				<li><a href="sign-up.php">Вход</a></li>
		<?php endswitch; ?>
	</ul>
</header>