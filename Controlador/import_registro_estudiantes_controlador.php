<?php
require_once('../clases/Conexion.php');
require_once('vendor2/php-excel-reader/excel_reader2.php');
require_once('vendor2/SpreadsheetReader.php');


if (isset($_POST["import"]))
{
    
$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["file"]["type"],$allowedFileType)){

        $targetPath = 'subidas/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
          
                $_nombres = "";
                if(isset($Row[0])) {
                    $nombres = mysqli_real_escape_string($con,$Row[0]);
                }
                
                $_apellidos = "";
                if(isset($Row[1])) {
                    $cargo = mysqli_real_escape_string($con,$Row[1]);
                }
				
                $_identidad = "";
                if(isset($Row[2])) {
                    $celular = mysqli_real_escape_string($con,$Row[2]);
                }
				
                $_sexo = "";
                if(isset($Row[3])) {
                    $descripcion = mysqli_real_escape_string($con,$Row[3]);
                }

                $_nacionalidad = "";
                if(isset($Row[4])) {
                    $descripcion = mysqli_real_escape_string($con,$Row[4]);
                }
                
                $_fecha_nacimiento = "";
                if(isset($Row[5])) {
                    $descripcion = mysqli_real_escape_string($con,$Row[5]);
                }

                $_n_cuenta = "";
                if(isset($Row[6])) {
                    $descripcion = mysqli_real_escape_string($con,$Row[6]);
                }
                
                $_telefono = "";
                if(isset($Row[7])) {
                    $descripcion = mysqli_real_escape_string($con,$Row[7]);
                }
                
                $_email = "";
                if(isset($Row[8])) {
                    $descripcion = mysqli_real_escape_string($con,$Row[8]);
                }

                $existe_id_persona="";
                $existe_id_persona=("select id_persona from tbl_personas where identidad='$_identidad'");
                $id_usuario2=mysqli_fetch_assoc($mysqli->query($existe_id_persona));

                $letra=substr($_nombres, 0, 1);
                $palabra = explode (" ", $_apellidos);
                $usuario=$letra.$palabra[0].$id_usuario2;
                $_usuario = strtoupper($usuario);
        
                function gtoken ($longitud){
                    $cadena = "_@&1Aa2Bb3Cc4Dd5Ee6Ff7Gg8Hh9Ii0JjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz_";
                    $token = "";
                
                    for ($i=0; $i < $longitud; $i++) { 
                        # code...
                        $token .= $cadena[rand(0, $longitud)]; //rand genera un número aleatorio desde un mínimo a un máximo, en este caso el mínimo será cero y el máximo la longitud
                    }
                    return $token;
                }
                
                $_contrasena = gtoken(8);
                
                $_contrasena=cifrado::encryption(gtoken());
                
                if (!empty($_nombres) || !empty($_apellidos) || !empty($_identidad) || !empty($sexo) || !empty($_nacionalidad) || !empty($_fecha_nacimiento) || !empty($_n_cuenta) || !empty($_telefono) || !empty($_email)){
                    $query = "call proc_insert_usuario_estudiantes_IMPORT (nombres, apellidos, identidad, sexo, nacionalidad,fecha_nacimiento, ncuenta, telefono, email, usuario, contrasena) VALUES ('".$_nombres."','".$_apellidos."','".$_identidad."','".$_sexo."','".$_nacionalidad."','".$_fecha_nacimiento."','".$_n_cuenta."','".$_telefono."','".$_email."','".$_usuario."','".$_contrasena."')"; 
                    $resultados = mysqli_query($con, $query);
                
                    if (! empty($resultados)) {
                        $type = "success";
                        $message = "Excel importado correctamente";
                    } else {
                        $type = "error";
                        $message = "Hubo un problema al importar registros";
                    }
                }
             }
        
         }
  }
  else
  { 
        $type = "error";
        $message = "El archivo enviado es invalido. Por favor vuelva a intentarlo";
  }
}
?>