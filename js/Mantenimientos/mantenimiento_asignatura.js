var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);
	})
}

//Función limpiar
function limpiar()
{
	$("#codigo").val("");
	$("#asignatura").val("");
	$("#uv").val("");
	$("#año").val("");
	$("#calificacion").val("");
	$("#obs").val("");
}





//Función Listar
function listar()
{
	$('#tbllistado').DataTable({
		"language": {
	"sProcessing":    "Procesando...",
	"sLengthMenu":    "Mostrar _MENU_ registros",
	"sZeroRecords":   "No se encontraron resultados",
	"sEmptyTable":    "Ningún dato disponible en esta tabla",
	"sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
	"sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
	"sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
	"sInfoPostFix":   "",
	"sSearch":        "Buscar:",
	"sUrl":           "",
	"sInfoThousands":  ",",
	"sLoadingRecords": "Cargando...",
	"oPaginate": {
		"sFirst":    "Primero",
		"sLast":    "Último",
		"sNext":    "Siguiente",
		"sPrevious": "Anterior"
	},
	"oAria": {
		"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
		"sSortDescending": ": Activar para ordenar la columna de manera descendente"
	}
},
		"ajax":
				  {     
				url: '../Controlador/crear_asignatura_controlador.php?op=listar',
				type : "get",
				dataType : "json",
				error: function(e)
				{
				  console.log(e.responseText);
				}
		  }
	  });
}
//Función para guardar o editar

function guardaryeditar()
{
	
	
    
    var datos = $("#formulario").serialize();
	console.log(datos);
	$.ajax({
		url: "../Controlador/crear_asignatura_controlador.php?op=guardaryeditar",
	    type: "POST",
	    data: datos,
	    

	    success: function(d)
	    {
            
	    	swal({
				  title: d,

				  icon: "success",
				  button: "OK",
				  
				}).then(function() {
					window.location = "../vistas/gestion_asignaturas_vista.php";
				});
				

		}
		

	});
	
	//limpiar();
}
function redirigir(idclase){
	
}
function mostrar(idclase)
{
	console.log('mostrar se ejecuto');
	
	$.post("../Controlador/crear_asignatura_controlador.php?op=mostrar",{id_asignatura : idclase}, function(data, status)
	{
		data = JSON.parse(data);
		console.log(data);
		//mostrarform(true);

		$("#id_asignatura").val(data.Id_asignatura);
		$("#id_codigo").val(data.codigo);
		$("#nombre_asignatura").val(data.asignatura);
 		$("#id_uv").val(data.uv);
		

	
	 })
	
//	
	
}

//Función para desactivar registros
function desactivar(idclase)
{
	console.log(' funcion activo');
	bootbox.confirm("¿Está seguro de desactivar la asignatura?", function(result){
		if(result)
        {
        	$.post("../Controlador/crear_asignatura_controlador.php?op=desactivar", {id_asignatura : idclase}, function(e){
        		swal({
				  title: e,

				  icon: "success",
				  button: "OK",
				}).then(function() {
					window.location = "../vistas/gestion_asignaturas_vista.php";
				});

	            
        	});
        }
	})
}

//Función para activar registros
function activar(idclase)
{
	
	bootbox.confirm("¿Está seguro de activar la asignatura?", function(result){
		if(result)
        {
        	$.post("../Controlador/crear_asignatura_controlador.php?op=activar", {id_asignatura : idclase}, function(e){
        		swal({
				  title: e,

				  icon: "success",
				  button: "OK",
				}).then(function() {
					window.location = "../vistas/gestion_asignaturas_vista.php";
				});
        	});
        }
	})
}

console.log('estoy funcionando');

listar();
