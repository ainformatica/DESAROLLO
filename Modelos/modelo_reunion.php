<?php
ob_start();
session_start();
require_once('../PHPMAILER/PHPMailer.php');
require_once('../PHPMAILER/SMTP.php');
require_once('../PHPMAILER/Exception.php');
require_once('../clases/Conexion.php');
$enlace = $_POST['NULL'];
$agenda = $_POST['agenda'];
$agendaformato = nl2br($agenda);
$asunto = $_POST['asunto'];
$enlace = $_POST['enlace'];
$estado = $_POST['estado'];
$fecha = $_POST['fecha'];
$fecha_formateada = date('Y-m-d', strtotime($fecha));
$horafinal = $_POST['horafinal'];
$horainicio = $_POST['horainicio'];
$horainiciof = date('H:i;s', strtotime($horainicio));
$lugar = $_POST['lugar'];
$nombre = $_POST['nombre'];
$tipo = $_POST['tipo'];
$anio_formateada = date('Y', strtotime($fecha));
$correojefatura = 'patricia.ellner@unah.edu.hn';
if ($_POST['clasif'] == '2'){
    $participante = $_POST['chk'];
    $categoria = 'ASAMBLEA';
}
if ($_POST['clasif'] == '3'){
    $participante = $_POST['chknormal'];
    $categoria = 'REUNIONES DE DEPARTAMENTO';
}

