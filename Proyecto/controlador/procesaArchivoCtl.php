<?php
	require_once('controlador/genericCtl.php');
	class ProcesaArchivoCtl extends generic{
		/*constructor*/
		function __construct($driver) {
			/*cargar modelo*/
			parent::__construct($driver);
			require_once("modelo/procesaArchivoMdl.php");
			$this->modelo = new ProcesaArchivoMdl($driver);
		}
	
		function ejecutar($NOMBRE_ARCHIVO) {
			if(!isset($NOMBRE_ARCHIVO)){
			/*	require_once("vista/registro.html");*/
				self::generarVista('subirArchivo.html',true);
			}
			 else {
			 	$resultado = $this->modelo->procesar($NOMBRE_ARCHIVO);	
				if($resultado !== false){
					//self::generarVista('ArchivoSubido.html',true);
					//require_once("controlador/procesaArchivoCtl.php");
					
					//header('location: index.php?ctl=alumno&acc=listar');
				}else{
					require_once("vista/error.html");
				}
			}
		}	
	}
?>
