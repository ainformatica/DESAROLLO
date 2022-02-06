// $(document).ready(function () {

//     $("#importar").on("click", function () {

//         var importar_excel = $('#archivo_excel')[0].files[0];

//         let formData = new FormData();
//         formData.append('archivo_excel', importar_excel);

//         $.ajax({
//             url: '../Controlador/importar_carga_controlador.php',
//             type: 'POST',
//             data: formData,
//             contentType: false,
//             processData: false,

//             success: function (data) {
//                 console.log(data);

//             }
//         });

//     });
// });

function cargar_excel() {
    var excel = $("#archivo_excel").val();

    if (excel === "") {
        alert("Debe seleccionar un archivo excel para continuar");
    } else {
        // swal("Advertencia!", "Espera un momento", "warning");
        var formData = new FormData();
        var files = $("#archivo_excel")[0].files[0];

        formData.append("archivoExcel", files);

        $.ajax({
            url: "../Controlador/importar.php?",
            type: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(respuesta) {
                // alert(respuesta);
                $("#div_tabla").html(respuesta);
                document.getElementById("btn_guardar").disabled = false;
            },
        });
        return false;
    }
}

function registrar_excel() {
    // swal("Advertencia!", "Espera un momento", "warning");

    var contador = 0;
    var arreglo_control = new Array();
    var arreglo_cod_asig = new Array();
    var arreglo_asignatura = new Array();
    var arreglo_seccion = new Array();
    var arreglo_hra_inicio = new Array();
    var arreglo_hra_final = new Array();
    var arreglo_dias = new Array();
    var arreglo_aula = new Array();
    var arreglo_profesor = new Array();
    var arreglo_matriculados = new Array();

    $("#tabla_detalle tbody#tbody_tabla_detalle tr").each(function() {
        arreglo_control.push($(this).find("td").eq(0).text());
        arreglo_cod_asig.push($(this).find("td").eq(1).text());
        arreglo_asignatura.push($(this).find("td").eq(2).text());
        arreglo_seccion.push($(this).find("td").eq(3).text());
        arreglo_hra_inicio.push($(this).find("td").eq(4).text());
        arreglo_hra_final.push($(this).find("td").eq(5).text());
        arreglo_dias.push($(this).find("td").eq(6).text());
        arreglo_aula.push($(this).find("td").eq(7).text());
        arreglo_profesor.push($(this).find("td").eq(8).text());
        arreglo_matriculados.push($(this).find("td").eq(9).text());
        contador++;
    });

    var control = arreglo_control.toString();
    var cod_asig = arreglo_cod_asig.toString();
    var seccion = arreglo_seccion.toString();
    var hra_inicio = arreglo_hra_inicio.toString();
    var hra_final = arreglo_hra_final.toString();
    var dias = arreglo_dias.toString();
    var aula = arreglo_aula.toString();
    var profesor = arreglo_profesor.toString();
    var matriculados = arreglo_matriculados.toString();



    if (contador == 0) {
        return swal(
            "Advertencia!",
            "La tabla tiene que tener como minimo 1 dato",
            "warning"
        );
    } else {
        var id_periodo = $("#txt_id_periodo").val();
        swal({
            title: "Alerta",
            text: "Al continuar se eliminarán los datos de carga en el periodo actual, desea continuar?",
            icon: "warning",
            buttons: {
                cancel: "Cancelar",
                confirm: "Aceptar",
            },
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "../Controlador/eliminar_carga_periodo_controlador.php",
                    type: "POST",
                    data: {
                        id_periodo: id_periodo,
                    },
                }).done(function(resp) {
                    if (resp > 0) {
                        llamarregistrar(
                            cod_asig,
                            seccion,
                            hra_inicio,
                            hra_final,
                            dias,
                            aula,
                            profesor,
                            matriculados,
                            control
                        );
                    } else {
                        swal(
                            "Alerta!",
                            "No se pudo completar la intenta de nuevo",
                            "warning"
                        );
                    }
                });
            } else {
                swal("Advertencia!", "cancelado!", "Success");
            }
        });

    }
}
//aqui comienza la carga preliminar

function cargar_excel_preliminar1() {
    var excel = $("#archivo_excel_preliminar").val();

    if (excel === "") {
        alert("Debe seleccionar un archivo excel para continuar");
    } else {
        var formData = new FormData();
        var files = $("#archivo_excel_preliminar")[0].files[0];

        formData.append("archivo_excel_preliminar", files);

        $.ajax({
            url: "../Controlador/importar_preliminar.php",
            type: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(respuesta) {
                $("#div_tabla_preliminar").html(respuesta);
                document.getElementById("btn_guardar_preliminar").disabled = false;
            },
        });
        return false;
    }
}

