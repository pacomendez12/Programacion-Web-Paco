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
				if($resultado != 0){
					if($resultado > 0){
						$errores = '';
					}else{
						$resultado*=-1;
						$errores = "<p class=\"desplazar\">No se pudieron insertar todos los registros</p>";
					}
					$alumnos = '<br>';
						$arr = $this->modelo->getAlumnos();
						foreach ($arr as $al) {
							$alumnos.='<strong>Código: </strong>'.$al[0].'<br>';
							$alumnos.='<strong>Nombre: </strong>'.$al[1].'<br>';
							$alumnos.='<strong>Apellidos: </strong>'.$al[2].'<br>';
							$alumnos.='<strong>Correo: </strong>'.$al[4].'<br>';
							$alumnos.='<strong>Carrera: </strong>'.$al[5].'<br>';
							$alumnos.='<strong>Celular: </strong>'.$al[6].'<br>';
							$alumnos.='<strong>Cuenta Github: </strong>'.$al[7].'<br>';
							$alumnos.='<strong>Página Web: </strong>'.$al[8].'<br><hr>';
						}
						$array = array(
						'{botones}' => self::obtenBotonesMenuSuperior('alumno'),
						'{numero}' => $resultado,
						'{alumnos}' => $alumnos,
						'{errores}' => $errores
						);
					
						self::generarVista('alumnosAgregados.html','Alumnos Agregados correctamente',$_SESSION['permisos'],$array);
				}else{
					$mensaje = array('{mensaje}' => 'El archivo no contiene el formato necesario para
						poder ser procesado, recuerda que el formato debe ser:<br><br>
						<strong>codigo,nombre,apellidos,contraseña,email,carrera,celular,github,pagina</strong><br>
						en caso de no tener celular, github o pagina, recuerda dejar los espacio en blanco');
					self::generarVista('error.html','Error subiendo el archivo',0,$mensaje);
				}
			}
		}	
	}
?>
