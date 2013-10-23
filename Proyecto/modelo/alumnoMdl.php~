<?php
	class AlumnoMdl{
		public $driver;
		
		function __construct() {
			$this->driver = new mysqli('localhost', 'cc409_user106', 'bNLQSfu005', 'cc409_user106');
			if($this->driver->connect_errno)
				die("no se pudo conectar");			
		
		}
	
		function alta($codigo, $nombre, $ap) {
			$query = 
				"INSERT INTO alumno(id,nombre,correo,ap)
				VALUES(
					default,
					\"$codigo\",
					\"$nombre\"	,			
					\"$ap\"
				)";
			$this->driver->query($query);
			if($this->driver->insert_id)
				return $this->driver->insert_id;
			else
				return false; 
		}
		
		function consulta() {
			$resultado = $con->query($myquery);
			
			while($fila = $resultado->fetch_array(MYSQLI_ASSOC)){
				$alumnos[] = $fila;
			}
		}	
	
	}

?>