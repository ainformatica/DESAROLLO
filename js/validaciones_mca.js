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
			swal('Error', 'No se permiten tres letras consecutivas', 'error');

			$('#' + id_input).val(nuevo_valor);
		}
	}
}

//hora final no sea menor a la de inicio
const inicio = document.getElementById("horainicio");
const final = document.getElementById("horafinal");
const fechaselect = document.getElementById("fecha");
const comparaHoras = () => {
    const vInicio = inicio.value;
    const vFinal = final.value;
    const vfecha = fechaselect.value;
    if (!vInicio || !vFinal) {
        return;
    }
    const tIni = new Date();
    const pInicio = vInicio.split(":");
    tIni.setHours(pInicio[0], pInicio[1]);
    const tFin = new Date();
    const pFin = vFinal.split(":");
    tFin.setHours(pFin[0], pFin[1]);
    if (tFin.getTime() < tIni.getTime()) {
        swal('Error', '<h5>La hora final no puede menor a la de inicio</h5>', 'error');
        document.getElementById('horafinal').value = ''
    }
    if (tFin.getTime() === tIni.getTime()) {
        swal('Error', '<h5>La hora inicio con la hora final no pueden ser Iguales</h5>', 'error');
        document.getElementById('horafinal').value = ''
    }
    
}
inicio.addEventListener("change", comparaHoras);
final.addEventListener("change", comparaHoras);

