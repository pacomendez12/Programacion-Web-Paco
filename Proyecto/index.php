<?php
	require_once('datos.inc');
	$driver = new mysqli($servidor, $usuario, $contrasena, $DB);
	if($driver->connect_errno){
		die("no se pudo cnectar");
	}
	
	//$driver=null;
		
	/*recibir variables de la url*/
	if(isset($_GET["ctl"])) {
	switch($_GET["ctl"]){
		case "alumno":
			/*cargo el controlador*/
			require_once("controlador/alumnoCtl.php");
			$ctl = new AlumnoCtl($driver);
			break;
		case "ciclo":
			require_once("controlador/cicloCtl.php");
			$ctl = new CicloCtl($driver);
			break;
		case 'login':
			require_once("controlador/loginCtl.php");
			$ctl = new LoginCtl($driver);
			break;
		case 'recupera':
			require_once("controlador/recuperaCtl.php");
			$ctl = new RecuperaCtl($driver);
			break;
		default:
			require_once("controlador/principalCtl.php");
			$ctl = new PrincipalCtl($driver);
	}
}else{
require_once("controlador/principalCtl.php");
			$ctl = new PrincipalCtl($driver);
			}

/*...*/


$ctl->ejecutar();

?>
