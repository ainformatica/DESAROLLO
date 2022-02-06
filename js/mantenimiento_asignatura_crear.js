//llena el plan de asignatura
function llenar_plan() {
  var cadena = "&activar=activar";
  $.ajax({
    url: "../Controlador/plan_estudio_controlador.php?op=plan",
    type: "POST",
    data: cadena,
    success: function (r) {
      $("#cbm_plan").html(r).fadeIn();
      var o = new Option("SELECCIONAR", 0);

      $("#cbm_plan").append(o);
      $("#cbm_plan").val(0);
    },
  });
}
llenar_plan();
//llena el area de asignatura

function llenar_area() {
  var cadena = "&activar=activar";
  $.ajax({
    url: "../Controlador/plan_estudio_controlador.php?op=area",
    type: "POST",
    data: cadena,
    success: function (r) {
      $("#cbm_area").html(r).fadeIn();
      var o = new Option("SELECCIONAR", 0);

      $("#cbm_area").append(o);
      $("#cbm_area").val(0);
    },
  });
}
llenar_area();

//lena perido de asignatura
function llenar_periodo() {
  var cadena = "&activar=activar";
  $.ajax({
    url: "../Controlador/plan_estudio_controlador.php?op=periodo",
    type: "POST",
    data: cadena,
    success: function (r) {
      $("#cbm_periodo").html(r).fadeIn();
      var o = new Option("SELECCIONAR", 0);

      $("#cbm_periodo").append(o);
      $("#cbm_periodo").val(0);
    },
  });
}
llenar_periodo();

//llena el plan para equivalencia
function llenar_plan1() {
  var cadena = "&activar=activar";
  $.ajax({
    url: "../Controlador/plan_estudio_controlador.php?op=plan",
    type: "POST",
    data: cadena,
    success: function (r) {
      $("#cbm_plan1").html(r).fadeIn();
      var o = new Option("SELECCIONAR", 0);

      $("#cbm_plan1").append(o);
      $("#cbm_plan1").val(0);
    },
  });
}
llenar_plan1();

//llenar plan para requisito
function llenar_plan2() {
  var cadena = "&activar=activar";
  $.ajax({
    url: "../Controlador/plan_estudio_controlador.php?op=plan",
    type: "POST",
    data: cadena,
    success: function (r) {
      $("#cbm_plan_requisito").html(r).fadeIn();
      var o = new Option("SELECCIONAR", 0);

      $("#cbm_plan_requisito").append(o);
      $("#cbm_plan_requisito").val(0);
    },
  });
}
llenar_plan2();

//llena en cascada equivalencia que selecciona del plan
$("#cbm_plan1").change(function () {
  var id_plan_estudio = $(this).val();
  // console.log(id_plan_estudio);
  //  document.getElementById("txt_capacidad_edita").value = "";
  // Lista deaulas
  $.post("../Controlador/plan_estudio_controlador.php?op=id_plan", {
    id_plan_estudio: id_plan_estudio,
  }).done(function (respuesta) {
    $("#cbm_asignaturas").html(respuesta);

    // $("#cbm_requisito_asignaturas").html(respuesta);
    // console.log(respuesta);
  });
});

//llena las asignaturas para requisito de ella
$("#cbm_plan").change(function () {
  var id_plan_estudio = $(this).val();
  // console.log(id_plan_estudio);
  //  document.getElementById("txt_capacidad_edita").value = "";
  // Lista deaulas
  $.post("../Controlador/plan_estudio_controlador.php?op=id_plan", {
    id_plan_estudio: id_plan_estudio,
  }).done(function (respuesta) {
    $("#cbm_asignaturas_requisito").html(respuesta);

    // $("#cbm_requisito_asignaturas").html(respuesta);
    //  console.log(respuesta);
  });
});

//trae los creditos del plan
$("#cbm_plan").change(function () {
  var id_plan = $(this).val();
  var txt_uv = $("#txt_uv").val();
  //  console.log(id_plan);

  $.post(
    "../Controlador/plan_estudio_controlador.php?op=UVplan",
    { id_plan_estudio: id_plan },
    function (data_, status) {
      data_ = JSON.parse(data_);

      $("#txt_uv_plan").val(data_.creditos_plan);
      $("#num_clases_plan").val(data_.num_clases);
    }
  );
  $.post(
    "../Controlador/plan_estudio_controlador.php?op=contarAsignaturas",
    { id_plan_estudio: id_plan },
    function (data, status) {
      data = JSON.parse(data);
      $("#suma_clases_plan").val(data.suma);
      // var a = $("#suma_clases_plan").val();
      //   console.log(a);
    }
  );
  $.post(
    "../Controlador/plan_estudio_controlador.php?op=contarCreditosPlan",
    { id_plan_estudio: id_plan },
    function (data, status) {
      data = JSON.parse(data);
      $("#suma_unidades_plan").val(data.suma);
      // var a = $("#suma_clases_plan").val();
      //   console.log(a);
    }
  );
});

