<?php
	
	function validaFecha($cad){
		return preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $cad);
	}
	
	function validaFechaInvertida($cad){
		return preg_match("/^\d{4}\/\d{2}\/\d{2}$/", $cad);
	}

	function validaCiclo($cad){
		return preg_match("/^\d\d\d\d[A,B,a,b]$/", $cad);
	}

	function validaCodigo($cad){
		return is_int($cad);
	}

	function validaNombre($cad){
		return preg_match("/^([a-zA-Z ñÑáéíóúÁÉÍÓÚüÜ])*$/", $cad);
	}

	/*function valida*/
	
	
	
		function invierteFecha($fecha){
			$fecha = str_replace('\\', '', $fecha);
			$fi_t = explode('/', $fecha);
			$fi=$fi_t[2].'/'.$fi_t[1].'/'.$fi_t[0];
			return $fi;
		}

		function cambiaGuionPorBarra($fecha){
			return str_replace('-', '/', $fecha);
		}

?>
