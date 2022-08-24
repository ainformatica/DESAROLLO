


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

function llenar_selectNAC() {
    var cadena = '&activar=activar';
    $.ajax({
        url: '../Controlador/registro_estudiantes_controlador.php?op=selectNAC',
        type: 'POST',
        data: cadena,
        success: function(r) {
            //  console.log(r);

            $('#cb_nacionalidad').html(r).fadeIn();
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

if ((document.getElementsByName = 'cb_nacionalidad')) {
    llenar_selectNAC();
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


//telefonos
var sendData = {};
var list = [];
var telefono = document.getElementById('tel');
var table1 = document.getElementById('tbData2');

//FUNCION QUE VALIDA QUE LOS NUMEROS DE TELEFONO SEAN LOCALES
function valtel(tel) {
    var expresion3 = /(9|8|3|2)\d{3}[-]\d{4}/;
    console.log(expresion3.test(tel));
    if (list.length <= 3 && expresion3.test(tel)) {
        return 1;
    } else {
        return 0;
    }
}

var addTask = () => {
    //var n = telefono.search("_");
    if ($('#tel').val().length == 0) {
        swal('Ingrese el telefono!', '', 'warning');

        return false;
    } else {
        if (list.length == 0) {
            if (valtel($('#tel').val()) == 0) {
                //aqui debo validar que no se agregue a la tabla ...
                swal('Ingrese un número válido');

                limpiarTEL();
                return false;
            }
        } else {
            if (valtel($('#tel').val()) == 0) {
                //aqui debo validar que no se agregue a la tabla ...
                swal('Ingrese un número válido');

                limpiarTEL();
                return false;
            }
        }

        var item = {
            telefono: telefono.value
        };
        console.log(item);

        list.push(item);

        viewlist();
        limpiarTEL();
    }


};

function limpiarTEL() {
    document.getElementById('tel').value = '';
}


var viewlist = () => {
    if (list.length <= 3) {
        var viewItem = '';
        list.map((item, index) => {
            item.id = index + 1;
            viewItem += `<tr>`;
            viewItem += `<td >${item.telefono}</td>`;
            //viewItem += `<td><button class="btn btn-danger btn_remove" type='button' id="remove">X</button></td>`;
            viewItem += `</tr>`;
        });
        table1.innerHTML = viewItem;
        $('#ModalTask1').modal('hide');

        if (list.length == 3) {
            desactivarboton1();
            swal('¡Aviso!', 'límite 3 teléfonos', 'warning');

            $('#ModalTask1').modal('hide');
        }
    }


};

var saveAll = () => {
    if (list.length > 0) {
        sendData.id = 1;
        sendData.data = list;
        console.log(sendData);

        fetch('../api/guardar_telefonos.php', {
                method: 'POST',
                body: JSON.stringify(sendData)
            })
            .then((response) => response.json())
            .then((response) => console.log(response));
        //alert("contactos creados!");

        //window.location.href = window.location.href;
    } else {
        //alert("No registró telefonos!");
        // Location.reload()
    }
};

function limpiarTEL() {
    document.getElementById('tel').value = '';
}

function desactivarboton1() {
    document.getElementById('gcorreotel').disabled = true;
}

//correos
var sendData5 = {};
var list5 = [];
var correo = document.getElementById('email');
var table5 = document.getElementById('tbData5');

const x = 0;

function correoInstDet(correo) {
    var expresion = /^([a-z0-9_\.-]+)@unah\.hn$/;
    //console.log(expresion.test(correo));
    if (list5.length <= 2 && expresion.test(correo)) {
        return 1;
    } else {
        return 0;
    }
}
//FUNCION QUE VERIFICA UN CORREO VALIDO
function correovalido(correo1) {
    var expresion1 = /^\w+([\.-]?\w+)*@(?:|hotmail|outlook|yahoo|live|gmail)\.(?:|com|es)+$/;

    //console.log(expresion1.test(correo1));
    if (list5.length <= 2 && expresion1.test(correo1)) {
        return 1;
    } else {
        return 0;
    }
}

var addTask5 = () => {
    if ($('#email').val().length == 0) {
        swal('¡Ingrese el correo!', '', 'warning');

        return false;
    } else {
        //console.clear();
        if (list5.length == 0) {
            if (correoInstDet($('#email').val()) == 0) {
                //aqui debo validar que no se agregue a la tabla ...

                swal('¡Alerta!', 'Primero ingresar correo institucional', 'warning');

                limpiarCOR();
                return false;
            } else {
                //console.log("exitosss xD") ;
            }
        } else {
            if (correovalido($('#email').val()) == 0) {
                //aqui debo validar que no se agregue a la tabla ...
                swal('Ingresar un correo válido');

                limpiarCOR();
                return false;
            } else {
                desactivarboton();

                swal('¡Aviso!', 'Límite 2 correos', 'warning');

                $('#ModalTask5').modal('hide');
            }
        }
        var item5 = {
            correo: correo.value
        };

        list5.push(item5);

        //console.log(correo);

        viewlist5();
        limpiarCOR();
    }
};

function limpiarCOR() {
    document.getElementById('email').value = '';
}

function limpiarTEL() {
    document.getElementById('tel').value = '';
}

var viewlist5 = () => {
    if (list5.length <= 2) {
        var viewItem5 = '';
        list5.map((item5, index) => {
            item5.id = index + 1;
            viewItem5 += `<tr>`;
            viewItem5 += `<td>${item5.correo}</td>`;
            viewItem5 += `</tr>`;
            console.log(index);
            console.log(item5);
        });

        table5.innerHTML = viewItem5;

        $('#ModalTask5').modal('hide');
    } else {
        alert('Sólo puede ingresar 2 correos warning');
        return false;
    }
};

function desactivarboton() {
    document.getElementById('gcorreo').disabled = true;
}

var saveAll2 = () => {
    if (list5.length > 0) {
        sendData5.id = 1;
        sendData5.data = list5;

        fetch('../api/guardar_correos.php', {
                method: 'POST',
                body: JSON.stringify(sendData5)
            })
            .then((response) => response.json())
            .then((response) => console.log(response));
    } else {
    }
};

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

//FUNCIO QUE VALIDA QUE EL NUMERO DE IDENTIDAD ESTÉ CORRECTO
function ValidarIdentidad(identidad) {
    //console.log(n);
    var n = identidad.search('_');
    console.log(n);
    var mayor_edad = $('#mayoria_edad').val();
    var depto = identidad.substring(0, 4);
    var contar = depto;

    console.log(contar);

    if (n == 5) {
        var ver = false;
        $.post('../Controlador/registro_estudiantes_controlador.php?op=validar_depto', { codigo: contar }, function(
            data,
            status
        ) {
            console.log(data);
            data = JSON.parse(data);
            console.log(data);
            /*si no tiene datos va copiar  */
            //$("#contar_depto").val(data.regis);

            if (data.regis == 0) {
                var ver = true;

                if (ver == true) {
                    swal(
                        '¡Datos incorrectos!',
                        'Asegúrese de introducir los dígitos correspondientes a su departamento y município',
                        'warning'
                    );
                    $('#contar_depto').val('');
                    $('#identidad').val('');
                    $('#identidad').attr('placeholder', '____-____-_____');
                }
            }
        });
    }

    if (n == 10) {
        var currentTime = new Date();
        var year = currentTime.getFullYear();
        var anio = identidad.substring(5, 9);
        //console.log(year-anio);
        if (year < anio) {
            //swal("Aviso", "Debe ser mayor de edad", "warning");
            $('#Textomayor1').removeAttr('hidden');
            $("#identidad").val("");
            $("#identidad").attr("placeholder", "____-____-_____");
            //$("#identidad").val("");
            //$("#identidad").attr("placeholder", "____-____-_____");
        } else if (year - anio < mayor_edad)

        {
            $('#Textomayor').removeAttr('hidden');


        } else {

            $('#Textomayor').attr('hidden', 'hidden');
            $('#Textomayor1').attr('hidden', 'hidden');

        }
        if (anio == '0000') {
            swal('¡Aviso!', 'Año inválido', 'warning');
            $('#identidad').val('');
            $('#identidad').attr('placeholder', '____-____-_____');
            $('#Textomayor').attr('hidden', 'hidden');
        } else {}
    }

    if (n == -1) {
        var ultimo = identidad.substring(10, 15);
        // console.log(anio);
        if (ultimo == '00000') {
            swal('¡Aviso!', 'No se permiten 5 ceros', 'warning');
            $('#identidad').val('');
            $('#identidad').attr('placeholder', '____-____-_____');
            $('#Textomayor').attr('hidden', 'hidden');
        } else {}
    }
}


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
    //console.log(valor+longitud);
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


$(document).ready(function() {
    $("#tel").keyup(function() {
        var value = $(this).val();
        $("#telefonox").val(value);
    });
});


$(document).ready(function() {
    $("#email").keyup(function() {
        var value = $(this).val();
        $("#correosx").val(value);
    });
});

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
    ncuenta,
    tipo_estudiante,
    trabajo
        
) {
    var idcarrera = $('#cb_carrera').children('option:selected').val();
    var idcr = $('#cb_cr').children('option:selected').val();
    var foto = document.getElementById('seleccionararchivo');
    var curriculo = document.getElementById('curriculum');
    var telefonox = $("#telefonox").val();
    var correosx = $("#correosx").val();
    
     {
            nombre = nombre.toUpperCase();
            apellidos = apellidos.toUpperCase();
            sexo = sexo.toUpperCase();
            identidad = identidad.toUpperCase();
            nacionalidad = nacionalidad.toUpperCase();
            estado = estado.toUpperCase();
            ncuenta = ncuenta.toUpperCase();
            trabajo = trabajo.toUpperCase();            
            tipo_estudiante = tipo_estudiante.toUpperCase();
                        
            $.post(
                '../Controlador/registro_estudiantes_controlador.php?op=registrar', {
                    nombre: nombre,
                    apellidos: apellidos,
                    sexo: sexo,
                    identidad: identidad,
                    nacionalidad: nacionalidad,
                    estado: estado,
                    fecha_nacimiento: fecha_nacimiento,                    
                    ncuenta: ncuenta,
                    tipo_estudiante: tipo_estudiante, 
                    trabajo: trabajo,                   
                    idcarrera: idcarrera,
                    idcr: idcr
                    
                },

                function(e) {
                    saveAll();                                        
                    saveAll2();
                    Registrar();
                    Registrarcurriculum();

                }

            );

            //window.location.href = window.location.href;

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
    // formData.append('nombrearchivo', nombrearchivo);

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
    //formData.append('nombrearchivo', nombrearchivo);

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
    // console.log(extensiones);
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
    // console.log(extensiones);
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