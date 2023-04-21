


function llenar_selectEST() {
    var cadena = '&activar=activar';
    $.ajax({
        url: '../Controlador/registro_estudiantes_controlador.php?op=selectEST',
        type: 'POST',
        data: cadena,
        success: function(r) {
            // console.log(r);

            $('#cb_ecivil').html(r).fadeIn();
        }
    });
}

function llenar_selectGEN() {
    var cadena = '&activar=activar';
    $.ajax({
        url: '../Controlador/registro_estudiantes_controlador.php?op=selectGEN',
        type: 'POST',
        data: cadena,
        success: function(r) {
            //  console.log(r);

            $('#cb_genero').html(r).fadeIn();
        }
    });
}


function llenar_selectCAR() {
    var cadena = '&activar=activar';
    $.ajax({
        url: '../Controlador/registro_estudiantes_controlador.php?op=selectCAR',
        type: 'POST',
        data: cadena,
        success: function(r) {
            console.log(r);

            $('#cb_carrera').html(r).fadeIn();
        }
    });
}

function llenar_selectCR() {
    var cadena = '&activar=activar';
    $.ajax({
        url: '../Controlador/registro_estudiantes_controlador.php?op=selectCR',
        type: 'POST',
        data: cadena,
        success: function(r) {
            console.log(r);

            $('#cb_cr').html(r).fadeIn();
        }
    });
}

// TRABAJA SI/NO
$(document).ready(function() {
    $('[name="check[]"]').click(function() {
        var arr = $('[name="check[]"]:checked')
            .map(function() {
                return this.value;
            })
            .get();

        $("#arr").text(JSON.stringify(arr));

        $("#trabajo").val(arr);

        console.log(str);
    });
});

$(document).click(function() {
        var checked = $(".CheckedAK:checked").length;
        
        if (checked == '2') {
            swal({
                title: "¡Alerta!",
                text: "Solo puede seleccionar una opción ",
                type: "warning",
                showConfirmButton: true,
                timer: 10000,
            });
            document.getElementById('trabajo').value = '';
            document.getElementById("si").checked = false;
            document.getElementById("no").checked = false;
        }
    })
    .trigger("click");

    // EGRESADO SI/NO
    $(document).ready(function() {
        $('[name="egresado"]').click(function() {
            var ra = $('[name="egresado"]:checked')
                .map(function() {
                    return this.value;
                })
                .get();
    
            $("#ra").text(JSON.stringify(ra));
    
            $("#tipo_estudiante").val(ra);
    
            console.log(str);
        });
    });
    
    $(document).click(function() {
            var egresar = $(".Check:checked").length;
            
            if (egresar == '2') {
                swal({
                    title: "¡Alerta!",
                    text: "Solo puede seleccionar una opción ",
                    type: "warning",
                    showConfirmButton: true,
                    timer: 10000,
                });
                
                document.getElementById('tipo_estudiante').value = '';
                document.getElementById("siegresado").checked = false;
                document.getElementById("noegresado").checked = false;
            }
        })
        .trigger("click");
    
if ((document.getElementsByName = 'cb_ecivil')) {
    llenar_selectEST();
}

if ((document.getElementsByName = 'cb_genero')) {
    llenar_selectGEN();
}

if ((document.getElementsByName = 'cb_carrera')) {
    llenar_selectCAR();
}

if ((document.getElementsByName = 'cb_cr')) {
    llenar_selectCR();
}

//FUNCION QUE VALIDA QUE LOS NUMEROS DE TELEFONO SEAN LOCALES
function valtel(telef) {
    var expresion3 = /(9|8|3|2)\d{3}[-]\d{4}/;
    console.log(expresion3.test(tel));
    if (telef.value.match(expresion3)){
        document.miFormulario.tel.length();
                return true;
        } else {
        
        swal('Ingresar un número de teléfono válido');
        limpiarTEL();
        return false;
        }
}

//FUNCION QUE VERIFICA UN CORREO VALIDO
function validarcorreo(Input) {

    var expresion1 = /^\w+([\.-]?\w+)*@[a-zA-Z_]+?.[a-zA-Z]{2,3}$/;//ingresa cualquier dominio de correo electronico
        if (Input.value.match(expresion1)){
        document.miFormulario.email.length();
                return true;
        } else {
        
        swal('Ingresar un correo válido');
        limpiarCOR();
        return false;
        }
}

function limpiarCOR() {
    document.getElementById('email').value = '';
}

function limpiarTEL() {
    document.getElementById('tel').value = '';
}

//FECHA MAXIMA HOY
let today = new Date();
let dd = today.getDate();
let mm = today.getMonth() + 1; //January is 0!
let yyyy = today.getFullYear();
if (dd < 10) {
    dd = '0' + dd;
}
if (mm < 10) {
    mm = '0' + mm;
}

