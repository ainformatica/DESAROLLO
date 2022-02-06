<?php
 require_once '../clases/Conexion.php';
//tabla segmento_usuario
$valor = (int)$_POST['tipoPersona'];
$Segmento_id = (int)$_POST['segmento'];
if ($valor > 0) {
    $sql_segmentos = "SELECT u.Id_usuario,p.nombres,p.apellidos FROM tbl_personas p
    inner JOIN tbl_usuarios u on u.id_persona=p.id_persona and p.id_tipo_persona = $valor";
    $resultado_segmentos = $mysqli->query($sql_segmentos); ?>
    <table id='tabla_usuarios' class='table table-bordered table-striped'>
                <thead>
                  <tr>
                    <th hidden>ID</th>
                    <th>NOMBRE</th>
                    <th>APELLIDOS</th>
                    <th>SELECCIONAR <input type='checkbox' class='ml-2' name='marcar_todos' id='marcar_todos' onclick='toggle(this)'></th>
                  </tr>
                </thead>
                <tbody>
                <?php while ($segmento = $resultado_segmentos->fetch_array(MYSQLI_ASSOC)) { 
                  $id = $segmento['Id_usuario'];
                  $nombre = $segmento['nombres'];
                  $apellidos = $segmento['apellidos'];
                $sql_exist = "select count(usuario_id) as exist from tbl_movil_segmento_usuario where segmento_id = $Segmento_id and usuario_id = $id";
                $resultado = $mysqli->query($sql_exist);
                $row = $resultado->fetch_assoc();
                if($row['exist']!=1){ ?>
                
      <tr>
        <td hidden> <?php echo $id?></td>
        <td><?php echo $nombre ?></td>
        <td><?php echo $apellidos ?></td>
        <td style='text-align: center;'>
          <input type='checkbox' class='personas-check' name='persona[]' value='<?php echo $id?>' onclick='this.disabled = true' onchange='validar(this)'><br>
          </a>
        </td>
        </tr>
             <?php   }
              } ?>
    
        </tbody>
        </table>
      
    <?php } ?>

    <script>
       $(function() {
      $('#tabla_usuarios').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
        }
      });
    });
    </script>
  
  
    
  

