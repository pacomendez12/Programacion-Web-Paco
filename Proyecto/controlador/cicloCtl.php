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
				
				$array = array('{botones}' => self::obtenBotonesMenuSuperior('ciclo') );
				if(isset($_GET['acc'])){
				switch($_GET["acc"]) {
					case "nuevo":
						if(empty($_POST)){
						/*	require_once("vista/registro.html");*/
							self::generarVista('nuevo_ciclo_escolar.html','Nuevo ciclo escolar',1,$array);
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
						 			header('location: index.php?ctl=ciclo&acc=modificar&nombre='.strtoupper($codigo));
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
						}else{
							//para mostrar la vista donde se realizan las modificaciones
							if(!isset($_POST['modificado'])){
								//cuando si se ha elegido un ciclo escolar a modificar
								$nombre = trim($this->driver->real_escape_string($_GET["nombre"]));
								if($this->modelo->verificaExistenciaCiclo($nombre)){
									//cuando si existe el ciclo escolar
									$contenido = file_get_contents('vista/modificar_ciclo_escolar.html');
									$inicio = strrpos($contenido,'<div class="dia-festivo" id="dia-festivo{id}">');
									$fin = strrpos($contenido,'</div><div id="fin-dias"></div>')+6;
									$dia_vacio = substr($contenido, $inicio, $fin-$inicio);
									
									//echo $dia_vacio;
									//exit();
									$diasReemplazo = $this->modelo->obtendDiasFestivos($dia_vacio,$nombre);
									$datosCiclo = $this->modelo->obtenDatosCiclo($nombre);
									$array = array(
										'{botones}' => self::obtenBotonesMenuSuperior('ciclo'),
										'{nombre}' => $datosCiclo['nombre'],
										'{fi}' => $datosCiclo['fecha_inicio'],
										'{ff}' => $datosCiclo['fecha_fin'],
										$dia_vacio =>  $diasReemplazo,);
									
									self::generarVista('modificar_ciclo_escolar.html','Modificación del ciclo escolar',$_SESSION['permisos'],$array);
								}else{
									//no existe el ciclo escolar indicado
									unset($_POST);
									$array = array('{mensaje}' => "El ciclo escolar $nombre no existe,
										verifique que no ha intentado ingresar a este sitio desde un link
										inválido");
									self::generarVista('error.html','Ciclo inexistente',0,$array);
								}
							}else{
								//cuando se han guardado los cambios
							 	$fi = trim($this->driver->real_escape_string($_POST["fecha_inicio"]));
							 	$ff = trim($this->driver->real_escape_string($_POST["fecha_fin"]));
							 	$ciclo = $_POST['modificado'];
							 	unset($_POST);
							 	include('validador.php');
							 	if(validaFecha($fi) && validaFecha($ff)){
							 		$resultado = $this->modelo->modificar($ciclo,$fi,$ff);
							 		if($resultado !== false){
							 			/*require_once("vista/listaAlumnoView.html");*/
							 			$array = array('{botones}' => self::obtenBotonesMenuSuperior('ciclo'),
							 				'{ciclo}' => $ciclo);
										self::generarVista('cicloModificado.html','Ciclo escolar modificado',$_SESSION['permisos'],$array);
							 			//header('location: index.php?ctl=ciclo&acc=modificar&nombre='.strtoupper($codigo));
							 		}else{
							 			$mensaje = array('{mensaje}' => 'Falló al intentar modificar el ciclo escolar');
							 			self::generarVista('error.html','Datos no válidos',0,$mensaje);
							 			exit();
							 		}
							 	}else{
							 		$mensaje = array('{mensaje}' => 'Los datos proporcionados no son válidos, verifique que estos tengan los formatos adecuados');
							 		self::generarVista('error.html','Datos no válidos',0,$mensaje);
							 		exit();
							 	}
								
							}
						}//fin del else general para modificar
					break;

					case 'listar':
						$contenido = file_get_contents('vista/listar_ciclo_escolar.html');
						$inicio = strrpos($contenido,'<div class="linea-pequena">');
						$fin = strrpos($contenido,'<div class="last-element"></div>')-31;
						$ciclo_vacio = substr($contenido, $inicio, $fin-$inicio);

						$elementosAReemplazar = $this->modelo->listar($ciclo_vacio);

						$array = array('{botones}' => self::obtenBotonesMenuSuperior('ciclo'),
							$ciclo_vacio => $elementosAReemplazar);

						self::generarVista('listar_ciclo_escolar.html','Lista de ciclos',1,$array);
					break;
					case 'clonar':
						if(empty($_POST)){
						/*	require_once("vista/registro.html");*/
							$sust = $this->modelo->obtenCiclosParaSelect();
							$array = array('{ciclos_option}' => $sust,
								'{botones}' => self::obtenBotonesMenuSuperior('ciclo'));
							self::generarVista('clonar_ciclo_escolar.html','Clonación de ciclo escolar',1,$array);
						}
						 else {
						 	/*obtener datos de POST*/
						 	/*$codigo = $con->real_escape_string($_POST["codigo"]);*/
						 	$codigo_clonado = trim($this->driver->real_escape_string($_POST["nombre_clonado"]));
						 	$codigo = trim($this->driver->real_escape_string($_POST["nombre"]));
						 	$fi = trim($this->driver->real_escape_string($_POST["fecha_inicio"]));
						 	$ff = trim($this->driver->real_escape_string($_POST["fecha_fin"]));
						 	unset($_POST);
						 	include('validador.php');
						 	if(validaCiclo($codigo) && validaCiclo($codigo_clonado) && validaFecha($fi) && validaFecha($ff)){
						 		$resultado = $this->modelo->clonar($codigo_clonado,$codigo,$fi,$ff);
						 		if($resultado !== false){
						 			/*require_once("vista/listaAlumnoView.html");*/
						 			//self::generarVista('modificar_ciclo_escolar.html',1,$array);
						 			header('location: index.php?ctl=ciclo&acc=modificar&nombre='.strtoupper($codigo));
						 		}else{
						 			$mensaje = array('{mensaje}' => 'Falló al intentar clonar el ciclo');
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
				}
				}else{
					$mensaje = array('{mensaje}' => 'Página no encontrada');
					self::generarVista('error.html','Datos no válidos',0,$mensaje);
					exit();
				}
			} else if(!isset($_SESSION['codigo'])){
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