today = yyyy + '-' + mm + '-' + dd;


//FUNCION CONSULTA SI EXISTE UN NUMERO DE IDENTIDAD EN LA BASE
function ExisteIdentidad() {
    identidad = $('#identidad').val();

    $.post('../Controlador/registro_estudiantes_controlador.php?op=ExisteIdentidad', { identidad: identidad }, function(
        data,
        status
    ) {
        console.log(data);
        data = JSON.parse(data);
        console.log(data);
        if (data.existe == 1) {
            $('#TextoIdentidad').removeAttr('hidden');
            
            $('#identidad').val('');
        } else {
            $('#TextoIdentidad').attr('hidden', 'hidden');
        }
    });
}

//FUNCION CONSULTA SI EXISTE UN NUMERO DE CUENTA EN LA BASE
function ExisteNCuenta() {
    ncuenta = $('#txt_n_cuenta').val();

    $.post('../Controlador/registro_estudiantes_controlador.php?op=ExisteNCuenta', { ncuenta: ncuenta }, function(
        data,
        status
    ) {
        console.log(data);
        data = JSON.parse(data);
        console.log(data);
        if (data.existe == 1) {
            $('#TextoNCuenta').removeAttr('hidden');
            
            $('#txt_n_cuenta').val('');
        } else {
            $('#TextoNCuenta').attr('hidden', 'hidden');
        }
    });
}

//FUNCION NO DEJA ESCRIBIR 3 LETRAS IGUEALES
function MismaLetra(id_input) {
    var valor = $('#' + id_input).val();
    var longitud = valor.length;
    
    if (longitud > 2) {
        var str1 = valor.substring(longitud - 3, longitud - 2);
        var str2 = valor.substring(longitud - 2, longitud - 1);
        var str3 = valor.substring(longitud - 1, longitud);
        nuevo_valor = valor.substring(0, longitud - 1);
        if (str1 == str2 && str1 == str3 && str2 == str3) {
            swal('¡Error!', 'No se permiten 3 letras consecutivamente', 'error');

            $('#' + id_input).val(nuevo_valor);
        }
    }
}

//FUNCION PARA SOLO PERMITIR NUMEROS
function soloNumeros(e) {
    var key = window.Event ? e.which : e.keyCode;
    return (key >= 48 && key <= 57) || key == 8;
}

function pierdeFoco(e) {
    var valor = e.value.replace(/^0*/, '');
    e.value = valor;
}

//============================
//      TAMAÑO DE FOTO       =
//============================
var uploadField = document.getElementById('seleccionararchivo');

uploadField.onchange = function() {
    if (this.files[0].size > 5242880) {
        //alert("Archivo muy grande!");
        swal('¡Error!', 'Archivo muy grande', 'warning');

        this.value = '';
    }
};

//============================
//      TAMAÑO DE CURRICULUM    =
//============================
var uploadField = document.getElementById('curriculum');

uploadField.onchange = function() {
    if (this.files[0].size > 15728640) {
        //alert("Archivo muy grande!");
        swal('¡Error!', 'Archivo muy grande', 'warning');

        this.value = '';
    }
};

