function llenar_TipoPersona() {
    var cadena = "&activar=activar";
    $.ajax({
        url: "../Controlador/guardar_personas_controlador.php?op=Tipopersona",
        type: "POST",
        data: cadena,
        success: function(r) {
            $("#tipo_persona").html(r).fadeIn();
            var o = new Option("SELECCIONAR", 0);

            $("#tipo_persona").append(o);
            $("#tipo_persona").val(0);
        },
    });
}
llenar_TipoPersona();

function llenar_genero() {
    var cadena = "&activar=activar";
    $.ajax({
        url: "../Controlador/guardar_personas_controlador.php?op=genero",
        type: "POST",
        data: cadena,
        success: function(r) {
            $("#genero_persona").html(r).fadeIn();
            var o = new Option("SELECCIONAR", 0);

            $("#genero_persona").append(o);
            $("#genero_persona").val(0);
        },
    });
}
llenar_genero();

function llenar_estado_civil() {
    var cadena = "&activar=activar";
    $.ajax({
        url: "../Controlador/guardar_personas_controlador.php?op=estado_civil",
        type: "POST",
        data: cadena,
        success: function(r) {
            $("#estado_civil_persona").html(r).fadeIn();
            var o = new Option("SELECCIONAR", 0);

            $("#estado_civil_persona").append(o);
            $("#estado_civil_persona").val(0);
        },
    });
}
llenar_estado_civil();

function llenar_nacionalidad() {
    var cadena = "&activar=activar";
    $.ajax({
        url: "../Controlador/guardar_personas_controlador.php?op=nacionalidad",
        type: "POST",
        data: cadena,
        success: function(r) {
            $("#nacionalidad_persona").html(r).fadeIn();
            var o = new Option("SELECCIONAR", 0);

            $("#nacionalidad_persona").append(o);
            $("#nacionalidad_persona").val(0);
        },
    });
}
llenar_nacionalidad();

$("#guardar_persona").click(function() {
    var tipo_persona = $("#tipo_persona").val();

    var foto = $("#imagen_persona").val();
    var tipo_persona1 = document.getElementById("tipo_persona");

    var selected_tipo_persona =
        tipo_persona1.options[tipo_persona1.selectedIndex].text;

    var num_cuenta = $("#num_cuenta").val();
    var nombre_persona = $("#nombre_persona").val();
    var apellido_persona = $("#apellido_persona").val();

    var genero_persona = document.getElementById("genero_persona");
    var selected_genero_persona =
        genero_persona.options[genero_persona.selectedIndex].text;

    var estado_civil_persona = document.getElementById("estado_civil_persona");
    var selected_estado_civil_persona =
        estado_civil_persona.options[estado_civil_persona.selectedIndex].text;

    var correo_persona = $("#correo_persona").val();
    var fecha_persona = $("#fecha_persona").val();

    var nacionalidad_persona = document.getElementById("nacionalidad_persona");

    var selected_nacionalidad_persona =
        nacionalidad_persona.options[nacionalidad_persona.selectedIndex].text;

    var identidad_persona = $("#identidad_persona").val();
    var Estado_persona = "ACTIVO";
    var telefono_persona = $("#telefono_persona").val();
    var direccion_persona = $("#direccion_persona").val();

    if (
        num_cuenta.length == 0 ||
        nombre_persona.length == 0 ||
        apellido_persona.length == 0 ||
        correo_persona.length == 0 ||
        fecha_persona.length == 0 ||
        identidad_persona.length == 0 ||
        telefono_persona.length == 0
    ) {
        swal({
            title: "alerta",
            text: "Llene los campos vacios correctamente",
            type: "warning",
            showConfirmButton: true,
            timer: 15000,
        });
    } else if (
        tipo_persona == 0 ||
        genero_persona == 0 ||
        estado_civil_persona == 0 ||
        nacionalidad_persona == 0
    ) {
        swal("Alerta!", "Seleccione una opción válida", "warning");
    } else {
        if (foto == "") {
            swal("Alerta!", "Seleccione una foto válida", "warning");
        } else {
            if (
                selected_tipo_persona == "ESTUDIANTE" ||
                selected_tipo_persona == "estudiante" ||
                selected_tipo_persona == "Estudiante"
            ) {
                registrarEstudiante(
                    nombre_persona,
                    apellido_persona,
                    selected_genero_persona,
                    identidad_persona,
                    selected_nacionalidad_persona,
                    selected_estado_civil_persona,
                    fecha_persona,
                    tipo_persona,
                    Estado_persona,
                    correo_persona,
                    num_cuenta,
                    telefono_persona,
                    direccion_persona
                );
            } else {
                registrarAdministrativo(
                    nombre_persona,
                    apellido_persona,
                    selected_genero_persona,
                    identidad_persona,
                    selected_nacionalidad_persona,
                    selected_estado_civil_persona,
                    fecha_persona,
                    tipo_persona,
                    Estado_persona,
                    correo_persona,
                    num_cuenta,
                    telefono_persona,
                    direccion_persona
                );
            }
        }

    }
});
//funcion registrar persona estuduante
function registrarEstudiante(
    nombre_persona,
    apellido_persona,
    selected_genero_persona,
    identidad_persona,
    selected_nacionalidad_persona,
    selected_estado_civil_persona,
    fecha_persona,
    tipo_persona,
    Estado_persona,
    correo_persona,
    num_cuenta,
    telefono_persona,
    direccion_persona
) {
    var estudiante = 1;
    $.post(
        "../Controlador/guardar_personas_controlador.php?op=verificarPersona", {
            cuenta: num_cuenta,
        },

        function(data, status) {
            console.log(data);
            data = JSON.parse(data);

            if (data.registro > 0) {
                alert("Ya existe una persona con ese cuenta");
            } else {
                bloquea();
                $.ajax({
                    url: "../Controlador/registrar_persona_controlador.php",
                    type: "POST",
                    data: {
                        nombres: nombre_persona,
                        apellidos: apellido_persona,
                        sexo: selected_genero_persona,
                        identidad: identidad_persona,
                        nacionalidad: selected_nacionalidad_persona,
                        estado_civil: selected_estado_civil_persona,
                        fecha_nacimiento: fecha_persona,
                        id_tipo_persona: tipo_persona,
                        Estado: Estado_persona,
                        correo: correo_persona,
                        cuenta: num_cuenta,
                        telefono: telefono_persona,
                        direccion: direccion_persona,
                        estud: estudiante,
                    },
                }).done(function(resp) {
                    if (resp > 0) {
                        Registrar();
                    } else {
                        swal(
                            "Alerta!",
                            "No se pudo completar intente de nuevo!",
                            "warning"
                        );
                        //document.getElementById("txt_registro").value = "";
                    }
                });
            }
        }
    );
}

