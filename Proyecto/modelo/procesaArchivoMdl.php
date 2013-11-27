<?php
	class ProcesaArchivoMdl{
		public $driver;
		
		function __construct($driver) {
			$this->driver = $driver;
		}
	
		function procesar($file) {
			$renglones = file('uploads/'.$file);
			//separa por comas
			foreach ($renglones as &$renglon) {
				$renglon = explode(',', $renglon);
				var_dump($renglon);
				echo '<br>';
			}

			exit();
			return true;
		}
	}

?>