//FUNCION PARA REGISTRAR ESTUDIANTES
function RegistrarEstudiante(
    nombre,
    apellidos,
    sexo,
    identidad,
    nacionalidad,
    estado,    
    fecha_nacimiento,
    lugar_nacimiento,
    ncuenta,
    tipo_estudiante,
    trabajo,
    idcarrera,
    idcr,
    telefono,
    correo
        
) {
    var foto = document.getElementById('seleccionararchivo');
    var curriculo = document.getElementById('curriculum');

    if(
        
        foto.value == 0 ||
        nombre.length == 0 ||
        apellidos.length == 0 ||
        nacionalidad == null ||
        identidad.length == 0 ||
        fecha_nacimiento.length == 0 ||
        lugar_nacimiento.length == 0 ||
        estado == null ||
        sexo == null ||
        curriculo.value == 0   

    ) {
        swal({
            title: '¡Alerta!',
            text: 'Rellene o seleccione los campos vacíos de Datos Personales',
            type: 'warning',
            showConfirmButton: true,
            timer: 15000
        });

    } else if (
        telefono.length == 0 ||
        correo.length == 0 ||
        trabajo.length == 0
    ) {
        swal({
            title: '¡Alerta!',
            text: 'Rellene o seleccione los campos vacíos de Información de Contacto',
            type: 'warning',
            showConfirmButton: true,
            timer: 15000
        });

    } else {
        if (

            ncuenta.length == 0 ||
            idcarrera.length == null ||
            idcr.length == null ||
            tipo_estudiante.length == 0

        ) {
            swal({
                title: '¡Alerta!',
                text: 'Rellene o seleccione los campos vacíos en Información de Estudiante',
                type: 'warning',
                showConfirmButton: true,
                timer: 15000
            });
        } else {
            nombre = nombre.toUpperCase();
            apellidos = apellidos.toUpperCase();
            sexo = sexo.toUpperCase();
            identidad = identidad.toUpperCase();
            nacionalidad = nacionalidad.toUpperCase();
            estado = estado.toUpperCase();
            lugar_nacimiento = lugar_nacimiento.toUpperCase();            
            tipo_estudiante = tipo_estudiante.toUpperCase();
            trabajo = trabajo.toUpperCase();            
                                    
            $.post(
                '../Controlador/registro_estudiantes_controlador.php?op=registrar', {
                    nombre: nombre,
                    apellidos: apellidos,
                    sexo: sexo,
                    identidad: identidad,
                    nacionalidad: nacionalidad,
                    estado: estado,
                    fecha_nacimiento: fecha_nacimiento,                    
                    lugar_nacimiento: lugar_nacimiento,
                    ncuenta: ncuenta,
                    tipo_estudiante: tipo_estudiante, 
                    trabajo: trabajo,
                    idcarrera: idcarrera,
                    idcr: idcr,
                    telefono: telefono,
                    correo: correo
                    
                },
                
                function(data,status) {
                    
                    console.log(data);
                    console.log(status);
                    Registrar();
                    Registrarcurriculum();

                }

            );

            swal({
                title: "¡Alerta!",
                text: "Por favor espere un momento",
                type: "warning",
                showConfirmButton: false,
                timer: 12000,

            });
            refrescar(15000);
            mensaje();

        }

    }
}



//FUNCION PARA ACTUALIZAR PAGINA DESPUES DE 10 SEGUNDOS DE HABER GUARDADO
function refrescar(tiempo) {
    setTimeout('location.reload(true);', tiempo);


}

function mensaje() {
    setTimeout(function() {
        swal('¡Buen trabajo!', 'Los datos se insertaron correctamente', 'success');
    }, 14000);
}

//FUNCION DE PREVISUALIZACION DE IMAGEN
document.getElementById('seleccionararchivo').addEventListener('change', () => {
    var archivoseleccionado = document.querySelector('#seleccionararchivo');
    var archivos = archivoseleccionado.files;
    var imagenPrevisualizacion = document.querySelector('#mostrarimagen');
    // Si no hay archivos salimos de la función y quitamos la imagen
    if (!archivos || !archivos.length) {
        imagenPrevisualizacion.src = '';
        return;
    }
    // Ahora tomamos el primer archivo, el cual vamos a previsualizar
    var primerArchivo = archivos[0];
    // Lo convertimos a un objeto de tipo objectURL
    var objectURL = URL.createObjectURL(primerArchivo);
    // Y a la fuente de la imagen le ponemos el objectURL
    imagenPrevisualizacion.src = objectURL;
});

var archivo = $('#seleccionararchivo').val();
//FUNCION QUE INGRESSA O CARGA LA FOTO
function Registrar() {
    var formData = new FormData();
    var foto = $('#seleccionararchivo')[0].files[0];
    formData.append('f', foto);

    $.ajax({
        url: '../Controlador/subirperfil_estudiantes.php',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            if (respuesta != 0) {
                //Swal('Mensaje De Confirmacion', 'Se subio fotografia con exito', 'success');
            }
        }
    });
    return false;
}
//FUNCION QUE INGRESA O CARGA EL CURRICULUM
function Registrarcurriculum() {
    var formData = new FormData();
    var curriculum = $('#curriculum')[0].files[0];
    formData.append('c', curriculum);

    $.ajax({
        url: '../Controlador/subircurriculum_estudiantes.php',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            if (respuesta != 0) {         
            }
        }
    });
    return false;
}
//validar pdf
var c = document.getElementById("curriculum");

c.onchange = function() {
    var archivo = $("#curriculum").val();
    var extensiones = archivo.substring(archivo.lastIndexOf("."));
    
    if (extensiones != ".pdf") {
        alert("El archivo de tipo " + extensiones + " no es válido");
        document.getElementById("curriculum").value = "";
    }
};

// validar imagen
var d = document.getElementById("seleccionararchivo");

d.onchange = function() {
    var archivo = $("#seleccionararchivo").val();
    var extensiones = archivo.substring(archivo.lastIndexOf("."));
    
    if (
        extensiones != ".jpg" &&
        extensiones != ".png" &&
        extensiones != ".jpeg" &&
        extensiones != ".PNG"
    ) {
        alert("El archivo de tipo " + extensiones + " no es válido");
        document.getElementById("seleccionararchivo").value = "";
    }
};