<?php
	class LoginMdl{
		public $driver;
		
		function __construct($driver) {
			$this->driver = $driver;
		}
	
		function entrar($codigo, $contras) {
			$query = 
				"select * from administrador where 
					codigo = \"$codigo\" and
					contrasena =\"$contras\"			
				";
			
			$resultado = $this->driver->query($query);
			if($resultado->num_rows > 0){
				return 1;
			}
			else{
				$query = 
				"select * from profesor where 
					codigo = \"$codigo\" and
					contrasena =\"$contras\"			
				";
			
				$resultado = $this->driver->query($query);
				if($resultado->num_rows > 0)
					return 2;
				else{
					$query = 
					"select * from alumno where 
						codigo = \"$codigo\" and
						contrasena =\"$contras\" and
						status=1			
					";
				
					$resultado = $this->driver->query($query);
					
					if($resultado->num_rows > 0)
						return 3;
				}
			}
			//regresa 1 si es admin, 2 si es maestro y 3 si es alumno, 0 en caso de error
			return 0;
		}

		function getNombreCompleto($codigo,$tipo){
			$query = 'select concat(nombre," ",apellidos) as name from ';
			switch ($tipo) {
				case 1:
					$query.='administrador';
					break;
				case 2:
					$query.='profesor';
					break;
				case 3:
					$query.='alumno';
					break;
			}
			$query.=" where codigo = \"$codigo\"";
			//echo $query;
			$resultado = $this->driver->query($query);
			$nombre = $resultado->fetch_assoc();
			return $nombre['name'];
		}

		function getCorreo($codigo,$tipo){
			$query = 'select email from ';
			switch ($tipo) {
				case 1:
					$query.='administrador';
					break;
				case 2:
					$query.='profesor';
					break;
				case 3:
					$query.='alumno';
					break;
			}
			$query.=" where codigo = \"$codigo\"";
			//exit();
			$resultado = $this->driver->query($query);
			$nombre = $resultado->fetch_assoc();
			return $nombre['email'];
		}

	}
?>