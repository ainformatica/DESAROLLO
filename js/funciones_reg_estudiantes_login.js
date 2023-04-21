//PARA TRAER EL ID_PERSONA DEL USUARIO
function traerId() {
    $.post(
        '../Controlador/reg_estudiantes_login_controlador.php?op=traerId-estudiante', {
            
            id_persona: ""
        },

        function(data, status) {
            $('#txt_id_persona').val(data); //data nos trae
            //$('#identidad').val(data.identidad), $('#cb_nacionalidad').val(data.nacionalidad), $('#cb_ecivil').val(data.estado_civil), $('#txt_fecha_nacimiento').val(data.fecha_nacimiento), $('#txt_lugar_nacimiento').val(data.lugar_nacimiento), $('#rb_trabajo').val(data.trabajo), $('#rb_egresado').val(data.egresado), $('#cb_carrera').val(data.carrera), $('#cb_cr').val(data.cregional), $('#tel').val(data.telefonos)
            
        }

    );
}

$(document).ready(function(){
    //traerId();
    $("#btn_guardar_datos_estudiantes").on('click', function() {
        registro_estudiantes(
            $('#identidad').val(), $('#cb_nacionalidad').val(), $('#cb_ecivil').val(), $('#txt_fecha_nacimiento').val(), $('#txt_lugar_nacimiento').val(), $('#rb_trabajo').val(), $('#rb_egresado').val(), $('#cb_carrera').val(), $('#cb_cr').val(), $('#tel').val()
        );
    })
  });
  //fin

//FUNCION PARA SOLO PERMITIR NUMEROS Y GUIONES
function solonumeros(e){
    tecla = (document.all) ? e.keyCode : e.which;
    tecla = String.fromCharCode(tecla)
    return /^[0-9]+$/.test(tecla);
  }

  function solonumeros2(e){
    tecla = (document.all) ? e.keyCode : e.which;
    tecla = String.fromCharCode(tecla)
    return /^[0-9\-]+$/.test(tecla);
  }

    //no permite dobre espacio
    function DobleEspacio(campo, event) {

        CadenaaReemplazar = "  ";
        CadenaReemplazo = " ";
        CadenaTexto = campo.value;
        CadenaTextoNueva = CadenaTexto.split(CadenaaReemplazar).join(CadenaReemplazo);
        campo.value = CadenaTextoNueva;
      
      }

