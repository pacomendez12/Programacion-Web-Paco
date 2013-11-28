<?php
	require_once('../datos.inc');
	$driver = new mysqli($servidor, $usuario, $contrasena, $DB);
	if($driver->connect_errno){
		die("no se pudo conectar");
	}

	include('validador.php');
	$id = trim($driver->real_escape_string($_POST['i']));
	
	$query = "update dias_de_suspension set nombre_ciclo_escolar=null where id_dia=$id";
	$result = $driver->query($query);
	$res_a_enviar = true;
	if($result == 0){
		$res_a_enviar = false;
	}
	
	echo json_encode($res_a_enviar);
	$driver->close();
?>