if ($_POST['reunion'] == 'nuevo') {
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    try {
        $stmt = $mysqli->prepare("INSERT INTO tbl_reunion (id_tipo, id_estado, fecha, nombre_reunion, lugar, enlace, hora_inicio, hora_final, asunto, agenda_propuesta, categoria) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("iisssssssss", $tipo, $estado, $fecha_formateada, $nombre, $lugar, $enlace, $horainicio, $horafinal, $asunto, $agenda, $categoria);
        $stmt->execute();
        $id_registro = $stmt->insert_id;
        $id_reunion = $id_registro;
        foreach ($participante as $par) {
            if ($_POST['clasif'] == '2'){
                $part = $par - 10000;
                $stmt = $mysqli->prepare("INSERT INTO tbl_participantes (id_reunion, id_persona) VALUES (?,?)");
                $stmt->bind_param("ii", $id_reunion, $part);
                $stmt->execute();
            }
            if ($_POST['clasif'] == '3'){
                $stmt = $mysqli->prepare("INSERT INTO tbl_participantes (id_reunion, id_persona) VALUES (?,?)");
                $stmt->bind_param("ii", $id_reunion, $par);
                $stmt->execute();
            }
        }
 

        if ($id_registro > 0) {
            $respuesta = array(
                'respuesta' => 'exito',
                'id_registro' => $id_registro
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }
               $dtz = new DateTimeZone("America/Tegucigalpa");
        $dt = new DateTime("now", $dtz);
        $hoy = $dt->format("Y-m-d H:i:s");
        $id_objetoac = 5000;
        $id_userac = $_SESSION['id_usuario'];
        $accionac = 'INSERTO';
        $descripcionac= 'la reunion con nombre: '.$nombre;
        $fechaac = $hoy;
        $stmt = $mysqli->prepare("INSERT INTO `tbl_bitacora` (`Id_usuario`, `Id_objeto`, `Fecha`, `Accion`, `Descripcion`) VALUES (?,?,?,?,?)");
        $stmt->bind_param("iisss", $id_userac, $id_objetoac, $fechaac, $accionac, $descripcionac);
        $stmt->execute();

        //Server settings
        $correo = 'jefatura@informaticaunah.com';
        $Password = 'J3f@tur@';
        $mail->SMTPDebug = 0;                      //Enable verbose debug output                                          //Send using SMTP
        $mail->Host = 'informaticaunah.com';
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username = $correo;
        $mail->Password = $Password;                              //SMTP password          //Enable implicit TLS encryption
        //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        //Recipients

        $stmt->close();
        $mail->setFrom($correo, 'Jefatura Departamento de Informática');
        $sql = "SELECT t1.valor AS participantes FROM tbl_contactos t1 INNER JOIN tbl_personas t2 ON t2.id_persona = t1.id_persona INNER JOIN tbl_participantes t3 ON t3.id_persona = t2.id_persona WHERE t1.id_tipo_contacto = 4 and t3.id_reunion = $id_reunion";
        $res = $mysqli->query($sql);
        while ($destino = $res->fetch_assoc()) {
            $email = $destino['participantes'];
            $mail->addAddress($email);
        }
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = "$asunto";
        $body  = "<h1><b>MEMORÁNDUM IA-$id_registro/$anio_formateada</b></h1><br>";
        $body .= "Nombre Reunión: <strong>$nombre</strong><br>";
        $body .= "Categoria de la Reunión: <strong>$categoria</strong><br>";
        $body .= "Lugar: <strong>$lugar</strong><br>";
        $body .= "Fecha: <strong>$fecha</strong><br>";
        $body .= "Hora de Inicio: <strong>$horainicio</strong><br>";
        $body .= "Hora Final: <strong>$horafinal</strong><br>";
        $body .= "Asunto: <strong>$asunto</strong><br>";
        $body .= "<br>";
        $body .= "Por medio de la presente se notifica que el <strong>$fecha</strong>";
        $body .= " se realizará la reunión con asunto: <strong>$asunto</strong>,";
        $body .= " lugar: <strong>$lugar</strong>";
        $body .= " en el horario de <strong>$horainicio</strong>";
        $body .= " a <strong>$horafinal</strong> con los siguientes puntos a tratar: <br><br>";
        $body .= "<strong>AGENDA</strong><br><br>";
        $body .= "<strong>$agendaformato</strong><br>";
        $body .= "<br>";
        $body .= "<br>";
        $body .= "Este es un correo automático favor no responder a esta dirección, si quiere contactarse con nosotros por algún motivo escribanos a: ";
        $body .= "<strong><a href=''>$correojefatura</a></strong>";
        $body .= "<br>";
        $body .= "<br>";
        $body .= "Enlace: <strong><a href='$enlace'>$enlace</a></strong><br>";
        $body .= "<h3>Saludos Cordiales, <strong>Departamento de Informática</strong></h3><br>";
        $body .= "<br>";
        $body .= "--<br>Msc. Patricia Ellner<br><br>Departamento de Informática";
        $body .= "<br>";
        $body .= "<br>";
        $mail->Body = $body;
        $mail->CharSet = 'utf-8';
        $mail->send();
        $mysqli->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    die(json_encode($respuesta));
}

if ($_POST['reunion'] == 'actualizar') {
    $participante = $_POST['chk'];
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $id_registro = $_POST['id_registro'];
    $invitados = $_POST['invitados'];
    try {
        $stmt = $mysqli->prepare('UPDATE tbl_reunion SET nombre_reunion=?,lugar=?,hora_inicio=?,hora_final=?,fecha=?,asunto=?,agenda_propuesta=?,enlace=?,id_tipo =? WHERE id_reunion=?');
        $stmt->bind_param("ssssssssii", $nombre, $lugar, $horainicio, $horafinal, $fecha_formateada, $asunto, $agenda, $enlace, $tipo, $id_registro);
        $stmt->execute();
        $id_reunion = $id_registro;
        $desc = 1;
        foreach ($participante as $par) {
            $stmt = $mysqli->prepare("INSERT INTO tbl_participantes (id_reunion, id_persona) VALUES (?,?)");
            $stmt->bind_param("ii", $id_reunion, $par);
            $stmt->execute();
        }

        foreach ($invitados as $inv) {
            $stmt = $mysqli->prepare("UPDATE tbl_participantes SET descripcion=? WHERE id_reunion=? and id_persona=?");
            $stmt->bind_param("iii", $desc, $id_reunion, $inv);
            $stmt->execute();
        }
        $dtz = new DateTimeZone("America/Tegucigalpa");
        $dt = new DateTime("now", $dtz);
        $hoy = $dt->format("Y-m-d H:i:s");
        $id_objetoac = 5000;
        $id_userac = $_SESSION['id_usuario'];
        $accionac = 'MODIFICO';
        $descripcionac= 'la reunion con nombre: '.$nombre;
        $fechaac = $hoy;
        $stmt = $mysqli->prepare("INSERT INTO `tbl_bitacora` (`Id_usuario`, `Id_objeto`, `Fecha`, `Accion`, `Descripcion`) VALUES (?,?,?,?,?)");
        $stmt->bind_param("iisss", $id_userac, $id_objetoac, $fechaac, $accionac, $descripcionac);
        $stmt->execute();


    $correo = 'jefatura@informaticaunah.com';
    $Password = 'J3f@tur@';
    $mail->SMTPDebug = 0;                      //Enable verbose debug output                                          //Send using SMTP
    $mail->Host = 'informaticaunah.com';
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username = $correo;
    $mail->Password = $Password;                              //SMTP password          //Enable implicit TLS encryption
    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    
    $mail->setFrom($correo, 'Jefatura Departamento de Informática');
    $sql = "SELECT t1.valor AS participantes FROM tbl_contactos t1 INNER JOIN tbl_personas t2 ON t2.id_persona = t1.id_persona INNER JOIN tbl_participantes t3 ON t3.id_persona = t2.id_persona WHERE t3.descripcion = 1 and t1.id_tipo_contacto = 4 and t3.id_reunion = $id_reunion";
    $res = $mysqli->query($sql);
    while ($destino = $res->fetch_assoc()) {
        $email = $destino['participantes'];
        $mail->addAddress($email);
    }
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Eliminado de la reunión';
    $body  = "<h3>Por medio de la presente se le notifica que usted ha sido eliminado de la reunión $nombre </h3><br>";
    $body .= "<b>Si cree que ha ocurrido un error, favor contactarse al siguiente correo: $correojefatura</b><br>";
    $body .= "<br>";
    $body .= "<br>";
    $body .= "Este es un correo automático favor no responder a esta dirección, si quiere contactarse con nosotros por algún motivo escribanos a: ";
    $body .= "<strong><a href=''>$correojefatura</a></strong>";
    $body .= "<br>";
    $body .= "<br>";
    $body .= "Enlace: <strong><a href='$enlace'>$enlace</a></strong><br>";
    $body .= "<h3>Saludos Cordiales, <strong>Departamento de Informática</strong></h3><br>";
    $body .= "<br>";
    $body .= "--<br>Msc. Patricia Ellner<br><br>Departamento de Informática";
    $body .= "<br>";
    $body .= "<br>";
    $mail->Body = $body;
    $mail->CharSet = 'UTF-8';
    $mail->send();

    foreach ($invitados as $inv) {
        $stmt = $mysqli->prepare("DELETE FROM tbl_participantes WHERE descripcion=?");
        $stmt->bind_param("i", $desc);
        $stmt->execute();
    }

    if ($stmt->affected_rows) {
        $respuesta = array(
            'respuesta' => 'exito',
            'id_actualizado' => $id_registro
        );
    } else {
        $respuesta = array(
            'respuesta' => 'error'
        );
    }
        $correo = 'jefatura@informaticaunah.com';
        $Password = 'J3f@tur@';
        $mail->SMTPDebug = 0;                      //Enable verbose debug output                                          //Send using SMTP
        $mail->Host = 'informaticaunah.com';
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username = $correo;
        $mail->Password = $Password;                              //SMTP password          //Enable implicit TLS encryption
        //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        
        $mail->setFrom($correo, 'Jefatura Departamento de Informática');
        $sql = "SELECT t1.valor AS participantes FROM tbl_contactos t1 INNER JOIN tbl_personas t2 ON t2.id_persona = t1.id_persona INNER JOIN tbl_participantes t3 ON t3.id_persona = t2.id_persona WHERE t1.id_tipo_contacto = 4 and t3.id_reunion = $id_reunion AND t3.descripcion IS NULL";
        $res = $mysqli->query($sql);
        while ($destino = $res->fetch_assoc()) {
            $email = $destino['participantes'];
            $mail->addAddress($email);
        }
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Modificación de la reunión';
        $body  = "<h3>Por medio de la presente se le notifica que la reunión $nombre";
        $body .= " ha recibido cambios por favor verificar las nuevas modificaciones.</h3><br>";
        $body .= "<h2><b>MEMORÁNDUM IA-$id_registro/$anio_formateada</b></h2><br>";
        $body .= "Nombre Reunión: <strong>$nombre</strong><br>";
        $body .= "Lugar: <strong>$lugar</strong><br>";
        $body .= "Fecha: <strong>$fecha</strong><br>";
        $body .= "Hora de Inicio: <strong>$horainicio</strong><br>";
        $body .= "Hora Final: <strong>$horafinal</strong><br>";
        $body .= "Asunto: <strong>$asunto</strong><br>";
        $body .= "<br>";
        $body .= "Por medio de la presente se notifica que el <strong>$fecha</strong>";
        $body .= " se realizará la reunión con asunto <strong>$asunto</strong>,";
        $body .= " lugar: <strong>$lugar</strong>";
        $body .= " en el horario de <strong>$horainicio</strong>";
        $body .= " a <strong>$horafinal</strong> con los siguientes puntos a tratar: <br><br>";
        $body .= "<strong>AGENDA</strong><br><br>";
        $body .= "<strong>$agendaformato</strong><br>";
        $body .= "<br>";
        $body .= "<br>";
        $body .= "Este es un correo automático favor no responder a esta dirección, si quiere contactarse con nosotros por algún motivo escribanos a: ";
        $body .= "<strong><a href=''>$correojefatura</a></strong>";
        $body .= "<br>";
        $body .= "<br>";
        $body .= "Enlace: <strong><a href='$enlace'>$enlace</a></strong><br>";
        $body .= "<h3>Saludos Cordiales, <strong>Departamento de Informática</strong></h3><br>";
        $body .= "<br>";
        $body .= "--<br>Msc. Patricia Ellner<br><br>Departamento de Informática";
        $body .= "<br>";
        $body .= "<br>";
        $mail->Body = $body;
        $mail->CharSet = 'UTF-8';
        $mail->send();
        $stmt->close();
        $mysqli->close();
    } catch (Exception $e) {
        $respuesta = array(
            'respuesta' => 'error'
        );
    }
    die(json_encode($respuesta));
}

if ($_POST['reunion'] == 'cancelar') {
    $id_registro = $_POST['id_registro'];
    $estadocancelar = 2;
    $id_cancelar = $_POST['id'];
    $mensaje = $_POST['mensaje'];
    $motivo = ' -- motivo: ' . $_POST['mensaje'];
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    try {
        $stmt = $mysqli->prepare('UPDATE tbl_reunion SET id_estado = ?, mensaje =? WHERE id_reunion = ?');
        $stmt->bind_param('isi', $estadocancelar, $motivo, $id_cancelar);
        $stmt->execute();
        if ($stmt->affected_rows) {
            $respuesta = array(
                'respuesta' => 'exito',
                'id_eliminado' => $id_borrar
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }
        $dtz = new DateTimeZone("America/Tegucigalpa");
        $dt = new DateTime("now", $dtz);
        $hoy = $dt->format("Y-m-d H:i:s");
        $id_objetoac = 5000;
        $id_userac = $_SESSION['id_usuario'];
        $accionac = 'CANCELO';
        $descripcionac= 'la reunion con el siguiente id: '.$id_cancelar;
        $fechaac = $hoy;
        $stmt = $mysqli->prepare("INSERT INTO `tbl_bitacora` (`Id_usuario`, `Id_objeto`, `Fecha`, `Accion`, `Descripcion`) VALUES (?,?,?,?,?)");
        $stmt->bind_param("iisss", $id_userac, $id_objetoac, $fechaac, $accionac, $descripcionac);
        $stmt->execute();

        //Server settings
        $correo = 'jefatura@informaticaunah.com';
        $Password = 'J3f@tur@';
        $mail->SMTPDebug = 0;                      //Enable verbose debug output                                          //Send using SMTP
        $mail->Host = 'informaticaunah.com';
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username = $correo;
        $mail->Password = $Password;                              //SMTP password          //Enable implicit TLS encryption
        //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        //Recipients
        $mail->setFrom($correo, 'Departamento Informática');
        $sql = "SELECT t1.valor AS participantes FROM tbl_contactos t1 INNER JOIN tbl_personas t2 ON t2.id_persona = t1.id_persona INNER JOIN tbl_participantes t3 ON t3.id_persona = t2.id_persona WHERE t1.id_tipo_contacto = 4 and t3.id_reunion = $id_cancelar";
        $res = $mysqli->query($sql);
        while ($destino = $res->fetch_assoc()) {
            $email = $destino['participantes'];
            $mail->addAddress($email);
        }
        $sql = "SELECT nombre_reunion,lugar,hora_inicio,hora_final FROM tbl_reunion where id_reunion = $id_cancelar";
        $datosreunion = $mysqli->query($sql);
        while ($datos = $datosreunion->fetch_assoc()) {
            $nom = $datos['nombre_reunion'];
            $lugar = $datos['lugar'];
            $inicio = $datos['hora_inicio'];
            $final = $datos['hora_final'];
        }
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'CANCELACIÓN reunión';
        $body .= "<br>";
        $body .= "Por medio de la presente se notifica que la Reunión: <strong>$nom</strong>";
        $body .= " lugar en que se iba a realizar: <strong>$lugar</strong><br>";
        $body .= " en el horario de <strong>$inicio</strong>";
        $body .= " a <strong>$final</strong>";
        $body .= " HA SIDO <strong>CANCELADA</strong> por el siguiente motivo: <strong>$mensaje</strong>.<br><br>";
        $body .= "<b>Este es un correo automático favor no responder a esta dirección, si quiere contactarse con nosotros por algún motivo escribanos a:</b><br>";
        $body .= "<b>patricia.ellner@unah.edu.hn</b>";
        $body .= "<br>";
        $body .= "<br>";
        $body .= "<h3>Saludos Cordiales, <strong>Departamento de Informática</strong></h3><br>";
        $body .= "<br>";
        $body .= "--<br>Msc. Patricia Ellner<br><br>Departamento de Informática";
        $body .= "<br>";
        $body .= "<br>";
        $mail->Body = $body;
        $mail->CharSet = 'UTF-8';
        $mail->send();
        $stmt->close();
        $mysqli->close();
    } catch (Exception $e) {
        $respuesta = array(
            'respuesta' => $e->getMessage()
        );
    }
    die(json_encode($respuesta));
}
