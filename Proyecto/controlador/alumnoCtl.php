<?php
	include('controlador/genericCtl.php');
	class AlumnoCtl extends generic{
		
		/*constructor*/
		function __construct($driver) {
			/*cargar modelo*/
			parent::__construct($driver);
			require_once("modelo/alumnoMdl.php");
			$this->modelo = new AlumnoMdl($driver);
		}
	
		function ejecutar() {
			/*recibir acción*/
			if(isset($_SESSION['codigo']) && $_SESSION['permisos'] == 2){
				switch($_GET["acc"]) {
					case "alta":
						if(empty($_POST)){
						/*	require_once("vista/registro.html");*/
							$array = array('{nombre_para_menu}' => $_SESSION['nombre'],
								'{botones}'=> self::obtenBotonesMenuSuperior('alumno'));
							self::generarVista('registro.html','Registro de alumno',$_SESSION['permisos'],$array);
						}
						 else {
						 	/*obtener datos de POST*/
						 	//$codigo = $driver->real_escape_string($_POST["codigo"]);*/
						 	$codigo = trim($this->driver->real_escape_string($_POST["codigo"]));
						 	$nombre = trim($this->driver->real_escape_string($_POST["nombre"]));
						 	$apellidos = trim($this->driver->real_escape_string($_POST["apellido"]));
						 	$correo = trim($this->driver->real_escape_string($_POST['correo']));
						 	$carrera = trim($this->driver->real_escape_string($_POST['carrera']));

						 	if($codigo ==='' || $nombre === '' || $apellidos === '' ||
						 		$correo === '' || $carrera === ''){
						 		$mensaje = array('{mensaje}' => 'Se encontró un error con los datos proporcionados al servidor',
						 			'{nombre_para_menu}' => $_SESSION['nombre']);
						 		self::generarVista('error.html','Error',0,$mensaje);
						 		exit();
						 	}


						 	/*opcionales*/
						 	$celular = '';
						 	$pagina = '';
						 	$github = '';
						 	if(isset($_POST['celular']))
						 		$celular = trim($this->driver->real_escape_string($_POST['celular']));
						 	if(isset($_POST['pagina']))
						 		$pagina = trim($this->driver->real_escape_string($_POST['pagina']));
						 	if(isset($_POST['github']))
						 		$github = trim($this->driver->real_escape_string($_POST['github']));

						 	unset($_POST);
						 	//limpiamos post
						 	$_POST = array();
							$resultado = $this->modelo->alta($codigo,$nombre,$apellidos, $correo,
								$carrera,$celular,$pagina,$github);

							if($resultado !== false){
								$valores = array('{codigo}' => $codigo, '{nombre}' => $nombre, '{apellidos}' => $apellidos,
									'{correo}' => $correo, '{carrera}' => $carrera,
									'{celular}' => ($celular!==''?'<br><strong>Celular:</strong> '.$celular:''),
									'{pagina}' => ($pagina!==''?'<br><strong>Página Web:</strong> '.$pagina:''),
									'{github}' => ($github!==''?'<br><strong>Cuenta de github:</strong> '.$github:''),
									'{nombre_para_menu}' => $_SESSION['nombre']);
								self::generarVista('alumnoAgregado.html','Alumno Agregado',2,$valores);
							}else{
								require_once("vista/error.html");
							}
						}
					break;
					case 'listar':
					if(empty($_POST) && !isset($_GET['b'])){
						$resultado = $this->modelo->consulta(null);
						//print_r($resultado);
						if($resultado){
							$tabla = self::creaTabla("Lista de alumnos");
							$inicio_fila = strrpos($tabla,'<tr>');
							$final_fila = strrpos($tabla,'</tr>') + 5;

							$fila = substr($tabla,$inicio_fila,$final_fila-$inicio_fila);
							$filas = "";

							foreach ($resultado as  $row) {
								$new_fila = $fila;
								$diccionario = array(
									'{codigo}' => $row['codigo'], 
									'{nombre}' => $row['nombre'],
									'{apellidos}' => $row['apellidos'],
									'{email}' => $row['email'],
									'{carrera}' => $row['carrera'],
									
									'{celular}' => $row['celular'],
									'{github}' => $row['github'],
									'{pagina}' => $row['pagina'],
									'{eliminar}' => "<a href='index.php?ctl=alumno&acc=eliminar&codigo=".$row['codigo']."'><img src='www/img/eliminar.png' alt='eliminar' title='Eliminar' width='15' /></a>"
									);

								$new_fila = strtr($new_fila,$diccionario);
								$filas .= $new_fila;
							}
							$valores = str_replace($fila, $filas, $tabla);
							

							$valores = array('{contenido}' => $valores,
								'{nombre_para_menu}' => $_SESSION['nombre'],
								'{botones}'=> self::obtenBotonesMenuSuperior('alumno'),
								'{busqueda}' => ''
								);
							
							self::generarVista('listarAlumnos.html','Lista de alumnos',$_SESSION['permisos'],$valores);
						}

					}else{
						if(!empty($_POST))
							$busqueda = trim($this->driver->real_escape_string($_POST["busqueda"]));
						else
							$busqueda = trim($this->driver->real_escape_string($_GET["b"]));
						unset($_POST);
						$resultado = $this->modelo->consulta($busqueda);
						//print_r($resultado);
						if($resultado!==false){
							$tabla = self::creaTabla("Lista de alumnos");
							$inicio_fila = strrpos($tabla,'<tr>');
							$final_fila = strrpos($tabla,'</tr>') + 5;

							$fila = substr($tabla,$inicio_fila,$final_fila-$inicio_fila);
							$filas = "";

							foreach ($resultado as  $row) {
								$new_fila = $fila;
								if($row['status']==true)
									$estado = "Activo";
								else
									$estado = "Inactivo";

								$diccionario = array(
									'{codigo}' => $row['codigo'], 
									'{nombre}' => $row['nombre'],
									'{apellidos}' => $row['apellidos'],
									'{email}' => $row['email'],
									'{carrera}' => $row['carrera'],
									
									'{celular}' => $row['celular'],
									'{github}' => $row['github'],
									'{pagina}' => $row['pagina'],
									'{eliminar}' => "<a href='index.php?ctl=alumno&acc=eliminar&codigo=".$row['codigo']."&b=".$busqueda."'><img src='www/img/eliminar.png' alt='eliminar' title='Eliminar' width='15' /></a>"
									);

								$new_fila = strtr($new_fila,$diccionario);
								$filas .= $new_fila;
							}
							$valores = str_replace($fila, $filas, $tabla);
							$valores.="<button id='btn' class='boton' type='button' 
										onclick='location.href=\"index.php?ctl=alumno&acc=listar\"'>
										Ver todos los alumnos</button>";
							$valores = array('{contenido}' => $valores,
								'{nombre_para_menu}' => $_SESSION['nombre'],
								'{botones}'=> self::obtenBotonesMenuSuperior('alumno'),
								'{busqueda}' => $busqueda
								);
							
							self::generarVista('listarAlumnos.html','Lista de alumnos',$_SESSION['permisos'],$valores);
						}

					}
					break;
					case 'eliminar':
						if(isset($_GET['codigo'])){
							$codigo = trim($this->driver->real_escape_string($_GET["codigo"]));
							$resultado = $this->modelo->eliminar($codigo);

							if($resultado !== false){
								if(isset($_GET['b']))
									header('Location: index.php?ctl=alumno&acc=listar&b='.$_GET['b']);
								else
									header('Location: index.php?ctl=alumno&acc=listar');
								
							}else{
								$mensaje = array('{mensaje}' => 'Erro en la conexión a la base de datos');
								self::generarVista('error.html','Error de base de datos',0,$mensaje);
							}
						}else{
							//si no se especifica el código a eliminar
							header('Location: index.php?ctl=alumno&acc=listar');
						}

					break;
					case 'cargar':
					if(empty($_FILES)){
						/*	require_once("vista/registro.html");*/
						$array = array('{nombre_para_menu}' => $_SESSION['nombre'],
							'{botones}'=> self::obtenBotonesMenuSuperior('alumno'));
						self::generarVista('subirArchivo.html','Cargar alumnos desde archivo externo',$_SESSION['permisos'],$array);
					}else{
						$resultado = $this->modelo->subir();
						if($resultado !== false){
							//self::generarVista('ArchivoSubido.html',true);
							$NOMBRE_ARCHIVO = $_FILES['archivo']['name'];
							
							require_once("controlador/procesaArchivoCtl.php");
							$ctl = new ProcesaArchivoCtl($this->driver);
							$ctl->ejecutar($NOMBRE_ARCHIVO);
							unset($_FILES);
						}else{
							$mensaje = array('{mensaje}' => 'No se pudo subir el archivo, es posible que el tamaño exceda los límites del servidor');
							self::generarVista('error.html','Error subiendo el archivo',0,$mensaje);
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
