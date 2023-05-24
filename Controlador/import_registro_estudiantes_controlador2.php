 <?php
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;
 require '../Vendor_mail/vendor/autoload.php';
 
                 function token_u ($long){
                     $cadena = "1234567890";
                     $token_usuario = "";
                 
                     for ($i=0; $i < $long; $i++) { 
                         # code...
                         $token_usuario .= $cadena[rand(0, $long)]; //rand genera un número aleatorio desde un mínimo a un máximo, en este caso el mínimo será cero y el máximo la longitud
                     }
                     return $token_usuario;
                 };
                 $num_user = token_u(4);
 
                 function gtoken ($longitud){
                     $cadena = "_@&1Aa2Bb3Cc4Dd5Ee6Ff7Gg8Hh9Ii0JjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz_";
                     $token_pass = "";
                 
                     for ($i=0; $i < $longitud; $i++) { 
                         # code...
                         $token_pass .= $cadena[rand(0, $longitud)]; //rand genera un número aleatorio desde un mínimo a un máximo, en este caso el mínimo será cero y el máximo la longitud
                     }
                     return $token_pass;
                 };          
                 
                 function enviar_mail ($destino, $mensaje1, $mensaje2){
                     $mail = new PHPMailer(TRUE);
                     try {
                         $mail -> isSMTP(); //PARA INDICAR QUE VAMOS A UTILIZAR ESTA TECNOLOGIA
                         $mail -> Host = /*'smtp.gmail.com'*/'smtp.mail.yahoo.com'; //AQUI VAMOS A INDICAR EL HOST
                         $mail -> SMTPAuth = true; //INDICAMOS QUE VAMOS A TENER AUTENTICACION DE ESE MTP
                         $mail -> Username = /*'ainformatica2020@gmail.com'*/'victoria.alejandra_aguilar@yahoo.es'; // AQUI COLOCAREMOS NUESTRO CORREO ELECTRÓNICO
                         $mail -> Password = /*'zbpjaxyvanzaoyod'*/'djvkrsvamrjhoado'; //CONTRASEÑA DEL CORREO, no es de acceso sino para que una aplicación se pueda conectar al servidor
                         $mail -> SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //INDICAR LA SEGURIDAD CON LA QUE SE VA A TRABAJAR, LO ENCONTRARAS EN LA CONFIGURACIÓN SMTP DE TU CUENTA, POR EJEMPLO EL CIFRADO 465 SSL Y 587 TLS
                         $mail -> Port = 587;
                 
                         //Ahora haremos el envío
                         $mail -> SetFrom('victoria.alejandra_aguilar@yahoo.es', 'Informatica UNAH'); //Dirección desde donde vas a enviar los correos
                         $mail -> AddAddress($destino);//Dirección en la cual va a recibir este correo, también puedes agregar título
                                         
                         //Ahora indicaremos el tipo de corre electrónico que podemos enviar, puede ser uno de texto simple pero, también podemos enviar uno tipo HTML, donde ya podemos agregar imágenes y tags de HTML
                         $mail -> isHTML(True);
                         $mail -> Subject = 'Credenciales de Usuario'; //ESto es el título
                         $mail -> Body = 'Su nombre de usuario es: '.$mensaje1. ' y su contrase&ntilde;a: '.$mensaje2.' para su ingreso al sistema.';
                         $mail -> Send();
 
                     } catch (Exception $e) {
                     }
                 }
 ?>