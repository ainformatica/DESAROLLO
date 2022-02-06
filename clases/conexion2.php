<?php
class conexion2
{
    private const DBHOST = '51.222.86.251';
    private const DBUSER = 'informat_desarrollo';
    private const DBPASS = '^Kwd{PE^(L&#';
    private const DBNAME = 'informat_desarrollo_automatizacion';

    private $dsn = 'mysql:host=' . self::DBHOST . ';dbname=' . self::DBNAME . '';
    protected $conn = null;

    function __construct()
    {
        try {
            $this->conn = new PDO($this->dsn, self::DBUSER, self::DBPASS);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            //echo 'conecta';
        } catch (PDOException $e) {
            die('Error' . $e->getMessage());
        }
    }
    
}