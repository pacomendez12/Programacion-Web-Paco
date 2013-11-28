<?php


require_once "dompdf/dompdf_config.inc.php";

//crar objeto
$dompdf = new DOMPDF();

//generar html
$html = '
	<body>
		<div>hola</div>
	</body>';

//obtenemos el html en una caddena
//también se puede obtener desde una archivo con load_html_file()
	
	//$dompdf->load_html($html);
	$dompdf->load_html_file('http://localhost/vista/nuevo_ciclo_escolar.html');

	//convertimos el html a pdf
	$dompdf->render();

	//enviamos el pdf al navegador con el nombre del archivo
	//el segundo parámetro es para indicar si se envía como adjunto
	//por default es true
	$dompdf->stream('hello.pdf');

	//para obtener el pdf como un archivo en el server y guardarlo
	$pdf = $dompdf->output();
	file_put_contents('hello.pdf',$pdf);


