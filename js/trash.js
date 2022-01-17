

function productInTrash(id){
	
	var query = "?product=" + id; // передача параметров через адресную строку
	var resourcePath = "include/trash.php";
	var uri = resourcePath + query;
	
	var xhr = new XMLHttpRequest(); // создаём новый экземляр объекта
		
		// метод запроса, адрес URL ресурса, асинхроность/синхроность
		xhr.open("GET", uri, true);// aсинхроно
		
		xhr.onreadystatechange = function() {
			
			
			if(xhr.readyState == 4 && xhr.status == 200) {
				
				var res = xhr.responseText;
				var a = document.getElementById("trash-menu-txt"); // меню в заголовке
				
				a.innerHTML = "Корзина - " + res + " товар";
				
			}
		}
		
		xhr.send();
}