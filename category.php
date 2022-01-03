<?php
	require_once "include/session.php";
	require_once "include/mysqli.php";
	
	define("MAX_PRODUCTS_ON_PAGE", 4);
	
	if(!empty($_GET["category"])) {
		$category = $_GET["category"];
	
		db_connect();
		
		// многомерный массив с результирующей таблицей
		$result = db_select("product", "category='$category'");
		
		db_close();
	} else
		header("Location: /");
?>
<!DOCTYPE html>
<html>

<head>
	<?php require_once "block/head.php"; ?>
	
	<link rel="stylesheet" href="css/category.css">
</head>

<body>

	<?php 
		require_once "block/header.php"; // шапка сайта
		require_once "block/nav.php"; // меню 
	?>
	
	<main>
		<?php
			$count_article = 0;
			
			foreach($result as $key => $val) {
				$id = $val["id"];
				$name = $val["name"];
				$price = $val["price"];
				$decsription = $val["description"];
				$img = $val["img"] == "" ? "img/Shablon.jpg" : $val["img"];
				
				$count_article++;
				
				switch($_SESSION["status"]) {
					case "user":
						$article = <<<_OUT
						<article id="$id">
							<header class="name">$name</header>
							<div class="wrap">
								<figure>
									<img src="$img">
								</figure>
							
							<p class="description">$decsription</p>
							</div>
							<footer class="price">$price</footer>
							<a href="viewer.php?product=$id" class="btn">Посмотреть</a>
							<button type="button" onclick="productInTrash($id)">Заказать</button>
						</article>
_OUT;
						break;
						
					case "admin":
						$article = <<<_OUT
						<article id="$id">
							<header class="name">$name</header>
							<div class="wrap">
								<figure>
									<img src="$img">
								</figure>
							
							<p class="description">$decsription</p>
							</div>
							<footer class="price">$price</footer>
							<a href="viewer.php?product=$id" class="btn">Посмотреть</a>
							<button type="button" onclick="productInTrash($id)">Заказать</button>
							<a class="tools" href="edit.php?product=$id"><img src="img/edit.png"></a>
							<a class="tools" href="delete.php?product=$id"><img src="img/delete.png"></a>
						</article>
_OUT;
						break;
					
					default:
						$article = <<<_OUT
						<article id="$id">
							<header class="name">$name</header>
							<div class="wrap">
								<figure>
									<img src="$img">
								</figure>
							
							<p class="description">$decsription</p>
							</div>
							<footer class="price">$price</footer>
							<a href="viewer.php?product=$id" class="btn">Посмотреть</a>
						</article>
_OUT;
					break;
				}
				
				echo $article;
				
			}
			
		?>
		
		
	</main>

</body>
<footer>	
	<?php 
	require_once "block/footer.php"; // подвал
	?>
</footer>
</html>