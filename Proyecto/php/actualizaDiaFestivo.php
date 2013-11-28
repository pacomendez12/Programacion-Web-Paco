<?php
	require_once('../datos.inc');
	$driver = new mysqli($servidor, $usuario, $contrasena, $DB);
	if($driver->connect_errno){
		die("no se pudo conectar");
	}

	include('validador.php');
	$fecha = trim($driver->real_escape_string(invierteFecha($_POST['fe'])));
	$motivo = trim($driver->real_escape_string($_POST['mo']));
	$id = trim($driver->real_escape_string($_POST['i']));
	$res_a_enviar = false;
	if(validaFechaInvertida($fecha)){
		$query = "update dias_de_suspension set fecha='$fecha', motivo='$motivo'  where id_dia=$id";
		$result = $driver->query($query);
		$res_a_enviar = true;
		if($result == 0){
			$res_a_enviar = false;
		}
	}
	echo json_encode($res_a_enviar);
	$driver->close();
?>