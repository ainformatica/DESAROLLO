console.log('indicador');
const formualrio = document.getElementById('enviar_Datos');
const button = document.getElementById('guardar_indicador');

button.addEventListener('click', function (e) {
    e.preventDefault();
    var form2 = new FormData(formualrio);
    form2.append('agregar_tipo_indicador', 1);

    if (formualrio.checkValidity() === false) {
        e.preventDefault();
        e.stopPropagation();
        formualrio.classList.add('was-validated')
    } else {
        fetch('../Controlador/action.php', {
            method: 'POST',
            body: form2
        })
            .then(respuesta => respuesta.json())
            .then(data => {
                console.log(data);
                if (data == 'exito') {
                    swal(
                        //'¡Agregado!',
                        '!Su registro ha sido agregado con éxito!',
                        'success'
                    );
                    document.getElementById("enviar_Datos").reset(); 
                } else {
                    swal(
                        '¡Error!',
                        'Algo ocurrio mal',
                        'Error'
                    );
                }
            })
    }  

});


function eliminar(id) {
    swal({
        title: '¿Seguro de querer eliminar este indicador de Gestión Académica?',
        text: "!Este registro no podra ser recuperado si decide continuar!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí ¡Eliminarlo!',
        cancelButtonText: 'No ¡Cancelar!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function () {

        const form = new FormData();
        form.append('eliminar_indicadorV2', 1);
        form.append('id', id);

        fetch('../Controlador/action.php', {
            method: 'POST',
            body: form
        })
            .then(res => res.json())
            .then(data => {
                //console.log(data);
                if (data == 'exito') {
                    swal(
                        //'Eliminado!',
                        '!Su registro ha sido eliminado!',
                        'success'
                    )
                    $('#tabla_indicadores_tipo').DataTable().ajax.reload();
                } else {
                    swal(
                        '¡Error!',
                        'Ha ocurrido un error en la consulta',
                        'error'
                    )
                }
            })
    }, function (dismiss) {
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
            swal(
                '¡Cancelado!',
                'Su registro está en la base de datos',
                'error'
            )
        }
    })

}
function cambiarEstado(id, estado) {
    swal({
        title: '¿Seguro de querer cambiar este indicador de Gestión Academica?',
        text: "!Este registro podrá ser cambiado si decide continuar!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí ¡Cambiarlo!',
        cancelButtonText: 'No ¡Cancelar!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function () {

        const formEstado = new FormData();
        formEstado.append('cambiar_estado_indicador', 1);
        formEstado.append('id', id);
        formEstado.append('estado', estado);

        fetch('../Controlador/action.php', {
            method: 'POST',
            body: formEstado
        })
            .then(res => res.json())
            .then(data => {
                //console.log(data);
                if (data == 'exito') {
                    swal(
                        //'Cambiado!',
                        '!Su registro ha sido cambiado!',
                        'success'
                    )
                    $('#tabla_indicadores_tipo').DataTable().ajax.reload();
                } else {
                    swal(
                        '¡Error!',
                        'Ha ocurrido un error en la consulta',
                        'error'
                    )
                }
            })
    }, function (dismiss) {
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
            swal(
                '¡Cancelado!',
                'Su registro sigue intacto',
                'error'
            )
        }
    })

}
const buttonGuardar = document.getElementById('guardar_indicador');
const formulario_datos = document.getElementById('enviar_Datos');

buttonGuardar.addEventListener('click', function (e) {
    //alert('hola_indicadores');
    e.preventDefault();
    const form2 = new FormData(formulario_datos);
    form2.append('tipo_indicadores', 1);

    if (enviar_Datos.checkValidity() === false) {
        e.preventDefault();
        e.stopPropagation();
        enviar_Datos.classList.add('was-validated')
    } else {

        fetch('../Controlador/action.php', {
            method: 'POST',
            body: form2
        }
        )
            .then(res => res.json())
            .then(data => {
                if (data == 'exito') {
                    swal.queue([{
                        title: 'Exito!',
                        confirmButtonText: 'Regresar',
                        text:
                            'Los datos han sido agregados exitosamente',
                        showLoaderOnConfirm: true,
                        preConfirm: function () {
                            location.href = "../vistas/mantenimiento_tipo_indicadores.php";
                        }
                    }]);

                    //     swal(
                    //         'Exito!',
                    //         'Los datos han sido agregados!',
                    //         'success'
                    //     )
                    //     $('#modal').modal('toggle');
                    //     // $('#tabla_recursos_tipo').DataTable().ajax.reload();
                    //     document.getElementById("enviar_Datos").reset();
                    //    // location.href ="../vistas/mantenimiento_tipos_recursos.php";

                } else {

                }
                console.log(data);
            })
    }
});