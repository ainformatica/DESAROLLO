<?php

ob_start();

require_once "conexion.php";

class Consultas
{

    //Consulta para obtener las notificaciones por token
    public function obtenerNotificaciones($token)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_get_notificacion('$token');";
        
        $respuesta = mysqli_query($bd, $query);

        mysqli_close($bd);
        return $respuesta;
    }

    //Consulta para obtener las noticias
    public function obtenerNoticias($token)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_get_noticias('$token');";
        
        $respuesta = mysqli_query($bd, $query);
echo mysqli_errno($bd)." error ";
        mysqli_close($bd);
        return $respuesta;
    }

    //Consulta para insertar en la bitacora
    public function insertarBitacora($accion, $descripcion, $token, $idObjeto)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_insert_bitacora('$accion', '$descripcion', '$token', $idObjeto);";
        
        $respuesta = mysqli_query($bd, $query);

        if(mysqli_errno($bd) == 0)
        {
            return $respuesta;

        }else
        {
            return false;
        }

        mysqli_close($bd);
    }

    //Funcion para insertar el token en la base de datos cuando se instala la app en el dispositivo
    public function insertarToken($token, $usuario, $tipoPlataforma)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_insert_token('$token', '$usuario', '$tipoPlataforma');";
        
        $respuesta = mysqli_query($bd, $query);

        if(mysqli_errno($bd) == 0)
        {
            return $respuesta;

        }else
        {
            return false;
        }

        mysqli_close($bd);        
    }

    //Para obtener los tokens a los que se enviara la notificacion
    public function obtenerTokensAndroid($segmento)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_get_tokens_android($segmento);";
        
        $respuesta = mysqli_query($bd, $query);
        
        mysqli_close($bd);
        return $respuesta;
    }

    //Actualizar si se leyo la notificacion
    public function actualizarNotLeida($notifUsuario)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_update_notif_leida('$notifUsuario');";
        
        $respuesta = mysqli_query($bd, $query);

        if(mysqli_errno($bd) == 0)
        {
            return $respuesta;

        }else
        {
            return false;
        }

        mysqli_close($bd);       
    }

    //Actualizar como leidas todas las notificaciones
    public function actualizarAllNotLeida($token)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_update_all_notif_leida('$token');";
        
        $respuesta = mysqli_query($bd, $query);

        if(mysqli_errno($bd) == 0)
        {
            return $respuesta;

        }else
        {
            return false;
        }

        mysqli_close($bd);       
    }

    //Actualizar cuando se elimine la notificacion
    public function NotificacionEliminada($notifUsuario)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_update_notif_eliminada('$notifUsuario');";
        
        $respuesta = mysqli_query($bd, $query);

        if(mysqli_errno($bd) == 0)
        {
            return $respuesta;

        }else
        {
            return false;
        }

        mysqli_close($bd);       
    }

    //Funcion para insertar cada transaccion en la base de datos cuando se envie una notificacion
    public function insertarTransaccionesAndroid($segmento, $idNotificacion)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_insert_transacciones_android($segmento, $idNotificacion);";
        
        $respuesta = mysqli_query($bd, $query);

        if(mysqli_errno($bd) == 0)
        {
            return $respuesta;

        }else
        {
            return false;
        }

        mysqli_close($bd);        
    }

    //Confirmar que la notificacion push fue recibida
    public function confirmarNotificacion($token, $idNotificacion)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_push_confirm('$token', $idNotificacion);";
        
        $respuesta = mysqli_query($bd, $query);

        if(mysqli_errno($bd) == 0)
        {
            return $respuesta;

        }else
        {
            return false;
        }

        mysqli_close($bd);       
    }

    //Funcion para insertar o actualizar los likes
    public function insertUpdateLikes($token, $idNoticia)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_insert_updates_likes('$token', $idNoticia);";
        
        $respuesta = mysqli_query($bd, $query);

        if(mysqli_errno($bd) == 0)
        {
            return $respuesta;

        }else
        {
            return false;
        }

        mysqli_close($bd);        
    }

    //Consulta para obtener los usuarios
    public function obtenerEstadoLike($token, $idNoticia)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_get_estado_like('$token', $idNoticia);";
        
        $respuesta = mysqli_query($bd, $query);

        mysqli_close($bd);
        return $respuesta;
    }

     //Consulta para obtener los usuarios
     public function obtenerLikes($idNoticia)
     {
         $conexion = new Conexion();
         $bd = $conexion->conexion_bd();
         
         $query = "CALL sp_get_likes($idNoticia);";
         
         $respuesta = mysqli_query($bd, $query);
 
         mysqli_close($bd);
         return $respuesta;
     }

    //Consulta para obtener los usuarios
    public function obtenerUsuarios($token)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_get_usuarios('$token');";
        
        $respuesta = mysqli_query($bd, $query);

        mysqli_close($bd);
        return $respuesta;
    }

    //Consulta para obtener los usuarios de la parte administrativa
    public function obtenerUsuariosAdmin()
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_get_usuarios_admin();";
        
        $respuesta = mysqli_query($bd, $query);

        mysqli_close($bd);
        return $respuesta;
    }

    //Consulta para obtener las sesiones de chat
    public function obtenerSesiones($token, $session)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_get_session('$token', $session);";
        
        $respuesta = mysqli_query($bd, $query);

        mysqli_close($bd);
        return $respuesta;
    }

    //Funcion para insertar las sesiones
    public function insertarSesion($token, $usuarioReceptor, $mensaje, $tipoMensaje)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_insert_session('$token', '$usuarioReceptor', '$mensaje', $tipoMensaje);";
        
        $respuesta = mysqli_query($bd, $query);

        if(mysqli_errno($bd) == 0)
        {
            return $respuesta;

        }else
        {
            return false;
        }

        mysqli_close($bd);        
    }

     //Funcion para insertar los Mensajes
     public function insertarMensaje($mensaje, $tipoMensaje, $session, $token)
     {
         $conexion = new Conexion();
         $bd = $conexion->conexion_bd();
         
         $query = "CALL sp_insert_mensaje('$mensaje', $tipoMensaje, $session, '$token');";
         
         $respuesta = mysqli_query($bd, $query);
 
         if(mysqli_errno($bd) == 0)
         {
             return $respuesta;
 
         }else
         {
             return false;
         }
 
         mysqli_close($bd);        
     }

     //Consulta para obtener los mensajes
    public function obtenerMensajes($token, $session, $idMensaje)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_get_mensajes('$token', $session, $idMensaje);";
        
        $respuesta = mysqli_query($bd, $query);

        mysqli_close($bd);
        return $respuesta;
    }

    //Consulta para obtener los usuarios
    public function obtenerIdUsuario($token)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_get_id('$token');";
        
        $respuesta = mysqli_query($bd, $query);

        mysqli_close($bd);
        return $respuesta;
    }

    //Funcion para actualizar los Frag de lectura
    public function updateFragLectura($token, $session, $idMensaje)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_update_frag_lectura('$token', $session, $idMensaje);";
        
        $respuesta = mysqli_query($bd, $query);

        if(mysqli_errno($bd) == 0)
        {
            return $respuesta;

        }else
        {
            return false;
        }

        mysqli_close($bd);        
    }

    //Consulta para obtener la cantidad de leidos
    public function obtenerFragLectura($token, $idMensaje, $session)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_get_frag_lectura('$token', $idMensaje, $session);";
        
        $respuesta = mysqli_query($bd, $query);

        mysqli_close($bd);
        return $respuesta;
    }

    //Para obtener los token de usuario receptor de la notificacion
    public function obtenerToken($usuarioReceptor)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_get_token('$usuarioReceptor');";
        
        $respuesta = mysqli_query($bd, $query);
        
        mysqli_close($bd);
        return $respuesta;
    }

    //Para obtener los token de usuario receptor de la notificacion
    public function obtenerNombre($token)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_get_nombre('$token');";
        
        $respuesta = mysqli_query($bd, $query);
        
        mysqli_close($bd);
        return $respuesta;
    }

     //Consulta para obtener el id de la session
     public function obtenerIdSession($idRemitente, $idReceptor)
     {
         $conexion = new Conexion();
         $bd = $conexion->conexion_bd();
         
         $query = "CALL sp_get_session_usuarios($idRemitente, $idReceptor);";
         
         $respuesta = mysqli_query($bd, $query);
 
         mysqli_close($bd);
         return $respuesta;
     }

    //Funcion para insertar notificacion y transaccion y traer el id de la notificacion
    public function insertarNotificacionTransaccion($titulo, $descripcion, $imagen, $remitente, $idToken, $idUsuario)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_insert_notificacion_transaccion('$titulo', '$descripcion', '$imagen', '$remitente', '$idToken', $idUsuario);";
        
        $respuesta = mysqli_query($bd, $query);

        if(mysqli_errno($bd) == 0)
        {
            return $respuesta;

        }else
        {
            return false;
        }

        mysqli_close($bd);        
    }   

    //Para obtener el nombre del usuario remitente
    public function obtenerNombreAdmon($usuarioRemitente)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_get_nombre_admon('$usuarioRemitente');";
        
        $respuesta = mysqli_query($bd, $query);
        
        mysqli_close($bd);
        return $respuesta;
    }
    
    // ----------Consultas para el registro de personas ----------

    //Para obtener los generos
    public function obtenerGenero()
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_get_genero();";
        
        $respuesta = mysqli_query($bd, $query);
        
        mysqli_close($bd);
        return $respuesta;
    }

    //Para obtener las nacionalidades
    public function obtenerNacionalidad()
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_get_nacionalidad();";
        
        $respuesta = mysqli_query($bd, $query);
        
        mysqli_close($bd);
        return $respuesta;
    }

    //Para obtener los estados civiles
    public function obtenerEstadoCivil()
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_get_estado_civil();";
        
        $respuesta = mysqli_query($bd, $query);
        
        mysqli_close($bd);
        return $respuesta;
    }

    //Para obtener los tipos de personas
    public function obtenerTipoPersona()
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_get_tipo_persona();";
        
        $respuesta = mysqli_query($bd, $query);
        
        mysqli_close($bd);
        return $respuesta;
    }

    //Para obtener las preguntas de seguridad
    public function obtenerPreguntasSeguridad()
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_get_preguntas();";
        
        $respuesta = mysqli_query($bd, $query);
        
        mysqli_close($bd);
        return $respuesta;
    }

    //Funcion para insertar los datos de registro
    public function insertarDatosRegistro($nombre, $apellido, $sexo, $identidad, $nacionalidad, $estadoCivil,
                                          $fechaNacimiente, $idTipoPersona, $usuario, $rol, $password, 
                                          $segmento, $correo, $celular, $telefono, $numeroCuenta)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_insert_datos_registro('$nombre', '$apellido', '$sexo', '$identidad', 
                                                '$nacionalidad', '$estadoCivil', '$fechaNacimiente', 
                                                $idTipoPersona, '$usuario', $rol, '$password',
                                                $segmento, '$correo', '$celular',
                                                '$telefono', '$numeroCuenta');";
        
        $respuesta = mysqli_query($bd, $query);
        echo mysqli_errno($bd);
        if(mysqli_errno($bd) == 0)
        {
            return $respuesta;

        }else
        {
            return false;
        }

        mysqli_close($bd);        
    }      

    ///// Preguntas de seguridad //////

    //Funcion para insertar las preguntas de seguridad cuando sea primer ingreso
    public function insertarPreguntas($usuario, $password, $pregunta, $respuesta)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_insert_preguntas('$usuario', '$password', '$pregunta', '$respuesta');";
        
        $respuesta = mysqli_query($bd, $query);

        if(mysqli_errno($bd) == 0)
        {
            return $respuesta;

        }else
        {
            return false;
        }

        mysqli_close($bd);        
    }

    //Funcion para insertar las preguntas de seguridad cuando sea primer ingreso con su password
    public function insertarPreguntasPassword($usuario, $password, $pregunta, $respuesta, $nuevoPassword)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_insert_preguntas_password('$usuario', '$password', '$pregunta', '$respuesta', '$nuevoPassword');";
        
        $respuesta = mysqli_query($bd, $query);

        if(mysqli_errno($bd) == 0)
        {
            return $respuesta;

        }else
        {
            return false;
        }

        mysqli_close($bd);        
    }

    //Para obtener todas las preguntas de seguridad
    public function obtenerTodasPreguntas($usuario, $password)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_get_preguntas_todas('$usuario', '$password');";
        
        $respuesta = mysqli_query($bd, $query);
        
        mysqli_close($bd);
        return $respuesta;
    }

    //Para obtener las preguntas del usuario
    public function obtenerPreguntasUsuario($idUsuario, $password)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_get_preguntas_usuario('$idUsuario', '$password');";
        
        $respuesta = mysqli_query($bd, $query);
        
        mysqli_close($bd);
        return $respuesta;
    }
    
    ////// Validaciones para el registro /////////

    //Funcion para validar el usuario
    public function ValidarUsuario($usuario)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_valid_usuario('$usuario');";
        
        $respuesta = mysqli_query($bd, $query);
        
        mysqli_close($bd);
        return $respuesta;
    }

    //Funcion para validar la identidad
    public function ValidarIdentidad($identidad)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_valid_identidad('$identidad');";
        
        $respuesta = mysqli_query($bd, $query);
        
        mysqli_close($bd);
        return $respuesta;
    }

    //Funcion para validar el correo
    public function ValidarCorreo($correo)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_valid_correo('$correo');";
        
        $respuesta = mysqli_query($bd, $query);
        
        mysqli_close($bd);
        return $respuesta;
    }

    //Funcion para validar el numero de cuenta
    public function ValidarNumeroCuenta($numeroCuenta)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_valid_numero_cuenta('$numeroCuenta');";
        
        $respuesta = mysqli_query($bd, $query);
        
        mysqli_close($bd);
        return $respuesta;
    }

    //Funcion para validar traer el tamano de la contrasena
    public function obtenerTamanContra()
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_get_tamano_password();";
        
        $respuesta = mysqli_query($bd, $query);
        
        mysqli_close($bd);
        return $respuesta;
    }


    ///////// Metodos para el login ////////////////
    
    //Funcion para validar el login
    public function validarLogin($usuario, $password, $token, $tipoPlataforma)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_login('$usuario', '$password', '$token', $tipoPlataforma);";
        
        $respuesta = mysqli_query($bd, $query);

        if(mysqli_errno($bd) == 0)
        {
            return $respuesta;

        }else
        {
            return false;
        }

        mysqli_close($bd);        
    }

    //Funcion para validar el logueo
    public function validarLogueo($token, $usuario)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_validar_logueo('$token', '$usuario');";
        
        $respuesta = mysqli_query($bd, $query);

        if(mysqli_errno($bd) == 0)
        {
            return $respuesta;

        }else
        {
            return false;
        }

        mysqli_close($bd);        
    }

    //////// Funciones para el reseteo de contrasena ///////////

    //Funcion para validar el correo y traer el id de usuario
    public function validarCorreoResetPass($correo)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_valid_correo_reset_pass('$correo');";
        
        $respuesta = mysqli_query($bd, $query);
        
        mysqli_close($bd);
        return $respuesta;
    }

    //Funcion para insertar el codigo en la base de datos
    public function insertarCodigo($idUsuario, $codigo)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_insert_codigo($idUsuario, '$codigo');";
        
        $respuesta = mysqli_query($bd, $query);

        if(mysqli_errno($bd) == 0)
        {
            return $respuesta;

        }else
        {
            return false;
        }

        mysqli_close($bd);        
    }

    //Funcion para insertar la nueva contrasena por codigo
    public function resetearPasswordCodigo($codigo, $password)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_reset_pass_codigo('$codigo', '$password');";
        
        $respuesta = mysqli_query($bd, $query);

        if(mysqli_errno($bd) == 0)
        {
            return $respuesta;

        }else
        {
            return false;
        }

        mysqli_close($bd);        
    }

    //Funcion para insertar la nueva contrasena por pregunta
    public function resetearPasswordPregunta($usuario, $pregunta, $respuesta, $password)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_reset_pass_pregunta('$usuario', '$pregunta', '$respuesta', '$password');";
        
        $respuesta = mysqli_query($bd, $query);

        if(mysqli_errno($bd) == 0)
        {
            return $respuesta;

        }else
        {
            return false;
        }

        mysqli_close($bd);        
    }

    //Para obtener las preguntas del usuario para resetear su contrasena
    public function obtenerPreguntasUser($usuario)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_get_reset_preguntas_usuario('$usuario');";
        
        $respuesta = mysqli_query($bd, $query);
        
        mysqli_close($bd);
        return $respuesta;
    }

    //Funcion para insertar la nueva contrasena cuando venza
    public function resetearPasswordVence($usuario, $password, $nuevoPassword)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_reset_pass_vence('$usuario', '$password', '$nuevoPassword');";
        
        $respuesta = mysqli_query($bd, $query);

        if(mysqli_errno($bd) == 0)
        {
            return $respuesta;

        }else
        {
            return false;
        }

        mysqli_close($bd);        
    }

    //////////////// Buzon de quejas /////////////////////////////

    //Para obtener las categorias de las quejas
    public function obtenerCategoria()
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_get_categoria_queja();";
        
        $respuesta = mysqli_query($bd, $query);
        
        mysqli_close($bd);
        return $respuesta;
    }

    //Funcion para insertar la nueva contrasena cuando venza
    public function insertarQueja($token, $titulo, $descripcion, $categoria)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_insert_queja('$token', '$titulo', '$descripcion', $categoria);";
        
        $respuesta = mysqli_query($bd, $query);

        if(mysqli_errno($bd) == 0)
        {
            return $respuesta;

        }else
        {
            return false;
        }

        mysqli_close($bd);        
    }

    //Para obtener las quejas
    public function obtenerQuejas($token)
    {
        $conexion = new Conexion();
        $bd = $conexion->conexion_bd();
        
        $query = "CALL sp_get_quejas('$token');";
        
        $respuesta = mysqli_query($bd, $query);
        
        mysqli_close($bd);
        return $respuesta;
    }
}

ob_end_flush();