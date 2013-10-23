/*creaCalendario(fecha_inicio);
creaCalendario(fecha_fin);
creaCalendario(fecha1);*/

(function () {
	var fechas = document.getElementsByClassName("fecha");
	for (var i = 0; i < fechas.length;i++) {
		creaCalendario(fechas[i]);
	}
})();


           
function creaCalendario(entrada) {
	new Calendar({
	inputField: entrada,
	dateFormat: "%d/%m/%Y",
	trigger: entrada,
	bottomBar: false,
	onSelect: function() {
		var date = Calendar.intToDate(this.selection.get());
		LEFT_CAL.args.min = date;
		LEFT_CAL.redraw();
		this.hide();
	}
	});
}