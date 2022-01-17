"use strict";

// удаление сообщения с экрана пользователя по нажатию на крестик в сообщении
function msgClose(id) {
	
	var msg = document.getElementById(id);
	var my_parent = msg.parentElement;
	
	my_parent.removeChild(msg);
	
	
}