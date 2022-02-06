<?php

ob_start(); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

class SendEmail
 {

    public function enviarCorreo($correo, $asunto, $mensaje, $mensajeAlternativo)
    {
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {

            //Server settings
            $mail->SMTPDebug = false;                                   //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );                                                          //Para error de smtp
            $mail->Encoding = 'base64';                                 //Para los caracteres y acentos
            $mail->CharSet = 'UTF-8';                                   //Para los caracteres y acentos
            $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'jnstreel@gmail.com';                   //SMTP username
            $mail->Password   = 'Jnoestreel-15';                        //SMTP password
            $mail->SMTPSecure = 'tls';                                  //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('jnstreel@gmail.com', 'Informática Administrativa');
            $mail->addAddress($correo);                                 //Add a recipient
            //$mail->addAddress('ellen@example.com');                   //Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');             //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');        //Optional name

            //Content
            $mail->isHTML(true);                                           //Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body    = $this->estructuraCorreo($mensaje);
            $mail->AltBody = $mensajeAlternativo;

            if($mail->send())
            {
                return true;
            }else
            {
                return false;
            }
             //'El correo se envió correctamente';
        } catch (Exception $e) {
            //echo $mail->ErrorInfo;
            return false;
            //echo "Error al enviar el correo. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    //Diseño del correo
    private function estructuraCorreo($mensaje)
    {
        $message  = "<html><body>";
   
            $message .= "<table width='100%' bgcolor='#e0e0e0' cellpadding='0' cellspacing='0' border='0'>";
               
            $message .= "<tr><td>";
               
            $message .= "<table align='center' width='100%' border='0' cellpadding='0' cellspacing='0' style='max-width:650px; background-color:#fff; font-family:Verdana, Geneva, sans-serif;'>";
                
            $message .= "<thead>
              <tr height='80'>
              <th colspan='4' style='background-color:#000080; border-bottom:solid 1px #bdbdbd; font-family:Verdana, Geneva, sans-serif; color:#FFFFFF; font-size:30px;' >Carrera informática Administrativa</th>
              </tr>
                         </thead>";
                
            $message .= $mensaje;
                
            $message .= "</table>";
               
            $message .= "</td></tr>";
            $message .= "</table>";
               
            $message .= "</body></html>";

            return $message;
    }
}

ob_end_flush();
