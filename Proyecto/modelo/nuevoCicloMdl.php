<?php
	class NuevoCicloMdl{
		public $driver;
		
		function __construct() {
			$this->driver = new mysqli('localhost', 'cc409_user106', 'bNLQSfu005', 'cc409_user106');
			if($this->driver->connect_errno)
				die("no se pudo conectar");			
		
		}
	
		/**
		*@args
		*
		*/
		function nuevo($nombre,$f_i,$f_f,$fecha1,$motivo1) {
			$query = 
				"INSERT INTO ciclo_escolar(nombre,fecha_inicio,fecha_fin)
				VALUES(
					\"$nombre\",			
					\"$f_i\",
					\"$f_f\"
				)";
				$this->driver->query($query);
				if($this->driver->insert_id)
					return $this->driver->insert_id;
				else
					return false;
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
	}

?>