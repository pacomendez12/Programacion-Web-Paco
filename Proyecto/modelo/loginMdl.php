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
						contrasena =\"$contras\"			
					";
				
					$resultado = $this->driver->query($query);
					
					if($resultado->num_rows > 0)
						return 3;
				}
			}

			//regresa 1 si es admin, 2 si es maestro y 3 si es alumno, 0 en caso de error
			return 0;
		}
	}

?>