window.onload = function() {
    var nom = document.getElementById('nombre');
    var asu = document.getElementById('asunto');
    var lugar = document.getElementById('lugar');
    var agenda = document.getElementById('agenda');

    
   
    nom.onpaste = function(e) {
      e.preventDefault();
      swal('Error', '<h5>La acción de <b>pegar</b> está prohibida</h5>', 'error');
    }
    
    nom.oncopy = function(e) {
      e.preventDefault();
      swal('Error', '<h5>La acción de <b>copiar</b> está prohibida</h5>', 'error');
    }
    asu.onpaste = function(e) {
      e.preventDefault();
      swal('Error', '<h5>La acción de <b>pegar</b> está prohibida</h5>', 'error');
    }
    
    asu.oncopy = function(e) {
      e.preventDefault();
      swal('Error', '<h5>La acción de <b>copiar</b> está prohibida</h5>', 'error');
    }
    lugar.onpaste = function(e) {
      e.preventDefault();
      swal('Error', '<h5>La acción de <b>pegar</b> está prohibida</h5>', 'error');
    }
    
    lugar.oncopy = function(e) {
      e.preventDefault();
      swal('Error', '<h5>La acción de <b>copiar</b> está prohibida</h5>', 'error');
    }
    agenda.onpaste = function(e) {
      e.preventDefault();
      swal('Error', '<h5>La acción de <b>pegar</b> está prohibida</h5>', 'error');
    }
    
    agenda.oncopy = function(e) {
      e.preventDefault();
      swal('Error', '<h5>La acción de <b>copiar</b> está prohibida</h5>', 'error');
    }

    
   
  }


  function validacion(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "abcdefghijklmnñopqrstuvwxyz,.;@:-()%#0123456789éáíóú"
    especiales = [37, 39, 46, 13, 8, 32];

    tecla_especial = false
    for(var i in especiales) {
        if(key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if(letras.indexOf(tecla) == -1 && !tecla_especial)
        return false;
}
function validacionn(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "abcdefghijklmnñopqrstuvwxyz,.;@:-()%#0123456789éáíóú"
    especiales = [8, 37, 39, 46, 32];

  

    if(letras.indexOf(tecla) == -1 && !tecla_especial)
        return false;
}

document.getElementById("asunto").addEventListener("keydown", teclear);
  document.getElementById("nombre").addEventListener("keydown", teclear);
  document.getElementById("agenda").addEventListener("keydown", teclear);
  document.getElementById("lugar").addEventListener("keydown", teclear);
  document.getElementById("enlace").addEventListener("keydown", teclear);
var flag = false;
var teclaAnterior = "";

function teclear(event) {
  teclaAnterior = teclaAnterior + " " + event.keyCode;
  var arregloTA = teclaAnterior.split(" ");
  if (event.keyCode == 32 && arregloTA[arregloTA.length - 2] == 32) {
    event.preventDefault();
  }
}
function marcar(source) {
    checkboxes = document.getElementsByTagName('input'); //obtenemos todos los controles del tipo Input
    for (i = 0; i < checkboxes.length; i++) //recoremos todos los controles
    {
        if (checkboxes[i].type == "checkbox") //solo si es un checkbox entramos
        {
            checkboxes[i].checked = source.checked; //si es un checkbox le damos el valor del checkbox que lo llamó (Marcar/Desmarcar Todos)
        }
    }
}
if (document.getElementById("enlace").value == "") {
    document.getElementById("enlace").style.display = "none";
    document.getElementById("enlaces").style.display = "none";
    document.getElementById("enlace").required = false;
}



function showInp() {
    getSelectValue = document.getElementById("tipo").value;
    if (getSelectValue == "2") {
        document.getElementById("enlace").style.display = "block";
        document.getElementById("enlace").required = true;
        document.getElementById("enlaces").style.display = "block";
    } else {
        document.getElementById("enlace").style.display = "none";
        document.getElementById("enlaces").style.display = "none";
        document.getElementById("enlace").required = false;
        document.getElementById("enlace").value = "";
    }
}
// ********************************
$(function() {
    $('input:checkbox').change(function() {
        $('button:submit').prop({
            disabled: $('input:checkbox:checked').length = 0
        });
    });
});
// ******************************************
$(function() {
    $('input:checkbox').change(function() {
        $('.bloquear').prop({
            disabled: $('input:checkbox:checked').length < 2
        });
    });
});


function showdatos() {
    getnombre = document.getElementById("nombre").value;
    getlugar = document.getElementById("lugar").value;
    getagenda = document.getElementById("agenda").value;
    getasunto = document.getElementById("asunto").value;
    getfecha = document.getElementById("fecha").value;
    gettipo = document.getElementById("tipo").value;
    getinicio = document.getElementById("horainicio").value;
    getfinal = document.getElementById("horafinal").value;

    if (getnombre == "" || getlugar == "" || getagenda == "" || getasunto == "" || getfecha == "" || gettipo == "0" || getinicio == "" || getfinal == "") {
        document.getElementById("datosreunion-tab").style.display = "none";
        document.getElementById("archivos-tab").style.display = "none";
    } else {
        document.getElementById("datosreunion-tab").style.display = "block";
        document.getElementById("archivos-tab").style.display = "block";
    }
}



function mayus(e) {
    e.value = e.value.toUpperCase();
}

$(function() {

    $("#clasif").on('change', function() {
        var selectValue = $(this).val();
        switch (selectValue) {

            case "1":
                $("#reu-normal").hide();
                $("#reu-asamblea").hide();
                $( "#chknormal" ).prop( "disabled", true );
                $( "#chk" ).prop( "disabled", true );
                $('input').filter(':checkbox').removeAttr('checked');
                $('button:submit').prop({
                    disabled: $('input:checkbox:checked').length < 2
                });
                break;

            case "2":
               
                $("#reu-normal").hide();
                $( "#chknormal" ).prop( "disabled", true );
                $( "#chk" ).prop( "disabled", false );
                $("#reu-asamblea").show();
                $('input').filter(':checkbox').removeAttr('checked');
                $('button:submit').prop({
                    disabled: $('input:checkbox:checked').length < 2
                });
                break;

            case "3":
                
                $("#chknormal").prop( "disabled", false );
                $("#reu-normal").show();
                $("#reu-asamblea").hide();
                $("#chk").prop( "disabled", true );
                $('input').filter(':checkbox').removeAttr('checked');
                $('button:submit').prop({
                    disabled: $('input:checkbox:checked').length < 2
                });
                break;

        }

    }).change();

});

