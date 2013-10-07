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
}

function quitarDiaFestivo() {
	if(cont>1){
		var form = document.getElementById("contenedor");
		var fin = document.getElementById("fin-dias");
		form.removeChild(fin.previousSibling);
		cont--;
	}

}