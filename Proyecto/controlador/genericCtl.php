<?php
	class generic{
		/*atributos*/
		public $modelo;
		public $driver;
		
		/*constructor*/
		function __construct($driver) {
			$this->driver = $driver;
		}
	
		public function generarVista($archivo,$menu,$datos=null) {
			$vista = file_get_contents('vista/encabezado.html');
			if($menu === true){
				$vista.= file_get_contents('vista/menu_superior.html');
				$vista.= file_get_contents('vista/menu_izquierdo.html');
			}
			$vista.= '{contenido}';
			$vista.= '<div class="clear"></div>';
			if($menu === true) {
				$vista.= file_get_contents('vista/pie.html');
			}else{
				$vista.= file_get_contents('vista/pieSinMenu.html');
			}
			$contenido = file_get_contents('vista/'.$archivo);
			$inicio = strrpos($contenido,'<section');
			$fin = strrpos($contenido,'</section>') + 10;
			$contenido = substr($contenido, $inicio, $fin-$inicio);
			$vista = str_replace('{contenido}', $contenido, $vista);

			/*se reemplazando los datos que hagan falta*/
			if($datos!==null){
				$vista = strtr($vista,$datos);
			}			
			
			echo $vista;
		}
	}
?>
