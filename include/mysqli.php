<?php

// параметры подключения 
	$host = "localhost";// хост
	$login = "root";	// логин / пароль пользователя
	$password = "";
	$db = "babak_db";	// имя БД

// объект соединения
	$conn = FALSE; // соединений на данном этапе нет
	
	
	/* Подключение к БД */
	function db_connect($host = "localhost", $login = "root", $password = "", $db = "babak_db") {
		global $conn;
		$err = false; // ошибок нет
		
		$conn = @mysqli_connect($host, $login, $password, $db);
		if($conn) 
			return $err; // connection OK
		else {
			return $err = true; // сообщаем об ошибке
		}
	}
	
	/* Закрытие соединения */
	function db_close() {
		@mysqli_close($GLOBALS["conn"]);
	}
	
	/* Регистрация пользователя */
	function add_usr($login, $password, $status = "login") {
		global $conn;
		$salt = get_salt();
		$password = hash("sha256", $password . $salt);
		
		$query = "INSERT INTO login VALUES(NULL, '$login', '$password', '$salt', '$status')";
		mysqli_query($conn, $query);
	}
	
	function add_product($category, $name, $description, $img, $property, $price) {
		global $conn;
		$query = "INSERT INTO product VALUES(NULL, '$category', '$name', '$description', '$img', '$property', $price)";
		
		mysqli_query($conn, $query);
	}
	
#######################################################################################################
	
	// проверка пары логин/пароль
	function db_user($login, $password) {
		global $conn;
		$query = "SELECT * FROM login WHERE login = '$login'";
		
		$result = mysqli_query($conn, $query);
		if( mysqli_num_rows($result) != 0 ) {
			
			$row = mysqli_fetch_assoc($result);
			$password = hash("sha256", $password . $row["salt"]);
			
			return strcmp($password, $row["password"]);
		} else
			return TRUE;
	}
	
	function update_password($login, $password) {
		global $conn;
		$salt = get_salt(); // новый пароль - новая соль
		$password = hash("sha256", $password . $salt);
		
		$query = "UPDATE usr SET password = '$password', salt = '$salt' WHERE login = '$login'";
		
		mysqli_query($conn, $query);
	}
	
	// проверка на существование пользователя
	function db_check_usr($login) {
		global $conn;
		$query = "SELECT * FROM login WHERE login = '$login'";
		
		$result = mysqli_query($conn, $query);
		
		return mysqli_num_rows($result) != 0; // смотрим на количество строк результирующего запроса
	}
	
	// уникальная соль
	function get_salt() {
		return md5(uniqid() . time . mt_rand());
	}
	
// формируем из результурующей таблицы один массив
	function rowSet($result) {
		$fetchArray = array();
		
		while($row = mysqli_fetch_assoc($result))
			array_push($fetchArray, $row);
		
		return $fetchArray;
	}
	
	function get_product($id = ""){
		global $conn;
		$query = $id === "" ? "SELECT * FROM product" : "SELECT * FROM product WHERE id = $id";

		
		$result = mysqli_query($conn, $query);
		if(mysqli_num_rows($result) > 0)
			return rowSet($result);
	}
	
	
	function db_select($table = "", $where = "") {
		global $conn;
		$table = $table == "" ? "product" : $table;
		$where = $where == "" ? "" : " WHERE $where";
		$query = "SELECT * FROM $table $where";

		
		$result = mysqli_query($conn, $query);
		if(mysqli_num_rows($result) > 0)
			return rowSet($result);
	}
	
	function get_user_status($login) {
		global $conn;
		$query = "SELECT status FROM login WHERE login = '$login'";
		
		
		$result = mysqli_query($conn, $query);
		
		return mysqli_fetch_array($result)["status"];
	}
	
	function db_update_product($id, $name, $description, $property, $price) {
		global $conn;
		$query = "UPDATE product SET name='$name', description='$description', property='$property', price='$price' WHERE id=$id";


		mysqli_query($conn, $query);
	}
	
	function db_delete_product($id) {
		global $conn;
		$query = "DELETE FROM product WHERE id=$id";
		
		
		mysqli_query($conn, $query);
		
	}
	