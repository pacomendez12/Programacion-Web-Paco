<?php
	include('controlador/genericCtl.php');
	class PrincipalCtl extends generic{
		function ejecutar() {
			/*require_once('vista/principal.html');*/
			self::generarVista('principal.html',false);
		}
	}
?>
