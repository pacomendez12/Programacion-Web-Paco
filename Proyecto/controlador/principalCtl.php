<?php
	include('controlador/genericCtl.php');
	class PrincipalCtl extends generic{
		function ejecutar() {
			/*require_once('vista/principal.html');*/
			$arrayName = array('{titulo_pagina}' => 'Pagina principal' );
			self::generarVista('principal.html','Pagina principal',0,$arrayName);
		}
	}
?>
