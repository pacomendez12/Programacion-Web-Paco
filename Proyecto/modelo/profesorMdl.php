<?php
class ProfesorMdl{
	public $driver;

	function __construct($driver) {
			/*$this->driver = new mysqli('localhost', 'cc409_user106', 'bNLQSfu005', 'cc409_user106');
			if($this->driver->connect_errno)
			die("no se pudo conectar");			*/
			$this->driver = $driver;
		}

function alta($nombre, $ap, $correo) {
	include("PHPMailer/class.phpmailer.php");
	include("PHPMailer/class.smtp.php");
	
	$pass = self::generaContra();
	/*al guardar la contraseña hay que cifrarla con sha1*/
	$passDB = sha1($pass);
	$query = 
	"INSERT INTO profesor VALUES(
		default,
		\"$nombre\"	,			
		\"$ap\",
		\"$passDB\",
		\"$correo\"
		)";
	$resultado = $this->driver->query($query);
	if($resultado == 1){
		$codigo = $this->driver->insert_id;
	}
	else{
		return false;
	}

	$mensaje="Hola $nombre $ap <br>";
	$mensaje.="Ha sido creada tu cuenta de maestro en el sistema de calificaciones<br>";
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

function generaContra() {
	$a = sha1("contraseña");
	$a = str_shuffle($a.'abcdefghijklmnopqrstuvwxyz0123456789#@,.');
	$c = substr($a,1,8);
	$b = strtoupper(substr($a,10,8));
	$a=$b.$c;
	$a = str_shuffle($a);
	$a = strrev($a);
	return substr($a,0,12);
}

function consulta($buscado) {
	$alumnos = array();
	if($buscado == null)
		$myquery = "select * from profesor";
	else
		$myquery = "select * from profesor where(
			codigo LIKE '%$buscado%' or
			nombre LIKE '%$buscado%' or
			apellidos LIKE '%$buscado%' or
			email LIKE '%$buscado%')";

	$resultado = $this->driver->query($myquery);
	
	
	if($resultado){
		while($fila = $resultado->fetch_array(MYSQLI_ASSOC)){
			$alumnos[] = $fila;
		}
		return $alumnos;
	} else{
		return false;
	}
}	

}

?>
