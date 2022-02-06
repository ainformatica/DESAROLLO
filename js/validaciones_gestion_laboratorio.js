
/*=============================================
     VALIDACION QUE SOLO PERMITE LETRAS Y  ACENTOS             
    =============================================*/
function validacion_para_nombre(e) {
  tecla = (document.all) ? e.keyCode : e.which;

  //Tecla de retroceso para borrar, siempre la permite
  if (tecla == 8) {
      return true;
  }

  // Patron de entrada, en este caso solo acepta numeros y letras
  patron = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ_äëïöüÄËÏÖÜàèìòùÀÈÌÒÙ-\s]+$/;
  tecla_final = String.fromCharCode(tecla);
  return patron.test(tecla_final);
}

/*=============================================
     VALIDACION QUE SOLO PERMITE LETRAS Y  ACENTOS Y NÚMEROS             
    =============================================*/
    function validacion_para_nombre_con_numeros(e) {
      tecla = (document.all) ? e.keyCode : e.which;
    
      //Tecla de retroceso para borrar, siempre la permite
      if (tecla == 8) {
          return true;
      }
    
      // Patron de entrada, en este caso solo acepta numeros y letras
      patron = /^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙÑ1234567890\s]+$/;
      tecla_final = String.fromCharCode(tecla);
      return patron.test(tecla_final);
    }


function sonLetrasMayYnumerosSolamente(texto) {
    var regex = /^[A-Z][0-9]+$/;
    return regex.test(texto);
}


/*=============================================
     VALIDACION QUE SOLO PERMITE LETRAS Y  ACENTOS Y NÚMEROS             
    =============================================*/
    function validacion_para_producto(e) {
      tecla = (document.all) ? e.keyCode : e.which;
    
      //Tecla de retroceso para borrar, siempre la permite
      if (tecla == 8) {
          return true;
      }
    
      // Patron de entrada, en este caso solo acepta numeros y letras
      patron = /^[a-zA-ZáéíóúÁÉÍÓÚñäëïöüÄËÏÖÜàèìòùÀÈÌÒÙÑ_0123456789\s]+$/;
      // patron = /^[a-zA-ZáéíóúÁÉÍÓÚñäëïöüÄËÏÖÜàèìòùÀÈÌÒÙÑ1234567890_/-\s]+$/;
      tecla_final = String.fromCharCode(tecla);
      return patron.test(tecla_final);
    }



/*=============================================
     VALIDACION QUE SOLO PERMITE LETRAS Y  ACENTOS Y NÚMEROS             
    =============================================*/
    function validacion_para_numero_inventario(e) {
      tecla = (document.all) ? e.keyCode : e.which;
    
      //Tecla de retroceso para borrar, siempre la permite
      if (tecla == 8) {
          return true;
      }
    
      // Patron de entrada, en este caso solo acepta numeros y letras
      // patron = /^[a-zA-ZáéíóúÁÉÍÓÚñäëïöüÄËÏÖÜàèìòùÀÈÌÒÙÑ_0123456789\s]+$/;
      patron = /^[a-zA-ZáéíóúÁÉÍÓÚñäëïöüÄËÏÖÜàèìòùÀÈÌÒÙÑ1234567890_-\s]+$/;
      tecla_final = String.fromCharCode(tecla);
      return patron.test(tecla_final);
    }






function sonLetrasMayYnumerosSolamente(texto) {
    var regex = /^[A-Z][0-9]+$/;
    return regex.test(texto);
}

