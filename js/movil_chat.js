
setInterval(mostrarBandeja(), 2000);

function mostrarBandeja(){
    $("#chats").load('../Controlador/movil_cargar_chats_controlador.php')
 }
function getChats(id_chat,id_usuario) {
    $("#resultado_chat").load('../Controlador/movil_mostrar_chat_controlador.php',{
        "id_chat": id_chat, "id_usuario":id_usuario, 'funcion':'mostrar'//,
    });
}

function getUser() {
    var parametros = {
        "funcion": 'buscarUsuarios'
    }
    $.ajax({
        data: parametros, //datos que se envian a traves de ajax
        url: '../Controlador/movil_chat_controlador.php', //archivo que recibe la peticion
        type: 'post', //método de envio
        beforeSend: function() {
            $("#resultado_chat").html("Procesando, espere por favor...");
        },
        success: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
            $("#resultado_chat").html(response);
        }
    });
}
function cerrar(){
    $("#resultado_chat").empty();
}

function getid(id) {
    var parametros = {
        "funcion": 'crearNuevoChat',
         "id": id
    }
    $.ajax({
        data: parametros, //datos que se envian a traves de ajax
        url: '../Controlador/movil_chat_controlador.php', //archivo que recibe la peticion
        type: 'post', //método de envio
        success: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
            $("#resultado_chat").html(response);
        }
    });
}

function enviar(id_chat,id_usuario){
    var message = document.getElementById('mensaje').value;
    var parametros = {
        "funcion": 'enviarINFO',
        "id_chat": id_chat,
        "id_usuario": id_usuario,
         "message": message 
    }
    if(message != ''){
    $.ajax({
        data: parametros, //datos que se envian a traves de ajax
        url: '../Controlador/movil_envio_info_chat_controlador.php', //archivo que recibe la peticion
        type: 'POST',
        success: function() { //una vez que el archivo recibe el request lo procesa y lo devuelve
            getChats(id_chat,id_usuario);
        }
         });
    
            }else{
                swal({
                    title: "",
                    text: "No se pueden enviar mensajes vacios!!",
                    type: "error",
                    showConfirmButton: false,
                    timer: 3000
                });
            }
}
function filtrarUsuarios(buscar) {
    var parametros = {
        "funcion": 'filtrarUsuarios',
        "buscar":buscar
    }
    $.ajax({
        data: parametros, //datos que se envian a traves de ajax
        url: '../Controlador/movil_chat_controlador.php', //archivo que recibe la peticion
        type: 'post', //método de envio
        beforeSend: function() {
            $("#filtro_chat").html("Procesando, espere por favor...");
        },
        success: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
            $("#filtro_chat").html(response);
        }
    });
}