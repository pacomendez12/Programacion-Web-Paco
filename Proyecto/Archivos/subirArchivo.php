<?php

//
echo '<br>';
var_dump($_FILES);

if(move_uploaded_file($_FILES['archivo']['tmp_name'], 'uploads/'.$_FILES['archivo']['name'])){
	echo "Se guardó el archivo";


}else{
	echo "hubo problemas al subir el archivo";
}





//forma larga
$archivo = 'archivo.csv';

//leer archivo
$cadena = file_get_contents($archivo);

//separar por renglones
$renglones = explode(PHP_EOL, $cadena);
foreach ($renglones as &$renglon) {
	$renglon = explode(',', $renglon);
}


//forma corta
$renglones = file($archivo);
//separa por comas
foreach ($renglones as &$renglon) {
	$renglon = explode(',', $renglon);
}


//con fgets

?>