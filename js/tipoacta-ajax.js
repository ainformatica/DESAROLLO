$(document).ready(function () {
/********** finalizar acta ***********/
    $('.finalizar_registroacta').on('click', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var tipo = $(this).attr('data-tipo');
        swal({
            title: '¿Está Seguro en finalizar el acta?',
            text: '¡Por favor asegúrese de llenar el acta, de lo contrario no podrá revertirlo!',
            type: 'warning',
            showCancelButton: true,
            allowOutsideClick: false, //bloquear click fuera
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Finalizarla!',
            cancelButtonText: 'Cancelar'
        }).then(function () {
            $.ajax({
                type: 'post',
                data: {
                    'id': id,
                    'acta': 'finalizar'
                },
                url: '../Modelos/modelo_' + tipo + '.php',
                success: function (data) {
                    var resultado = JSON.parse(data);
                    if (resultado.respuesta == 'exito') {
                        swal({
                            title: "Correcto",
                            text: "Se Finalizo con Exito!",
                            type: "success"
                        }).then(function () {
                            location.href = "../vistas/actas_pendientes_vista";
                        });
                    } else {
                        swal(
                            'Error!',
                            'No se pudo Finalizar faltan campos Importantes',
                            'error'
                        )
                    }
                }
            })
        });
    });
/********** editar acta ***********/
    $('#editar-actas-archivo').on('submit', function (e) {
        e.preventDefault();
        var datos = new FormData(this);
        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            contentType: false,
            processData: false,
            async: true,
            cache: false,
            success: function (data) {
                console.log(data);
                var resultado = data;
                if (resultado.respuesta == 'exito') {
                    swal({
                        title: "Correcto",
                        text: "Borrador guardado correctamente!",
                        type: "success",
                        confirmButtonText: "Ir a Actas Pendientes",
                        html: `<br>
                                ¿Desea gestionar los acuerdos ahora?
                                <br>
                                <b><a target="_blank" href="../vistas/crear_acuerdo_vista">Crear Un acuerdo</a></b>`,
                    }).then(function () {
                        location.href = "../vistas/actas_pendientes_vista";
                    }
                    );
                } else {
                    swal(
                        'Error',
                        'Hubo un error!',
                        'error'
                    )
                }
            }
        })
    });
/********** editar acta ***********/
    $('#actas-archivo').on('submit', function (e) {
    e.preventDefault();
    var datos = new FormData(this);
    $.ajax({
        type: $(this).attr('method'),
        data: datos,
        url: $(this).attr('action'),
        dataType: 'json',
        contentType: false,
        processData: false,
        async: true,
        cache: false,
        success: function (data) {
            console.log(data);
            var resultado = data;
            if (resultado.respuesta == 'exito') {
                swal({
                    title: "Correcto",
                    text: "El acta se ha archivado correctamente!",
                    type: "success",
                    confirmButtonText: "Ir a Actas Archivadas",
                        html: `<br>
                                ¿Desea archivar otra acta ahora?
                                <br>
                                <b><a target="_blank" href="../vistas/archivar_actas_vista">Archivar Acta</a></b>`,
                }).then(function () {
                    location.href = "../vistas/listar_actasarchivadas_vista";
                }
                );
            } else {
                swal(
                    'Error',
                    'Hubo un error!',
                    'error'
                )
            }
        }
    })
    });
/********** editar reunion ***********/
    $('#editar-reunion').on('submit', function (e) {
        e.preventDefault();
        var datos = $(this).serializeArray();
        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var resultado = data;
                if (resultado.respuesta == 'exito') {
                    swal({
                        title: "Correcto", text: "Se editó correctamente!", type:
                            "success"
                    }).then(function () {
                        location.href = "../vistas/reuniones_pendientes_vista";
                    }
                    );
                } else {
                    swal(
                        'Error',
                        'Hubo un error!',
                        'error'
                    )
                }
            }
        })
    });
/********** guardarestado noti ***********/
    $('#guardar-estadoparticipante').on('submit', function (e) {
        e.preventDefault();
        var datos = $(this).serializeArray();
        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var resultado = data;
                if (resultado.respuesta == 'exito') {
                    swal({
                        title: "Correcto", text: "Se guardo correctamente!", type:
                            "success"
                    }).then(function () {
                        location.href = "../vistas/mantenimiento_estadoparticipante_vista";
                    }
                    );
                } else {
                    swal(
                        'Error',
                        'Hubo un error!',
                        'error'
                    )
                }
            }
        })
    });
