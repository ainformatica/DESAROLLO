<?php
require_once('../clases/Conexion.php');

// $id_area = $_POST['id_area'];
//$id_persona = $_POST['id_persona'];


// $Id_asignatura = json_decode($_POST['Id_asignatura']);
//$data = $_POST['array'];
$data = json_decode($_POST['array1']);

//var_dump($Id_asignatura);
// var_dump($id_persona);

foreach ($data as $item) {
    $sql = "CALL proc_insertar_requisitos_plan(:id_asignatura_requisito)";
    $stmt =  $connect->prepare($sql);
    $stmt->bindParam(":id_asignatura_requisito", $item, PDO::PARAM_INT);
    // $stmt->bindParam(":Id_asignatura", $Id_asignatura, PDO::PARAM_INT);



    $stmt->execute();

    // $idTask = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['id_pref_area_doce'];
    // array_push($info, $idTask);  

}
