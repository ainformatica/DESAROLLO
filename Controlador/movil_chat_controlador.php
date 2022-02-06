<?php
if(!isset($_SESSION)){ 
    session_start();
}
ob_start();
$funcion = isset($_POST['funcion']) ? $_POST['funcion'] : '';
if ($funcion == 'buscarUsuarios') {
    getUser();
}

function getUser()
{ //obtinen los usuarios
    require '../clases/Conexion.php';
        ?>
       
<div class="col-span-1">
    <div class="my-3 mx-3 border-b border-gray-300">
        <div class="relative text-gray-600 focus-within:text-gray-400">
            <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    viewBox="0 0 24 24" class="w-6 h-6 text-gray-500">
                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
            <input placeholder="Buscar Usuario" class="py-2 pl-10 block w-full rounded bg-gray-100 outline-none focus:text-gray-700" type="search"
                name="search" id="search" required onclick="filtrarUsuarios(this.value);"
                onkeyup="filtrarUsuarios(this.value);" />
        </div>
    </div>


    <div id='filtro_chat'>

    </div>


</div>
<?php }

$funcion = isset($_POST['funcion']) ? $_POST['funcion'] : '';
$id = isset($_POST['id']) ? $_POST['id'] : '';
if ($funcion == 'crearNuevoChat') {
    CrearChat($id);
}

function CrearChat($id){
    require_once('../clases/Conexion.php');
    require_once('../Controlador/movil_mostrar_chat_controlador.php');
    $chat = new mostrarChat();
    //comprobamos si el chat ya existe
    $sql_existe = "SELECT COUNT(`id_session_chat`) as existe,id_session_chat,id_usuario2  FROM `tbl_movil_session_chats` WHERE `id_usuario1` = 1 and `id_usuario2` = $id";
    $rspta = $mysqli->query($sql_existe)->fetch_assoc();
    if($rspta['existe'] == '1'){
        //se abre el chat 
        $message = 'existe';
        $id_chat = $rspta['id_session_chat'];
        $chat->mostrarChat($id_chat,$id);
       
    }elseif($rspta['existe'] == '0'){
        //se crea la sesion del chat
        $sql_crear_session = "INSERT INTO tbl_movil_session_chats VALUES (null,1,$id)";
        $mysqli->query($sql_crear_session);
        $sql_id = "SELECT id_session_chat FROM tbl_movil_session_chats WHERE id_usuario2 = $id";
        $nuevo = $mysqli->query($sql_id)->fetch_assoc();
        $chat->mostrarChat($nuevo['id_session_chat'],$id);
    }
}


//filtrar busqueda de usuarios
$funcion = isset($_POST['funcion']) ? $_POST['funcion'] : '';
if ($funcion == 'filtrarUsuarios') {
    filtroUser();
}

function filtroUser()
{
    //filtrar usuarios
    require '../clases/Conexion.php';
        
  
      $dato = $_POST['buscar'];
      $sql = "SELECT u.Id_usuario,p.nombres,p.apellidos FROM tbl_usuarios u INNER JOIN
        tbl_personas p on u.id_persona = p.id_persona";

        if (!empty($dato)) {
            $sql .= " WHERE p.nombres LIKE '%$dato%' or p.apellidos LIKE '%$dato%'";
        }
        
        $resultado = $mysqli->query($sql);
      while ($row = $resultado->fetch_array(MYSQLI_ASSOC)) {
        $id = $row['Id_usuario'];
        $nombre_usuario = $row['nombres'].' '.$row['apellidos'];
     ?>   
    <a onclick='getid(<?php echo $id ?>)'
    class='hover:bg-gray-100 border-b border-gray-300 px-3 py-2 cursor-pointer flex items-center text-sm focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out'>
    <img class='h-10 w-10 rounded-full object-cover' src='' alt='photo' />
    <div class='w-full p-2'>
        <div class='flex justify-between'>
            <span class='block ml-2 font-semibold text-base text-gray-600'><?php echo $nombre_usuario?></span>
        </div>
    </div>
</a>

<?php }
  
}
ob_end_flush();
?>