<?php
	class CicloMdl{
		public $driver;
		
		function __construct($driver) {
			$this->driver = $driver;
		}
	
		/**
		*@args
		*
		*/
		function invierteFecha($fecha){
			$fi_t = explode('/', $fecha);
			$fi=$fi_t[2].'/'.$fi_t[1].'/'.$fi_t[0];
			return $fi;
		}

		function nuevo($nombre,$fi,$ff) {
			/*reorganizamos las cadenas para las fechas*/
			$fi = CicloMdl::invierteFecha($fi);
			$ff = CicloMdl::invierteFecha($ff);

			$query = 
				"INSERT INTO ciclo_escolar(nombre,fecha_inicio,fecha_fin)
				VALUES(
					\"$nombre\",			
					\"$fi\",
					\"$ff\"
				)";
				$res = $this->driver->query($query);
				/*echo 'res: ';
				var_dump($res);
				echo '<br>id: '.$this->driver->insert_id;
				exit();*/
				if($res){	
					return true;
				}
				else
					return false;
		}	

		function listar($nombre){

		}

		function mostrarCiclos($nombre){
			$cad = "<div class='dia-festivo' id='dia-festivo1'>
						<div id='close' class='close' onclick='eliminaDiaFestivo(1)'><img src='www/img/cerrar.png' alt='cerrar' width='15' />
						</div>

						<div class='linea'>							
							<label class='opt' for='fecha1'>Fecha:	</label>
							<input class='fecha' id='fecha1' class='input-mini' type='text' class='fecha' name='fecha1' placeholder='12/10/2013' value='12/10/2013' />
							<div class='clear'></div>
						</div>			
						<div class='linea'>
							<label class='opt' for='motivo1'>Causa:	</label>
							<input class='motivo' id='motivo1' class='input-medio' type='text' name='motivo1' value='Aniversario UDG' />
							<div class='clear'></div>
						</div>	
					</div>";

		}

		public function generarVistaListar($archivo,$menu,$datos=null) {
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
				
				$vista = str_replace('{nombre_para_menu}', $_SESSION['nombre'], $vista);
			}else{
				$vista.= file_get_contents('vista/pieSinMenu.html');
			}
			$contenido = file_get_contents('vista/'.$archivo);
			$inicio = strrpos($contenido,'<section');
			$fin = strrpos($contenido,'</section>') + 10;
			$contenido = substr($contenido, $inicio, $fin-$inicio);

			$inicio = strrpos($contenido, 'div class'); // obtenemos la posición donde se encuentrael div para cada ciclo
			$fin = strripos($contenido, '</div>')+6;

			
			$vista = str_replace('{contenido}', $contenido, $vista);

			/*se reemplazando los datos que hagan falta*/
			if($datos!==null){
				$vista = strtr($vista,$datos);
			}			
			
			echo $vista;
		}

	}
?>