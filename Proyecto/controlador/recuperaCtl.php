<?php
	include('controlador/genericCtl.php');
	class RecuperaCtl extends generic{
		/*atributos*/
		public $modelo;
		
		/*constructor*/
		function __construct($driver) {
			/*cargar modelo*/
			require_once("modelo/recuperaMdl.php");
			$this->modelo = new RecuperaMdl($driver);
		}
	
		function ejecutar() {
			/*recibir acción*/
					if(empty($_POST)){
					/*	require_once("vista/registro.html");*/
						self::generarVista('recupera_contrasena.html','Recuperación de contraseña',0);
					}
					 else {
					 	/*obtener datos de POST*/
					 	/*$codigo = $con->real_escape_string($_POST["codigo"]);*/
					 	$email = $_POST['email'];
					 	unset($_POST);
					 	$datos = array('{email}' => $email);
						$resultado = $this->modelo->recuperar($email);
						if($resultado !== false){
							self::generarVista('confirma_recupera_contrasena.html','Contraseña modificada',0,$datos);
						}else{
							require_once("vista/error.html");
						}
					}

			
		}
	}
?>
