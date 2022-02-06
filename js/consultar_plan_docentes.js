var table3;
function Tabla_consulta_plan(nombre_, codigo) {
  table3 = $("#tabla_consultar_plan_docente").DataTable({
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
      url: "../Controlador/tabla_consulta_plan_docentes_controlador.php",
      type: "POST",
      data: { nombre: nombre_, codigo_plan: codigo },
    },

    columns: [
      { data: "periodo_plan" },
      { data: "asig_vigente" },
      { data: "codigo_asig" },
      { data: "uv" },
      { data: "requisitos" },
      { data: "equivalencia" },
     
     
      {
        defaultContent:
          
          "<div class='text-center'><div class='btn-group'><button class='ver1 btn btn-primary btn-m '><i class='fas fa-arrow-down'></i></button> </div></div>",
      },
    ],

    language: idioma_espanol,
    select: true,
  });
 
}
{/* <a href='' target='_blank' id='curriculum' style='color:white;font-weight: bold;'>Descargar Sílabo</a> */}


$("#tabla_consultar_plan_docente").on("click", ".ver1", function () {
  var data = table3.row($(this).parents("tr")).data();
  if (table3.row(this).child.isShown()) {
    var data = table3.row(this).data();
    
  }
  var id_asignatura=(data.id_asignatura);
  if (data.silabo==null) {
    
    alert("No tiene silabo")
    
  }else{
    $('#Modalsilabo').modal('show');
    $("#curriculum").attr("href", data.silabo);
    
  }
   $('#Modalsilabo').modal('hide');
  
  


});

