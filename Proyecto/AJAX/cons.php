<?php
$mysql = new mysqli('localhost','paco','paco','proyecto');

$consulta = 'SELECT * FROM alumno';
$resultado = $mysql->query($consulta);

while($row = $resultado->fetch_assoc())
	$alumnos[] = $row;

echo json_encode($alumnos);

$mysql->close();

?>
