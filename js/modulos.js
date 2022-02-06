function listar() {
	//console.log('ejecutandose');

	$('#tbl_modulos').DataTable({
		"language": {
			"sProcessing": "Procesando...",
			"sLengthMenu": "Mostrar _MENU_ registros",
			"sZeroRecords": "No se encontraron resultados",
			"sEmptyTable": "Ningún dato disponible en esta tabla",
			"sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
			"sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix": "",
			"sSearch": "Buscar Usuarios:",
			"sUrl": "",
			"sInfoThousands": ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
				"sFirst": "Primero",
				"sLast": "Último",
				"sNext": "Siguiente",
				"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending": ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			},
			"dom": "Bfrtip",
			buttons: ['copy', 'excel', 'pdf']
		},


		"ajax": {
			url: '../Controlador/modulos_controlador.php?op=listar',
			type: "get",
			dataType: "json",
			error: function (e) {
				console.log(e.responseText);
			}
		}
	});
}
function modificar(ob) {
	id_modulo_m = $(ob).attr("id");
	$.post('../Controlador/modulos_controlador.php?op=mostrar', {
		id_modulo: id_modulo_m
	}, function (data, status) {
		data = JSON.parse(data);
		console.log(data);

		$("#id_modulo1").val(data.id_modulo);
		$("#txtnombre_modulo").val(data.nombre);
		$("#descripcion_modulo1").val(""+data.descripcion);
		
	});

}

$(document).ready(function(){
	
listar();

	$("#btn_guardar_modulo").on("click", function () {
		var cadena = "&modulo=" + $("#txt_modulo").val() + "&descripcion=" + $("#txt_descripcionmodulo").val() ;



		$.ajax({
			url: '../Controlador/modulos_controlador.php?op=registrar_modulo',
			type: 'POST',
			data: cadena,
			success: function (data) {
				console.log(data);
				if (data == 1) {
					swal({//alerta de datos insertados
						title:"",
						text:"Los datos  se almacenaron correctamente",
						type: "success",
						showConfirmButton: true,
						timer: 3000
					 });

				} else {
					console.log(data);
					alert("ups algo sucedio");
				}
			}
		})
	});

$("#btn_modificar_modulo").on("click", function () {

    cadena = "&id_modulo=" + $("#id_modulo1").val() + "&modulo=" + $("#txtnombre_modulo").val() + "&descripcion=" + $("#descripcion_modulo1").val();
    console.log(cadena);

    $.ajax({
        url: '../Controlador/modulos_controlador.php?op=actualizar_modulo',
        type: 'POST',
        data: cadena,
        success: function (data) {
            console.log(data);
            if (data == 1) {
                
                swal({//alerta de datos actualizados
                    title:"",
                    text:"Los datos  se almacenaron correctamente",
                    type: "success",
                    showConfirmButton: true,
                    timer: 3000
                 });
                window.location="gestion_modulos_vista.php"

            } else {
                swal({
                    title:"",
                    text:"Lo sentimos ha ocurrido un error",
                    type: "info",
                    showConfirmButton: false,
                    timer: 3000
                 });
                console.log(data)
            }
        }
    })

})

});