<?php

//Me conecto a la base de datos
$mysql = new mysqli('localhost','paco','paco','proyecto');

//Hago un query para obtener los alumnos
$consulta = 'SELECT * FROM alumno';
$resultado = $mysql->query($consulta);

//Proceso el resultado
while($row = $resultado->fetch_assoc())
	$alumnos[] = $row;

//Muestro el resultado
echo json_encode($alumnos);

//Cierro la conexion
$mysql->close();

?>
