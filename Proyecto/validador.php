<?php
	
	function validaFecha($cad){
		return preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $cad);
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

	//function valida

?>
