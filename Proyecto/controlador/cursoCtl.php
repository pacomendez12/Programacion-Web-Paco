<?php
	include('controlador/genericCtl.php');
	class CursoCtl extends generic{
		
		/*constructor*/
		function __construct($driver) {
			/*cargar modelo*/
			parent::__construct($driver);
			require_once("modelo/cursoMdl.php");
			$this->modelo = new CursoMdl($driver);
		}
	
		function ejecutar() {
			/*recibir acción*/
			if(isset($_SESSION['codigo']) && $_SESSION['permisos'] == 2){
				switch($_GET["acc"]) {
					case "alta":
						if(empty($_POST)){
						/*	require_once("vista/registro.html");*/
							$sust1 = $this->modelo->obtenAcademiasParaSelect();
							$sust2 = $this->modelo->obtenCiclosParaSelect();
							$array = array('{nombre_para_menu}' => $_SESSION['nombre'],
								'{botones}'=> '',
								'{academias_option}' => $sust1,
								'{ciclos_option}' => $sust2
								);
							self::generarVista('nuevo_curso.html','Creación de un curso',$_SESSION['permisos'],$array);
						}
						 else {
						 	/*obtener datos de POST*/
						 	//$codigo = $driver->real_escape_string($_POST["codigo"]);*/
						 	$nombre = trim($this->driver->real_escape_string($_POST["nombre"]));
						 	$academia = trim($this->driver->real_escape_string($_POST["academia"]));
						 	$ciclo = trim($this->driver->real_escape_string($_POST['ciclo']));
						 	$dias = trim($this->driver->real_escape_string($_POST['dias']));
						 	$hi = trim($this->driver->real_escape_string($_POST['hi']));
						 	$hf = trim($this->driver->real_escape_string($_POST['hf']));
						 	$maestro = $_SESSION['codigo'];
						 	$maestroNombre = $_SESSION['nombre'];

						 	echo "dias: ".$dias;


						 	if($ciclo ==='' || $nombre === '' || $academia === '' ||
						 		$hi === '' || $hf === '' || $dias === ''){
						 		$mensaje = array('{mensaje}' => 'Se encontró un error con los datos proporcionados al servidor, esto normalmente se debe a un intento ilegal de acceso a la base de datos',
						 			'{nombre_para_menu}' => $_SESSION['nombre']);
						 		self::generarVista('error.html','Error de datos',0,$mensaje);
						 		exit();
						 	}

						 	//limpiamos post
						 	$_POST = array();
						 	unset($_POST);

						 	//convertimos los dias en arreglo
						 	$dias = explode(',', $dias);
						 	//eliminamos el ultimo valor que en realidad es
						 	//un espacio en blanco
						 	unset($dias[count($dias) - 1]);
							
						 	//se guarda el curso en la base de datos
							$resultado = $this->modelo->alta($nombre,$academia, $ciclo,
								$dias,$hi,$hf,$maestro);
							$datos = "<div><p><strong>Nombre: </strong>$nombre<br>
							<strong>Ciclo: </strong>$ciclo<br>
							<strong>Profesor: </strong>$maestroNombre<br></p>
							</div>";

							if($resultado !== false){
								$valores = array('{nombre}' => $nombre, '{datos}' => $datos,
									'{nrc}' => $resultado,
									'{nombre_para_menu}' => $_SESSION['nombre'],
									'{botones}' => self::obtenBotonesMenuSuperior('curso')
									);
								self::generarVista('cursoAgregado.html','Alumno Agregado',$_SESSION['permisos'],$valores);
							}else{
								$mensaje = array('{mensaje}' => 'Hubo un problema al guardar el curso en la base de datos, intente nuevamente, si el problema continua le pedimos contacte al administrador del sistema');
						 		self::generarVista('error.html','Error de base de datos',0,$mensaje);
						 		exit();
							}
						}
					break;
					case 'listar':
						$contenido = file_get_contents('vista/listar_curso.html');
						$inicio = strrpos($contenido,'<div class="linea-grande">');
						$fin = strrpos($contenido,'</div><div class="clear"></div>') + 6;
						$curso_vacio = substr($contenido, $inicio, $fin-$inicio);

						$elementosAReemplazar = $this->modelo->listar($curso_vacio);
						$array = array('{botones}' => self::obtenBotonesMenuSuperior('curso'),
							$curso_vacio => $elementosAReemplazar,
							'{nombre_para_menu}' => $_SESSION['nombre'],);

						self::generarVista('listar_curso.html','Lista de los cursos',$_SESSION['permisos'],$array);
					break;
					case 'configurar':
						if(isset($_GET['nrc'])){
							if(empty($_POST)){
								$array = array('{nombre_para_menu}' => $_SESSION['nombre'],
									'{botones}'=> '',
									);
								self::generarVista('configurarEvaluacionCurso.html','Configuración de la evaluación del curso',$_SESSION['permisos'],$array);
							}


/*
							$codigo = trim($this->driver->real_escape_string($_GET["codigo"]));
							$resultado = $this->modelo->eliminar($codigo); 
							*/

							/*if($resultado !== false){
								if(isset($_GET['b']))
									header('Location: index.php?ctl=curso&acc=listar&b='.$_GET['b']);
								else
									header('Location: index.php?ctl=curso&acc=listar');
								
							}else{
								$mensaje = array('{mensaje}' => 'Erro en la conexión a la base de datos');
								self::generarVista('error.html','Error de base de datos',0,$mensaje);
							}*/
						}else{
							//si no se especifica el código a eliminar
							header('Location: index.php?ctl=curso&acc=listar');
						}

					break;

					case "ver":
						if(empty($_POST)){
							$dias = $this->modelo->obtenDiasLaborales($_GET['nrc']);
							$array = array('{nombre_para_menu}' => $_SESSION['nombre'],
								'{botones}'=> '',
								);
							self::generarVista('asistencia.html','Asistencia del curso',$_SESSION['permisos'],$array);
						}
						 else {
						 	/*obtener datos de POST*/
						 	//$codigo = $driver->real_escape_string($_POST["codigo"]);*/
						 	$nombre = trim($this->driver->real_escape_string($_POST["nombre"]));
						 	$academia = trim($this->driver->real_escape_string($_POST["academia"]));
						 	$ciclo = trim($this->driver->real_escape_string($_POST['ciclo']));
						 	$dias = trim($this->driver->real_escape_string($_POST['dias']));
						 	$hi = trim($this->driver->real_escape_string($_POST['hi']));
						 	$hf = trim($this->driver->real_escape_string($_POST['hf']));
						 	$maestro = $_SESSION['codigo'];
						 	$maestroNombre = $_SESSION['nombre'];

						 	echo "dias: ".$dias;


						 	if($ciclo ==='' || $nombre === '' || $academia === '' ||
						 		$hi === '' || $hf === '' || $dias === ''){
						 		$mensaje = array('{mensaje}' => 'Se encontró un error con los datos proporcionados al servidor, esto normalmente se debe a un intento ilegal de acceso a la base de datos',
						 			'{nombre_para_menu}' => $_SESSION['nombre']);
						 		self::generarVista('error.html','Error de datos',0,$mensaje);
						 		exit();
						 	}

						 	//limpiamos post
						 	$_POST = array();
						 	unset($_POST);

						 	//convertimos los dias en arreglo
						 	$dias = explode(',', $dias);
						 	//eliminamos el ultimo valor que en realidad es
						 	//un espacio en blanco
						 	unset($dias[count($dias) - 1]);
							
						 	//se guarda el curso en la base de datos
							$resultado = $this->modelo->alta($nombre,$academia, $ciclo,
								$dias,$hi,$hf,$maestro);
							$datos = "<div><p><strong>Nombre: </strong>$nombre<br>
							<strong>Ciclo: </strong>$ciclo<br>
							<strong>Profesor: </strong>$maestroNombre<br></p>
							</div>";

							if($resultado !== false){
								$valores = array('{nombre}' => $nombre, '{datos}' => $datos,
									'{nrc}' => $resultado,
									'{nombre_para_menu}' => $_SESSION['nombre'],
									'{botones}' => self::obtenBotonesMenuSuperior('curso')
									);
								self::generarVista('cursoAgregado.html','Alumno Agregado',$_SESSION['permisos'],$valores);
							}else{
								$mensaje = array('{mensaje}' => 'Hubo un problema al guardar el curso en la base de datos, intente nuevamente, si el problema continua le pedimos contacte al administrador del sistema');
						 		self::generarVista('error.html','Error de base de datos',0,$mensaje);
						 		exit();
							}
						}
					break;
				}
			}else if(!isset($_SESSION['codigo'])){
				header('Location: index.php');
			}else{
				$mensaje = array('{mensaje}' => 'No tienes los permisos para estar en esta página');
				self::generarVista('error.html','Error de permisos',0,$mensaje);
			}
		}



		public function generarVista($archivo,$titulo,$menu,$datos=null) {
			$vista = file_get_contents('vista/encabezado.html');
			if($menu === 1){
				$vista.= file_get_contents('vista/menu_superior.html');
				$vista.= file_get_contents('vista/menu_izquierdo_administrador.html');
			}else if($menu === 2){
				$vista.= file_get_contents('vista/menu_superior.html');
				$vista.= file_get_contents('vista/menu_izquierdo_profesor.html');
			}elseif($menu === 3){
				$vista.= file_get_contents('vista/menu_superior.html');
				$vista.= file_get_contents('vista/menu_izquierdo_alumno.html');
			}
			$vista.= '{contenido}';
			$vista.= '<div class="clear"></div>';
			if($menu > 0) {
				$vista.= file_get_contents('vista/pie.html');
			}else{
				$vista.= file_get_contents('vista/pieSinMenu.html');
			}
			$contenido = file_get_contents('vista/'.$archivo);
			$inicio = strrpos($contenido,'<section');
			$fin = strrpos($contenido,'</section>') + 10;
			$contenido = substr($contenido, $inicio, $fin-$inicio);
			$vista = str_replace('{contenido}', $contenido, $vista);

			//reemplazamos el titulo de la página
			$vista = str_replace('{titulo_pagina}', $titulo, $vista);

			/*se reemplazando los datos que hagan falta*/
			if($datos!==null){
				$vista = strtr($vista,$datos);
			}			
			
			echo $vista;
		}

		public function creaTabla($nombre){
			$tabla ="<table id='contenedor' class='tabla contenedor-grande'>
				<caption>$nombre</caption>
				<thead class='iz'>
				<tr>
					<th class='iz'>Código</th>
					<th>Nombre</th>
					<th>Apellidos</th>
					<th>Correo</th>
					<th>Carrera</th>
					
					<th>Celular</th>
					<th>Github</th>
					<th>Página web</th>
					<th>Eliminar</th>
				</tr>
				</thead>
				<tbody>
					<tr>
						<td class='iz'>{codigo}</td>
						<td>{nombre}</td>
						<td>{apellidos}</td>
						<td>{email}</td>
						<td>{carrera}</td>
						
						<td>{celular}</td>
						<td>{github}</td>
						<td>{pagina}</td>
						<td>{eliminar}</td>
					</tr>
				</tbody>
			</table>";
			return $tabla;
		}	
	}
?>
