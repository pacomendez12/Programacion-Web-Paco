<?php
	include('controlador/genericCtl.php');
	class ProfesorCtl extends generic{
		
		/*constructor*/
		function __construct($driver) {
			/*cargar modelo*/
			parent::__construct($driver);
			require_once("modelo/profesorMdl.php");
			$this->modelo = new ProfesorMdl($driver);
		}
	
		function ejecutar() {
			/*recibir acción*/
			if(isset($_GET['acc']) && isset($_SESSION['codigo']) && $_SESSION['permisos'] == 1){
				switch($_GET["acc"]) {
					case "alta":
						if(empty($_POST)){
						/*	require_once("vista/registro.html");*/
							$array = array('{nombre_para_menu}' => $_SESSION['nombre'],
								'{botones}' => self::obtenBotonesMenuSuperior('profesor'));
							self::generarVista('nuevoMaestro.html','Registro de alumno',$_SESSION['permisos'],$array);
						}
						 else {
						 	/*obtener datos de POST*/
						 	//$codigo = $driver->real_escape_string($_POST["codigo"]);*/

						 	$nombre = trim($this->driver->real_escape_string($_POST["nombre"]));
						 	$apellidos = trim($this->driver->real_escape_string($_POST["apellido"]));
						 	$correo = trim($this->driver->real_escape_string($_POST['correo']));

						 	if($nombre === '' || $apellidos === '' ||
						 		$correo === ''){
						 		$mensaje = array('{mensaje}' => 'Se encontró un error con los datos proporcionados al servidor',
						 			'{nombre_para_menu}' => $_SESSION['nombre']);
						 		self::generarVista('error.html','Datos inválidos',0,$mensaje);
						 		exit();
						 	}


						 	/*opcionales*/
						 	unset($_POST);
						 	//limpiamos post
						 	$_POST = array();
							$resultado = $this->modelo->alta($nombre,$apellidos, $correo);

							if($resultado !== false){
								$valores = array('{codigo}' => $this->driver->insert_id, '{nombre}' => $nombre, '{apellidos}' => $apellidos,
									'{correo}' => $correo,
									'{nombre_para_menu}' => $_SESSION['nombre'],
									'{botones}' => self::obtenBotonesMenuSuperior('profesor'));
								self::generarVista('maestroAgregado.html','Maestro Agregado',$_SESSION['permisos'],$valores);
							}else{
								$mensaje = array('{mensaje}' => 'Los datos proporcionados no son válidos, verifique que estos tengan los formatos adecuados');
						 		self::generarVista('error.html','Datos no válidos',0,$mensaje);
						 		exit();
							}
						}
					break;
					case 'listar':
					if(empty($_POST)){
						$resultado = $this->modelo->consulta(null);
						//print_r($resultado);
						if($resultado){
							$tabla = self::creaTabla("Lista de profesores");
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
				
									);

								$new_fila = strtr($new_fila,$diccionario);
								$filas .= $new_fila;
							}
							$valores = str_replace($fila, $filas, $tabla);
							$valores = array('{contenido}' => $valores,
								'{nombre_para_menu}' => $_SESSION['nombre'],
								'{botones}' => self::obtenBotonesMenuSuperior('profesor'));
							
							self::generarVista('listarProfesores.html','Lista de profesores',$_SESSION['permisos'],$valores);
						}

					}else{
						$busqueda = trim($this->driver->real_escape_string($_POST["busqueda"]));
						$resultado = $this->modelo->consulta($busqueda);
						//print_r($resultado);
						if($resultado!==false){
							$tabla = self::creaTabla("Lista de profesores");
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
				
									);

								$new_fila = strtr($new_fila,$diccionario);
								$filas .= $new_fila;
							}
							$valores = str_replace($fila, $filas, $tabla);
							$valores = array('{contenido}' => $valores,
								'{nombre_para_menu}' => $_SESSION['nombre'],
								'{botones}' => self::obtenBotonesMenuSuperior('profesor'));
							
							self::generarVista('listarProfesores.html','Lista de profesores',$_SESSION['permisos'],$valores);
						}
					}

					break;
				}
			} else{
				$mensaje = array('{mensaje}' => 'Se encontró un error con los datos proporcionados al servidor',
						 	'{nombre_para_menu}' => $_SESSION['nombre']);
				self::generarVista('error.html','Error',0,$mensaje);
			}
		}



		public function generarVista($archivo,$titulo,$menu,$datos=null) {
			$vista = file_get_contents('vista/encabezado.html');
			if($menu === 1){
				$vista.= file_get_contents('vista/menu_superior.html');
				$vista.= file_get_contents('vista/menu_izquierdo_administrador.html');
			}else if($menu === 2 || $menu === 3){
				$vista.= file_get_contents('vista/menu_superior.html');
				$vista.= file_get_contents('vista/menu_izquierdo_alumno_profesor.html');
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
				</tr>
				</thead>
				<tbody>
					<tr>
						<td class='iz'>{codigo}</td>
						<td>{nombre}</td>
						<td>{apellidos}</td>
						<td>{email}</td>
					</tr>
				</tbody>
			</table>";
			return $tabla;
		}	
	}
?>
