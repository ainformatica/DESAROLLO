<style>
  table,
  tbody {
    text-align: center;
  }

  .modal-header.edit {
    background-color: #ff5733;
  }

  .modal-header.create {
    background-color: #aed2ef;
  }
</style>
<html>

<div class="container-fluid">

  <!-- modal de edicion de los datos -->

  <div class="modal fade edicion_modal" id="edicion_modal_cr" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edición Datos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" id="datos_edit_crd">
            <div class="container">
              <div class="row">
                <div class="col-sm">

                  <label for="">Periodo</label><br>
                  <select name="periodo_cr_edit" id="periodo_cr_edit" class="form-control">
                    <option value="PERIODO I">PERIODO I</option>
                    <option value="PERIODO II">PERIODO II</option>
                    <option value="PERIODO III">PERIODO III</option>
                  </select>
                  <!-- <input type="text" class="form-control" name="periodo_cr" id="periodo_cr" required> -->
                </div>
                <div class="col-sm">
                  <label for="">Descripción</label><br>
                  <input type="text" class="form-control" autocomplete="off" name="descrip_cr_edit" id="descrip_cr_edit" maxlength="50" value="" style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('descrip_cr');" oncopy="return false" onpaste="return false" onkeypress="return sololetras(event)" required="">
                </div>
                <div class="col-sm">
                  <label for="">Año Periodo</label><br>
                  <input type="text" id="datepicker_cr" name="txt_fecha_ingreso_cr" onkeydown="return false" class="form-control" placeholder="AÑO PERIODO" required="">
                </div>
              </div>
            </div>


          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" id="send_datos_edit_crd">Enviar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- fin modal de edicion de datos -->


  <!-- inicio del modal2 -->
  <div id="modal" class="modal fade bd-example-modal-lg archivos_craed" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Archivo de CRAED</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="table-wrapper-scroll-y my-custom-scrollbar" id="cargar_excel_cr">

          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Generar WORD</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- fin del modal2 -->

  <div class="row justify-content-center">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table id="tabla_craed" class="table table-bordered table-striped table-dark" cellpadding="0" width="100%">
              <thead class="thead-light">
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">PERIODO</th>
                  <th scope="col">DESCRIPCIÓN</th>
                  <th scope="col">ARCHIVO</th>
                  <th scope="col">AÑO PERIODO</th>
                  <th scope="col">FECHA SUBIDA</th>
                  <th scope="col">ACCIÓN</th>
                  <th scope="col">Generar WORD</th>
                  <th scope="col">ACCIONES</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</html>

