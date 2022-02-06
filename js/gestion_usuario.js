function abrirmodalusuario() {
    $("#modalReset").modal({ backdrop: "static", keyboard: false });
    $("#modalReset").modal("show");
}

function usuario() {
    var cadena = "&activar=activar";
    $.ajax({
        url: "../Controlador/reset_usuario_controlador.php?op=usuario",
        type: "POST",
        data: cadena,
        success: function(r) {
            $("#usuario").html(r).fadeIn();
            var o = new Option("Seleccionar un usuario", 0);

            $("#usuario").append(o);
            $("#usuario").val(0);
        },
    });
}
usuario();

function reiniciar() {
    var usuario = $("#usuario").val();
    console.log(usuario);

    if (usuario == 0) {
        swal("Alerta!", "seleccione una opcion valida", "warning");

    } else {
        var opcion = confirm("Estas seguro de continuar?");
        if (opcion == true) {

            $.ajax({
                url: "../Controlador/reset_usuario_controlador.php?op=confirmar",
                type: "POST",
                data: {
                    id_usuario: usuario,
                },
            }).done(function(resp) {


                if (resp > 0) {
                    if (resp == 1) {
                        //alert("si");
                        swal({
                            title: "Bien",
                            text: "Se guardó correctamente",
                            type: "success",
                            showConfirmButton: false,
                            timer: 11000,
                        });
                        location.reload();
                    } else {
                        swal("Alerta!", "No se pudo completar la acción", "warning");
                    }
                }
            });

        }
    }


}