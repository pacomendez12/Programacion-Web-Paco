<?php
class CursoMdl{
	public $driver;

	function __construct($driver) {
			/*$this->driver = new mysqli('localhost', 'cc409_user106', 'bNLQSfu005', 'cc409_user106');
			if($this->driver->connect_errno)
			die("no se pudo conectar");			*/
			$this->driver = $driver;
		}

function obtenAcademiasParaSelect(){
	$op = '<option value="{id_academia}">{nombre}</option>';
	$final = '';
	$query = "select * from academia";
	$resultado = $this->driver->query($query);
	if($resultado){
		while($fila = $resultado->fetch_array(MYSQLI_ASSOC)){
			$final.=$op;
			$final = str_replace('{nombre}', $fila['nombre'], $final);
			$final = str_replace('{id_academia}', $fila['id_academia'], $final).PHP_EOL;
		}
		return $final;
	} else{
		return '';
	}
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

function alta($nombre,$academia, $ciclo,$dias,$hi,$hf,$maestro) {
	$query = 
	"INSERT INTO curso VALUES(
		\"default\",
		\"$nombre\"	,			
		\"$ciclo\",
		\"$maestro\",
		\"$academia\"
		)";

	$resultado = $this->driver->query($query);
	$nrc = -1;
	if($resultado){
		$id = $nrc = $this->driver->insert_id;
		foreach ($dias as $d) {
			$dia = self::letraADia($d);
			$query =
			"INSERT INTO dias_clases VALUES(
				default,
				\"$dia\",
				\"$hi\",
				\"$hf\",
				\"$id\"
			)";
			$resultado = $this->driver->query($query);
		}
		if($resultado){
			return $nrc;
		}else{
			return false;;
		}
	}else{
		return false;
	}
}

function listar($lineaHtml){
			$codigo_maestro = $_SESSION['codigo'];
			$final = '';
			$query = "select nrc,nombre from curso where codigo_profesor='$codigo_maestro' order by nombre";
			$url1 = "index.php?ctl=curso&acc=configurar&nrc=";
			$url2 = "index.php?ctl=curso&acc=ver&nrc=";
			$url3 = "index.php?ctl=curso&acc=inscribir&nrc=";
			$resultado = $this->driver->query($query);
			if($resultado){
				$it = 1;
				while($fila = $resultado->fetch_array(MYSQLI_ASSOC)){
					if($fila['nombre']!='elimi'){
						$final.=$lineaHtml;
						$final = str_replace('{nombre_curso}', $it.' - '.$fila['nombre'], $final);
						$final = str_replace('{url-configurar}', $url1.$fila['nrc'], $final);
						$final = str_replace('{url-curso}', $url2.$fila['nrc'], $final);
						$final = str_replace('{url-inscribir}', $url3.$fila['nrc'], $final);
						$it++;
					}
				}
				return $final;
			} else{
				return '';
			}

		}


function eliminar($codigo){
	$query = "update alumno set status=0 where codigo='$codigo'";
	if($this->driver->query($query)){
		return true;
	}else{
		return false;
	}

}

function consulta($buscado) {
	$alumnos=array();
	if($buscado == null)
		$myquery = "select * from alumno where status=1";
	else
		$myquery = "select * from alumno where(
			codigo LIKE '%$buscado%' or
			nombre LIKE '%$buscado%' or
			apellidos LIKE '%$buscado%' or
			email LIKE '%$buscado%' or
			carrera LIKE '%$buscado%' or
			celular LIKE '%$buscado%' or
			github LIKE '%$buscado%' or
			pagina LIKE '%$buscado%') and status=1";
	$resultado = $this->driver->query($myquery);

	if($resultado){
		while($fila = $resultado->fetch_array(MYSQLI_ASSOC)){
			$alumnos[] = $fila;
		}
		return $alumnos;
	} else{
		return false;
	}
}

function letraADia($letra){
	switch ($letra) {
		case 'L':
			return "Lunes";
			break;
		case 'M':
			return "Martes";
			break;
		case 'I':
			return "Miércoles";
			break;
		case 'J':
			return "Jueves";
			break;
		case 'V':
			return "Viernes";
			break;
		case 'S':
			return "Sábado";
			break;
	}
}


function diaALetra($dia){
	switch ($dia) {
		case 'Lunes':
			return "L";
			break;
		case 'Martes':
			return "M";
			break;
		case 'Miércoles':
			return "i";
			break;
		case 'Jueves':
			return "J";
			break;
		case 'Viernes':
			return "V";
			break;
		case 'Sábado':
			return "S";
			break;
	}
}

function obtenDiasLaborales($curso){
	$query = "select nombre_ciclo_escolar from curso where nrc='$curso'";
	$res = $this->driver->query($query);
	$fechas = $res->fetch_array(MYSQLI_ASSOC);
	$ciclo = $fechas['nombre_ciclo_escolar'];
	$query = "select * from ciclo_escolar where nombre='$ciclo'";
	$res = $this->driver->query($query);
	$fechas = $res->fetch_array(MYSQLI_ASSOC);
	$fechaInicio = $fechas['fecha_inicio'];
	$fechaFin = $fechas['fecha_fin'];

	$query = "select dia from dias_clases where nrc=$curso";
	$res = $this->driver->query($query);
	$diasLaborales = $res->fetch_array(MYSQLI_ASSOC);


	$query = "select * from dias_de_suspension
		where nombre_ciclo_escolar=
			'$ciclo' and 
			fecha > '$fechaInicio' and 
			fecha < '$fechaFin'";
	$res = $this->driver->query($query);
	if($res){
		while($fila = $res->fetch_array(MYSQLI_ASSOC)){
			foreach ($diasLaborales as $d) {
				if(false){
					$dias[] = $fila;
				}	
			}
		}
	}

}



function invierteFecha($fecha){
	$fi_t = explode('/', $fecha);
	$fi=$fi_t[2].'/'.$fi_t[1].'/'.$fi_t[0];
	return $fi;
}

function nameDate($fecha='')//formato: 00/00/0000
{ 	
	date_default_timezone_set("America/Mexico_City");
	$dias = array('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo');
	$fecha = $dias[date('N', strtotime($fecha))];
	return $fecha;
}

}

?>
