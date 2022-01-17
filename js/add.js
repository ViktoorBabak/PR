
function addProperty() {
	var list = document.getElementById("listProperty");
	var items = document.createElement("div");
	var name = document.createElement("input");
	var val = document.createElement("input");
	
	// атрибуты для поля имени свойства
	name.setAttribute("type", "text");
	name.setAttribute("maxlength", "50");
	name.setAttribute("placeholder", "Название свойства");
	name.setAttribute("name", "property-name[]");// массив для имён свойств
	name.setAttribute("required", "");
	
	// атрибуты для поля значения
	val.setAttribute("type", "text");
	val.setAttribute("maxlength", "50");
	val.setAttribute("placeholder", "Значение свойства");
	val.setAttribute("name", "property-value[]");// массив для значений свойств
	val.setAttribute("required", "");
	
	items.classList.add("items");
	
	items.appendChild(name);
	items.appendChild(val);
	
	list.appendChild(items);
	
}


function deleteProperty() {
	var parent = document.getElementById("listProperty");
	
	if(parent.children.length != 0) {
		// удаление последнего элемента
		parent.removeChild(parent.lastElementChild);
	}
}