/********** guardarestado noti ***********/
    $('#guardar-estadonoti').on('submit', function (e) {
        e.preventDefault();
        var datos = $(this).serializeArray();
        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var resultado = data;
                if (resultado.respuesta == 'exito') {
                    swal({
                        title: "Correcto", text: "Se guardo correctamente!", type:
                            "success"
                    }).then(function () {
                        location.href = "../vistas/mantenimiento_estadonoti_vista";
                    }
                    );
                } else {
                    swal(
                        'Error',
                        'Hubo un error!',
                        'error'
                    )
                }
            }
        })
    });
/********** guardar tipo reunion/acta ********** UNICO*/
    $('#guardar-tiporeu').on('submit', function (e) {
        e.preventDefault();
        var datos = $(this).serializeArray();
        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var resultado = data;
                if (resultado.respuesta == 'exito') {
                    swal({
                        title: "Correcto",
                        text: "Se guardo correctamente!",
                        type: "success"
                    }).then(function () {
                        location.href = "../vistas/mantenimiento_actareunion_vista";
                    }
                    );
                } else {
                    swal(
                        'Error',
                        'Hubo un error!',
                        'error'
                    )
                }
            }
        })
    });
/********** guardarestado acta ***********/
    $('#guardar-estadoacta').on('submit', function (e) {
        e.preventDefault();
        var datos = $(this).serializeArray();
        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var resultado = data;
                if (resultado.respuesta == 'exito') {
                    swal({
                        title: "Correcto", text: "Se guardo correctamente!", type:
                            "success"
                    }).then(function () {
                        location.href = "../vistas/mantenimiento_estadoacta_vista";
                    }
                    );
                } else {
                    swal(
                        'Error',
                        'Hubo un error!',
                        'error'
                    )
                }
            }
        })
    });
/********** guardarestado reunion ***********/
    $('#guardar-estadoreunion').on('submit', function (e) {
        e.preventDefault();
        var datos = $(this).serializeArray();
        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var resultado = data;
                if (resultado.respuesta == 'exito') {
                    swal({
                        title: "Correcto", text: "Se guardo correctamente!", type:
                            "success"
                    }).then(function () {
                        location.href = "../vistas/mantenimiento_estadoreunion_vista";
                    }
                    );
                } else {
                    swal(
                        'Error',
                        'Hubo un error!',
                        'error'
                    )
                }
            }
        })
    });
/********** guardar estado acuerdo ***********/
    $('#guardar-estadoacuerdo').on('submit', function (e) {
        e.preventDefault();
        var datos = $(this).serializeArray();
        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var resultado = data;
                if (resultado.respuesta == 'exito') {
                    swal({
                        title: "Correcto", text: "Se guardo correctamente!", type:
                            "success"
                    }).then(function () {
                        location.href = "../vistas/mantenimiento_estadoacuerdo_vista";
                    }
                    );
                } else {
                    swal(
                        'Error',
                        'Hubo un error!',
                        'error'
                    )
                }
            }
        })
    });
/********** borrar acta/reunion ***********/
    $('.borrar_registro').on('click', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var tipo = $(this).attr('data-tipo');
        swal({
            title: '¿Está Seguro?',
            text: 'Si lo elimina no podra revertirlo!!',
            type: 'warning',
            showCancelButton: true,
            allowOutsideClick: false, //bloquear click fuera
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminarlo!',
            cancelButtonText: 'Cancelar'
        }).then(function () {
            $.ajax({
                type: 'post',
                data: {
                    'id': id,
                    'tipo-actareunion': 'eliminar'
                },
                url: '../Modelos/modelo_' + tipo + '.php',
                success: function (data) {
                    var resultado = JSON.parse(data);
                    if (resultado.respuesta == 'exito') {
                        swal(
                            'Eliminado!',
                            'Eliminado con Exito!',
                            'success'
                        )
                        jQuery('[data-id="' + resultado.id_eliminado + '"]').parents('tr').remove();
                    } else {
                        swal(
                            'Error!',
                            'No se pudo eliminar',
                            'error'
                        )
                    }
                }
            })
        });
    });
