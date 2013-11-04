<?php
	include('controlador/genericCtl.php');
	class LoginCtl extends generic{
		/*atributos*/
		public $modelo;
		
		/*constructor*/
		function __construct($driver) {
			/*cargar modelo*/
			require_once("modelo/loginMdl.php");
			$this->modelo = new LoginMdl($driver);
		}
	
		function ejecutar() {
			/*recibir acción*/
			if(!isset($_GET['acc'])){
					if(empty($_POST)){
					/*	require_once("vista/registro.html");*/
						self::generarVista('login.html',false);
					}
					 else {
					 	/*obtener datos de POST*/
					 	/*$codigo = $con->real_escape_string($_POST["codigo"]);*/
					 	$codigo = $_POST["codigo"];
					 	$contrasena = $_POST["contrasena"];
					 	unset($_POST);
						$resultado = $this->modelo->entrar($codigo,$contrasena);

						if($resultado !== 0){
							/*require_once("vista/listaAlumnoView.html");*/
							self::generarVista('alumno.html',true);
						}else{
							self::generarVista('loginError.html',false);
							echo '<script type="text/javascript">errorLogin()</script>';
						}
					}
			} else if($_GET['acc'] == 'out') {
				/*desloguear*/
				echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php'>";
			} else {
				echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php'>";
			}
		}
	}
?>
