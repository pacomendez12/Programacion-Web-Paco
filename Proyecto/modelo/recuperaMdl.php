<?php
	class RecuperaMdl{
		public $driver;
		
		function __construct($driver) {
			$this->driver = $driver;
		}
	
		function recuperar($email) {
			include("PHPMailer/class.phpmailer.php");
			include("PHPMailer/class.smtp.php");
			/*$query = 
				"INSERT INTO alumno(id,nombre,correo,ap)
				VALUES(
					default,
					\"$codigo\",
					\"\"	,			
					\"\"
				)";*/
			/*$this->driver->query($query);
			if($this->driver->insert_id)
				return $this->driver->insert_id;
			else
				return false; */

			/*envío del correo*/
			/*$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "tls";
			$mail->CharSet="UTF-8";
			$mail->Host = "smtp.gmail.com";
			$mail->Port = 587;
			$mail->Username = "pacomendez12@gmail.com";
			$mail->Password = "Pacotorro12@";
			$mail->From = 'pacomendez12@gmail.com';
			$mail->FromName = 'Francisco Méndez';
			$mail->IsHTML(true);
			$mail->Subject = "Cuenta en el sistema de calificaciones";
			$mail->AltBody = "Hola,\neste correo ha sido enviado desde PHP usando PHPMailer.";
			$mail->MsgHTML("Hola,<br>este correo ha sido enviado desde PHP usando <strong>PHPMailer</strong>.");
			
			$mail->WordWrap = 50;  
			$mail->Body = "fdlfjaf";  

			$mail->AddAddress($correo);
			if(!$mail->Send()) {
			  echo "<br>Error: " . $mail->ErrorInfo;
			} else {
			  echo "<br>Mensaje enviado.";
			}*/
			return true;
		}
	}

?>