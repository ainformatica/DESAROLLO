function listar_objetos() { //Lista los objetos por modulos
    // console.log(document.querySelectorAll('.modulo-div'));
    divs = document.querySelectorAll('.modulo-div');
    i = 0;

    //Peticion
    $.post('../Controlador/objetos_controlador.php?op=listar_objetos_modulo', {
        id_modulo: 0
    }, async function (data, status) {
        data = JSON.parse(data);


        divs.forEach(element => {
            //  console.log(element);
            data.forEach(element2 => {
                // console.log(element2);
                if (element2[4] == element["id"]) {


                    $("div#" + element['id'] + ".modulo-div").append(' <div class=" row"><div class=" col-md-8"><div class="form-group"><tr><td class="sorting_1 "><label class="" for="">' + element2[1] + '</label></td></div></div><div class=" col-sm-4"><div class="form-group td-input" id="' + element['id'] + '"><td class="td-input" " style="text-align: center;"><input class="form-control" type="checkbox" name="objeto[]" id="' + element2[0] + '" value="' + element2[0] + '"></td></tr><br></div></div></div>');
                }
            })


            i++;

        });

    });

}

function listarmodulos() { //Lista los modulos en los permisos

    cadena = "&activar='activar'"
    //peticion
    $.ajax({
        url: "../Controlador/objetos_controlador.php?op=listar_modulos",
        type: "POST",
        data: cadena,
        success: function (r) {

            // console.log(r);

            $("#modulos").html(r).fadeIn();


        },
        error: function (r) {
            console.log(r)
        }


    }).done(function () {
        listar_objetos(); //Lista los objetos despues de cargar los modulos
    });


}
// Inputs de los apartados de módulo
function checked_input(obj, id) {

    id_input = $(obj).attr('id');
    console.log($(obj))
    if ($("input#modulo_input" + id + ".principal-input").attr('estado') == 0) {
        console.log("activado")
        $('div#' + id + ".td-input").children("input").prop('checked', true);
        $("input#modulo_input" + id + ".principal-input").attr('estado', '1');


    } else {
        console.log("desactivado")

        $('div#' + id + ".td-input").children("input").prop('checked', false);
        $("input#modulo_input" + id + ".principal-input").attr('estado', '0');

    }

}
// marcar inputs al elegir un rol
function marcar_objetos(id) {
    $("#" + id).prop('checked', true) //marca el input
    $("#" + id).attr('disabled', true); //lo inhabilita

}
$(document).ready(function () { // funciones en el documento 
    //console.clear();
    $("#editar_permisos").hide();
   
    listarmodulos(); //Lista los modulos en los permisos

    //Evento al cambiar de rol, para asi mostrar los permisos asignados actuales
    $("#select_roles").on("change", function () {
        $("#editar_permisos").hide();
        $("#editar_permisos").attr('class', 'btn btn-warning form-control-sm');
        $("#editar_permisos").html('EDITAR <i id="icono_editar" class="fas fa-times-circle"></i>');
        $("#operacion").attr('value', '1');
        $("input").removeAttr("disabled"); // Habilita todos los inputs
        $("input").removeAttr("disabled"); // Habilita todos los inputs
        $("input[type='checkbox'].form-control").prop('checked', false); //Limpia los inputs con checkeds
        $("input[type='checkbox'].principal-input").prop('checked', false); //Limpia los inputs con checkeds
        $("input[type='checkbox'].principal-input").attr('estado', 0); //Limpia los inputs con checkeds
        $(".card-header").removeAttr('style');
        if ($(this).val() != 0) {
           

            var rol = $(this).val(); //contiene el id del rol seleccionado
           

            $("#editar_permisos").show();
            //Post al controlador
            $.post('../Controlador/objetos_controlador.php?op=permisos_objetos', {
                id_rol: rol
            }, function (data1, status) {
                data1 = JSON.parse(data1); //respuesta del controlador
                //console.log(data1);

                data1.forEach(index => {
                    console.log(index);
                    marcar_objetos(index[1]) //marcando inputs que tenga permisos el rol.
                    $("#modulo_input" + index[0]).attr('disabled', true); //lo inhabilita
                    $("#modulo_input" + index[0]).attr('estado', 1); //lo inhabilita
                    $("#modulo_input" + index[0]).prop('checked', true) //marca el input
                    $("#tarjeta_modulo"+index[0]).attr('style', 'background-color: #C6E3FA;')

                })

            })

        }


    })

    //editar
    $("#editar_permisos").on('click', function () {
        if ($(this).attr('class') == 'btn btn-warning form-control-sm') {
            $(this).attr('class', 'btn btn-danger form-control-sm');
            $(this).html('CANCELAR <i id="icono_editar" class="fas fa-times-circle"></i>');
            $("#operacion").attr('value', '2');
            $("input").removeAttr("disabled"); // Habilita todos los inputs
        } else {
            location.reload();

        }

    })






});
