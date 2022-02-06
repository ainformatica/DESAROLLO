
<?php
ob_start();
session_start();
require_once("../Modelos/calculo_fecha_pps_modelos.php");
require_once('../Controlador/corre_supervisor.php');
require_once('../clases/Conexion.php');
require_once('../clases/conexion_mantenimientos.php');

$db = new pruebas();
$correo = new correo();

$cuenta_estud = $_POST['cuenta_estud'];
$obs_prac = $_POST['obs_prac'];
$tipo = $_POST['tipo'];
$empresa_prac = $_POST['empresa_prac'];
$hrs_pps = $_POST['hrs_pps'];
$fecha_inicio_prac = $_POST['fecha_inicio_prac'];
$fecha_final_prac = $_POST['fecha_final_prac'];
$horario_incio_prac = $_POST['horario_incio_prac'];
$horario_fin_prac = $_POST['horario_fin_prac'];
$dias_prac = $_POST['dias_prac'];
$correo_estud = $_POST['correo'];
$nombre_estud = $_POST['nombre_estud'];

$consulta = $db->update_pps($cuenta_estud, $obs_prac, $tipo, $empresa_prac, $hrs_pps, $fecha_inicio_prac, $fecha_final_prac, $horario_incio_prac, $horario_fin_prac, $dias_prac);
echo $consulta;

    

        $asunto_estudiante_aproba = "APROBACIÓN DE PRÁCTICA PROFESIONAL SUPERVISADA";

        $cuerpo_aproba = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>------------</title>

</head>
<body style="-webkit-text-size-adjust: none; box-sizing: border-box; color: #74787E; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; height: 100%; line-height: 1.4; margin: 0; width: 100% !important;" bgcolor="#F2F4F6"><style type="text/css">
body {
width: 100% !important; height: 100%; margin: 0; line-height: 1.4; background-color: #F2F4F6; color: #74787E; -webkit-text-size-adjust: none;
}
@media only screen and (max-width: 600px) {
.email-body_inner {
width: 100% !important;
}
.email-footer {
width: 100% !important;
}
}
@media only screen and (max-width: 500px) {
.button {
width: 100% !important;
}
}
</style>
<table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; margin: 0; padding: 0; width: 100%;" bgcolor="#F2F4F6">
<tr>
<td align="center" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; word-break: break-word;">
<table class="email-content" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; margin: 0; padding: 0; width: 100%;">
<tr>
    <td class="email-masthead" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; padding: 25px 0; word-break: break-word;" align="center">
        <h2  class="email-masthead_name" style="box-sizing: border-box; color: #000000; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; font-size: 16px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;">
Comité de Vinculación Universidad Sociedad 
</h2>
    </td>
</tr>

<tr>
    <td class="email-body" width="100%" cellpadding="0" cellspacing="0" style="-premailer-cellpadding: 0; -premailer-cellspacing: 0; border-bottom-color: #EDEFF2; border-bottom-style: solid; border-bottom-width: 1px; border-top-color: #EDEFF2; border-top-style: solid; border-top-width: 1px; box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; margin: 0; padding: 0; width: 100%; word-break: break-word;" bgcolor="#FFFFFF">
        <table class="email-body_inner" align="center" width="800" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; margin: 0 auto; padding: 0; width: 570px;" bgcolor="#FFFFFF">


            <tr>
                <td class="content-cell" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; padding: 35px; word-break: break-word;">
                    <h4 style="box-sizing: border-box; color: #2F3133; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; font-size: 19px; font-weight: bold; margin-top: 0;" align="left">Estimado: ' . $nombre_estud . ' </h4>


                    <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; margin: 30px auto; padding: 0; text-align: center; width: 100%;">
                        <tr>
                            <td align="center" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; word-break: break-word;">

                                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;">
                                    <tr>
                                        <td align="center" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; word-break: break-word;">
                                            <table border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;">
                                                <tr>
                                                    <td style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; word-break: break-word;">

                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <p style="box-sizing: border-box; color: #000000; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;" align="left">Un placer saludarle, deseándole abundantes éxitos. Por este medio el comité de Vinculación Universidad-Sociedad del departamento de Informática-UNAH, le informa que Aprueba su Práctica Profesional Supervisada, ésta se concede en los términos siguientes:<br>
<br> 1.	Institución: ' . $empresa_prac . '
<br> 2.	Fecha de inicio: ' . $fecha_inicio_prac . '
<br> 3.	Fecha de Finalización: ' . $fecha_final_prac . '
<br> 4.	Dias: ' . $dias_prac . '
<br> 5.	Horario: ' . $horario_incio_prac . ' a ' . $horario_fin_prac . '
<br>
<br>Usted no puede terminar su práctica antes de esta fecha, ni realizar cambios ni tratos sin previa consulta al comité, de lo contrario, no será tomada como válida. En caso de requerir cambios deberá realizar la solicitud por escrito, presentando la solicitud al comité y enviando una copia digital a este correo.
</p>
                    <p style="box-sizing: border-box; color: #000000; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;" align="left">
                        <br />Coordinación del Departamento de Informática</p>

                    <table class="body-sub" style="border-top-color: #EDEFF2; border-top-style: solid; border-top-width: 1px; box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; margin-top: 25px; padding-top: 25px;">
                        <tr>
                            <td style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; word-break: break-word;">

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; word-break: break-word;">
        <table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; margin: 0 auto; padding: 0; text-align: center; width: 570px;">
            <tr>
                <td class="content-cell" align="center" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; padding: 35px; word-break: break-word;">
                    <p class="sub align-center" style="box-sizing: border-box; color: #000000; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; font-size: 12px; line-height: 1.5em; margin-top: 0;" align="center">Facultad de Ciencias Económicas <br/>Departamento de Informatica Administrativa <br/>Comité de Vinculación Universidad Sociedad</p>
                    <p class="sub align-center" style="box-sizing: border-box; color: #000000; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; font-size: 12px; line-height: 1.5em; margin-top: 0;" align="center">

                    </p>
                </td>
            </tr>
        </table>
    </td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>
';





        $correo->correo_aprobacion_prac($cuerpo_aproba, $asunto_estudiante_aproba, $correo_estud , $nombre_estud);
    







ob_end_flush();
?>
