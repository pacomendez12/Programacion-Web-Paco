<?php
include("PHPMailer/class.phpmailer.php");
include("PHPMailer/class.smtp.php");
class ProcesaArchivoMdl{
	public $driver;
	public $alumnos;

	function __construct($driver) {
		$this->driver = $driver;
		$this->alumnos = array();
	}

	function getAlumnos(){
		return $this->alumnos;
	}

	function procesar($file) {
		$cont = 0;
		$band = true;
		$renglones = file('uploads/'.$file);
		//separa por comas
		foreach ($renglones as &$renglon) {
			$renglon = explode(',', $renglon);
			if(count($renglon)!==9){
				//unlink('uploads/'.$file);
				//return -1 * $cont;
				$band = false;
			}else{
				$codigo = trim($this->driver->real_escape_string($renglon[0]));
				$nombre = trim($this->driver->real_escape_string($renglon[1]));
				$apellidos = trim($this->driver->real_escape_string($renglon[2]));
				$contrasena = trim($this->driver->real_escape_string($renglon[3]));
				$correo = trim($this->driver->real_escape_string($renglon[4]));
				$carrera= trim($this->driver->real_escape_string($renglon[5]));
				$celular = trim($this->driver->real_escape_string($renglon[6]));
				$github = trim($this->driver->real_escape_string($renglon[7]));
				$pagina = trim($this->driver->real_escape_string($renglon[8]));
				if(self::alta($codigo,$nombre,$apellidos,$contrasena,$correo,$carrera,$celular,$github,$pagina)){
					$cont++;
					array_push($this->alumnos, $renglon);
				}else{
					$band = false;
				}
			}
		}
		unlink('uploads/'.$file);
		if($band==false)
			return (-1 * $cont);
		return $cont;
	}

	function alta($codigo, $nombre, $ap, $pass, $correo, $carrera, $celular,$github ,$pagina) {		
		/*al guardar la contraseña hay que cifrarla con sha1*/
		$passDB = sha1($pass);
		$query = 
		"INSERT INTO alumno VALUES(
			\"$codigo\",
			\"$nombre\"	,			
			\"$ap\",
			\"$passDB\",
			\"$correo\",
			\"$carrera\",
			true,
			\"$celular\",
			\"$github\",
			\"$pagina\"
			)";

		$resultado = $this->driver->query($query);
		
		if($resultado == true){
		}
		else{
			return false;
		}

		$mensaje="Hola $nombre $ap <br>";
		$mensaje.="Ha sido creada tu cuenta en el sistema de calificaciones<br>";
		$mensaje.="a continuación te proporcionamos tus datos:<br><br><br>";			
		$mensaje.="Tu código es: $codigo <br>Tu contraseña es: $pass";
		$mensaje.="<br><br>Para ingresar al sistema da en el sieguiente link: <a href='http://alanturing.cucei.udg.mx/cc409/user106/index.php?ctl=login'>http://alanturing.cucei.udg.mx/cc409/user106/index.php?ctl=login</a>";


		/*envío del correo*/
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "tls";
		$mail->CharSet="UTF-8";
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 587;
		$mail->Username = "pacomendez1210@gmail.com";
		$mail->Password = "pacotorro";
		$mail->From = 'pacomendez1210@gmail.com';
		$mail->FromName = 'Francisco Méndez';
		$mail->IsHTML(true);
		$mail->Subject = "Cuenta en el sistema de calificaciones";
		$mail->AltBody = "Tu código es: $codigo\nTu contraseña es: $pass";
		$mail->MsgHTML($mensaje);

		/*$mail->WordWrap = 50;*/  
		/*$mail->Body = "Tu código es: $codigo <br>Tu contraseña es: $pass";*/  

		$mail->AddAddress($correo);
		if(!$mail->Send()) {
					  //echo "<br>Error: " . $mail->ErrorInfo;
		}
		return true;
	}
}

?>
