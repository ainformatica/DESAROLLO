<?php
session_start();
include_once '../clases/Conexion.php';

    $acta  = filter_input(INPUT_POST, 'acta');
?>

    <select class="form-control select2" style="width: 35%;" name="responsable" id="responsable" required>
                                        <option value="-1">-- Seleccione --</option>
                                        <?php
                                        
                                                try {
                                                    $sql = "SELECT 
                                                    t1.id_persona,concat_ws(' ', t1.nombres, t1.apellidos) as nombres
                                                    FROM tbl_personas t1 
                                                    INNER JOIN tbl_horario_docentes t2 ON t2.id_persona = t1.id_persona 
                                                    INNER JOIN tbl_jornadas t3 ON t2.id_jornada = t3.id_jornada 
                                                    ORDER BY nombres ASC";
                                                    $resultado = $mysqli->query($sql);
                                                    while ($resp= $resultado->fetch_assoc()) { ?>
                                                        <option value="<?php echo $resp['id_persona']; ?>">  
                                                            <?php echo $resp['nombres']; ?>
                                                        </option>
                                                <?php }
                                                } catch (Exception $e) {
                                                    echo "Error: " . $e->getMessage();
                                                }
                                                ?>                                    
    </select>