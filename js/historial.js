function cargartablaabajo(anno,periodo) {
  // var periodo = $("#txt_num_periodo").val();
  // var anno = $("#txt_anno1").val();

  if (periodo.length == 0 || anno.length == 0) {
   // swal("Alerta!", "ingrese datos a buscar!", "warning");
    swal({
      title: "Alerta",
      text: "¡Ingrese el período y año a buscar!",
      type: "error",
      showConfirmButton: true,
      timer: 20000,
    });
  } else {
    cambiar(anno, periodo);
  }

  console.log(periodo);
  console.log(anno);
}



function cambiar(a, p) {
  console.log(a);
  console.log(p);

  TablaHcargahistorial(a, p);
}

/* para limpiar la tabla de abajo */

function limpiar() {
  var table = $("#ver_carga").DataTable();

  table.clear().draw();
}

/* limpiar los text */

function limpiarinput() {
  document.getElementById("txt_num_periodo").value = "";
  document.getElementById("txt_anno1").value = "";
}



var table;
function TablaHcargahistorial(anno1, periodo1) {
  table = $("#ver_carga").DataTable({
    paging: true,
    lengthChange: true,
    ordering: true,
    info: true,
    autoWidth: true,
    responsive: false,
    ordering: true,
    // LengthChange: false,
    searching: { regex: true },
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
    sortable: false,
    pageLength: 15,
    destroy: true,
    async: false,
    processing: true,
    ajax: {
      url: "../Controlador/tabla_periodo_controlador.php",
      type: "POST",
      data: { num_anno: anno1, num_periodo: periodo1 },
    },
    buttons: [
      
      {
        extend: "pdfHtml5",
        download: 'open',
      
        text: '<i class="fas fa-file-pdf"></i> ',
        titleAttr: "Exportar a PDF",
        className: "btn btn-danger",
        orientation: "landscape",
        pageSize: "letter",
        exportOptions: {
          columns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
        },

        title: " Universidad Nacional Autónoma De Honduras                                                                                                  "
          + " Facultad De Ciencias Económicas,   Administrativas Y Contables                                                                                            "
          + "    Departamento De Informática ",




        // messageTop: "REPORTE CARGA ACADÉMICA                                                     " + "FECHA: " + fechaYHora,
        //Coloca el título dentro del PDF
      },
    ],
   
    columns: [
      { data: "id_carga_academica" },
      { data: "num_empleado" },
      { data: "nombres" },
      { data: "control" },
      { data: "codigo" },
      { data: "asignatura" },
      { data: "seccion" },
      { data: "hra_inicio" },
      { data: "hra_final" },
      { data: "aula" },
      { data: "edificio" },
      { data: "num_alumnos" },
      { data: "dia" },
    ],

    language: idioma_espanol,
    select: true,
  });
 
}
// comprobar datos para copiar carga
function copiar_carga(anno2, periodo2) {
  // var periodo2 = $("#txt_num_periodo").val();
  // var anno2 = $("#txt_anno1").val();
  console.log(anno2);
  console.log(periodo2);
  if (periodo2.length == 0 || anno2.length == 0) {
    // swal("Alerta!", "campos vacios", "warning");
    swal({
      title: "Alerta",
      text: "¡Campos  de búsqueda vacios!",
      icon: "warning",
      showConfirmButton: true,
      timer: 20000,
    });
  } else {
    swal({
      title: "¿Estás seguro de continuar?",
      text: "Si lo haces ¡Se copiará la carga al período actual!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        swal({
          title: "¡Alerta!",
          text: "Verificando datos",
          icon: "warning",
          showConfirmButton: true,
          timer: 20000,
        });
        /* 1 trae el id del periodo que ingresa */
        $.post(
          "../Controlador/reporte_carga_controlador.php?op=id_periodo_historial",
          { num_anno: anno2, num_periodo: periodo2 },

          function (data, status) {
            console.log(data);
            data = JSON.parse(data);

            if (data == null) {
              //   swal("Alerta!", "el periodo no existe!", "warning");
              swal({
                title: "¡Alerta!",
                text: "El período que busca no existe",
                icon: "warning",
                showConfirmButton: true,
                timer: 20000,
              });

              document.getElementById("txt_id_periodo_busca").value = "";
              /* 1 hasta aqui */
            } else {
              $("#txt_id_periodo_busca").val(data.id_periodo);
              /* si esxiste el periodo hace la validacion de que no tenga datos el periodo nuevo */
              var idnuevo = $("#id_periodo_actual").val();

              $.post(
                "../Controlador/reporte_carga_controlador.php?op=id_periodo_nuevo",
                { id_periodo: idnuevo },

                function (data, status) {
                  console.log(data);
                  data = JSON.parse(data);
                  /*si no tiene datos va copiar  */
                  $("#txt_count").val(data.suma);
                  var count = $("#txt_count").val();

                  if (count > 0) {
                    // swal(
                    //   "Alerta!",
                    //   "el periodo actual contiene datos, registre un periodo nuevo para continuar la copia",
                    //   "warning"
                    // );
                    swal({
                      title: "¡Alerta!",
                      text:
                        "El período actual contiene datos, registre un nuevo período para continuar la copia",
                      icon: "warning",
                      showConfirmButton: true,
                      timer: 20000,
                    });
                    document.getElementById("txt_id_periodo_busca").value = "";
                    document.getElementById("txt_count").value = "";
                  } else {
                    /* si tiene datos no va copiar */
                    var idbusca = $("#txt_id_periodo_busca").val();

                    var periodonuevo = $("#id_periodo_actual").val();

                    insertarCopia(idbusca, periodonuevo);
                  }
                }
              );
            }
          }
        );
      } else {
        swal("¡Cancelado!");
      }
    });
  }
}
//insertar la carga al periodo nuevo
function insertarCopia(periodobusca,periodonuevo) {
  console.log(periodobusca);
  $.ajax({
    url: "../Controlador/copiar_carga_historial_controlador.php",
    type: "POST",
    data:
      { id_periodo: periodobusca,id_periodo_nuevo_: periodonuevo }
  }).done(function (resp) {
    console.log(resp);
    if (resp > 0) {
      if (resp == 1) {
        
         swal({
           title: "Buen trabajo",
           text:
             "¡Los datos se insertaron correctamente! ¿Deseas ir a la pantalla Gestion de Carga?",
           icon: "success",
           buttons: true,
           dangerMode: false,
         }).then((willDelete) => {
           if (willDelete) {
              location.href = "../vistas/gestion_carga_academica_vista.php";
           } else {
            
              // swal({
              //         title: "Alerta",
              //         text:
              //           "el periodo actual contiene datos, registre un periodo nuevo para continuar la copia",
              //         icon: "warning",
              //         showConfirmButton: true,
              //         timer: 20000,
              //       });
           }
         });

       
        
        document.getElementById("txt_id_periodo_busca").value = "";
        document.getElementById("txt_count").value = "";
        
      }
    
    } else {
     
      swal({
        title: "¡Alerta!",
        text: "No se logró insertar los datos, intente de nuevo",
        type: "warning",
        showConfirmButton: true,
        timer: 20000,
      });
      
        
    
      document.getElementById("txt_id_periodo_busca").value = "";
      document.getElementById("txt_count").value = "";
    }
         
  });
}

