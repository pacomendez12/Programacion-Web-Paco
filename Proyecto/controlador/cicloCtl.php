<?php
	include('controlador/genericCtl.php');
	class CicloCtl extends generic{
		/*atributos*/
		public $modelo;
		
		/*constructor*/
		function __construct($driver) {
			/*cargar modelo*/
			require_once("modelo/cicloMdl.php");
			$this->modelo = new CicloMdl($driver);
		}
	
		function ejecutar() {
			/*recibir acción*/
			switch($_GET["acc"]) {
				case "nuevo":
					if(empty($_POST)){
					/*	require_once("vista/registro.html");*/
						self::generarVista('nuevo_ciclo_escolar.html',true);
					}
					 else {
					 	/*obtener datos de POST*/
					 	/*$codigo = $con->real_escape_string($_POST["codigo"]);*/
					 	$codigo = $_POST["codigo"];
					 	$nombre = $_POST["nombre"];
					 	$apellidos = $_POST["apellido"];
					 	$correo = $_POST['correo'];
					 	$carrera = $_POST['carrera'];
					 	unset($_POST);
						$resultado = $this->modelo->alta($codigo,$nombre,$apellidos, $correo, $carrera);
						if($resultado !== false){
							/*require_once("vista/listaAlumnoView.html");*/
							self::generarVista('listaAlumnoView.html',true);
						}else{
							require_once("vista/error.html");
						}
					}
				break;
			}
		}
	}
?>
