<?php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ob_start();
require_once('../clases/Conexion.php');

require_once('../clases/funcion_bitacora_movil.php');

require_once('../vistas/pagina_inicio_vista.php');

require_once('../clases/funcion_visualizar.php');

$Id_objeto = 10161;

bitacora_movil::evento_bitacora($_SESSION['id_usuario'], $Id_objeto, 'INGRESO', 'A LA VISTA DEL CHAT ');
if (permiso_ver('161') == '0') {
    header("location: ../vistas/pagina_inicio_vista");
}
?>

<head>
    <script src="../js/autologout.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://unpkg.com/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="../js/movil_chat.js" defer></script>
</head>

<body>
    <div class="content-wrapper">
        <!-- This is an example component -->
        <div class="w-100 h-auto">
            <div class="grid grid-cols-3 min-w-full border rounded">
                <!-- pagina chats -->
                <div class="col-span-1" style="background-color: #007BFF;">
                    <div class="my-3 mx-3">
                    </div>
                    <span class="grid gap-1 grid-cols-3 overflow-auto">
                        <h2 class="ml-2 mb-2 mr-2 text-white text-lg my-1">Chats</h2>
                        <button class="ml-2 mb-2 mr-2 btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Cerrar Chat" onclick="cerrar()">Cerrar</button>
                        <button class="ml-2 mb-2 mr-2 btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="Nuevo Chat" onclick="getUser()">Nuevo</button>
                    </span>
                    <ul class="overflow-auto" style="height: 601px; background-color:whitesmoke;">
                        <li id="chats">

                        </li>
                    </ul>
                </div>
                <!-- pagina mensajes -->

                <div id="resultado_chat" class="col-span-2 bg-gray-500 overflow-auto" style="height: 713px;">

                </div>

            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>

</body>

<?php ob_end_flush(); ?>