function registrar_excel_preliminar() {
    // swal("Advertencia!", "Espera un momento", "warning");
    var contador = 0;
    //var arreglo_control = new Array();
    var arreglo_cod_asig = new Array();
    var arreglo_asignatura = new Array();
    var arreglo_seccion = new Array();
    var arreglo_hra_inicio = new Array();
    var arreglo_hra_final = new Array();
    var arreglo_dias = new Array();
    var arreglo_aula = new Array();
    var arreglo_profesor = new Array();
    var arreglo_matriculados = new Array();

    $("#tabla_detalle_preliminar tbody#tbody_tabla_detalle_preliminar tr").each(
        function() {

            arreglo_cod_asig.push($(this).find("td").eq(0).text());
            arreglo_asignatura.push($(this).find("td").eq(1).text());
            arreglo_seccion.push($(this).find("td").eq(2).text());
            arreglo_hra_inicio.push($(this).find("td").eq(3).text());
            arreglo_hra_final.push($(this).find("td").eq(4).text());
            arreglo_dias.push($(this).find("td").eq(5).text());
            arreglo_aula.push($(this).find("td").eq(6).text());
            arreglo_profesor.push($(this).find("td").eq(7).text());
            arreglo_matriculados.push($(this).find("td").eq(8).text());
            // arreglo_control.push($(this).find("td").eq(9).text());
            contador++;
        }
    );

    var cod_asig = arreglo_cod_asig.toString();
    var seccion = arreglo_seccion.toString();
    var hra_inicio = arreglo_hra_inicio.toString();
    var hra_final = arreglo_hra_final.toString();
    var dias = arreglo_dias.toString();
    var aula = arreglo_aula.toString();
    var profesor = arreglo_profesor.toString();
    var matriculados = arreglo_matriculados.toString();
    //  var control = arreglo_control.toString();

    if (contador == 0) {
        return swal(
            "Advertencia!",
            "La tabla tiene que tener como minimo 1 dato",
            "warning"
        );
    } else {
        var id_periodo = $("#txt_id_periodo").val();
        swal({
            title: "Alerta",
            text: "Al continuar se eliminarán los datos de carga en el periodo actual, desea continuar?",
            icon: "warning",
            buttons: {
                cancel: "Cancelar",
                confirm: "Aceptar",
            },
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "../Controlador/eliminar_carga_periodo_controlador.php",
                    type: "POST",
                    data: {
                        id_periodo: id_periodo,
                    },
                }).done(function(resp) {
                    if (resp > 0) {
                        llamarregistrarPreliminar(
                            cod_asig,
                            seccion,
                            hra_inicio,
                            hra_final,
                            dias,
                            aula,
                            profesor,
                            matriculados,
                            // control
                        );
                    } else {
                        swal(
                            "Alerta!",
                            "No se pudo completar la intenta de nuevo",
                            "warning"
                        );
                    }
                });
            } else {
                swal("Advertencia!", "cancelado!", "Success");
            }
        });
    }
}

function llamarregistrarPreliminar(
    cod_asig,
    seccion,
    hra_inicio,
    hra_final,
    dias,
    aula,
    profesor,
    matriculados
) {

    $.ajax({
        url: "../Controlador/guardar_impor_carga_preliminar_controlador.php",
        type: "post",
        data: {
            prof: profesor,
            aula: aula,
            cod: cod_asig,
            seccion: seccion,
            matri: matriculados,
            dias: dias,
            hra_inicio: hra_inicio,
            hra_final: hra_final,
            // control: control
        },
    }).done(function(resp) {
        // alert(resp);
        if (resp == 1) {
            swal("Bien!", "Se guardo con exito!", "success");

            window.location = "../vistas/importar_carga_preliminar_vista.php";
        } else {
            swal("Error!", "No se pudo completar, intente de nuevo!", "warning");
            //   window.location = "../vistas/importar_carga_final_vista.php";
        }
    });
}


function llamarregistrar(
    cod_asig,
    seccion,
    hra_inicio,
    hra_final,
    dias,
    aula,
    profesor,
    matriculados, control
) {

    $.ajax({
        url: "../Controlador/guardar_impor_carga_controlador.php",
        type: "post",
        data: {
            prof: profesor,
            aula: aula,
            cod: cod_asig,
            control: control,
            seccion: seccion,
            matri: matriculados,
            dias: dias,
            hra_inicio: hra_inicio,
            hra_final: hra_final,
        },
    }).done(function(resp) {
        // alert(resp);
        if (resp == 1) {
            swal("Bien!", "Se guardo con exito!", "success");

            window.location = "../vistas/importar_carga_final_vista.php";
        } else {
            swal("Error!", "No se pudo completar, intente de nuevo!", "warning");
            //   window.location = "../vistas/importar_carga_final_vista.php";
        }
    });
}