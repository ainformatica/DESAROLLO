console.log('hola_planificacion');

//?CREACION DE UN NUEVO PLAN OPERATIVO
const button = document.getElementById("guardar_plani");
const poa_form = document.getElementById('poa_form');
const button_edit = document.getElementById('edit_plani');

button.addEventListener('click', function (e) {
    //alert('hola');
    if (poa_form.checkValidity() === false) {
        e.preventDefault();
        e.stopPropagation();
        poa_form.classList.add('was-validated')
    } else {
        const formulario = new FormData(poa_form);
        formulario.append('crear_plani', 1);
        fetch('../Controlador/action.php', {
            method: 'POST',
            body: formulario
        })
            .then(res => res.json())
            .then(data => {
                console.log(data);
                if (data == 'exito') {
                    $('#exampleModal').modal('toggle');
                    $('#tabla_poa').DataTable().ajax.reload();
                    swal(
                        '¡Éxito!',
                        '¡Datos subidos correctamente!',
                        'success'
                    )
                    document.getElementById("poa_form").reset();
                } else if (data == 'año_viejo') {
                    swal(
                        '¡Año incorrecto!',
                        '¡Verifique que el año sea mayor o igual que el actual!',
                        'info'
                    )
                } else if (data == 'anio_existe') {
                    swal(
                        '¡Año incorrecto!',
                        '¡El año ingresado ya tiene una plan, ingrese otro!',
                        'info'
                    )
                } else {
                    swal(
                        'Oops...',
                        '¡Algo ocurrió mal!',
                        'error'
                    )
                }
            })
    }
});
//?FIN CREACION DE UN NUEVO PLAN OPERATIVO 

//?edicion de un plan

button_edit.addEventListener('click', function (e) {
    //alert('hola');
    const edit_form = new FormData(poa_form);
    edit_form.append('edit_form_plan', 1);

    fetch('../Controlador/action.php', {
        method: 'POST',
        body: edit_form
    })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            if (data == 'exito') {
                $('#exampleModal').modal('toggle');
                $('#tabla_poa').DataTable().ajax.reload();
                swal(
                    '¡Éxito!',
                    '¡Datos editados correctamente!',
                    'success'
                )
            }
        })
})
