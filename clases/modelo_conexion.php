<?php
class conexion{

    private $servidor;
    private $usuario;
    private $contrasena;
    private $baseDatos;

    public $conexion;

    public function __construct()
    {
        $this->servidor = "167.114.169.207";
        $this->usuario = "informat_desarrollo";
        $this->contrasena = "!fuRCr3XR-tz";
        $this->baseDatos = "informat_desarrollo_automatizacion";
    }

    function conectar(){
        $this->conexion = new mysqli($this->servidor, $this->usuario, $this->contrasena, $this->baseDatos);
        $this->conexion->set_charset("utf-8");

    }

    function cerrar(){
        $this->conexion->close();
    }
    


}








?>