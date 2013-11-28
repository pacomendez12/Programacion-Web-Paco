<?php
require_once('../datos.inc');
$driver = new mysqli($servidor, $usuario, $contrasena, $DB);
if($driver->connect_errno){
	die("no se pudo conectar");
}

$ciclo = trim($driver->real_escape_string($_POST['ce']));
$res_a_enviar = false;

$query = "insert into dias_de_suspension values (default,'0000-00-00','','$ciclo')";
$result = $driver->query($query);
$res_a_enviar = true;
if($result == 0){
	$res_a_enviar = false;
}
echo json_encode($res_a_enviar);
$driver->close();