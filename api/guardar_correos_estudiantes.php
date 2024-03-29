<?php
require_once('../clases/Conexion.php');

$body = file_get_contents("php://input");
$data = json_decode($body, true);

$id = $data['id'];

$list = $data['data'];
echo $list;
$info = array();

foreach($list as $item){


    $sql = "call proc_insertar_correos(:correo)";
    $stmt =  $connect->prepare($sql);
    $stmt->bindParam(":correo",$item['correo'],PDO::PARAM_STR);
   
    
    $stmt->execute();
    $idTask = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['id_contacto'];
    array_push($info,$idTask);
    
}

$send = array("info"=>$info, "status" => 200);
http_response_code(200);
echo json_encode($send);