/********** borrar acta/reunion ***********/
    $('.cancelar_registro').on('click', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var tipo = $(this).attr('data-tipo');
        swal({
            title: '¿Está Seguro?',
            text: 'Si la cancela no podra revertirlo!!',
            type: 'warning',
            showCancelButton: true,
            allowOutsideClick: false, //bloquear click fuera
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, cancelarla!',
            cancelButtonText: 'Cancelar'
        }).then(function () {
            $.ajax({
                type: 'post',
                data: {
                    'id': id,
                    'reunion': 'cancelar'
                },
                url: '../Modelos/modelo_' + tipo + '.php',
                success: function (data) {
                    var resultado = JSON.parse(data);
                    if (resultado.respuesta == 'exito') {
                        swal({
                            title: "cancelado",
                            text: "cancelada con Exito!",
                            type: "success"
                        }).then(function () {
                            location.href = "../vistas/reuniones_pendientes_vista";
                        }
                        );
                    } else {
                        swal(
                            'Error!',
                            'No se pudo cancelar',
                            'error'
                        )
                    }
                }
            })
        });
    });
/********** borrar recursos***********/
    $('.borrar_recursoacta').on('click', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var estado = $(this).attr('data-tipo');
        swal({
            title: '¿Está Seguro?',
            text: 'Desea elimar el archivo',
            type: 'warning',
            showCancelButton: true,
            allowOutsideClick: false, //bloquear click fuera
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminarlo!',
            cancelButtonText: 'Cancelar'
        }).then(function () {
            $.ajax({
                type: 'post',
                data: {
                    'id': id,
                    'recurso': 'borrar'
                },
                url: '../Modelos/modelo_' + estado + '.php',
                success: function (data) {
                    var resultado = JSON.parse(data);
                    if (resultado.respuesta == 'exito') {
                        swal(
                            'Eliminado!',
                            'Eliminado con Exito!',
                            'success'
                        )
                        jQuery('[data-id="' + resultado.id_eliminado + '"]').parents('tr').remove();
                    } else {
                        swal(
                            'Error!',
                            'No se pudo eliminar',
                            'error'
                        )
                    }
                }
            })
        });
    });
/********** borrar estado acta ***********/
    $('.borrar_estadoacta').on('click', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var estado = $(this).attr('data-tipo');
        swal({
            title: '¿Está Seguro?',
            text: 'Si lo elimina no podra revertirlo!!',
            type: 'warning',
            showCancelButton: true,
            allowOutsideClick: false, //bloquear click fuera
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminarlo!',
            cancelButtonText: 'Cancelar'
        }).then(function () {
            $.ajax({
                type: 'post',
                data: {
                    'id': id,
                    'estado-acta': 'eliminar'
                },
                url: '../Modelos/modelo_' + estado + '.php',
                success: function (data) {
                    var resultado = JSON.parse(data);
                    if (resultado.respuesta == 'exito') {
                        swal(
                            'Eliminado!',
                            'Eliminado con Exito!',
                            'success'
                        )
                        jQuery('[data-id="' + resultado.id_eliminado + '"]').parents('tr').remove();
                    } else {
                        swal(
                            'Error!',
                            'No se pudo eliminar',
                            'error'
                        )
                    }
                }
            })
        });
    });
/********** borrar estado reunion ***********/
    $('.borrar_estadoreunion').on('click', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var estado = $(this).attr('data-tipo');
        swal({
            title: '¿Está Seguro?',
            text: 'Si lo elimina no podra revertirlo!!',
            type: 'warning',
            showCancelButton: true,
            allowOutsideClick: false, //bloquear click fuera
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminarlo!',
            cancelButtonText: 'Cancelar'
        }).then(function () {
            $.ajax({
                type: 'post',
                data: {
                    'id': id,
                    'estado-reunion': 'eliminar'
                },
                url: '../Modelos/modelo_' + estado + '.php',
                success: function (data) {
                    var resultado = JSON.parse(data);
                    if (resultado.respuesta == 'exito') {
                        swal(
                            'Eliminado!',
                            'Eliminado con Exito!',
                            'success'
                        )
                        jQuery('[data-id="' + resultado.id_eliminado + '"]').parents('tr').remove();
                    } else {
                        swal(
                            'Error!',
                            'No se pudo eliminar',
                            'error'
                        )
                    }
                }
            })
        });
    });
