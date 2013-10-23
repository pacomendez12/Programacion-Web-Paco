<?php
	class AlumnoCtl{
		/*atributos*/
		public $modelo;
		
		/*constructor*/
		function __construct() {
			/*cargar modelo*/
			require_once("modelo/alumnoMdl.php");
			$this->modelo = new AlumnoMdl();
		}
	
		function ejecutar() {
			/*recibir acción*/
			switch($_GET["acc"]) {
				case "alta":
					echo "<br>Debug: entró a alta en el controlador";
					if(empty($_POST))
						require_once("vista/registro.html");
					 else {
					 	/*obtener datos de POST*/
					 	/*$codigo = $con->real_escape_string($_POST["codigo"]);*/
					 	$codigo = $_POST["codigo"];
					 	$nombre = $_POST["nombre"];
					 	$apellidos = $_POST["apellido"];
					 	$correo = $_POST['correo'];
					 	$carrera = $_POST['carrera'];
					 	
						$resultado = $this->modelo->alta($codigo,$nombre,$apellidos, $correo, $carrera);
						if($resultado !== false){
							require_once("vista/listaAlumnoView.html");
						}else{
							require_once("vista/error.html");
						}
					}
				break;
			}
		}
	}
?>