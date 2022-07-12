$(document).ready(function () {
  readProducts();
});
function readProducts() {
    var parametro;
    $.ajax({
      data: parametro, //datos que se envian a traves de ajax
      url: '../Controlador/movil_listar_noticias_controlador.php', //archivo que recibe la peticion
      type: 'POST', //método de envio
      beforeSend: function() {
        $('#Noticias').html("Procesando, espere por favor...");
      },
      success: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
        $('#Noticias').html(response);
      }
    });
  }
  function leer(buscar){
    var parametro = {"buscar":buscar}
    $.ajax({
      data: parametro, //datos que se envian a traves de ajax
      url: '../Controlador/movil_listar_noticias_controlador.php', //archivo que recibe la peticion
      type: 'POST', //método de envio
      beforeSend: function() {
        $('#Noticias').html("Procesando, espere por favor...");
      },
      success: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
        $('#Noticias').html(response);
      }
    });
  }
  function eliminar(id) {
    var parametro = {
      'funcion': 'eliminar',
      'id': id
    }
    var confirmacion = confirm('¿Está seguro de eliminar?');
    if (confirmacion) {
      $.ajax({
        data: parametro, //datos que se envian a traves de ajax
        url: '../Controlador/movil_noticia_controlador.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        success: function(data) { //una vez que el archivo recibe el request lo procesa y lo devuelve
            console.log(data);
          if (data != '') {
            readProducts();
            datoseliminados();
          } else {
            alert('¡No se pudo eliminar!');
          }

        }
      });
    } else {
      console.log('Decidió no eliminar');
    }
  }

  function datoseliminados() {
    swal({
      title: "",
      text: "¡Los datos se eliminaron correctamente!",
      type: "success",
      showConfirmButton: true,
      timer: 3000
    });
  }

  function eliminar_archivos(id_noticia,id_recurso) {

    var parametro = {
      'funcion': 'eliminar',
      'id_noticia':id_noticia,
      'id_recurso':id_recurso
    }
    console.log(parametro);
    var confirmacion = confirm('¿Está seguro de eliminar?');
    if (confirmacion) {
      $.ajax({
        data: parametro, //datos que se envian a traves de ajax
        url: '../Controlador/movil_tabla_archivos_noticia_controlador.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        success: function(data) { //una vez que el archivo recibe el request lo procesa y lo devuelve
          if (data == '') {
            location.reload(true);
          }

        }
      });
    } else {
      console.log('Decidió no eliminar');
    }
  }
