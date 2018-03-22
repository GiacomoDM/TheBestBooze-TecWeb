var checkQta = ["", /^([1-9][0-9][0-9]|[1-9][0-9]|[0-9])$/, "Inserire solo numeri, quantità massima 999"];

function validateQta(elem) {
	var input = document.getElementById(elem);
	var p = input.parentNode;
	if (p.children.length == 2) 
		p.removeChild(p.children[1]);
	var regex = checkQta[1];
	var text = input.value;
	if ((text == checkQta[0]) || (text.search(regex) != 0)) {
		inputError(input);
		input.value="";
		return false;
	}
	return true;
}

function inputError(input) {
	var p = input.parentNode;
	var e = document.createElement("p");
	e.className = "errin";
	e.innerHTML=checkQta[2];
	p.appendChild(e);
}