<script type="text/javascript">
  var currentdate = new Date();
  var datetime = "Fecha: " + currentdate.getDate() + "/" +
    (currentdate.getMonth() + 1) + "/" +
    currentdate.getFullYear() + " Hora " +
    currentdate.getHours() + ":" +
    currentdate.getMinutes() + ":" +
    currentdate.getSeconds();

  $(document).ready(function() {
    var table = $("#tabla_craed").DataTable({
      "lengthMenu": [
        [5],
        [5]
      ],
      "order": [
        [0, 'desc']
      ],
      "responsive": true,
      "language": {
        "lengthMenu": "Mostrar _MENU_ Registros",
        "zeroRecords": "No se encontraron resultados",
        "info": "Mostrando la pagina de _PAGE_ de _PAGES_",
        "infoEmpty": "No records available",
        "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
        "search": "Buscar:",
        "pagingType": "full_numbers",
        "oPaginate": {
          "sNext": "Siguiente",
          "sPrevious": "Anterior"
        },
      },
      "ajax": {
        "url": "../clases/tabla_craed.php",
        "type": "POST",
        "dataSrc": ""
      },
      dom: 'Bfrtip',
      "buttons": [{
          extend: 'copyHtml5',
          title: 'Datos Exportados',
          text: 'Copiar <i class="fas fa-copy"></i>',
          messageTop: 'La información contenida en este documento pertenece a, UNAH 2021-2022',
          messageBottom: 'La información contenida en este documento pertenece a, UNAH 2021-2022',
          exportOptions: {
            columns: [0, ':visible']
          }
        },
        {
          extend: 'excelHtml5',
          title: 'Datos Exportados',
          text: 'Excel <i class="fas fa-file-excel"></i>',
          messageTop: 'La información contenida en este documento pertenece a, UNAH 2021-2022',
          messageBottom: 'La información contenida en este documento pertenece a, UNAH 2021-2022',
          exportOptions: {
            columns: [1, 2, 3, 4, 5]
          }
        },
        {
          extend: 'pdfHtml5',
          title: 'UNIVERSIDAD NACIONAL AUTONOMA DE HONDURAS REGISTRO DE CRAED',
          text: 'PDF <i class="fas fa-file-pdf"></i>',
          download: 'open',
          //messageTop: 'UNIVERSIDAD NACIONAL AUTONOMA DE HONDURAS REGISTRO DE CRAED',
          //messageBottom: 'La información contenida en este documento pertenece a, UNAH 2021-2022',
          exportOptions: {
            columns: [1, 2, 3, 4, 5]
          },
          customize: function(doc) {
            doc.content[1].table.widths = ["13%", "18%", "34%", "15%", "20%"];
            //doc.styles.tableBodyOdd.alignment = 'center';
            doc.defaultStyle.alignment = 'center';
            doc.styles.tableHeader.alignment = 'center';
            doc['footer'] = (function(page, pages) {
                return {
                  columns: [
                    datetime,
                    {
                      alignment: 'left',
                      text: [{
                          text: page.toString(),
                          italics: true
                        },
                        ' de ',
                        {
                          text: pages.toString(),
                          italics: true
                        }
                      ]
                    }
                  ],
                  margin: [10, 0]
                }
              }),
              //doc.content[1].margin = [100, 0, 110, 0] //left, top, right, bottom                              
              doc.content.splice(1, 0, {
                width: 50,
                height: 50,
                margin: [0, 0, 0, 12],
                alignment: 'left',
                image: 'data:image/jpeg;base64,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'
              });
          }
        },
        //'colvis'
      ],
      "columns": [{
          "data": "id_craed_jefa",
          "visible": false
        },
        {
          "data": "periodo_cr"
        },
        {
          "data": "descripcion_cr"
        },
        {
          "data": "nombre_archivo_cr"
        },
        {
          "data": "fecha_cr"
        },
        {
          "data": "fecha_subida"
        },
        {
          "data": null,
          defaultContent: '<center><div class="btn-group"> <button id="ver_archivo_craed" class="ver btn btn-primary btn - m" data-toggle="modal" data-target=".archivos_craed"><i class="fas fa-eye"></i></button><button id="descarga_cr" class=" btn btn-success btn - m"><i class="fas fa-file-download"></i></button><div></center>'
        },
        {
          "data": null,
          defaultContent: '<center><button class="btn btn-primary" id="generar_wordCR" data-toggle="modal" data-target="#modal_final">Generar WORD</button></center>'
        },
        {
          "data": null,
          defaultContent: '<center><div class="btn-group btn-btn" role="group" aria-label="Basic example"><button type="button" id="delete_craed" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button><button type="button" id="edit_fil_crd" class="btn btn-warning" data-toggle="modal" data-target="#edicion_modal_cr"><i class="fas fa-edit"></i></button></div></center>'
        }
        // { "data": "ip" },
        // { "data": "cambio" },                                                    
      ],
    });

    //!creacion de la edicion de los datos de un archivo
    $('#tabla_craed tbody').on('click', '#edit_fil_crd', function() {
      var fila = table.row($(this).parents('tr')).data();
      var id_edit_cr = fila.id_craed_jefa;
      var periodo_cr = fila.periodo_cr;
      var descripcion_cr = fila.descripcion_cr;
      var anio_cr = fila.fecha_cr;
      console.log(id_edit_cr + " " + periodo_cr + " " + descripcion_cr + " " + anio_cr);
      localStorage.removeItem('id_editar_crd');
      localStorage.setItem('id_editar_crd', id_edit_cr);

      document.getElementById('descrip_cr_edit').value = descripcion_cr;
      document.getElementById('datepicker_cr').value = anio_cr;
      let element = document.getElementById('periodo_cr_edit');
      element.value = periodo_cr;

    });
    //!fin edicion de los datos de archivo


    $('#tabla_craed tbody').on('click', '#delete_craed', function() {
      //alert('eliminar craed');
      var fila = table.row($(this).parents('tr')).data();
      var id_crd = fila.id_craed_jefa;
      //alert(id_acd);
      swal({
        title: 'Seguro que quiere eliminar este archivo?',
        text: "!Este registro no podra ser recuperado!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminarlo!',
        cancelButtonText: 'No, Cancelar!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
      }).then(function() {

        const formDelete = new FormData();
        formDelete.append('file_delete_crd', 1);
        formDelete.append('id', id_crd);


        fetch('../Controlador/action.php', {
            method: 'POST',
            body: formDelete
          })
          .then(res => res.json())
          .then(data => {
            //console.log(data);
            if (data == 'exito') {
              swal(
                '¡Eliminado!',
                '!Su registro ha sido eliminado!',
                'success'
              )
              $('#tabla_craed').DataTable().ajax.reload();
            } else {
              swal(
                'Error',
                'A ocurrido un error en la consulta!',
                'error'
              )
            }
          })
        //alert('id a eliminar:' + id_crd);
      }, function(dismiss) {
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
          swal(
            'Cancelado',
            'Su registro sigue intacto!',
            'error'
          )
        }
      })
    });

    $('#tabla_craed tbody').on('click', '#ver_archivo_craed', function() {
      var fila = table.row($(this).parents('tr')).data();
      var nombre_archivo_cr = fila.nombre_archivo_cr;
      console.log(nombre_archivo_cr);
      //comienza ajax
      var ver_excel_cr = "ver_excel_cr";

      $.ajax({
        url: "../Controlador/action.php",
        type: "POST",
        dataType: "html",
        data: {
          nombre_archivo_cr: nombre_archivo_cr,
          ver_excel_cr: ver_excel_cr
        },
        success: function(r) {
          console.log(r);
          //document.getElementById('cargar_excel').innerHTML = r;
          $('#cargar_excel_cr').html(r);
        } //FIN SUCCES
      });
      //FIN  AJAX
    });

    $('#tabla_craed tbody').on('click', '#descarga_cr', function() {
      var fila = table.row($(this).parents('tr')).data();
      var nombre_archivo_cr = fila.nombre_archivo_cr;
      console.log(nombre_archivo_cr);

      var url = `../archivos/file_craed/${nombre_archivo_cr}`;
      download(url);

    });
  });


  function download(url) {
    var link = document.createElement("a");
    $(link).click(function(e) {
      e.preventDefault();
      window.location.href = url;
    });
    $(link).click();
  }


  const button_editar_cr = document.getElementById('send_datos_edit_crd');
  const formu_cr = document.getElementById('datos_edit_crd');

  button_editar_cr.addEventListener('click', function(e) {
    //alert('hola');
    const form_edit_Cr = new FormData(formu_cr);
    form_edit_Cr.append('datos_editar_crd', 1);
    form_edit_Cr.append('id_editarCrd', localStorage.getItem('id_editar_crd'));

    if (formu_cr.checkValidity() === false) {
      e.preventDefault();
      e.stopPropagation();
      formu_cr.classList.add('was-validated')
    } else {
      fetch('../Controlador/action.php', {
          method: 'POST',
          body: form_edit_Cr
        })
        .then(res => res.json())
        .then(data => {
          console.log(data);
          if (data == 'exito') {
            swal(
              '¡Exito!',
              '!Su registro ha sido actualizado!',
              'success'
            )
            $('#tabla_craed').DataTable().ajax.reload();
            $('#edicion_modal_cr').modal('hide');
          } else {
            swal(
              'Error',
              'A ocurrido un error en la consulta!',
              'error'
            )
          }
        })
    }



  });
</script>