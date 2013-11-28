<?php
	class generic{
		/*atributos*/
		public $modelo;
		public $driver;
		
		/*constructor*/
		function __construct($driver) {
			$this->driver = $driver;
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
				
				$vista = str_replace('{nombre_para_menu}', $_SESSION['nombre'], $vista);
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
				if(!isset($datos['{botones}'])){
					$vista = str_replace('{botones}',"", $vista);
				}
			}else{
				$vista = str_replace('{botones}',"", $vista);
			}
			
			echo $vista;
		}

		function obtenBotonesMenuSuperior($ctl){
			return file_get_contents("vista/menu_superior/$ctl.html");
		}
	}
?>