/*=============================================
     VALIDACION QUE SOLO PERMITA LETRAS Y NUMEROS             
    =============================================*/
    
    function letrasynumeros1(e){
        
        key=e.keyCode || e.wich;
    
        teclado= String.fromCharCode(key).toUpperCase();
    
        letras= "ABCDEFGHIJKLMNOPQRSTUVWXYZÑ1234567890";
        
        especiales ="8-37-38-46-164";
    
        // teclado_especial=false;
    
        for (var i in especiales) {
          
          if(key==especiales[i]){
            teclado_especial= true;break;
          }
        }
    
        if (letras.indexOf(teclado)==-1) {
          return false;
        }
    
    }

    function validate(s){
        if (/^(\w+\s?)*\s*$/.test(s)){
          return s.replace(/\s+$/,  '');
        }
        return 'NOT ALLOWED';
        }


        function NumText(string){//solo letras y numeros
            var out = '';
            //Se añaden las letras validas
            var filtro = 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890';//Caracteres validos
            
            for (var i=0; i<string.length; i++)
               if (filtro.indexOf(string.charAt(i)) != -1) 
                 out += string.charAt(i);
            return out;
        }
        function DobleEspacio(campo, event) {

            CadenaaReemplazar = "  ";
            CadenaReemplazo = " ";
            CadenaTexto = campo.value;
            CadenaTextoNueva = CadenaTexto.split(CadenaaReemplazar).join(CadenaReemplazo);
            campo.value = CadenaTextoNueva;
          
          }
    
          
           /*==============================================
    =     VALIDACION SOLO LETRAS            =
    ==============================================*/
    function sololetras(e){
        
      key=e.keyCode || e.wich;
  
      teclado= String.fromCharCode(key).toUpperCase();
  
      letras= " ABCDEFGHIJKLMNOPQRSTUVWXYZÑ";
      
      especiales ="8-37-38-46-164";
  
      teclado_especial=false;
  
      for (var i in especiales) {
        
        if(key==especiales[i]){
          teclado_especial= true;break;
        }
      }
  
      if (letras.indexOf(teclado)==-1 && !teclado_especial) {
        return false;
      }
  
  }
  
  /*==============================================
  =        VALIDACION SOLO NUMEROS           =
  ==============================================*/
  function solonumeros(e){
      
      key=e.keyCode || e.wich;
  
      teclado= String.fromCharCode(key).toUpperCase();
  
      letras= "1234567890";
      
      especiales ="8-37-38-46-164";
  
      teclado_especial=false;
  
      for (var i in especiales) {
        
        if(key==especiales[i]){
          teclado_especial= true;break;
        }
      }
  
      if (letras.indexOf(teclado)==-1 && !teclado_especial) {
        return false;
      }
  
  }



   /*=============================================
     VALIDACION QUE SOLO PERMITA LETRAS Y NUMEROS             
    =============================================*/
    
    function letrasynumeros(e){
        
      key=e.keyCode || e.wich;
  
      teclado= String.fromCharCode(key).toUpperCase();
  
      letras= "ABCDEFGHIJKLMNOPQRSTUVWXYZÑ1234567890";
      
      especiales ="8-37-38-46-164";
  
      teclado_especial=false;
  
      for (var i in especiales) {
        
        if(key==especiales[i]){
          teclado_especial= true;break;
        }
      }
  
      if (letras.indexOf(teclado)==-1 && !teclado_especial) {
        return false;
      }
  
  }
  $("input.txt_descripcion").bind('keypress', function(event) {
    var regex = new RegExp("^[a-zA-Z0-9 ]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
      event.preventDefault();
      return false;
   }
  });


  function salir(){
    console.log('d');

  }
  function myFunction() {
  if(confirm("Desea guardar los datos?")){
    alert("Datos guardados exitosamente");
  }else{
    alert("Usted cancelo la acción para guardar");
  }
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
			swal('Error', 'No se permiten 3 letras consecutivamente', 'error');

			$('#' + id_input).val(nuevo_valor);
		}
	}
}





/*=============================================
     VALIDACION QUE SOLO PERMITA LETRAS Y NUMEROS Y ESPACIO             
                =============================================*/
    
    function numerosletrasyespacio(e){
        
      key=e.keyCode || e.wich;
  
      teclado= String.fromCharCode(key).toUpperCase();
  
      letras= " ABCDEFGHIJKLMNOPQRSTUVWXYZÑ1234567890";
      
      especiales ="8-37-38-46-164";
  
      teclado_especial=false;
  
      for (var i in especiales) {
        
        if(key==especiales[i]){
          teclado_especial= true;break;
        }
      }
  
      if (letras.indexOf(teclado)==-1 && !teclado_especial) {
        return false;
      }
  
  }
  
  /*=====  End of Section comment block  ======*/
function validar(){
  var expresion = /^[a-z][\w.-]+@\w[\w.-]+\.[\w.-]*[a-z][a-z]$/i;
var email = document.form1.email.value;
if (!expresion.test(email)){
    todo_correcto = false;
}


}

/*=============================================
     VALIDACION DE AJAX            
                =============================================*/

