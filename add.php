<?php
	require_once "include/session.php";
	require_once "include/mysqli.php";
	
	db_connect();

	if(!empty($_POST)) 
		if(isset($_POST["product"])) {

			$category = htmlentities(mysqli_real_escape_string($conn,$_POST["category"]));
			$name = htmlentities(mysqli_real_escape_string($conn,$_POST["name"]));
			$description = htmlentities(mysqli_real_escape_string($conn,$_POST["description"]));
			$price = htmlentities(mysqli_real_escape_string($conn,$_POST["price"]));

			// процесс преобразование пары свойство/значение в строку формата JSON
			$property_name = $_POST["property-name"]; // массивы
			$property_value = $_POST["property-value"];
			
			$property= array( 
				"name" => array(), 
				"value" => array() 
			);
			
			var_dump($property_name);
			var_dump($property_value);
			
			
			// значение массива на постороние вставки кода
			for($len = count($property_name), $i = 0; $i < $len; ++$i) {
				$property["name"][] = htmlentities(mysqli_real_escape_string($conn,$property_name[$i]));
				$property["value"][] = htmlentities(mysqli_real_escape_string($conn,$property_value[$i]));
			}
			
			var_dump($property);
			
			// массив в строку формата JSON
			$property = json_encode($property, JSON_UNESCAPED_UNICODE); //второй параметр чтобы отменить кодирование многобайтных символов
			
			
			if( $_FILES["img"]["error"] == UPLOAD_ERR_OK )

				if ( is_uploaded_file($_FILES["img"]["tmp_name"])) {
						$tmpPath = $_FILES["img"]["tmp_name"];// путь к файлу
						$toBuffer = file_get_contents($tmpPath); // весь файл полностью 
						$type = mime_content_type($tmpPath); // MIME тип файла
					} 
			
			add_product($category, $name, $description, $img, $property, $price);
		}
	
	db_close();
?>
<!DOCTYPE html>
<html>

<head>
	<?php require_once "block/head.php"; ?>
	
	<link rel="stylesheet" href="css/add.css">
	<script src="js/add.js"></script>
</head>

<body>

	<?php 
		require_once "block/header.php"; // шапка сайта
		require_once "block/nav.php"; // меню 
	?>
	
	<main>
		
		<h2>Добавление</h2>
				
		<!-- Форма служит так же для отправки файла изображения -->
		<form id="product" class="add" method="post" enctype="multipart/form-data">
			<!-- Общая информация -->
			<div class="box">
				<label>Категория продукта</label>
				<select name="category">
					<option value="Сказки" selected>Сказки</option>
					<option value="Поэзия">Поэзия</option>
					<option value="Юмор">Юмор</option>
					<option value="Русская литература">Русская литература</option>
				</select>
				
				<label>Название</label>
				<input type="text" placeholder="Название" name="name" maxlength="50" required>
				
				<label>Выберите изображение</label>
				<input type="file" name="img" accept="image/jpeg,image/png">
				
				<label>Описание</label>
				<textarea placeholder="Описание выдаваемое при поиске" name="description" required rows="4" style="resize: none;" maxlength="255"></textarea>
				
				<label>Цена</label>
				<input type="number" placeholder="Цена за один товара" name="price"  required>
				
				<label>Характеристики</label>
				<div id="listProperty"></div>
				<button onclick="addProperty()" type="button">Добавить</button>
				<button onclick="deleteProperty()" type="button">Удалить</button>
			</div>
			
			<input type="submit" name="product" value="Записать в БД">
			
		</form>
		
		
		
	</main>
	

</body>

</html>