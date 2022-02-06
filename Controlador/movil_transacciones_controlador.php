<?php 
if(!isset($_SESSION)){ 
    session_start();
}
ob_start();
function transaccion($request,$response,$estado,$mysqli){
    $sql = "INSERT INTO tbl_movil_transacciones values (null,sysdate(),'$request','$response','$estado')";
    $resultado = $mysqli->query($sql);

    if($resultado){
        return true;
    }else{
        return false;
    }

}
ob_end_flush();
?>