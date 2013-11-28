<?php
	require_once('../datos.inc');
	$driver = new mysqli($servidor, $usuario, $contrasena, $DB);
	if($driver->connect_errno){
		die("no se pudo conectar");
	}
	echo SiguienteIdDiaFestivo();
	$driver->close();


		function SiguienteIdDiaFestivo(){
			global $driver;
			$id = false;
			$resultado = $driver->query("SELECT MAX(id_dia) AS id FROM dias_de_suspension");
			if($fila = $resultado->fetch_array(MYSQLI_ASSOC)){
				if($fila['id']==NULL)
					$id = -1;
				else
					$id = trim($fila['id']);
			}
			return $id + 1;
		}
		