<?php
$mysql = new mysqli('localhost','paco','paco','proyecto');

$id = $_POST['id_alumno'];

$consulta = "SELECT * FROM alumno WHERE id_alumno = $id";
$resultado = $mysql->query($consulta);

$alumno = $resultado->fetch_assoc();

echo json_encode($alumno);

$mysql->close();

?>
