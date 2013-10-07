<?php
	//conexion a la base
	$con = new mysqli('localhost', 'cc409_user106', 'bNLQSfu005', 'cc409?user106');
	if($con->connect_errno){
		echo "Error con la conexión a la bd";
		exit();
		//die("Error con la conexión a la bd");	igual a lo anterior

	}

	var_dump($_POST);
	$n = $_POST['usuario'];
	$c = $_POST['contrasena'];
	
	$miquery = "INSERT INTO alumno
						(nombre, email)
						VALUES (
							\"$n\",
							\"$c\"
						)";
	$resultado = $con->query($miquery);
	if($resultado === FALSE){
		echo $con->errno.$con->error;
	}

	echo "id insertado: ".$con->insert_id;
	$con->errno; //guarda si hubo error en el query

	var_dump($resultado);

	//var_dump($con);
?>