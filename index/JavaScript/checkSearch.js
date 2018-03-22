function setupSearch() {
	var input = document.getElementById("ricerca");
	input.className = "ricPlaceholder";
	input.value = "Cerca qui...";
	input.onfocus = function(){ clear(this); };
	input.onblur = function(){ validateSearch(this); };
}

function clear() {
	var input = document.getElementById("ricerca");
	if (input.value == "Ricerca non valida" || input.value == "Cerca qui...")
		input.value=""; 
	input.removeAttribute("class");
}

function validateSearch() {
	var input = document.getElementById("ricerca");
	if (input.value == "Cerca qui...") {
		input.value = "";
		return true;
	}
	var regex = /(^$|^[\w \u00C0-\u017F,.'-/]{2,30}$)/i;
	if ((input.value).search(regex) != 0 || input.value == "Ricerca non valida") {
		input.className = "errin";
		input.value="Ricerca non valida";
		return false;
	}
	return true;
}