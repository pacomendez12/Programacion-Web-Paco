<?php
	require_once('datos.inc');
	$driver = new mysqli($servidor, $usuario, $contrasena, $DB);
	if($driver->connect_errno){
		die("no se pudo conectar");
	}
	
	session_start();


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
		case 'upload':
			require_once("controlador/uploadCtl.php");
			$ctl = new UploadCtl($driver);
			break;	
		case 'configurar':
			require_once("controlador/configurarCtl.php");
			$ctl = new ConfigurarCtl($driver);
			break;
		case 'profesor':
			require_once("controlador/profesorCtl.php");
			$ctl = new ProfesorCtl($driver);
			break;
		default:
		case 'curso':
			require_once("controlador/cursoCtl.php");
			$ctl = new CursoCtl($driver);
			break;
		default:
			//require_once("controlador/principalCtl.php");
			//$ctl = new PrincipalCtl($driver);
			header('location: index.php?ctl=login');
			break;
	}
}else 
	if(!isset($_SESSION['codigo']))
	{
		require_once("controlador/principalCtl.php");
		$ctl = new PrincipalCtl($driver);
	}
	else{
		header('location:index.php?ctl=login');
	}
$ctl->ejecutar();
?>