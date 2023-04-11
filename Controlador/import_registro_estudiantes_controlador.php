<?php
require_once('../vendor_importExcel/php-excel-reader/excel_reader2.php');
require_once('../vendor_importExcel/SpreadsheetReader.php');
require_once('../clases/encriptar_desencriptar.php');
require_once('../Modelos/gestion_estudiantes_modelo.php');
require_once('../Controlador/import_registro_estudiantes_controlador2.php');

$op = isset($_POST["op"]) ? limpiarCadena1($_POST["op"]) : "";

$instancia_modelo = new modelo_gestion_estudiante();

$errores=0;
if (isset($_POST["import"])) {

    $allowedFileType = ['application/vnd.ms-excel', 'text/xls', 'text/xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

    if (in_array($_FILES["file"]["type"], $allowedFileType)) {

        $targetPath = '../subidas/' . $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

        $Reader = new SpreadsheetReader($targetPath);

        
        $sheetCount = count($Reader->sheets());
        for ($i = 0; $i < $sheetCount; $i++) {
            
            $Reader->ChangeSheet($i);
            $primera = true;

            $message = "";
            foreach ($Reader as $Row) {
                
                if ($primera) { //omitiendo la fila del encabezado del documento
                    $primera = false;
                    continue;
                }
                           
                            $resultado=$instancia_modelo->buscar_estudiante($Row[6])->fetch_object();
                            
                            if ($resultado->cantidad>0) {
                                $type = "error";
                                $message = $message."El estudiante ".$Row[0]." ".$Row[1]." ya existe<br/>";
                                $errores++;

                            }

            }
            
            
        }
    } else {
        $type = "error";
        $message = "El archivo enviado es invalido. Por favor vuelva a intentarlo";
    }
}





if ($errores==0) {
    if (isset($_POST["import"])) {

        $allowedFileType = ['application/vnd.ms-excel', 'text/xls', 'text/xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
    
        if (in_array($_FILES["file"]["type"], $allowedFileType)) {
    
            move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
    
            $Reader = new SpreadsheetReader($targetPath);
    
            $sheetCount = count($Reader->sheets());
            for ($i = 0; $i < $sheetCount; $i++) {
    
                $Reader->ChangeSheet($i);
                $primera = true;
    
                foreach ($Reader as $Row) {
    
                    if ($primera) { //omitiendo la fila del encabezado del documento
                        $primera = false;
                        continue;
                    }
    
                    $_nombres = "";
                    if (isset($Row[0])) {
                        $_nombres = mysqli_real_escape_string($mysqli, $Row[0]);
                    }
    
                    $_apellidos = "";
                    if (isset($Row[1])) {
                        $_apellidos = mysqli_real_escape_string($mysqli, $Row[1]);
                    }
    
                    $_sexo = "";
                    if (isset($Row[2])) {
                        $_sexo = mysqli_real_escape_string($mysqli, $Row[2]);
                    }
    
                    $_identidad  = "";
                    if (isset($Row[3])) {
                        $_identidad = mysqli_real_escape_string($mysqli, $Row[3]);
                    }
    
                    $_nacionalidad = "";
                    if (isset($Row[4])) {
                        $_nacionalidad = mysqli_real_escape_string($mysqli, $Row[4]);
                    }
    
                    $_fecha_nacimiento = "";
                    if (isset($Row[5])) {
                        $_fecha_nacimiento = mysqli_real_escape_string($mysqli, $Row[5]);
                    }
    
                    $_n_cuenta = "";
                    if (isset($Row[6])) {
                        $_n_cuenta = mysqli_real_escape_string($mysqli, $Row[6]);
                    }
    
                    $_telefono = "";
                    if (isset($Row[7])) {
                        $_telefono = mysqli_real_escape_string($mysqli, $Row[7]);
                    }
    
                    $_email = "";
                    if (isset($Row[8])) {
                        $_email = mysqli_real_escape_string($mysqli, $Row[8]);
                    }
    
                    $num_user = token_u(4);
    
                    $letra = substr($_nombres, 0, 1);
                    $palabra = explode(" ", $_apellidos);
                    $usuario = $letra . $palabra[0] . $num_user;
                    $_usuario = strtoupper($usuario);
    
                    $_contrasena = gtoken(8);
    
                    if (!empty($_nombres) || !empty($_apellidos) || !empty($sexo) || !empty($_identidad) || !empty($_nacionalidad) || !empty($_fecha_nacimiento) || !empty($_n_cuenta) || !empty($_telefono) || !empty($_email)) {
                        $contrasena = cifrado::encryption($_contrasena);
    
                        $resultados = $instancia_modelo->importar_excel_estudiantes($_nombres, $_apellidos, $_sexo, $_identidad, $_nacionalidad, $_fecha_nacimiento, $_n_cuenta, $_telefono, $_email, $_usuario, $contrasena);
    
                        if ($resultados) {
                            enviar_mail($_email, $_usuario, $_contrasena);
                            $type = "success";
                            $message = "Los datos se importaron y almacenaron correctamente";
                            
                        } else {
                            $type = "error";
                            $message = "Hubo un problema al importar registros";
                        }
                    }
                }
            }
        } else {
            $type = "error";
            $message = "El archivo enviado es invalido. Por favor vuelva a intentarlo";
        }
    }

}
?>