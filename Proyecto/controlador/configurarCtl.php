<?php
	include('controlador/genericCtl.php');
	class ConfigurarCtl extends generic{
		
		/*constructor*/
		function __construct($driver) {
			/*cargar modelo*/
			parent::__construct($driver);
			require_once("modelo/configurarMdl.php");
			$this->modelo = new ConfigurarMdl($driver);
		}
	
		function ejecutar() {
			/*recibir acción*/
			if(isset($_SESSION['codigo'])){
				if(!isset($_GET["acc"])){
					if(empty($_POST)){
						//cuando se selecciona configurar
						$array = array('{nombre_para_menu}' => $_SESSION['nombre'], '{email_usuario}' => $_SESSION['correo']);
						self::generarVista('configurar.html','Configurar Usuario',2,$array);
					}else{
						$actual = trim($this->driver->real_escape_string($_POST["actual"]));
						$nueva = trim($this->driver->real_escape_string($_POST["nueva"]));
						$email = trim($this->driver->real_escape_string($_POST["email"]));
						if($actual === '' || ($nueva === '' && $nueva.length() < 8) ||
							$email === ''){
							$mensaje = array('{mensaje}' => 'Se encontró un error con los datos proporcionados al servidor');
						 	self::generarVista('error.html','Datos no válidos',0,$mensaje);
						 	exit();
						}

						unset($_POST);
						$resultado = $this->modelo->modificar($actual,$nueva,$email);
						if($resultado){
							$_SESSION['correo']=$email;
							$array = array('{usuario}' => $_SESSION['nombre'],
								'{nombre_para_menu}' => $_SESSION['nombre']);
							self::generarVista('usuarioModificado.html','Usuario modificado',2,$array);
						}else{
							$mensaje = array('{mensaje}' => 'La contraseña actual no corresponde');
						 	self::generarVista('error.html','Datos no válidos',0,$mensaje);
						 	exit();
						}
					}
				} else{
					$mensaje = array('{mensaje}' => 'La acción indicada no existe para la configuración del usuario',
						 	'{nombre_para_menu}' => $_SESSION['nombre']);
					self::generarVista('error.html','Error',0,$mensaje);
				}
			} else{
				header('location: index.php');
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
					<th>Carrera</th>
					<th>Estado</th>
					<th>Celular</th>
					<th>Github</th>
					<th>Página web</th>
				</tr>
				</thead>
				<tbody>
					<tr>
						<td class='iz'>{codigo}</td>
						<td>{nombre}</td>
						<td>{apellidos}</td>
						<td>{email}</td>
						<td>{carrera}</td>
						<td>{status}</td>
						<td>{celular}</td>
						<td>{github}</td>
						<td>{pagina}</td>
					</tr>
				</tbody>
			</table>";
			return $tabla;
		}	
	}
?>
