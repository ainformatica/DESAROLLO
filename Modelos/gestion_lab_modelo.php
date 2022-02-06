<?php
require "../clases/conexion_mantenimientos.php";



$instancia_conexion = new conexion();

class reportes
{
      //Implementamos nuestro constructor
  public function __construct()
  {

  }

  //Implementamos un método para insertar registros del producto
  
  
  public function reportesTipo_adquisicion()
  {
     global $instancia_conexion;
    $sql="select tipo_adquisicion FROM tbl_tipo_adquisicion";
    return $instancia_conexion->ejecutarConsulta($sql);

  }

  public function reportes_existencias()
  {
     global $instancia_conexion;
    $sql="SELECT  p.id_tipo_producto as tipo_producto, p.stock_minimo as stock, inv.id_inventario as id_inventario, p.id_producto as id_producto, p.nombre_producto as nombre_producto, inv.existencia as existencia FROM tbl_inventario inv INNER JOIN 
      tbl_productos p ON inv.id_producto=p.id_producto";
  
    return $instancia_conexion->ejecutarConsulta($sql);

  }
  public function reportes_detalle_existencias($id_producto)
  {
    global $instancia_conexion;
    $id_producto1=intval($id_producto);

  /* Manda a llamar todos las datos de la tabla para llenar el gridview  */
    $sql="CALL sel_reportes_existencia('$id_producto1')";
  
    return $instancia_conexion->ejecutarConsulta($sql);
  }

  public function reportes_productos($nombre_producto)
  {
     global $instancia_conexion;
     $sql = "CALL sel_reporte_producto2('$nombre_producto')";

  
    return $instancia_conexion->ejecutarConsulta($sql);

  }
  public function reportes_adquisicion($nombre_producto)
  {
     global $instancia_conexion;
     $sql = "SELECT a.id_detalle as id_detalle,
     c.nombre_producto as nombre_producto,a.numero_inventario as 
     numero_inventario FROM tbl_detalle_adquisiciones a 
     INNER JOIN tbl_productos c WHERE a.id_producto=c.id_producto and 
     a.id_adquisicion = $nombre_producto";

  
    return $instancia_conexion->ejecutarConsulta($sql);

  }
  public function reportes_adquisicion_caracteristicas($id_detalle)
  {
     global $instancia_conexion;
     $sql = "SELECT d.id_detalle_caracteristica,d.valor_caracteristica as valor,
     a.tipo_caracteristica as caracteristica FROM tbl_tipo_caracteristica 
     a INNER JOIN tbl_detalle_adquisiciones b INNER JOIN 
     tbl_caracteristicas_producto c INNER JOIN 
     tbl_detalle_caracteristica d WHERE  b.id_detalle = '$id_detalle' and 
     b.id_producto = c.id_producto and 
     c.id_tipo_caracteristica = a.id_tipo_caracteristica 
     and b.id_detalle=d.id_detalle and 
     c.id_caracteristica_producto=d.id_caracteristica_producto;";

  
    return $instancia_conexion->ejecutarConsulta($sql);

  }
  public function reportes_adquisicion_tipo($id_adquisicion)
  {
     global $instancia_conexion;
     $sql = "SELECT a.id_adquisicion as id, ta.tipo_adquisicion as tipo, a.descripcion_adquisicion as descripcion,a.fecha_adquisicion as fecha, e.estado as estado
     FROM tbl_adquisiciones a inner join tbl_tipo_adquisicion ta inner join tbl_estado e where a.id_adquisicion='$id_adquisicion' and a.id_tipo_adquisicion=ta.id_tipo_adquisicion and a.id_estado=e.id_estado;";

  
    return $instancia_conexion->ejecutarConsulta($sql);

  }




  public function reportes_asignacion($id_asignacion)
  {
     global $instancia_conexion;
     $sql = "SELECT a.id_asignacion AS id,
     a.id_asignacion AS id_asignacion, da.numero_inventario as inventario,p.nombre_producto as producto, u.ubicacion as ubicacion,uu.ubicacion as ubicacion_previa, CONCAT(per.nombres, ' ', per.apellidos) AS nombre,CONCAT(perr.nombres, ' ', perr.apellidos) AS nombre_previo, a.fecha_asignacion as fecha,a.fecha_asignacion_previa as fecha_previa, a.motivo as motivo,a.motivo_previo as motivo_previo
     FROM tbl_asignaciones AS a
     LEFT JOIN tbl_detalle_adquisiciones AS da ON a.id_detalle = da.id_detalle
     LEFT JOIN tbl_productos AS p ON da.id_producto = p.id_producto
     LEFT JOIN tbl_ubicacion AS u ON a.id_ubicacion = u.id_ubicacion
     LEFT JOIN tbl_ubicacion AS uu ON a.id_ubicacion_previa = uu.id_ubicacion
     LEFT JOIN tbl_personas AS perr ON a.id_usuario_responsable_previo = perr.id_persona
     LEFT JOIN tbl_personas AS per ON a.id_usuario_responsable = per.id_persona where a.id_asignacion ='$id_asignacion'";

  
    return $instancia_conexion->ejecutarConsulta($sql);

  }

  


  public function prueba1($id_producto)
  {
     global $instancia_conexion;
     $sql = "CALL sel_reportes_existencia_asignados('$id_producto');";

  
    return $instancia_conexion->ejecutarConsulta($sql);

  }
  public function prueba2($id_producto)
  {
     global $instancia_conexion;
     $sql = "CALL sel_reportes_existencia_asignados1('$id_producto');";

  
    return $instancia_conexion->ejecutarConsulta($sql);

  }
    
  public function reportes_salida($num_inventario)
  {
     global $instancia_conexion;
     $sql = "CALL select_reporte_salida('$num_inventario')";
     return $instancia_conexion->ejecutarConsulta($sql);
  } 
  
   public function reportes_salida_caracteristicas1($id_detalle)
  {
     global $instancia_conexion;
     $sql = "SELECT d.id_detalle_caracteristica,d.valor_caracteristica as valor,
     a.tipo_caracteristica as caracteristica FROM tbl_tipo_caracteristica 
     a INNER JOIN tbl_detalle_adquisiciones b INNER JOIN 
     tbl_caracteristicas_producto c INNER JOIN 
     tbl_detalle_caracteristica d WHERE  b.id_detalle ='4' and 
     b.id_producto = c.id_producto and 
     c.id_tipo_caracteristica = a.id_tipo_caracteristica 
     and b.id_detalle=d.id_detalle and 
     c.id_caracteristica_producto=d.id_caracteristica_producto;";

  
    return $instancia_conexion->ejecutarConsulta($sql);

  }

}



