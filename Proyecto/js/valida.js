
function validaFormularioRegistro() {
	var form = document.getElementById("registro");
		
	
	if (validaNumero(form.codigo.value) == "") {
		var msg = document.createTextNode('Ingresa el código');
		var error = document.getElementById("error");
		error.appendChild(msg);
		error.setAttribute('class', 'errorV');
		form.codigo.focus();
		setTimeout("error.setAttribute('class', 'errorI')", 3000);
		return 0;
	} else if (form.nombre.value == "") {
		var msg = document.createTextNode('Ingresa un nombre');
		var error = document.getElementById("error");
		error.appendChild(msg);
		error.setAttribute('class', 'errorV');
		form.codigo.focus();
		setTimeout("error.setAttribute('class', 'errorI')", 3000);
		return 0;
	}


	else {
		form.submit();
	}
}

function ocultaError() {
	var error = document.getElementById("error");
	error.setAttribute();
}

function pausecomp1(millis)
{
var date = new Date();
var curDate = null;

do { curDate = new Date(); }
while(curDate-date < millis);
} 

function pausecomp(ms) {
ms += new Date().getTime();
while (new Date() < ms){}
} 

function delay(milisegundos)
{
	for(i=0;i<=milisegundos;i++)
	{
		setTimeout('return 0',1);
	}
}

function validaNumero(numero) {
	var n = parseInt(numero);
	
	if (isNaN(n)) {
		return "";
	}else {
		return n;
	}

}