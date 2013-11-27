<?php
	//HTTP_REFERER
	//variable $_SERVER

	include('controlador/genericCtl.php');
	class LoginCtl extends generic{
		/*atributos*/
		public $modelo;
		
		/*constructor*/
		function __construct($driver) {
			/*cargar modelo*/
			parent::__construct($driver);
			require_once("modelo/loginMdl.php");
			$this->modelo = new LoginMdl($driver);
		}
	
		function ejecutar() {
			/*recibir acción*/
			if(!isset($_GET['acc'])){
				//session_start();
				if(!isset($_SESSION['codigo'])){
					
					if(empty($_POST)){
					/*	require_once("vista/registro.html");*/
						self::generarVista('login.html','Login',0);
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
							$_SESSION['codigo'] = $codigo;
							$_SESSION['permisos'] = $resultado;
							$_SESSION['nombre'] = $this->modelo->getNombreCompleto($codigo,$resultado);
							$_SESSION['correo'] = $this->modelo->getCorreo($codigo,$resultado);

							$arr = array('{nombre_centro}' => $_SESSION['nombre'] );
							switch ($resultado) {
								case 1:
									$view = 'administrador';
									break;
								case 2:
									$view = 'maestro';
									break;
								case 3:
									$view = 'alumno';
									break;
							}
							self::generarVista($view.'.html','Principal',$resultado,$arr);
						}else{
							self::generarVista('loginError.html','Error',0);
							echo '<script type="text/javascript">errorLogin()</script>';
						}
					}
				}else{
					$arr = array('{nombre_centro}' => $_SESSION['nombre'] );
					self::generarVista('alumno.html','Principal',$_SESSION['permisos'],$arr);
				}
			} else if($_GET['acc'] == 'out') {
				/*desloguear*/
				session_start();
				session_unset();
				session_destroy();
				setcookie(session_name(),'',time()-3600);
				header('location: index.php');
				//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php'>";
			} else {
				header('location: index.php');
				//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=index.php'>";
			}
		}
	}
?>
