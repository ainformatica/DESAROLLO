<?php

require __DIR__ . '/../../vendor/autoload.php';

//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;

class enviarCorreo{

	public function correoActivarCuenta(string $email,string $token_verifid){
		$mail = new PHPMailer(true);
		try {
		// Configuraciones del servidor
		$mail->SMTPDebug = false;	// Habilitar salida de depuración detallada
		$mail->isSMTP(); 			// Configurar el remitente para usar SMTP
		$mail->Host = 'smtp.gmail.com'; // Especificar servidores SMTP principales y de respaldo
		$mail->SMTPAuth = true;         // Habilitar autenticación SMTP
		$mail->Username = 'correo@email.com';  // Nombre de usuario SMTP, correo que prestara el servicio de la cuenta que enviara los correos
		$mail->Password = 'contraseña';  // Contraseña SMTP, clave del correo 
		$mail->SMTPSecure = 'ssl';     // Habilitar enciptación SSL, TLS también aceptado con el puerto 587
		$mail->Port = 465;             // Puerto TCP para conectarse

		//Destinatarios
		$mail->setFrom('correo@email.com', 'nombre');
		$mail->addAddress('correo@email.com', 'Nombre del destinatario');// Agregar un destinatario
		//$mail->addAddress('contacto@example.com'); // Nombre es opcional
		//$mail->addReplyTo('info@example.com', 'Información');
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');

		//Archivos adjuntos
		//$mail->addAttachment('/var/tmp/archivo.tar.gz');// Añadir archivos adjuntos
		//$mail->addAttachment('/tmp/imagen.jpg', 'nuevo.jpg');// Nombre es opcional

		//Contenido
		$mail->isHTML(true);  // Establecer formato de correo electrónico a HTML
		$mail->Subject = 'describa el asusnto';
		$mail->Body    = "aqui el cuerpo del mensaje http://localhost:8080/recuperar_contrasena.php?token='".$token."'";
		//$mail->AltBody = 'Este es el cuerpo en texto plano para clientes de correo no HTML';

		
		$mail->send();
	
		return true;

		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}

	public function correoRecuperarContrasena($correo,$token,$usuario){
		$mail = new PHPMailer(true);
		try {
		// Configuraciones del servidor
		$mail->SMTPDebug = false;	// Habilitar salida de depuración detallada
		$mail->isSMTP(); 			// Configurar el remitente para usar SMTP
		$mail->Host = 'smtp.gmail.com'; // Especificar servidores SMTP principales y de respaldo
		$mail->SMTPAuth = true;         // Habilitar autenticación SMTP
		$mail->Username = 'correo que prestara el servicio';  // Nombre de usuario SMTP, correo que prestara el servicio de la cuenta que enviara los correos
		$mail->Password = 'la contraseña de dicho correo';  // Contraseña SMTP, clave del correo 
		$mail->SMTPSecure = 'ssl';     // Habilitar enciptación SSL, TLS también aceptado con el puerto 587
		$mail->Port = 465;             // Puerto TCP para conectarse

		//Destinatarios
		$mail->setFrom($correo,"App Informatica - UNAH");
		$mail->addAddress($correo, $usuario);// Agregar un destinatario
		//$mail->addAddress('contacto@example.com'); // Nombre es opcional
		//$mail->addReplyTo('info@example.com', 'Información');
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');

		//Archivos adjuntos
		//$mail->addAttachment('/var/tmp/archivo.tar.gz');// Añadir archivos adjuntos
		//$mail->addAttachment('/tmp/imagen.jpg', 'nuevo.jpg');// Nombre es opcional

		//Contenido
		$mail->isHTML(true);  // Establecer formato de correo electrónico a HTML
		$mail->Subject = 'Recuperacion de contraseña';
		$mail->Body    = "Usted a solicitado una recuperacion de contraeña, para los servicios de App Informatica<br><br><br>A continuacion haga click en el siguiente enlace, para realizar un cambio de contraseña <br>http://localhost/modulos/seguridad/autenticacion/recuperar_contrasena.php?token='".$token."'";
		//$mail->AltBody = 'Este es el cuerpo en texto plano para clientes de correo no HTML';

		
		$mail->send();
	
		return true;

		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}

}
