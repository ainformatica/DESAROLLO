<?php
ob_start();
session_start();


require_once ('../clases/Conexion.php');

// INGRESO DE LA EMPRESA
if(isset($_POST['nombre_empresa']) && $_POST['id_persona']!=="" && $_POST['cb_empresa']!=="" && $_POST['direccion_empresa']!==""){ 

            $ncuenta = $_POST['txt_cuenta'];
            $id_persona = $_POST['id_persona'];
            $nombreEmpresa = $_POST['nombre_empresa'];
            $cb_empresa = $_POST['cb_empresa'];
            $direccion_empresa = $_POST['direccion_empresa'];
            $nombre_jefe= $_POST['nombre_jefe'];
            $cargo_jefe=$_POST['cargo_jefe'];
            $correo_jefe=$_POST['correo_jefe'];
            $telefono_jefe=$_POST['telefono_jefe'];
            $celular_jefe=$_POST['celular_jefe'];
            $cb_nivel=$_POST['cb_nivel'];
            $cb_trabaja=$_POST['cb_trabaja'];
            $cargo_trabajo=$_POST['cargo_trabajo'];
            $fecha_ingreso=$_POST['fecha_ingreso'];
            $perfil_empresa=$_POST['perfil_empresa'];
  
    if($_FILES['croquis']['name']!=null){
            
            $sql="SELECT p.nombres,p.apellidos,pe.valor
                  FROM tbl_personas p, tbl_personas_extendidas pe
                  WHERE p.id_persona = pe.id_persona
                  AND pe.valor = $ncuenta";
            $resultado = $mysqli->query($sql);

          $consulta=" SELECT * FROM tbl_empresas_practica
                        WHERE id_persona=$id_persona";
            $resConsulta = $mysqli->query($consulta);

            if ($resConsulta->num_rows>=1) {
                $msg= Array(
                    "Status"=>"100",
                    "info"=> "ya tiene empresa"
                );
                echo json_encode($msg); 
            }else{

            
            if($resultado->num_rows>=1){

                $documento_nombre[] = $_FILES['croquis']['name'];
                $documento_nombre_temporal[] = $_FILES['croquis']['tmp_name'];
                

                

                $micarpeta = '../archivos/PPS01_CROQUIS/'.$ncuenta;
                    if (!file_exists($micarpeta)) {
                         mkdir($micarpeta, 0777, true);
                        }else{
                            $documento = glob('../archivos/carta_egresado/'.$ncuenta.'/*'); // obtiene los documentos
                            foreach($documento as $documento){ // itera los documentos
                            if(is_file($documento)) 
                            unlink($documento); // borra los documentos
                        }
                        }
                for ($i = 0; $i <=count($documento_nombre_temporal)-1 ; $i++) {
                
                    move_uploaded_file($documento_nombre_temporal[$i],"$micarpeta/$documento_nombre[$i]");
                    $ruta= '../archivos/carta_egresado/'.$ncuenta.'/'.$documento_nombre[$i];
                    $direccion[]= $ruta;
                }
                $documento = json_encode($direccion);

               
                
                $sql= "INSERT INTO tbl_empresas_practica ( id_persona, nombre_empresa, direccion_empresa, tipo_empresa, labora_dentro, puesto_en_trabajo, jefe_inmediato, titulo_jefe_inmediato, cargo_jefe_inmediato, correo_jefe_inmediato, telefono_jefe_inmediato, perfil_empresa, croquis_empresa, fecha_inicio_laborar)
                             VALUES ('$id_persona','$nombreEmpresa','$direccion_empresa','$cb_empresa','$cb_trabaja','$cargo_trabajo','$nombre_jefe','$cb_nivel','$cargo_jefe','$correo_jefe','$telefono_jefe','$perfil_empresa','$documento','$fecha_ingreso')";
               
                $resultadop = $mysqli->query($sql);
                
                
                if($resultadop == true){
                  
                    $Ultimo_id= $mysqli->insert_id;
                    $msg= Array(
                        "Status"=>"200",
                        "info"=> $Ultimo_id
                    );
                    echo json_encode($msg);
                    
                                } 
                else {
                    // echo "Error: " . $sql ;

                    echo json_encode("Fallo"); 
                    }


            }else{
                echo '<script type="text/javascript">
                        swal({
                                title:"",
                                text:"El numero de cuenta es incorrecto....",
                                type: "error",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $(".FormularioAjax")[0];
                      </script>'; 
            }
        }

    }else{
        echo '<script type="text/javascript">
                swal({
                    title:"",
                    text:"Faltan Documentos por subir....",
                    type: "error",
                    showConfirmButton: false,
                    timer: 1500
                    });
                    $(".FormularioAjax")[0];
              </script>'; 
    }
}

//----------------------------------- INGRESO DE LA PRACTICA --------------------------------------------------------------
if (isset($_POST['cb_modalidad'])) {
   $cb_modalidad=$_POST['cb_modalidad'];
   $persona_id=$_POST['id_persona'];
   
   $fecha_inicio=$_POST['txt_fecha_inicio'];
   $fecha_final=$_POST['txt_fecha_final'];
   $cb_jornada=$_POST['cb_jornada'];
   $txt_hora_inicio=$_POST['txt_hora_inicio'];
   $txt_hora_final=$_POST['txt_hora_final'];

   //BUSCAMOS EL ID DE LA EMPRESA QUE EL ESTUDIANTE REGISTRO
   $query= "SELECT * FROM tbl_empresas_practica 
   WHERE id_persona=$persona_id";
    $respuesta = $mysqli->query($query);

   $dataempresa= mysqli_fetch_assoc($respuesta);
  $empresa_id=$dataempresa['Id_empresa'];
   
  //VERIFICAMOS QUE NO TENGA REGISTRO EL ESTUDIANTE PARA EVITAR DUPLICIDAD
    $consulta="SELECT * FROM tbl_practica_estudiantes
    WHERE id_persona= $persona_id";
    $verificar = $mysqli->query($consulta);

    if ($verificar->num_rows>=1) {
        $msg= Array(
            "Status"=>"100",
            "info"=> "ya tiene registro "
        );
        echo json_encode($msg);
    }else{

   //INSERTAMOS EL REGITRO DE PRACTICA
   $sql="INSERT INTO tbl_practica_estudiantes (id_persona,Id_empresa,fecha_inicio,fecha_finaliza,jornada_laboral_id,id_estado,hora_inicio,hora_final,id_modalidad)
   VALUES ('$persona_id','$empresa_id','$fecha_inicio','$fecha_final','$cb_jornada','1','$txt_hora_inicio','$txt_hora_final','$cb_modalidad')";
    $resultado = $mysqli->query($sql);
    

    //VERIFICAMOS QUE SE INSERTO EL REGISTRO
    if ($resultado) {
        $msg= Array(
            "Status"=>"200",
            "info"=> "insertado con exito"
        );
        echo json_encode($msg);
    }else{
        $msg= Array(
            "Status"=>"400",
            "info"=> "fallo"
        );
        echo json_encode($msg);
    }

    }
   

}

    

?>