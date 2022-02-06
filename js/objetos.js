//funciones de registro

//funcion de selects
function llenar_selectModulos() {

	cadena = "&activar='activar'"

	$.ajax({
		url: "../Controlador/objetos_controlador.php?op=selectModulos",
		type: "POST",
		data: cadena,
		success: function (r) {



			$("#select_modulo").html(r).fadeIn();
		}


	});

}
//funcion de tabla
function listar() {
	//console.log('ejecutandose');
	$('#tbl_objetos').DataTable({
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
			url: '../Controlador/objetos_controlador.php?op=listar',
			type: "get",
			dataType: "json",
			error: function (e) {
				console.log(e.responseText);
			}
		}
	});
}

//funcion para eliminar
function eliminar(ob) {
	console.log($(ob).attr("id"))


}



//funcion para modificar
function modificar(ob) {
	id_objeto_m = $(ob).attr("id");
	$.post('../Controlador/objetos_controlador.php?op=mostrar', {
		id_objeto: id_objeto_m
	}, function (data, status) {
		data = JSON.parse(data);
		console.log(data);

		$("#txtidobjeto").val(data.Id_objeto);
		$("#txtnombreobjeto").val(data.objeto);
		$("#txtdescripcionobjeto").val(data.descripcion);
		$('#select_modulo').val(data.id_modulo);
	});

}

//Funcion de lectura del documento al iniciar
$(document).ready(function () {
	console.clear();


	llenar_selectModulos()
	//registrar objeto
	$("#btn_guardar_objeto").on("click", function () {
		var cadena = "&objeto=" + $("#txt_objeto").val() + "&descripcion=" + $("#txt_descripcionobjeto").val() + "&id_modulo=" + $("#select_modulo").val();



		$.ajax({
			url: '../Controlador/objetos_controlador.php?op=registrar_objeto',
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
	$("#btn_modificar_objeto").on("click", function () {

		cadena = "&id_objeto=" + $("#txtidobjeto").val() + "&objeto=" + $("#txtnombreobjeto").val() + "&descripcion=" + $("#txtdescripcionobjeto").val()+"&id_modulo="+$('#select_modulo').val();
		console.log(cadena);

		$.ajax({
			url: '../Controlador/objetos_controlador.php?op=actualizar_objeto',
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
					window.location="gestion_objetos_vista.php"

				} else {
					swal({
						title:"",
						text:"Lo sentimos ha ocurrido un error",
						type: "info",
						showConfirmButton: false,
						timer: 3000
					 });
					
				}
			}
		})

	})
	//fin de registrar objeto

	if ($("#tbl_objetos")) {

		listar();



	}

})