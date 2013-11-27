<?php
	require_once('datos.inc');
	$driver = new mysqli($servidor, $usuario, $contrasena, $DB);
	if($driver->connect_errno){
		die("no se pudo conectar");
	}

	include('validador.php');
	$nombre = $_POST['nom'];
	$res_a_enviar = false;
	if(validaCiclo($nombre)){
		$query = "select nombre from ciclo_escolar where nombre='$nombre'";
		$result = $driver->query($query);

		if($result->num_rows == 0){
			$res_a_enviar = true;
		}
	}

	echo json_encode($res_a_enviar);
	$driver->close();
?>