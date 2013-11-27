<?php
	include('controlador/genericCtl.php');
	class CicloCtl extends generic{
		
		/*constructor*/
		function __construct($driver) {
			/*cargar modelo*/
			parent::__construct($driver);
			require_once("modelo/cicloMdl.php");
			$this->modelo = new CicloMdl($driver);
		}
	
		function ejecutar() {
			if(isset($_SESSION['codigo']) && $_SESSION['permisos'] == 1){
				/*recibir acción*/
				switch($_GET["acc"]) {
					case "nuevo":
						if(empty($_POST)){
						/*	require_once("vista/registro.html");*/

							self::generarVista('nuevo_ciclo_escolar.html','Nuevo ciclo escolar',1);
						}
						 else {
						 	/*obtener datos de POST*/
						 	/*$codigo = $con->real_escape_string($_POST["codigo"]);*/
						 	$codigo = trim($this->driver->real_escape_string($_POST["nombre"]));
						 	$fi = trim($this->driver->real_escape_string($_POST["fecha_inicio"]));
						 	$ff = trim($this->driver->real_escape_string($_POST["fecha_fin"]));
						 	unset($_POST);
						 	include('validador.php');
						 	if(validaCiclo($codigo) && validaFecha($fi) && validaFecha($ff)){
						 		$resultado = $this->modelo->nuevo($codigo,$fi,$ff);
						 		if($resultado !== false){
						 			/*require_once("vista/listaAlumnoView.html");*/
						 			//self::generarVista('modificar_ciclo_escolar.html',1,$array);
						 			header('location: index.php?ctl=ciclo&acc=modificar&nombre='.$codigo);
						 		}else{
						 			$mensaje = array('{mensaje}' => 'Falló al intentar registrar el nuevo ciclo');
						 			self::generarVista('error.html','Datos no válidos',0,$mensaje);
						 			exit();
						 		}
						 	}else{
						 		$mensaje = array('{mensaje}' => 'Los datos proporcionados no son válidos, verifique que estos tengan los formatos adecuados');
						 		self::generarVista('error.html','Datos no válidos',0,$mensaje);
						 		exit();
						 	}
						}
					break;

					case 'modificar':
						if(!isset($_GET['nombre'])){
							header('location: index.php?ctl=ciclo&acc=listar');
						}
						
					break;
					case 'listar':
						self::generarVista('listar_ciclo_escolar.html','Lista de ciclos',1);
					break;
				}
			} else if(!isset($_SESSION['codigo'])) {
				//si no está logeado
				header('location: index.php?ctl=login');
			}else{
				$mensaje = array('{mensaje}' => 'No tienes los permisos para estar en este sitio');
				self::generarVista('error.html','Datos no válidos',0,$mensaje);
				exit();
			}
		}
	}
?>
