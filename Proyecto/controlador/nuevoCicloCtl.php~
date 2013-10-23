<?php
	class NuevoCicloCtl{
		/*atributos*/
		public $modelo;
		
		/*constructor;/*
		function __construct() {
			/*cargar modelo;*/
			require_once("modelo/nuevoCicloMdl.php");
			$this->modelo = new NuevoCicloMdl();
		}
	
		function ejecutar() {
			/*recibir acción*/
			switch($_GET['acc']) {
				case "nuevo":
					echo "<br>Debug: entró a alta en el controlador";
					if(empty($_POST))
						require_once("vista/nuevo_ciclo_escolar.html");
					 else {
					 	/*obtener datos de POST*/
					 	$nombre = $_POST['nombre'];
					 	$f_i = $_POST['fecha_inicio'];
					 	$f_f = $_POST['fecha_fin'];
					 	$fecha1 = $_POST['fecha1'];
					 	$motivo1 = $_POST['motivo1'];
					 	
						$resultado = $this->modelo->nuevo($nombre,$f_i,$f_f,$fecha1,$motivo1);
						if($resultado !== false){
							require_once("vista/cicloAgregadoView.html");
						}else{
							require_once("vista/error.html");
						}
					}
				break;
			}
		}
	}
?>