//validar que solo acepte archivos pdf
function Validar() {
  var archivo = $("#txt_silabo").val();
  var extensiones = archivo.substring(archivo.lastIndexOf("."));
  // console.log(extensiones);
  if (extensiones != ".pdf") {
    alert("El archivo de tipo " + extensiones + " no es válido");
    document.getElementById("txt_silabo").value = "";
  }
}

//las equivalencias de la asignatura
function insertarEquivalencias() {
  var cbm_asignaturas = $("#cbm_asignaturas").val();

  // console.log(cbm_asignaturas);
  $.ajax({
    type: "POST",
    url: "../Controlador/equivalencia_crear_asignatura_controlador.php",
    //  data: { array: id_area}, //capturo array
    data: {
      array: JSON.stringify(cbm_asignaturas),
    },
    success: function (data) {
      // swal("Ingresado!", "Datos ingresados correctamente!", "success");
      //  console.log("equivalencia");
    },
  });
}
//las equivalencias de la asignatura
function insertarRequisitos() {
  var cbm_asignaturas_requisito = $("#cbm_asignaturas_requisito").val();

  //  console.log(cbm_asignaturas);
  $.ajax({
    type: "POST",
    url: "../Controlador/requisito_crear_asignatura_controlador.php",
    //  data: { array: id_area}, //capturo array
    data: {
      array1: JSON.stringify(cbm_asignaturas_requisito),
    },
    success: function (data) {
      // swal("Ingresado!", "Datos ingresados correctamente!", "success");
      //  console.log("requisito");
    },
  });
}

//el documento de la asignatura silabo
function RegistrarSilabo() {
  var formData = new FormData();
  var curriculum = $("#txt_silabo")[0].files[0];
  formData.append("c", curriculum);
  //formData.append('nombrearchivo',nombrearchivo);

  $.ajax({
    url: "../Controlador/silabo_asignatura_controlador.php",
    type: "post",
    data: formData,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      if (respuesta != 0) {
        // Swal(
        //   "Mensaje De Confirmacion",
        //   "Se subio el curriculum con exito",
        //   "success"
        // );
        //  console.log("silabo");
      }
    },
  });
  return false;
}

//insertar asignatura
$("#guardar_asig").click(function () {
  var cbm_plan = $("#cbm_plan").val();
  var cbm_usada_carga = $("#cbm_usada_carga").val();
  var cbm_periodo = $("#cbm_periodo").val();
  var cbm_area = $("#cbm_area").val();
  var txt_uv = $("#txt_uv").val();
  var txt_codigo_asignatura = $("#txt_codigo_asignatura").val();
  var txt_nombre_asignatura = $("#txt_nombre_asignatura").val();
  var cbm_reposicion = $("#cbm_reposicion").val();
  var cbm_suficiencia = $("#cbm_suficiencia").val();
  var txt_silabo = $("#txt_silabo").val();
  var estado = 0;
  var tipo_asignatura = 1;

  if (
    cbm_plan == null ||
    txt_uv.length == 0 ||
    cbm_periodo == null ||
    txt_codigo_asignatura.length == 0 ||
    cbm_area == null ||
    txt_nombre_asignatura.length == 0 ||
    cbm_reposicion == null ||
    txt_silabo.length == 0 ||
    cbm_suficiencia == null||
    cbm_usada_carga == null 
  ) {
    alert("no se permiten campos vacios");
  } else if (
    cbm_plan == 0 ||
    cbm_periodo == 0 ||
    cbm_area == 0 ||
    cbm_reposicion == 0 ||
    cbm_suficiencia == 0 ||
    cbm_usada_carga == 0
  ) {
    alert("seleccione una opcion valida");
  } else {
    var clases_plan = $("#suma_clases_plan").val();
    var num_clases_plan = $("#num_clases_plan").val();
    var suma_unidades_plan = $("#suma_unidades_plan").val();
    var txt_uv_plan = $("#txt_uv_plan").val();

    //  var suma_unidades_plan = document.getElementById("suma_unidades_plan").value();
    // var txt_uv_plan = document.getElementById("txt_uv_plan").val();

    var suma = parseInt(suma_unidades_plan) + parseInt(txt_uv);
    var sum_clases = parseInt(clases_plan) + 1;

    // alert(suma);

    if (sum_clases > num_clases_plan) {
      alert("La asignatura excede el numero de clases asignadas al plan!");
    } else if (suma > txt_uv_plan) {
      alert(
        "La uv de la asignatura excede el numero de unidades para el plan!"
      );
    } else {
      //  alert("no exce");
      $.post(
        "../Controlador/plan_estudio_controlador.php?op=nombreAsignatura",
        { id_plan_estudio: cbm_plan, asignatura: txt_nombre_asignatura },
        function (data, status) {
          data = JSON.parse(data);

          if (data.suma > 0) {
            alert("Ya existe una asignatura con ese nombre!");
          } else {
            swal({
              title: "alerta",
              text: "Por favor espere un momento",
              type: "warning",
              showConfirmButton: false,
              timer: 13000,
            });
            $.ajax({
              url: "../Controlador/registrar_asignatura_plan_controlador.php",
              type: "POST",
              data: {
                id_plan_estudio: cbm_plan,
                id_periodo_plan: cbm_periodo,
                id_area: cbm_area,
                uv: txt_uv,
                codigo: txt_codigo_asignatura,
                asignatura: txt_nombre_asignatura,
                reposicion: cbm_reposicion,
                suficiencia: cbm_suficiencia,
                estado: estado,
                carga: cbm_usada_carga,
                id_tipo_asignatura: tipo_asignatura,
              },
            }).done(function (resp) {
              console.log(resp);

              if (resp > 0) {
                if (resp == 1) {
                  //alert("si");
                  swal({
                    title: "alerta",
                    text: "Por favor espere un momento",
                    type: "warning",
                    showConfirmButton: false,
                    timer: 11000,
                  });

                  refrescar(15000);

                  RegistrarSilabo();
                  if ($("#cbm_asignaturas").val().length != 0) {
                    insertarEquivalencias();
                  }
                  if ($("#cbm_asignaturas_requisito").val().length != 0) {
                    insertarRequisitos();
                  }
                  mensaje();
                } else {
                  swal("Alerta!", "No se pudo completar la acción", "warning");
                }
              }
            });
          }
        }
      );
    }
  }
});

