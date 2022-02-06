<?php

    require_once "../../bd/consultas.php";    
    //require_once ('../../clases/encriptar_desencriptar.php');
    require_once "../../clases/encriptarPassword/encriptar_desencriptar.php";

    //Clase para insertar el token
    class ApiRestInsertData
    {

        public function insertData($datosJson)
        {
            try {
                
                //Declarar variables
                $consulta = new Consultas();
                $datosArray = json_decode($datosJson, true);

                /* Estructura que se debe recibir
                    {
                        "nombre": "Ambos nombres del usuario o los que tenga",
                        "apellido": "Ambos apellidos del usuario o los que tenga",
                        "sexo": "Los que el usuario escoja por genero",
                        "identidad": "La identidad, pasaporte o carnet de residencia del usuario",
                        "nacionalidad": "La nacionalidad que el usuario escoja",
                        "estadoCivil": "El estado civil que escoja",
                        "fechaNacimiento": "La fecha de nacimiento del usuario (Mayor a 10 anios)",
                        "idTipoPersona": "El id del tipo de persona",
                        "tipoPersona": "El tipo de persona que escoja, "docente", "estudiante", "egresado" o "administrativo" en mayuscula",
                        "usuario": "El usuario que la persona escogio",
                        "password": "La contrasenia del usuario",
                        "correo": "correo del usuario obligatorio para todos",
                        "celular": "celular del usuario obligatorio para todos",
                        "telefono": "telefono fijo del usuario o "null" en string", no es obligatorio",
                        "numeroCuenta": "numero de cuenta si el usuario es estudiante o egresado o "null" en string",
                    }                    
                        rol y segmento validar aqui en el metodo
                */

                //print_r($datosArray);
                if(isset($datosArray['nombre']) && isset($datosArray['apellido']) && 
                   isset($datosArray['sexo']) && isset($datosArray['identidad']) &&
                   isset($datosArray['nacionalidad']) && isset($datosArray['estadoCivil']) && 
                   isset($datosArray['fechaNacimiento']) && isset($datosArray['idTipoPersona']) && 
                   isset($datosArray['tipoPersona']) && isset($datosArray['usuario']) &&
                   isset($datosArray['password'])  && isset($datosArray['correo']) &&
                   isset($datosArray['celular']) && isset($datosArray['telefono']) &&
                   isset($datosArray['numeroCuenta']))
                {
                    //Validaciones para saber que rol y a que segmento pertencen
                    switch ($datosArray['tipoPersona']) {//Validar en base de datos como quedaria
                        case 'INVITADO':
                            $rol = 1;
                            $segmento = 1;
                            break;     
                        case 'ESTUDIANTE':
                            $rol = 49;
                            $segmento = 2;
                            break;     
                        case 'EGRESADO':
                            $rol = 49;
                            $segmento = 4;
                            break;                                       
                        default: //permisos de invitado por defecto
                            $rol = 1;
                            $segmento = 1;
                            break;
                    } 
                    
                    //encriptar contrasenia y respuesta
                    $password = cifrado::encryption($datosArray['password']);
                    //$respuesta = cifrado::encryption($datosArray['respuesta']);

                    $respuesta = $consulta->insertarDatosRegistro(strtoupper($datosArray['nombre']), strtoupper($datosArray['apellido']), strtoupper($datosArray['sexo']),
                                                                  $datosArray['identidad'], strtoupper($datosArray['nacionalidad']), strtoupper($datosArray['estadoCivil']),
                                                                  $datosArray['fechaNacimiento'], $datosArray['idTipoPersona'],
                                                                  strtoupper($datosArray['usuario']), $rol, $password, 
                                                                  $segmento, strtoupper($datosArray['correo']), $datosArray['celular'], $datosArray['telefono'], 
                                                                  $datosArray['numeroCuenta']);
                    
                    if($respuesta != false)
                    {
                        $datosbd = mysqli_fetch_assoc($respuesta);
                        return $datosbd;
                    }else
                    {
                        //Error al insertar en la base de datos
                        return false;
                    }
                }else
                {
                    //Error con las variables enviadas a la API REST;
                    return "var";
                }  
            } catch (Exception $e) {
                return "Error:".$e->getMessage;
            }
        }
    }