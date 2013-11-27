<?php
	include('controlador/genericCtl.php');
	class UploadCtl extends generic{
		
		/*constructor*/
		function __construct($driver) {
			/*cargar modelo*/
			parent::__construct($driver);
			require_once("modelo/uploadMdl.php");
			$this->modelo = new UploadMdl($driver);
		}
	
		function ejecutar() {
			/*recibir acción*/
			switch($_GET["acc"]) {
				case "subir":
					if(empty($_FILES)){
					/*	require_once("vista/registro.html");*/
						self::generarVista('subirArchivo.html',true);
					}
					 else {
					 	/*obtener datos de POST*/
					 	//$codigo = $driver->real_escape_string($_POST["codigo"]);*/
					 	$resultado = $this->modelo->subir();
					 	
						if($resultado !== false){
							//self::generarVista('ArchivoSubido.html',true);
							$NOMBRE_ARCHIVO = $_FILES['archivo']['name'];
							
							require_once("controlador/procesaArchivoCtl.php");
							$ctl = new ProcesaArchivoCtl($this->driver);
							$ctl->ejecutar($NOMBRE_ARCHIVO);
						}else{
							require_once("vista/error.html");
						}
					}
				break;
				
			}
		}



		
	}
?>
