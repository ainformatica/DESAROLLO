$(function () {
    $("#combo_depto").change(function () {
        var el_departamento = $(this).val();
        console.log(el_departamento);

        $.post("../Controlador/municipios.php", {
            id_departamento: el_departamento,
        }).done(function (respuesta) {
            $("#combo_muni").html(respuesta);
            console.log(respuesta);
        });
    });
});

$(function () {
    $("#combo_muni").change(function () {
        var el_municipio = $(this).val();
        console.log(el_municipio);

        $.post("../Controlador/aldeas_caserios.php", {
            id_municipio: el_municipio,
        }).done(function (respuesta) {
            $("#combo_aldea_caserio").html(respuesta);
            console.log(respuesta);
        });
    });
});

$("#combo_muni").change(function () {
    var id_municipio = $("#combo_muni option:selected").val();
  
    $("#id_municipio").val(id_municipio);
  });

  $("#combo_aldea_caserio").change(function () {
    var id_aldea = $("#combo_aldea_caserio option:selected").val();
  
    $("#id_aldea").val(id_aldea);
  });

  $("#combo_depto").change(function () {
    var id_depto = $("#combo_depto option:selected").val();
  
    $("#id_depto").val(id_depto);
  });

$(document).ready(function () {

    $(document).on('click', '.add', function () {
        var html = '';
        html += '<tr>';
        html += '<td><input class="form-control prueba" type="text" id="txt_nombre_estudiante1" name="txt_nombre_estudiante1[]"  value="" required  onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="60" placeholder="NOMBRE DEL ESTUDIANTE"/></td>';

        html += '<td><input class="form-control txt_num_estudiante1" type="text" id="txt_num_estudiante1" name="txt_num_estudiante1[]"  value="" required   onkeypress="return Numeros(event)" onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="60" placeholder=" Nº DE EMPLEADO"></td>';

        html += '<td><input class="form-control txt_direccion_estudiante1" type="text" id="txt_direccion_estudiante1" name="txt_direccion_estudiante1[]"  value="" required  onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="60" placeholder="DIRECCIÓN"/></td>';

        html += '<td><input class="form-control txt_cargo_estudiante1" type="text" id="txt_cargo_estudiante1" name="txt_cargo_estudiante1[]"  value="" required  onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" style="text-transform: uppercase" maxlength="60" placeholder="CARGO"/></td>';

        html += '<td><input class="form-control txt_telefono_estudiante1" type="text" id="txt_telefono_estudiante1" name="txt_telefono_estudiante1[]"  value=""  onkeypress="return Numeros(event)" maxlength="8" placeholder="TELEFONO" /></td>';

        html += '<td><input class="form-control txt_correo_estudiante1" type="email" id="txt_correo_estudiante1" name="txt_correo_estudiante1[]"  value="" required  onkeypress="return ValidaMail($Correo_electronico)" onkeyup="Espacio(this, event)" maxlength="50" placeholder="CORRECO ELECTRÓNICO"/></td>';

        html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="fa fa-minus-circle"</span></button></td></tr>';
        html += '<tr>';

        $('#integrantes').append(html);
    });

    $(document).on('click', '.remove', function () {
        $(this).closest('tr').remove();
    });

    $('#insert_form').on('submit', function (event) {
        event.preventDefault();
        var error = '';

        $('.txt_direccion_estudiante1').each(function () {
            var count = 1;
            if ($(this).val() == '') {
                error += "<p>Select Unit at " + count + " Row</p>";
                return false;
            }
            count = count + 1;
        });
        $('.txt_num_estudiante1').each(function () {
            var count = 1;
            if ($(this).val() == '') {
                error += "<p>Select Unit at " + count + " Row</p>";
                return false;
            }
            count = count + 1;
        });
        $('.txt_nombre_estudiante1').each(function () {
            var count = 1;
            if ($(this).val() == '') {
                error += "<p>Select Unit at " + count + " Row</p>";
                return false;
            }
            count = count + 1;
        }); $('.txt_correo_estudiante1').each(function () {
            var count = 1;
            if ($(this).val() == '') {
                error += "<p>Select Unit at " + count + " Row</p>";
                return false;
            }
            count = count + 1;
        }); $('.txt_telefono_estudiante1').each(function () {
            var count = 1;
            if ($(this).val() == '') {
                error += "<p>Select Unit at " + count + " Row</p>";
                return false;
            }
            count = count + 1;
        });
        $('.txt_cargo_estudiante1').each(function () {
            var count = 1;
            if ($(this).val() == '') {
                error += "<p>Select Unit at " + count + " Row</p>";
                return false;
            }
            count = count + 1;
        });
        var form_data = $(this).serialize();
        if (error == '') {
            $.ajax({
                url: "insert.php",
                method: "POST",
                data: form_data,
                success: function (data) {
                    if (data == 'ok') {
                        $('#integrantes').find("tr:gt(0)").remove();
                        $('#error').html('<div class="alert alert-success">Item Details Saved</div>');
                    }
                }
            });
        }
        else {
            $('#error').html('<div class="alert alert-danger">' + error + '</div>');
        }
    });

});


function calcular_total() {
      var benef_directo = $("#txt_beneficiario_directo").val();
      var benef_indi = $("#txt_beneficiario_indirecto").val();

      if (benef_indi == "" || benef_directo == "") {
        document.getElementById("txt_beneficiarios").value = "";
      }else{
        var resultado = parseInt(benef_directo) + parseInt(benef_indi);
        document.getElementById("txt_beneficiarios").value = resultado;
      }
   
}