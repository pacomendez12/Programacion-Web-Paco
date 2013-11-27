<?php
	include('controlador/genericCtl.php');
	class ConfirmacionCtl extends generic{
		/*atributos*/
		public $modelo;
		
		/*constructor*/
		function __construct($driver) {

		}
	
		function ejecutar() {
			/*recibimos el email para mostrarlo en la página*/
					if(!empty($_POST)){
						/*require_once("vista/registro.html");*/
						$email = $_POST['email'];
						self::generarVista('recupera_contrasena.html','Recuperación de contraseña',false);
					}
					 else {
							require_once("vista/error.html");
					}

			
		}
	}
?>
