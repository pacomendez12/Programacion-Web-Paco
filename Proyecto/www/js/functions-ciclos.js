cont = 1; 
sig = 0;
function nuevoDiaFestivo() {
	
	$.ajax({
		type: 'POST',
		url: 'php/siguienteDiaFestivo.php',
		dataType: 'json',
		success: function(json){
			json = parseInt(json);
			alert(json);
			if(json > 0){
				sig = json; 	
				var form = document.getElementById("contenedor");
				var ultimo = document.getElementById("fin-dias").previousSibling;
				var fin = document.getElementById("fin-dias");
				nuevoDia = ultimo.cloneNode(true);
				//alert(nuevoDia.id);
				nuevoDia.setAttribute("id","dia-festivo"+sig);
				nuevoDia.setAttribute("style","display:block");
				nuevoDia.firstChild.nextSibling.setAttribute("onclick","eliminaDiaFestivo("+sig+")");
				nuevoDia.firstChild.nextSibling.nextSibling.nextSibling.firstChild.nextSibling.setAttribute("for","fecha"+sig);
				nuevoDia.firstChild.nextSibling.nextSibling.nextSibling.firstChild.nextSibling.nextSibling.nextSibling.setAttribute("id","fecha"+sig);
				nuevoDia.firstChild.nextSibling.nextSibling.nextSibling.firstChild.nextSibling.nextSibling.nextSibling.setAttribute("name","fecha"+sig);
				nuevoDia.firstChild.nextSibling.nextSibling.nextSibling.firstChild.nextSibling.nextSibling.nextSibling.value="";
				nuevoDia.firstChild.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.firstChild.nextSibling.setAttribute("for","motivo"+sig);
				nuevoDia.firstChild.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.firstChild.nextSibling.nextSibling.nextSibling.setAttribute("id","motivo"+sig);
				nuevoDia.firstChild.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.firstChild.nextSibling.nextSibling.nextSibling.setAttribute("onblur","verificaMotivoDiaFestivo("+sig+")");
				nuevoDia.firstChild.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.firstChild.nextSibling.nextSibling.nextSibling.setAttribute("name","motivo"+sig);
				nuevoDia.firstChild.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.firstChild.nextSibling.nextSibling.nextSibling.value="";
				form.insertBefore(nuevoDia,fin);
				ob = document.getElementById("fecha"+sig);
				creaCalendario(ob);
				$.ajax({
					type: 'POST',
					data: {ce:document.getElementById('nombre').value},
					url: 'php/nuevoDiaFestivo.php',
					dataType: 'json',
					success: function(json){
						if(json != true){
							muestraError(null,"No se pudo agregar el día festivo, error de conexión a la base de datos");
						}
					}
				});		
			}else{
				muestraError(null,"Error intentando conectar a la base de datos");
				return 0;
			}
		}
	});

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
	var diaf = document.getElementById("dia-festivo"+dia);
	$.ajax({
		type: 'POST',
		data: {i:dia},
		url: 'php/eliminaDiaFestivo.php',
		dataType: 'json',
		success: function(json){
			if(json == true){
				form.removeChild(diaf);
				muestraNotificacion("Se ha eliminado el día festivo");
			}else{
				muestraNotificacion("No se pudo eliminar el día festivo");
			}
		}
	});	
}

function verificaFechaDiaFestivo(dia){
//verifica que el día sea correcto y
//hace la conexión asincrona para guardarlo
	inp = document.getElementById("fecha"+dia);
	if(!inp.value.match(exprFecha)){
		muestraError(inp,"El campo fecha no tiene formato válido");
	}else{
		actualizaDiaFestivo(inp,document.getElementById("motivo"+dia),dia);
	}
}

function verificaMotivoDiaFestivo(dia){
//verifica que el día sea correcto y
//hace la conexión asincrona para guardarlo
	inp = document.getElementById("motivo"+dia);
	fec = document.getElementById("fecha"+dia);
	if(inp.value.length <= 0){
		muestraError(inp,"Debe indicar el motivo");
	}else if(!fec.value.match(exprFecha)){
		muestraError(fec,"El formato de la fecha es inválido (dd/mm/aaaa)");
	}else{
		actualizaDiaFestivo(document.getElementById("fecha"+dia),inp,dia);
	}
}

function actualizaDiaFestivo(fecha,motivo,id){
	$.ajax({
		type: 'POST',
		data: {fe:fecha.value,mo:motivo.value,i:id},
		url: 'php/actualizaDiaFestivo.php',
		dataType: 'json',
		success: function(json){
			if(json == true){
				muestraNotificacion("Se ha modificado con éxito el día festivo");
			}else{
				muestraNotificacion("No se pudo modificar el día festivo");
			}
		}
	});
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
		url: 'php/consultaNombreCodigo.php',
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
