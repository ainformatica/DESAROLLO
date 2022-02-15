<?php
ob_start();
session_start();

require_once ('../clases/Conexion.php');

   
    if($_FILES['txt_cedula']['name']!=null){
            
		$ncuenta=$_POST['txt_cuenta_estudiante'];
	

            $sql="SELECT p.nombres,p.apellidos,pe.valor
                  FROM tbl_personas p, tbl_personas_extendidas pe
                  WHERE p.id_persona = pe.id_persona
                  AND pe.valor = $ncuenta";
            $resultado = $mysqli->query($sql);

            if($resultado->num_rows>=1){

                $documento_nombre[] = $_FILES['txt_bioseguridad']['name'];
                $documento_nombre[] = $_FILES['txt_cedula']['name'];
               

                $documento_nombre_temporal[] = $_FILES['txt_bioseguridad']['tmp_name'];
                $documento_nombre_temporal[] = $_FILES['txt_cedula']['tmp_name'];
               

                $micarpeta = '../Documentacion_practica/'.$ncuenta;
                    if (!file_exists($micarpeta)) {
                         mkdir($micarpeta, 0777, true);
                        }else{
                            $documento = glob('../Documentacion_practica/'.$ncuenta.'/*'); // obtiene los documentos
                            foreach($documento as $documento){ // itera los documentos
                           
                        }
                        }
                for ($i = 0; $i <=count($documento_nombre_temporal)-1 ; $i++) {
                
                    move_uploaded_file($documento_nombre_temporal[$i],"$micarpeta/$documento_nombre[$i]");
                    $ruta= '../Documentacion_practica/'.$ncuenta.'/'.$documento_nombre[$i];
                    $direccion[]= $ruta;
                }
                $documento = json_encode($direccion);
                
				echo '<script type="text/javascript">
				swal({
						title:"Carga de Documentos",
						text:"Carga de Documentos completa",
						type: "success",
						showConfirmButton:true ,
					
					});
					$(".FormularioAjax")[0];
					window.location.href="../vistas/subida_informacion_estudiante_vista.php";
			  </script>'; 
	}

               
			
                

            }else{
                echo '<script type="text/javascript">
                        swal({
                                title:"",
                                text:"Faltan Documentos...",
                                type: "error",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $(".FormularioAjax")[0];
                      </script>'; 
            }

   


        
ob_end_flush();
?>