//FUNCION DE PREVISUALIZACION DE IMAGEN DE PERFIL
document.getElementById('seleccionararchivo2').addEventListener('change', () => {
    var archivoseleccionado = document.querySelector('#seleccionararchivo2');
    var archivos = archivoseleccionado.files;
    var imagenPrevisualizacion = document.querySelector('#mostrarimagen2');
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
  
//============================
//      TAMAÑO DE FOTO       =
//============================
var uploadField = document.getElementById('seleccionararchivo2');

uploadField.onchange = function() {
  if (this.files[0].size > 5242880) {
      swal('¡Error!', 'Archivo muy grande', 'warning');

      this.value = '';
  }
};

// validar imagen
var d = document.getElementById("seleccionararchivo2");

d.onchange = function() {
  var archivo = $("#seleccionararchivo2").val();
  var extensiones = archivo.substring(archivo.lastIndexOf("."));
  if (
      extensiones != ".jpg" &&
      extensiones != ".png" &&
      extensiones != ".jpeg" &&
      extensiones != ".PNG"
  ) {
      alert("El archivo de tipo " + extensiones + " no es válido");
      document.getElementById("seleccionararchivo2").value = "";
  }
};


  //FUNCION QUE INGRESSA O CARGA LA FOTO
  function RegistrarFoto() {
    var formData = new FormData();
    var foto = $('#seleccionararchivo2')[0].files[0];
    formData.append('f', foto);
  
    $.ajax({
        url: '../Controlador/subirperfil_estudiantes_login.php',
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

  //FUNCION QUE INGRESA O CARGA EL CURRICULUM
function Registrarcurriculum() {
    var formData = new FormData();
    var curriculum = $('#curriculum')[0].files[0];
    formData.append('c', curriculum);
    //formData.append('nombrearchivo', nombrearchivo);

    $.ajax({
        url: '../Controlador/subircurriculum_estudiantes_login.php',
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

  //FUNCION CONSULTA SI EXISTE UN NUMERO DE IDENTIDAD EN LA BASE
function ExisteIdentidad() {
    identidad = $('#identidad').val();

    $.post('../Controlador/reg_estudiantes_login_controlador.php?op=ExisteIdentidad', { identidad: identidad }, function(
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

// TRABAJA SI/NO
$(document).ready(function() {
    $('[name="check[]"]').click(function() {
        var arr = $('[name="check[]"]:checked')
            .map(function() {
                return this.value;
            })
            .get();

        $("#arr").text(JSON.stringify(arr));

        $("#rb_trabajo").val(arr);
    });
});

    // EGRESADO SI/NO
    $(document).ready(function() {
        $('[name="egresado"]').click(function() {
            var ra = $('[name="egresado"]:checked')
                .map(function() {
                    return this.value;
                })
                .get();
    
            $("#ra").text(JSON.stringify(ra));
    
            $("#rb_egresado").val(ra);
        });
    });


    //FUNCION QUE VALIDA QUE LOS NUMEROS DE TELEFONO SEAN LOCALES
    function valtel(telef) {
        var expresion3 = /(9|8|3|2)\d{3}[-]\d{4}/;
        console.log(expresion3.test(tel));
        if (telef.value.match(expresion3)){
            document.miFormulario.tel.length;
                    return true;
            } else {
            
            swal('Ingresar un número de teléfono válido');
            limpiarTEL();
            return false;
            }
    }

    function limpiarTEL() {
        document.getElementById('tel').value = '';
    }
    
    function registro_estudiantes(
            identidad,
            nacionalidad,
            ecivil,
            fecha_nacimiento,
            lugar_nacimiento,
            trabajo,
            egresado,
            carrera,
            cregional,
            telefono
        ) {
                     
            var foto = document.getElementById('seleccionararchivo2');
            var curriculo = document.getElementById('curriculum');
            
    if(
        
        foto.value == 0 ||
        nacionalidad == null ||
        identidad.length == 0 ||
        fecha_nacimiento.length == 0 ||
        lugar_nacimiento.length == 0 ||
        ecivil == null ||
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
        telefono.length == 0 
       // trabajo.length == null
    ) {
        swal({
            title: '¡Alerta!',
            text: 'Rellene o seleccione los campos vacíos de Información de Contacto',
            type: 'warning',
            showConfirmButton: true,
            timer: 15000
        });

    } else { 
        if( 
        
    carrera.length == 0 ||
    cregional.length == null  
    //egresado.length == null
    ){
        swal({
            title: '¡Alerta!',
            text: 'Rellene o seleccione los campos vacíos de Información de Académica',
            type: 'warning',
            showConfirmButton: true,
            timer: 15000
        });

    }
        else {
                    //trabajo = trabajo.toUpperCase();
                    carrera = carrera.toUpperCase();
                    cregional = cregional.toUpperCase();
                    //egresado = egresado.toUpperCase();
                    lugar_nacimiento = lugar_nacimiento.toUpperCase();
                    nacionalidad = nacionalidad.toUpperCase();       
                    ecivil = ecivil.toUpperCase();

                    datos = $("#Formulario").serialize();
                    console.log(datos)

                    $.post(
                        '../Controlador/reg_estudiantes_login_controlador.php?op=completar_registro', {
                            
                            identidad: identidad,
                            nacionalidad: nacionalidad,
                            ecivil: ecivil,
                            fecha_nacimiento: fecha_nacimiento,
                            lugar_nacimiento: lugar_nacimiento,
                            trabajo: trabajo,
                            egresado: egresado,
                            carrera: carrera,
                            cregional:cregional,
                            telefono:telefono
                        },
        
                        function(data,status) {
                            console.log(data);
                            console.log(status);
                            RegistrarFoto();
                            Registrarcurriculum();

                            window.location='../vistas/cambiar_clave_x_usuario_vista.php';
        
                        }
        
                    );
                    
                    // refrescar(15000);
                    // mensaje();
                                                    
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


/*
//FUNCION QUE VALIDA QUE EL NUMERO DE IDENTIDAD ESTÉ CORRECTO
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
        $.post('../Controlador/reg_estudiantes_login_controlador.php?op=validar_depto', { codigo: contar }, function(
            data,
            status
        ) {
            data = JSON.parse(data);

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
        if (year < anio) {
            $('#Textomayor1').removeAttr('hidden');
            $("#identidad").val("");
            $("#identidad").attr("placeholder", "____-____-_____");
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
        if (ultimo == '00000') {
            swal('¡Aviso!', 'No se permiten 5 ceros', 'warning');
            $('#identidad').val('');
            $('#identidad').attr('placeholder', '____-____-_____');
            $('#Textomayor').attr('hidden', 'hidden');
        } else {}
    }
}
*/
        