/********** borrar estado acuerdo ***********/
    $('.borrar_estadoacuerdo').on('click', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var estado = $(this).attr('data-tipo');
        swal({
            title: '¿Está Seguro?',
            text: 'Si lo elimina no podra revertirlo!!',
            type: 'warning',
            showCancelButton: true,
            allowOutsideClick: false, //bloquear click fuera
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminarlo!',
            cancelButtonText: 'Cancelar'
        }).then(function () {
            $.ajax({
                type: 'post',
                data: {
                    'id': id,
                    'estado-acuerdo': 'eliminar'
                },
                url: '../Modelos/modelo_' + estado + '.php',
                success: function (data) {
                    var resultado = JSON.parse(data);
                    if (resultado.respuesta == 'exito') {
                        swal(
                            'Eliminado!',
                            'Eliminado con Exito!',
                            'success'
                        )
                        jQuery('[data-id="' + resultado.id_eliminado + '"]').parents('tr').remove();
                    } else {
                        swal(
                            'Error!',
                            'No se pudo eliminar',
                            'error'
                        )
                    }
                }
            })
        });
    });
/********** borrar estado noti ***********/
    $('.borrar_estadonoti').on('click', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var estado = $(this).attr('data-tipo');
        swal({
            title: '¿Está Seguro?',
            text: 'Si lo elimina no podra revertirlo!!',
            type: 'warning',
            showCancelButton: true,
            allowOutsideClick: false, //bloquear click fuera
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminarlo!',
            cancelButtonText: 'Cancelar'
        }).then(function () {
            $.ajax({
                type: 'post',
                data: {
                    'id': id,
                    'estado-noti': 'eliminar'
                },
                url: '../Modelos/modelo_' + estado + '.php',
                success: function (data) {
                    var resultado = JSON.parse(data);
                    if (resultado.respuesta == 'exito') {
                        swal(
                            'Eliminado!',
                            'Eliminado con Exito!',
                            'success'
                        )
                        jQuery('[data-id="' + resultado.id_eliminado + '"]').parents('tr').remove();
                    } else {
                        swal(
                            'Error!',
                            'No se pudo eliminar',
                            'error'
                        )
                    }
                }
            })
        });
    });
/********** borrar estado participante ***********/
    $('.borrar_estadoparticipante').on('click', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var estado = $(this).attr('data-tipo');
        swal({
            title: '¿Está Seguro?',
            text: 'Si lo elimina no podra revertirlo!!',
            type: 'warning',
            showCancelButton: true,
            allowOutsideClick: false, //bloquear click fuera
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminarlo!',
            cancelButtonText: 'Cancelar'
        }).then(function () {
            $.ajax({
                type: 'post',
                data: {
                    'id': id,
                    'estado-participante': 'eliminar'
                },
                url: '../Modelos/modelo_' + estado + '.php',
                success: function (data) {
                    var resultado = JSON.parse(data);
                    if (resultado.respuesta == 'exito') {
                        swal(
                            'Eliminado!',
                            'Eliminado con Exito!',
                            'success'
                        )
                        jQuery('[data-id="' + resultado.id_eliminado + '"]').parents('tr').remove();
                    } else {
                        swal(
                            'Error!',
                            'No se pudo eliminar',
                            'error'
                        )
                    }
                }
            })
        });
    });
/********** guardar acuerdo ***********/
    $('#guardar-acuerdo').on('submit', function (e) {
        e.preventDefault();
        var datos = $(this).serializeArray();
        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var resultado = data;
                if (resultado.respuesta == 'exito') {
                    swal({
                        title: "Correcto", text: "Se guardo correctamente!",
                        type: "success",
                        confirmButtonText: "Ir a Acuerdos Pendientes",
                        html: `<h3>El Acuerdo se guardo con Exito!</h3>
                                <br>
                                ¿Desea agregar otro acuerdo?
                                <br>
                                <b><a href="../vistas/crear_acuerdo_vista">Añadir otro acuerdo</a></b>`,
                    }).then(function () {
                        location.href = "../vistas/acuerdos_pendientes_vista";
                    }
                    );
                } else {
                    swal(
                        'Error',
                        'Hubo un error el nombre del acuerdo ya existe o falta un campo por llenar!',
                        'error'
                    )
                }
            }
        })
    });
/********** editar acuerdo ***********/
    $('#editar-acuerdo').on('submit', function (e) {
        e.preventDefault();
        var datos = $(this).serializeArray();
        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var resultado = data;
                if (resultado.respuesta == 'exito') {
                    swal({
                        title: "Correcto", text: "Se guardo correctamente!",
                        type: "success",
                    }).then(function () {
                        location.href = "../vistas/acuerdos_pendientes_vista";
                    }
                    );
                } else {
                    swal(
                        'Error',
                        'Hubo un error, no se modifico nada o falta un campo por llenar!',
                        'error'
                    )
                }
            }
        })
    });
