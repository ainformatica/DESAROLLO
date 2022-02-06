//para poner la fecha de hoy
window.onload = function () {
  var fecha = new Date(); //Fecha actual
  var mes = fecha.getMonth() + 1; //obteniendo mes
  var dia = fecha.getDate(); //obteniendo dia
  var ano = fecha.getFullYear(); //obteniendo año
  if (dia < 10) dia = "0" + dia; //agrega cero si el menor de 10
  if (mes < 10) mes = "0" + mes; //agrega cero si el menor de 10

  var a = (document.getElementById("fecha_hoy").value =
    ano + "-" + mes + "-" + dia);

  var start = new Date(a);
  start.setFullYear(start.getFullYear() + 1);
  var startf = start.toISOString().slice(0, 10).replace(/-/g, "-");
  document.getElementById("fecha_a").value = startf;
};

$("#cbm_persona").change(function () {
  var string = $("#cbm_persona option:selected").text();
  var e = string.split(" ");
  var d = e[3];
  var a = string.charAt(1).toUpperCase();
  $("#txt_usuario").val(a + d);
});

//select del persona
function llenar_Persona() {
  var cadena = "&activar=activar";
  $.ajax({
    url: "../Controlador/reporte_carga_controlador.php?op=persona",
    type: "POST",
    data: cadena,
    success: function (r) {
      $("#cbm_persona").html(r).fadeIn();
      var o = new Option("SELECCIONAR PERSONA", 0);

      $("#cbm_persona").append(o);
      $("#cbm_persona").val(0);
    },
  });
}
llenar_Persona();

//LLENAR ROL
function llenar_rol() {
  var cadena = "&activar=activar";
  $.ajax({
    url: "../Controlador/reporte_carga_controlador.php?op=rol",
    type: "POST",
    data: cadena,
    success: function (r) {
      $("#cbm_rol").html(r).fadeIn();
      var o = new Option("SELECCIONAR ROL", 0);

      $("#cbm_rol").append(o);
      $("#cbm_rol").val(0);
    },
  });
}
llenar_rol();

$("#guardar_usuario").click(function () {
  var cbm_persona = $("#cbm_persona").val();
  var cbm_rol = $("#cbm_rol").val();
  var txt_usuario = $("#txt_usuario").val();
  var txt_confirmar_contrasena = $("#txt_confirmar_contrasena").val();
  var estado = 2;
  var intentos = 0;
  var vencimiento = $("#fecha_a").val();
  var creacion = $("#fecha_hoy").val();
  var creado_por = $("#usuario").val();

  if (
    txt_usuario.length == 0 ||
    txt_confirmar_contrasena.length == 0
  ) {
    swal({
      title: "alerta",
      text: "Llene o seleccione los campos vacios correctamente",
      type: "warning",
      showConfirmButton: true,
      timer: 15000,
    });
  } else if (cbm_persona == 0 || cbm_rol == 0) {
    swal("Alerta!", "Seleccione una opción válida", "warning");
  } else {
    
    $.post(
      "../Controlador/reporte_carga_controlador.php?op=verificarUsuario",
      {
        Usuario: txt_usuario,
      },

      function (data, status) {
        console.log(data);
        data = JSON.parse(data);

        if (data.registro > 0) {
          alert("Ya existe un usuario con ese nombre");
        } else {
          bloquea();
          $.ajax({
            url: "../Controlador/registrar_usuario_controlador.php",
            type: "POST",
            data: {
              id_persona: cbm_persona,
              Id_rol: cbm_rol,
              Usuario: txt_usuario,
              Contrasena: txt_confirmar_contrasena,
              Fec_vence_contrasena: vencimiento,
              Intentos: intentos,
              estado: estado,
              Fecha_creacion: creacion,
              Creado_por: creado_por,
            },
          }).done(function (resp) {
            if (resp > 0) {
              swal(
                "Buen trabajo!",
                "datos ingresados correctamente!",
                "success"
              );
              location.reload();
            } else {
              swal(
                "Alerta!",
                "No se pudo completar intente de nuevo!",
                "warning"
              );
              //document.getElementById("txt_registro").value = "";
            }
          });
        }
      }
    );

    
  }
});
//
//boton.addEventListener("click", bloquea, false);

function bloquea() {
  
var boton = document.getElementById("guardar_usuario");
  if (boton.disabled == false) {
    boton.disabled = true;

    setTimeout(function () {
      boton.disabled = false;
    }, 5000);
  }
}
