
function validaFormularioRegistro() {
	var form = document.getElementById("registro");
	expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	
	if (validaNumero(form.codigo.value) == "") {
		var error = document.getElementById("error");
		document.getElementById("text-error").innerHTML = "Ingresa el código válido";
		error.setAttribute('class', 'errorV');
		form.codigo.focus();
		setTimeout("error.setAttribute('class', 'errorI')", 3000);
		return 0;
	} else if (form.nombre.value == "") {
		var error = document.getElementById("error");
		document.getElementById("text-error").innerHTML = "Ingresa un nombre";
		error.setAttribute('class', 'errorV');
		form.nombre.focus();
		setTimeout("error.setAttribute('class', 'errorI')", 3000);
		return 0;
	}
	else if (form.ap.value == "") {
		var error = document.getElementById("error");
		document.getElementById("text-error").innerHTML = "Ingresa un apellido";
		error.setAttribute('class', 'errorV');
		form.ap.focus();
		setTimeout("error.setAttribute('class', 'errorI')", 3000);
		return 0;
	}
	else if (form.carrera.value == "") {
		var error = document.getElementById("error");
		document.getElementById("text-error").innerHTML = "Ingresa una carrera";
		error.setAttribute('class', 'errorV');
		form.carrera.focus();
		setTimeout("error.setAttribute('class', 'errorI')", 3000);
		return 0;
	}
	else if (!expr.test(form.correo.value	)) {
		var error = document.getElementById("error");
		document.getElementById("text-error").innerHTML = "Ingresa un email válido";
		error.setAttribute('class', 'errorV');
		form.correo.focus();
		setTimeout("error.setAttribute('class', 'errorI')", 3000);
		return 0;
	}
	else {
		form.submit();
	}
}

function cerrarError(){
	error.setAttribute('class', 'errorI');
}


function activaCelular(){
	var cel = document.getElementById('celular');
	cel.disabled = !cel.disabled;
}



function oculta() {
	var error = document.getElementById("error");
	for(i = 100; i >=0  ; i--){
		error.setAttribute('opacity',i);
		setInterval("",100);
	}
	//error.setAttribute('class', 'errorI');
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
