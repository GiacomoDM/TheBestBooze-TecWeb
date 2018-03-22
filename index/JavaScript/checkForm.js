var checkIscr = {
	"inEmail": ["esempio@esempio.es", /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/ , "Formato <span xml:lang=\"en\">e-mail</span> errato"],
	"inPasswd": ["", /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/ , "La <span xml:lang=\"en\">password</span> deve essere di almeno 8 caratteri e contenere almeno una maiuscola, una minuscola ed un numero"],
	"inPasswd2": ["", /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/ , "Le <span xml:lang=\"en\">password</span> non corrispondono o non sono valide"],
	"inData": ["GG/MM/AAAA", /^[0-3][0-9]\/[0-1][0-9]\/[0-2][0-9]{3}$/, "Data non nel formato GG/MM/AAAA o utente minorenne"],
	"inNome": ["Nome", /^[a-z \u00C0-\u017F,.'-]{2,30}$/i, "Inserire un nome compreso tra 2 e 30 caratteri"],
	"inCognome": ["Cognome", /^[a-z \u00C0-\u017F,.'-]{2,30}$/i, "Inserire un cognome compreso tra 2 e 30 caratteri"],
	"inNum": ["Numero carta (solo numeri)", /^\d{4,16}$/, "Inserire solo cifre, massimo 16"],
	"inIVA": ["Partita IVA", /^[A-Z1-9]{4,15}$/, "Inserire solo numeri e lettere maiuscole, massimo 15"],
	"inInd": ["Via Esempio, 1", /^[\w \u00C0-\u017F,.'-/]{2,30}$/i, "Inserire via e numero civico"],
	"inCitta": ["Città", /^[a-z \u00C0-\u017F ,.'-]{2,30}$/i, "Inserire una città con massimo 30 caratteri"],
	"inTel": ["Telefono (solo numeri)", /^\d{7,15}$/, "Inserire solo cifre, massimo 15"]
};

var checkMod = {
	"inEmail": ["esempio@esempio.es", /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/ , "Formato <span xml:lang=\"en\">e-mail</span> errato"],
	"inNewPasswd": ["", /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/ , "La <span xml:lang=\"en\">password</span> deve essere di almeno 8 caratteri e contenere almeno una maiuscola, una minuscola ed un numero"],
	"inNewPasswd2": ["", /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/ , "Le <span xml:lang=\"en\">password</span> non corrispondono o non sono valide"],
	"inData": ["GG/MM/AAAA", /^[0-3][0-9]\/[0-1][0-9]\/[0-2][0-9]{3}$/, "Data non nel formato GG/MM/AAAA o utente minorenne"],
	"inNome": ["Nome", /^[a-z \u00C0-\u017F,.'-]{2,30}$/i, "Inserire un nome compreso tra 2 e 30 caratteri"],
	"inCognome": ["Cognome", /^[a-z \u00C0-\u017F,.'-]{2,30}$/i, "Inserire un cognome compreso tra 2 e 30 caratteri"],
	"inNum": ["Numero carta (solo numeri)", /^\d{4,16}$/, "Inserire solo cifre, massimo 16"],
	"inIVA": ["Partita IVA", /^[A-Z1-9]{4,15}$/, "Inserire solo numeri e lettere maiuscole, massimo 15"],
	"inInd": ["Via Esempio, 1", /^[\w \u00C0-\u017F,.'-/]{2,30}$/i, "Inserire via e numero civico"],
	"inCitta": ["Città", /^[a-z \u00C0-\u017F ,.'-]{2,30}$/i, "Inserire una città con massimo 30 caratteri"],
	"inTel": ["Telefono (solo numeri)", /^\d{7,15}$/, "Inserire solo cifre, massimo 15"]
};

var checkLogIn = {
	"inEmail": ["esempio@esempio.es", /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/ , "Formato <span xml:lang=\"en\">e-mail</span> errato"],
	"inPasswd": ["", /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/ , "Coppia <span xml:lang=\"en\">e-mail</span> e <span xml:lang=\"en\">Password</span> non corretta"]
};

var checkAm = {
	"inputNome": ["", /^[\w ]{2,30}$/i, "<span xml:lang=\"en\">Log-In</span> non valida"],
	"inputPasswd": ["", /^[\w ]{2,30}$/i , "<span xml:lang=\"en\">Password</span> non corretta"]
};

var checkBuy = {
	"inInd": ["Via Esempio, 1", /^[\w \u00C0-\u017F,.'-/]{2,30}$/i, "Inserire via e numero civico"],
	"inCitta": ["Città", /^[a-z \u00C0-\u017F ,.'-]{2,30}$/i, "Inserire una città con massimo 30 caratteri"],
	"inNum": ["Numero carta (solo numeri)", /^\d{4,16}$/, "Inserire solo cifre, massimo 16"]
};

var checkProd = {
	"inNome": ["Nome", /^[\w \u00C0-\u017F,.'-/]{2,30}$/i, "Inserire un nome compreso tra 2 e 30 caratteri"],
	"inPrezzo": ["Prezzo (massimo 6 cifre più due dopo il punto)", /^\d{1,6}((\,|\.)\d{2})?$/ , "Inserire un prezzo valido, massimo 999999.99"],
	"inSottocat": ["Sottocategoria", /^[\w \u00C0-\u017F,.'-/]{2,30}$/i, "Inserire un nome entro i 50 caratteri"],
	"inAnno": ["AAAA", /^[0-2][0-9]{3}$/, "Inserire l'anno espresso in AAAA"],
	"inProduttore": ["Produttore", /^[\w \u00C0-\u017F,.'-/]{2,30}$/i, "Inserire un nome compreso tra 2 e 30 caratteri"]
};

var checkQta = {
	"Qta": ["0", /^([1-9][0-9][0-9]|[1-9][0-9]|[1-9])$/, "Inserire solo numeri, quantità massima 999"]
};

var facoltativi = ["inNewPasswd", "inNewPasswd2", "inIVA", "inTel", "inSottocat", "inAnno"];

function callcheck(checkSpace) {
	removeHint();
	if (checkSpace == "checkLogIn")
		setupjs(checkLogIn);
	if (checkSpace == "checkIscr")
		setupjs(checkIscr);
	if (checkSpace == "checkMod")
		setupjs(checkMod);
	if (checkSpace == "checkBuy")
		setupjs(checkBuy);
	if (checkSpace == "checkProd")
		setupjs(checkProd);
	if (checkSpace == "checkQta")
		setupjs(checkQta);
	if (checkSpace == "checkAm")
		setupjs(checkAm);	
}

function removeHint() {
    var elements = document.getElementsByClassName("nojsalert");
    while (elements.length > 0){
        elements[0].parentNode.removeChild(elements[0]);
    }
}

function setupjs(checkSpace) {
	for (var key in checkSpace) {
		var input = document.getElementById(key);
		inputDefault(input, checkSpace);
		input.onfocus = function(){ clearIn(this, checkSpace); };
		input.addEventListener("blur", function(){ validateIn(this, checkSpace); });
	}
}

function inputDefault(input, checkSpace) {
	if (input.value == "") {
		input.className = "nojsalert";
		input.value = checkSpace[input.id][0];
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
	if (facoltativi.indexOf(input.id) != -1)
		return validateFac(input, checkSpace);
	else if ((text == checkSpace[input.id][0]) || (text.search(regex) != 0)) {
			inputError(input, checkSpace);
			return false;
		}
	return true;
}

function validateFac(input, checkSpace) {
	if (input.value == "" || input.value == checkSpace[input.id][0]) {
		input.value == "";
		return true;
	}
	else if ((input.value).search(checkSpace[input.id][1]) != 0) {
		inputError(input, checkSpace);
		return false;
	}
}

function inputError(input, checkSpace) {
	var p = input.parentNode;
	var e = document.createElement("p");
	e.className = "errin";
	e.innerHTML=checkSpace[input.id][2];
	p.appendChild(e);
}

function callValidateAll(checkSpace) {
	if (checkSpace == "checkLogIn")
		return validateAll(checkLogIn);
	if (checkSpace == "checkIscr")
		return validateAll(checkIscr);
	if (checkSpace == "checkMod")
		return validateAll(checkMod);
	if (checkSpace == "checkBuy")
		return validateAll(checkBuy);
	if (checkSpace == "checkProd")
		return validateAll(checkProd);
	if (checkSpace == "checkQta")
		return validateAll(checkQta);
	if (checkSpace == "checkAm")
		return validateAll(checkAm);
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

function checkPw() {
	var p1 = document.getElementById("inPasswd");
	var p2 = document.getElementById("inPasswd2");
	if (p1.value != p2.value) {
		var lung = (p2.value).length;
		p2.value = "";
		for (i=0; i<lung; i++) { 
			p2.value += "a";
		}
		validateIn(p2, checkIscr);
	}
}

function checkNewPw() {
	var p1 = document.getElementById("inNewPasswd");
	var p2 = document.getElementById("inNewPasswd2");
	if (p1.value != p2.value) {
		var lung = (p2.value).length;
		p2.value = "";
		for (i=0; i<lung; i++) { 
			p2.value += "a";
		}
		validateIn(p2, checkMod);
	}
}

function checkAdult(checkSpace) {
	var age = document.getElementById("inData");
	if (validateIn(age, checkIscr)) {
		var n = Date.now();
		var split = (age.value).split("/");
		var y = new Array();
		y.push(split[1]);
		y.push(split[0]);
		y.push(split[2]);
		var userAge = y.join("/");
		if (n - Date.parse(userAge) < 568025136000)
			age.value = "";
	}	
}