//FUNCION PARA ACTUALIZAR PAGINA DESPUES DE 10 SEGUNDOS DE HABER GUARDADO
function refrescar(tiempo) {
  setTimeout("location.reload(true);", tiempo);
}

function mensaje() {
  setTimeout(function () {
    swal("Buen trabajo!", "Los datos se insertaron correctamente!", "success");
  }, 13000);
}



//
//insertar asignatura de servicio
$("#guardar_asig_servicio").click(function () {
  
  var txt_uv = $("#txt_uv").val();
  var txt_codigo_asignatura = $("#txt_codigo_asignatura").val();
  var txt_nombre_asignatura = $("#txt_nombre_asignatura").val();
  var cbm_reposicion = $("#cbm_reposicion").val();
  var cbm_suficiencia = $("#cbm_suficiencia").val();
  var txt_silabo = $("#txt_silabo").val();
  var estado = 0;
  var tipo_asignatura = 2;

  if (
   
    txt_uv.length == 0 ||
    txt_codigo_asignatura.length == 0 ||
    txt_nombre_asignatura.length == 0 ||
    cbm_reposicion == null ||
    txt_silabo.length == 0 ||
    cbm_suficiencia == null
  ) {
    alert("no se permiten campos vacios");
  } else if (
    
    
    cbm_reposicion == 0 ||
    cbm_suficiencia == 0
  ) {
    alert("seleccione una opcion valida");
  } else {
    

    $.post(
      "../Controlador/plan_estudio_controlador.php?op=nombreAsignatura_servicio",
      { asignatura: txt_nombre_asignatura},
      function (data, status) {
        data = JSON.parse(data);

        if (data.suma > 0) {
          alert("Ya existe una asignatura con ese nombre!");
        } else {
          swal({
            title: "alerta",
            text: "Por favor espere un momento",
            type: "warning",
            showConfirmButton: false,
            timer: 13000,
          });
          $.ajax({
            url: "../Controlador/registrar_asignatura_servicio_plan_controlador.php",
            type: "POST",
            data: {
              
              uv: txt_uv,
              codigo: txt_codigo_asignatura,
              asignatura: txt_nombre_asignatura,
              reposicion: cbm_reposicion,
              suficiencia: cbm_suficiencia,
              estado: estado,
              id_tipo_asignatura: tipo_asignatura,
            },
          }).done(function (resp) {
            console.log(resp);

            if (resp > 0) {
              if (resp == 1) {
                // alert("si");
                swal({
                  title: "alerta",
                  text: "Por favor espere un momento",
                  type: "warning",
                  showConfirmButton: false,
                  timer: 11000,
                });

               refrescar(15000);

               RegistrarSilabo();
                  
               mensaje();
                alert("se registro");
              } else {
                swal("Alerta!", "No se pudo completar la acción", "warning");
              }
            }
          });
        }
        
      
      }
    );
  }
  
});