/* ////////////////////// */
var table2;
function Tablaverperiodo() {
  table2 = $("#tabla_historial_vista").DataTable({
    paging: true,
    lengthChange: true,
    ordering: true,
    info: true,
    autoWidth: true,
    responsive: false,
    ordering: true,
    // LengthChange: false,
    searching: { regex: true },
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
    sortable: false,
    pageLength: 15,
    destroy: true,
    async: false,
    processing: true,
    ajax: {
      url: "../Controlador/tabla_historial_periodo_controlador.php",
      type: "POST",
    },
    
    columns: [
      { data: "num_periodo" },
      { data: "num_anno" },
      { data: "total_carga" },
      {
        defaultContent:
          
          "<div class='text-center'><div class='btn-group'><button class='ver btn btn-primary btn-m '><i class='fas fa-eye'></i></button>  <button  class='copiar btn btn-danger btn-m '><i class='fas fa-copy'></i></button></div></div>",
      },
    ],

    language: idioma_espanol,
    select: true,
  });
 
}

$("#tabla_historial_vista").on("click", ".ver", function () {
  var data = table2.row($(this).parents("tr")).data();
  if (table2.row(this).child.isShown()) {
    var data = table2.row(this).data();
  }
 

  $("#pdf").removeAttr("disabled");//habilita boton

   $("#anno_busca").val(data.num_anno);
  $("#num_per_busca").val(data.num_periodo);
  $("#txt_count1").val(data.id_periodo);
  
 
  var anno = $("#anno_busca").val();
  var periodo = $("#num_per_busca").val();


  cargartablaabajo(anno,periodo);
  

 // seleccionar_dias($("#txt_dias_edita").val(), ",");
});

$("#tabla_historial_vista").on("click", ".copiar", function () {
  var data = table2.row($(this).parents("tr")).data();
  if (table2.row(this).child.isShown()) {
    var data = table2.row(this).data();
  }

  $("#anno_busca").val(data.num_anno);
  $("#num_per_busca").val(data.num_periodo);

  var anno = $("#anno_busca").val();
  var periodo = $("#num_per_busca").val();

  copiar_carga(anno,periodo);


});