$('.FormularioAjax2').submit(function(e){
  e.preventDefault();

 var form=$(this);

 var tipo=form.attr('data-form');
 var accion=form.attr('action');
 var metodo=form.attr('method');
 var respuesta=form.children('.RespuestaAjax2');

 var msjError="<script>swal('Ocurrió un error inesperado','Por favor recargue la página','error');</script>";
 var formdata = new FormData(this);


 var textoAlerta;
 if(tipo==="save"){
     textoAlerta="Los datos que enviaras quedaran almacenados en el sistema";
 }else if(tipo==="delete"){
     textoAlerta="Los datos serán eliminados completamente del sistema";
 }else if(tipo==="update"){
     textoAlerta="Los datos del sistema serán actualizados";
 }else if(tipo==="liquidar"){
     textoAlerta="Los datos seran liquidados completamente";
 }


 swal({
     
        
     text: textoAlerta,   
      
        
     
     

     
 }).then(function () {
     $.ajax({
         type: metodo,
         url: accion,
         data: formdata ? formdata : form.serialize(),
         cache: false,
         contentType: false,
         processData: false,
         xhr: function(){
             var xhr = new window.XMLHttpRequest();
             xhr.upload.addEventListener("progress", function(evt) {
               if (evt.lengthComputable) {
                 var percentComplete = evt.loaded / evt.total;
                 percentComplete = parseInt(percentComplete * 100);
                 if(percentComplete<100){
                     respuesta.html('<p class="text-center">Procesado... ('+percentComplete+'%)</p><div class="progress progress-striped active"><div class="progress-bar progress-bar-info" style="width: '+percentComplete+'%;"></div></div>');
                 }else{
                     respuesta.html('<p class="text-center"></p>');
                 }
               }
             }, false);
             return xhr;
         },
         success: function (data) {
             respuesta.html(data);
         },
         error: function() {
             respuesta.html(msjError);
         }
     });
     return false;
 });

});


$(document).ready(function() {
  $('#cmb_tipoproducto').change(function(e) {
    if ($(this).val() === "1") {
      $('#stock').prop("readonly", true);
      $('#stock').prop("value", "");
    } else {
      $('#stock').prop("readonly", false);
    }
  })
});

$(document).ready(function() {
  $('#cmb_tipoproducto2').change(function(e) {
    if ($(this).val() === "1") {
      $('#stock').prop("readonly", true);
      $('#stock').prop("value", "");
    } else {
      $('#stock').prop("readonly", false);
    }
  })
});




$(document).ready(function() {
  var f = new Date();
  var dd = (f.getDate() < 10 ? '0' : '') + f.getDate(); 
                       
  var MM = ((f.getMonth() + 1) < 10 ? '0' : '') + (f.getMonth() + 1);

  var fecha=(f.getFullYear()+ "-" + MM + "-" + dd );

  return $('#fecha_salida').val(fecha);
});

// window.onload = function(){
//   var fecha = new Date(); //Fecha actual
//   var mes = fecha.getMonth()+1; //obteniendo mes
//   var dia = fecha.getDate(); //obteniendo dia
//   var ano = fecha.getFullYear(); //obteniendo año
//   if(dia<10)
//     dia='0'+dia; //agrega cero si el menor de 10
//   if(mes<10)
//     mes='0'+mes //agrega cero si el menor de 10
//   document.getElementById('fechaActual').value=ano+"-"+mes+"-"+dia;
// }



// <script type="text/javascript">

// var hoy = new Date();
// fecha = hoy.getDate() + '-' + ( 
// var date = new Date();

// var day = date.getDate();
// var month = date.getMonth() + 1;
// var year = date.getFullYear();

// if (month < 10) month = "0" + month;
// if (day < 10) day = "0" + day;

// var today = year + "-" + month + "-" + day;       
// document.getElementById("theDate").value = today;


//  </script>

// $(document).ready(function() {
//   var fecha = new Date();
//   var anio = fecha.getFullYear();
//   var dia = fecha.getDate();
//   var _mes = fecha.getMonth(); //viene con valores de 0 al 11
//   _mes = _mes + 1; //ahora lo tienes de 1 al 12
//   if (_mes < 10) //ahora le agregas un 0 para el formato date
//   {
//     var mes = "0" + _mes;
//   } else {
//     var mes = _mes.toString;
//   }
  
//   let fecha_minimo = anio + '-' + mes + '-' + dia; // Nueva variable
  
//   document.getElementById("fechaActual").setAttribute('max',fecha_minimo);
// });