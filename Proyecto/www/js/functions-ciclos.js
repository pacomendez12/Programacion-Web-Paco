cont = 1; 

function nuevoDiaFestivo() {
	var form = document.getElementById("contenedor");
	var ultimo = document.getElementById("dia-festivo"+cont);
	cont++;
	var fin = document.getElementById("fin-dias");
	nuevoDia = ultimo.cloneNode(true);
	nuevoDia.setAttribute("id","dia-festivo"+cont);
	nuevoDia.firstChild.nextSibling.firstChild.nextSibling.setAttribute("for","fecha"+cont);
	nuevoDia.firstChild.nextSibling.firstChild.nextSibling.nextSibling.nextSibling.setAttribute("id","fecha"+cont);
	nuevoDia.firstChild.nextSibling.firstChild.nextSibling.nextSibling.nextSibling.setAttribute("name","fecha"+cont);
	nuevoDia.firstChild.nextSibling.firstChild.nextSibling.nextSibling.nextSibling.value="";
	nuevoDia.firstChild.nextSibling.nextSibling.nextSibling.firstChild.nextSibling.setAttribute("id","motivo"+cont);
	nuevoDia.firstChild.nextSibling.nextSibling.nextSibling.firstChild.nextSibling.nextSibling.nextSibling.setAttribute("id","motivo"+cont);
	nuevoDia.firstChild.nextSibling.nextSibling.nextSibling.firstChild.nextSibling.nextSibling.nextSibling.setAttribute("name","motivo"+cont);
	nuevoDia.firstChild.nextSibling.nextSibling.nextSibling.firstChild.nextSibling.nextSibling.nextSibling.value="";
	form.insertBefore(nuevoDia,fin);
	creaCalendario("fecha"+cont);
}

function quitarDiaFestivo() {
	if(cont>1){
		var form = document.getElementById("contenedor");
		var fin = document.getElementById("fin-dias");
		form.removeChild(fin.previousSibling);
		cont--;
	}

}

function eliminaDiaFestivo(dia) {
	var form = document.getElementById("contenedor"); 
	var dia = document.getElementById("dia-festivo"+dia);
	form.removeChild(dia);
}

function verificaNombre(nombre){
	n = document.getElementById('nombre');
	if (!exprCiclo.test(n.value)) {
		muestraError(n,"Ingresa un nombre válido para el ciclo con el formato adecuado");
		n.value == "";
	}else{
	$.ajax({
		type: 'POST',
		data: {nom:nombre},
		url: 'consultaNombreCodigo.php',
		dataType: 'json',
		success: function(json){
			if(json == false){
				muestraError(n,"Ya existe un ciclo con ese nombre");
				n.value = "";
			}
		}
	});
	}
}