/********** finalizar registro acuerdo ***********/
    $('.finalizar_registroacuerdo').on('click', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var estado = $(this).attr('data-tipo');
        swal({
            title: '¿Está Seguro?',
            text: 'El responsable cumplio con la tarea asignada?',
            type: 'warning',
            showCancelButton: true,
            allowOutsideClick: false, //bloquear click fuera
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Finalizar!',
            cancelButtonText: 'Cancelar'
        }).then(function () {
            $.ajax({
                type: 'post',
                data: {
                    'id': id,
                    'acuerdos': 'finalizar',
                    'mensaje': $('#mensaje').val()
                },
                url: '../Modelos/modelo_' + estado + '.php',
                success: function (data) {
                    var resultado = JSON.parse(data);
                    if (resultado.respuesta == 'exito') {
                        swal({
                            title: 'Finalizada!',
                            text: 'Finalizada con Exito!',
                            type: 'success'
                        }).then(function () {
                            location.href = "../vistas/acuerdos_pendientes_vista";
                        }
                        );
                    } else {
                        swal(
                            'Error!',
                            'No se pudo Finalizada',
                            'error'
                        )
                    }
                }
            })
        });
    });
 /********** cancelar reunion ***********/
    $('.cancelar_registrooo').on('click', function (e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    var tipo = $(this).attr('data-tipo');
    swal({
        title: '¿Está Seguro?',
        text: '<h5>¡Si la cancela no podrá revertirlo!</h5><br><b>Escriba el motivo por lo cual cancela la reunión:</b><br><br><input class="form-control" onkeyup="mayus(this);" id="mensaje" style="width: 65%; margin-left: 17%;  border: solid 2px #007EA7;" required="" name="mensaje" type="text">',
        type: 'warning',
        allowOutsideClick: false, //bloquear click fuera
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Si, cancelarla!',
        cancelButtonText: 'Cancelar'
    }).then(function () {
        $.ajax({
            type: 'post',
            data: {
                'id': id,
                'mensaje': $('#mensaje').val(),
                'reunion': 'cancelar'
            },
            url: '../Modelos/modelo_' + tipo + '.php',
            success: function (data) {
                var resultado = JSON.parse(data);
                if (resultado.respuesta == 'exito') {
                    swal({
                        title: "cancelada",
                        text: "<h5>¡Reunión cancelada con Éxito!</h5>",
                        type: "success"
                    }).then(function () {
                        location.href = "../vistas/reuniones_pendientes_vista";
                    });
                } else {
                    swal(
                        'Error!',
                        'No se pudo cancelar',
                        'error'
                    )
                }
            }
        })
    });
    });
/********** cancelar registro acuerdo ***********/
    $('.cancelar_registroacuerdo').on('click', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var estado = $(this).attr('data-tipo');
        swal({
            title: '¿Está Seguro?',
            text: 'Si lo cancelar no podra revertirlo y se notificará al responsable!!<br><br><b>Escriba el motivo por lo cual cancela el acuerdo</b><br><br><input class="form-control" onkeyup="mayus(this);" id="mensaje" style="width: 65%; margin-left: 17%;" required name="mensaje" type="text">',
            type: 'warning',
            showCancelButton: true,
            allowOutsideClick: false, //bloquear click fuera
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Cancelarlo!',
            cancelButtonText: 'Cancelar'
        }).then(function () {
            $.ajax({
                type: 'post',
                data: {
                    'id': id,
                    'acuerdo': 'cancelar',
                    'mensaje': $('#mensaje').val()
                },
                url: '../Modelos/modelo_' + estado + '.php',
                success: function (data) {
                    var resultado = JSON.parse(data);
                    if (resultado.respuesta == 'exito') {
                        swal({
                            title: 'Cancelado!',
                            text: 'acuerdo cancelado con Exito!',
                            type: 'success'
                        }).then(function () {
                            location.href = "../vistas/acuerdos_pendientes_vista";
                        }
                        );
                    } else {
                        swal(
                            'Error!',
                            'No se pudo Cancelar',
                            'error'
                        )
                    }
                }
            })
        });
    });

































});