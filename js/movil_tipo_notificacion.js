function leer(buscar){
    var parametro = {"buscar":buscar}
    $.ajax({
      data: parametro, //datos que se envian a traves de ajax
      url: '../Controlador/movil_listar_tipo_notificacion_controlador.php', //archivo que recibe la peticion
      type: 'POST', //método de envio
      beforeSend: function() {
        $('#tipo_notificacion').html("Procesando, espere por favor...");
      },
      success: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
        $('#tipo_notificacion').html(response);
      }
    });
  }

  function readProducts() {
    var parametro;
    $.ajax({
      data: parametro, //datos que se envian a traves de ajax
      url: '../Controlador/movil_listar_tipo_notificacion_controlador.php', //archivo que recibe la peticion
      type: 'POST', //método de envio
      beforeSend: function() {
        $('#tipo_notificacion').html("Procesando, espere por favor...");
      },
      success: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
        $('#tipo_notificacion').html(response);
      }
    });
  }

  function eliminar(id) {
    var parametro = {
      'funcion': 'eliminar',
      'id': id
    }
    var confirmacion = confirm('esta seguro de eliminar');
    if (confirmacion) {
      $.ajax({
        data: parametro, //datos que se envian a traves de ajax
        url: '../Controlador/movil_guardar_tiponotificacion_controlador.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        success: function(data) { //una vez que el archivo recibe el request lo procesa y lo devuelve
          console.log(data);
          if (data != '') {
            readProducts();
            datoseliminados();
          } else {
            alert('no se pudo eliminar!!');
          }
          
        }
      });
    } else {
      console.log('decidio no eliminar');
    }
  }

  function datoseliminados(){
                  swal({
                     title:"",
                     text:"los datos se eliminaron correctamente.",
                     type: "success",
                     showConfirmButton: true,
                     timer: 3000
                  });
                }

      