//funcion registrar persona estuduante
function registrarAdministrativo(
    nombre_persona,
    apellido_persona,
    selected_genero_persona,
    identidad_persona,
    selected_nacionalidad_persona,
    selected_estado_civil_persona,
    fecha_persona,
    tipo_persona,
    Estado_persona,
    correo_persona,
    num_cuenta,
    telefono_persona,
    direccion_persona
) {
    $.post(
        "../Controlador/guardar_personas_controlador.php?op=verificarPersonaAdmin", {
            cuenta: num_cuenta,
        },

        function(data, status) {
            console.log(data);
            data = JSON.parse(data);

            if (data.registro > 0) {
                alert("Ya existe una persona con ese número empleado");
            } else {
                bloquea();
                $.ajax({
                    url: "../Controlador/registrar_persona_controlador.php",
                    type: "POST",
                    data: {
                        nombres: nombre_persona,
                        apellidos: apellido_persona,
                        sexo: selected_genero_persona,
                        identidad: identidad_persona,
                        nacionalidad: selected_nacionalidad_persona,
                        estado_civil: selected_estado_civil_persona,
                        fecha_nacimiento: fecha_persona,
                        id_tipo_persona: tipo_persona,
                        Estado: Estado_persona,
                        correo: correo_persona,
                        cuenta: num_cuenta,
                        telefono: telefono_persona,
                        direccion: direccion_persona,
                    },
                }).done(function(resp) {
                    if (resp > 0) {
                        Registrar();

                    } else {
                        swal(
                            "Alerta!",
                            "No se pudo completar intente de nuevo!",
                            "warning"
                        );
                        //document.getElementById("txt_registro").value = "";
                    }
                });
            }
        }
    );
}

// boton.addEventListener("click", bloquea, false);

function bloquea() {
    var boton = document.getElementById("guardar_persona");
    if (boton.disabled == false) {
        boton.disabled = true;

        setTimeout(function() {
            boton.disabled = false;
        }, 5000);
    }
}

//FUNCION QUE INGRESSA O CARGA LA FOTO
function Registrar() {
    var formData = new FormData();
    var foto = $("#imagen_persona")[0].files[0];
    formData.append('f', foto);
    // formData.append('nombrearchivo', nombrearchivo);

    $.ajax({
        url: '../Controlador/subirimagene_estudiante_adm.php',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            if (respuesta != 0) {
                //Swal('Mensaje De Confirmacion', 'Se subio fotografia con exito', 'success');
                swal(
                    "Buen trabajo!",
                    "datos ingresados correctamente!",
                    "success"
                );

                location.reload();
            } else {
                swal("Alerta!", "intenta de nuevo", "warning");

            }
        }
    });
    return false;
} // validar imagen
var d = document.getElementById("imagen_persona");

d.onchange = function() {
    var archivo = $("#imagen_persona").val();
    var extensiones = archivo.substring(archivo.lastIndexOf("."));
    // console.log(extensiones);
    if (
        extensiones != ".jpg" &&
        extensiones != ".png" &&
        extensiones != ".jpeg" &&
        extensiones != ".PNG"
    ) {
        alert("El archivo de tipo " + extensiones + " no es válido");
        document.getElementById("imagen_persona").value = "";
    }
};