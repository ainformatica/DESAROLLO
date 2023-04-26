<?php
	

	session_start();
	ob_start();

	require_once ('../clases/Conexion.php');

	$id_persona= $_SESSION['id_persona'];
	$id_usuario= $_SESSION['id_usuario'];

$Respuesta=strtoupper ($_POST['txt_respuestapu']);
$Pregunta=$_POST['combopregunta'];


  	$sql_preguntas=" select valor from tbl_parametros where parametro='cantidad_preguntas' " ;
$resultado_pregunta = $mysqli->query($sql_preguntas);
 $row_parametro_pregunta = mysqli_fetch_array($resultado_pregunta); 


	    if ($Pregunta>0) 
	    {
		
     		
			 $sql_existe_pregunta=("select count(Id_pregunta) as pregunta  from tbl_preguntas_seguridad where Id_pregunta='$Pregunta' and  Id_usuario= ".$_SESSION['id_usuario']." ");
			 //Obtener la fila del query
			$existe_pregunta = mysqli_fetch_assoc($mysqli->query($sql_existe_pregunta));






			if ($existe_pregunta['pregunta']==1)
			{
			header("location: ../vistas/crear_preguntas_usuario_vista.php?msj=4&estatus=".$_SESSION["estatus"]."");
			}

    		else	{

         
            		if (isset($_REQUEST['estatus_pregunta']) and $_REQUEST['estatus_pregunta']==2)
            		 {

            		 	$sql_contador_pregunta_usuario=" select count(Id_pregunta) as Contador from tbl_preguntas_seguridad where Id_usuario= ".$_SESSION['id_usuario']." " ;
								$resultado_pregunta = $mysqli->query($sql_contador_pregunta_usuario);
								 $row_preguntas = mysqli_fetch_array($resultado_pregunta); 

										$Contador=$row_preguntas['Contador'];



            		 		if ($Contador<$row_parametro_pregunta['valor'])

							 {
				// Query para que haga el insert
										$sql = "call proc_insertar_pregunta_usuario('$Pregunta', ".$_SESSION['id_usuario'].", '$Respuesta')";									
										$resultado = $mysqli->query($sql);

												$Contador=$Contador + 1;
										   		header('location: ../vistas/crear_preguntas_usuario_vista.php?estatus='.$_SESSION["estatus"].' ');

										


            		 		 }	

					 if ($Contador==$row_parametro_pregunta['valor']) 

					 {
					 
					 //validación de usuario
					 $sql_verificar_usuario= "select Id_rol from tbl_usuarios where Id_usuario=".$id_usuario." ";
					 $resultado_usuario = $mysqli->query($sql_verificar_usuario);
					 $resultado_us = mysqli_fetch_array($resultado_usuario);
					 $rol=$resultado_us['Id_rol']; 
					 //echo $rol;
							 if ($rol==49){
								$sql_actualizar_estatus = "UPDATE tbl_usuarios SET   estado=1 WHERE id_usuario= ".$id_usuario." ";
								$resultado_actualizar_estatus= $mysqli->query($sql_actualizar_estatus);
								
								if ($resultado_actualizar_estatus=true){ 
												$sql_actualizar_estado = "UPDATE tbl_personas SET Estado='ACTIVO' WHERE id_persona= $id_persona";
												$resultado_actualizar_estado= $mysqli->query($sql_actualizar_estado);

						    					 header('location: ../vistas/reg_estudiantes_login_vista.php?estatus='.$_SESSION["estatus"].' ');
													}
												}
							else{
								$sql_actualizar_estatus = "UPDATE tbl_usuarios SET   estado=1 WHERE id_usuario= ".$id_usuario." ";
					 			$resultado_actualizar_estatus= $mysqli->query($sql_actualizar_estatus);
														header('location: ../vistas/cambiar_clave_x_usuario_vista.php?estatus=' . $_SESSION["estatus"] . ' ');
													}
							}
													

					}

            }


        }
		else
		{
		 header('location: ../vistas/crear_preguntas_usuario_vista.php?msj=2&estatus='.$_SESSION["estatus"].'');
        }


	?>