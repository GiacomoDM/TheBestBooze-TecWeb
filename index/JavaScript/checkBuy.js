var checkBuy = {
	"inInd": ["Via Esempio, 1", /^[\w \u00C0-\u017F,.'-/]{2,30}$/i, "Inserire via e numero civico"],
	"inCitta": ["Città", /^[a-z \u00C0-\u017F ,.'-]{2,30}$/i, "Inserire una città con massimo 30 caratteri"],
	"inNum": ["Numero carta (solo numeri)", /^\d{4,16}$/, "Inserire solo cifre, massimo 16"]
}

var checkBuy1 = {
	"inInd": ["Via Esempio, 1", /^[\w \u00C0-\u017F,.'-/]{2,30}$/i, "Inserire via e numero civico"],
	"inCitta": ["Città", /^[a-z \u00C0-\u017F ,.'-]{2,30}$/i, "Inserire una città con massimo 30 caratteri"]
};

var checkBuy2 = {
	"inNum": ["Numero carta (solo numeri)", /^\d{4,16}$/, "Inserire solo cifre, massimo 16"]
}

function setupBuy() {
	for (var key in checkBuy) {
		var input = document.getElementById(key);
		inputDefault(input);
		input.disabled = "disabled";
	}
}

function radioActivate (selected) {
	var r = document.getElementById(selected);
	if (r.checked) {
		if (selected == "newaddr")
			activateInput(checkBuy1);
		else 
			activateInput(checkBuy2);
	}
}

function deactivateInput (selected) {
	if (selected == "predaddr") {
		for (var key in checkBuy1) {
			var input = document.getElementById(key);
			input.disabled = "disabled";
			inputDefault(input);
			var p = input.parentNode;
			if (p.children.length == 2) {
				p.removeChild(p.children[1]);
			}
		}
	}
	else {
		for (var key in checkBuy2) {
			var input = document.getElementById(key);
			input.disabled = "disabled";
			inputDefault(input);
			var p = input.parentNode;
			if (p.children.length == 2) {
				p.removeChild(p.children[1]);
			}
		}
	}
}

function activateInput (checkSpace) {
	for (var key in checkSpace) {
		var txtField = document.getElementById(key);
		txtField.disabled = false;
		txtField.onfocus = function(){ clearIn(this, checkSpace); };
		txtField.onblur = function(){ validateIn(this, checkSpace); };
	}
}

function inputDefault(input) {
	if (input.value == "") {
		input.className = "nojsalert";
		input.value = checkBuy[input.id][0];
	}
}

function clearIn(input, checkSpace) {
	if (input.value == checkSpace[input.id][0]) {
		input.value = "";
		input.className = "";
	}
}

function validateIn(input, checkSpace) {
	var p = input.parentNode;
	if (p.children.length == 2) {
		p.removeChild(p.children[1]);
	}
	var regex = checkSpace[input.id][1];
	var text = input.value;
	if ((text == checkSpace[input.id][0]) || (text.search(regex) != 0)) {
		inputError(input, checkSpace);
		return false;
	}
	return true;
}

function inputError(input, checkSpace) {
	var p = input.parentNode;
	var e = document.createElement("p");
	e.className = "errin";
	e.innerHTML=checkSpace[input.id][2];
	p.appendChild(e);
}

function callValidateAll() {
	var c1 = document.getElementById("newaddr");
	var c2 = document.getElementById("newpay");
	if (c1.checked && c2.checked )
		return validateAll(checkBuy);
	if (c1.checked)
		return validateAll(checkBuy1);
	if (c2.checked)
		return validateAll(checkBuy2);
}

function validateAll(checkSpace) {
	var done = true;
	for(var key in checkSpace) {
		var input = document.getElementById(key);
		var validate = validateIn(input, checkSpace);
		if (validate && input.value == checkSpace[input.id][0])
			input.value = "";
		done = done && validate;
	}
	return done;
}