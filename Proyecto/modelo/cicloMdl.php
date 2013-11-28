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

		function cambiaGuionPorBarra($fecha){
			return str_replace('-', '/', $fecha);
		}

		function nuevo($nombre,$fi,$ff) {
			/*reorganizamos las cadenas para las fechas*/
			$fi = CicloMdl::invierteFecha($fi);
			$ff = CicloMdl::invierteFecha($ff);

			$nombre = strtoupper($nombre);

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

		function clonar($nombre_clonado,$nombre,$fi,$ff) {
			/*reorganizamos las cadenas para las fechas*/
			$fi = CicloMdl::invierteFecha($fi);
			$ff = CicloMdl::invierteFecha($ff);

			$nombre = strtoupper($nombre);

			$query = 
				"INSERT INTO ciclo_escolar(nombre,fecha_inicio,fecha_fin)
				VALUES(
					\"$nombre\",			
					\"$fi\",
					\"$ff\"
				)";
			if($this->driver->query($query)){
				/*copiado de todos los días de descanso*/
				$query = "select * from dias_de_suspension
				where nombre_ciclo_escolar='$nombre_clonado'";
				if(($resultado = $this->driver->query($query))){
					while($fila = $resultado->fetch_array(MYSQLI_ASSOC)){
						$fec = $fila['fecha'];
						$mot = $fila['motivo'];
						$anio = substr($nombre, 0, -1);
						//echo 'anio: '.$anio;
						$fecha = substr($fec, 4,6);
						//echo 'fe si a: '.$fecha;
						$fec = $anio.$fecha;
						//echo $fec;
						//exit();
						$query = "insert into dias_de_suspension values(default,'$fec','$mot','$nombre')";
						$this->driver->query($query);
					}
				}else{
					return false;
				}
			}else{
				return false;
			}
		}

		function modificar($id,$fi,$ff) {
			/*reorganizamos las cadenas para las fechas*/
			$fi = CicloMdl::invierteFecha($fi);
			$ff = CicloMdl::invierteFecha($ff);


			$query = "UPDATE ciclo_escolar set fecha_inicio='$fi',fecha_fin='$ff'
					where nombre='$id'";
				
				$res = $this->driver->query($query);
				if($res){	
					return true;
				}
				else
					return false;
		}	

		function listar($lineaHtml){
			$final = '';
			$query = "select nombre from ciclo_escolar";
			$url = "index.php?ctl=ciclo&acc=modificar&nombre=";
			$resultado = $this->driver->query($query);
			if($resultado){
				while($fila = $resultado->fetch_array(MYSQLI_ASSOC)){
					if($fila['nombre']!='elimi'){
						$final.=$lineaHtml;
						$final = str_replace('{nombre_ciclo}', $fila['nombre'], $final);
						$final = str_replace('{url}', $url.$fila['nombre'], $final);
					}
				}
				return $final;
			} else{
				return '';
			}

		}

		function obtendDiasFestivos($lineaHtml,$nombre){
			$final = '';
			$query = "select id_dia,fecha,motivo from dias_de_suspension where nombre_ciclo_escolar='$nombre'";
			$resultado = $this->driver->query($query);
			if($resultado){
				while($fila = $resultado->fetch_array(MYSQLI_ASSOC)){
					$final.=$lineaHtml;
					$final = str_replace('{id}', $fila['id_dia'], $final);
					$final = str_replace('{fecha}', self::invierteFecha(self::cambiaGuionPorBarra($fila['fecha'])), $final);
					$final = str_replace('{motivo}', $fila['motivo'], $final);
				}
				
				return $final;
			} else{
				return '';
			}

		}

		function obtenDatosCiclo($nombre){
			$query = "select * from ciclo_escolar where nombre='$nombre'";
			$resultado = $this->driver->query($query);
			$fila = $resultado->fetch_array(MYSQLI_ASSOC);
			$fila['fecha_inicio'] = self::invierteFecha(self::cambiaGuionPorBarra($fila['fecha_inicio']));
			$fila['fecha_fin'] = self::invierteFecha(self::cambiaGuionPorBarra($fila['fecha_fin']));
			return $fila;
		}

		function obtenCiclosParaSelect(){
			$op = '<option value="{nombre}">{nombre}</option>';
			$final = '';
			$query = "select nombre from ciclo_escolar";
			$resultado = $this->driver->query($query);
			if($resultado){
				while($fila = $resultado->fetch_array(MYSQLI_ASSOC)){
					$final.=$op;
					$final = str_replace('{nombre}', $fila['nombre'], $final).PHP_EOL;				
				}
				return $final;
			} else{
				return '';
			}

		}

		function verificaExistenciaCiclo($nombre){
			$query = "select * from ciclo_escolar where nombre='$nombre'";
			$res = $this->driver->query($query);
			return ($res -> num_rows == 0)?false:true;
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

		function SiguienteIdDiaFestivo(){
			$id = false;
			$resultado = $this->driver->query("SELECT MAX(id_dia) AS id FROM dias_de_suspension");
			if($fila = $resultado->fetch_array(MYSQLI_ASSOC)){
				if($fila['id']==NULL)
					$id = 0;
				else
					$id = trim($fila['id']);
			}
			return $id;
		}

	}
?>