<?php
	class AlumnoMdl{
		public $driver;
		
		function __construct() {
			/*$this->driver = new mysqli('localhost', 'cc409_user106', 'bNLQSfu005', 'cc409_user106');
			if($this->driver->connect_errno)
				die("no se pudo conectar");			*/
		
		}
	
		function alta($codigo, $nombre, $ap, $correo, $carrera) {
			include("PHPMailer/class.phpmailer.php");
			include("PHPMailer/class.smtp.php");
			$query = 
				"INSERT INTO alumno(id,nombre,correo,ap)
				VALUES(
					default,
					\"$codigo\",
					\"$nombre\"	,			
					\"$ap\"
				)";
			/*$this->driver->query($query);
			if($this->driver->insert_id)
				return $this->driver->insert_id;
			else
				return false; */

			/*envío del correo*/
			echo '<br> Antes de enviar correo';
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "ssl";
			$mail->Host = "smtp.gmail.com";
			$mail->Port = 465;
			$mail->Username = "pacomendez12@gmail.com";
			$mail->Password = "Pacotorro12@";
			$mail->From = 'pacomendez12@gmail.com';
			$mail->FromName = 'Francisco Méndez';
			$mail->Subject = "Cuenta en el sistema de calificaciones";
			$mail->AltBody = "Hola,\neste correo ha sido enviado desde PHP usando PHPMailer.";
			$mail->MsgHTML("Hola,<br>este correo ha sido enviado desde PHP usando <strong>PHPMailer</strong>.");

			$mail->AddAddress($correo, $nombre.' '.$ap);
			$mail->IsHTML(true);
			if(!$mail->Send()) {
			  echo "Error: " . $mail->ErrorInfo;
			} else {
			  echo "Mensaje enviado.";
			}

		}
		
		function consulta() {
			$resultado = $con->query($myquery);
			
			while($fila = $resultado->fetch_array(MYSQLI_ASSOC)){
				$alumnos[] = $fila;
			}
		}	
	
	}

?>