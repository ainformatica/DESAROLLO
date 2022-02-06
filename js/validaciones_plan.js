//FUNCION NO DEJA ESCRIBIR 3 LETRAS IGUEALES
function MismaLetra(id_input) {
  var valor = $("#" + id_input).val();
  var longitud = valor.length;
  //console.log(valor+longitud);
  if (longitud > 2) {
    var str1 = valor.substring(longitud - 3, longitud - 2);
    var str2 = valor.substring(longitud - 2, longitud - 1);
    var str3 = valor.substring(longitud - 1, longitud);
    nuevo_valor = valor.substring(0, longitud - 1);
    if (str1 == str2 && str1 == str3 && str2 == str3) {
      swal("Error", "No se permiten 3 letras consecutivamente", "error");

      $("#" + id_input).val(nuevo_valor);
    }
  }
}
//no permite dobre espacio
function DobleEspacio(campo, event) {
  CadenaaReemplazar = "  ";
  CadenaReemplazo = " ";
  CadenaTexto = campo.value;
  CadenaTextoNueva = CadenaTexto.split(CadenaaReemplazar).join(CadenaReemplazo);
  campo.value = CadenaTextoNueva;
}
//sin espacio
function NoEspacio(campo, event) {
  CadenaaReemplazar = " ";
  CadenaReemplazo = "";
  CadenaTexto = campo.value;
  CadenaTextoNueva = CadenaTexto.split(CadenaaReemplazar).join(CadenaReemplazo);
  campo.value = CadenaTextoNueva;
}
/*==============================================
    =     VALIDACION SOLO LETRAS            =
    ==============================================*/
function sololetras(e) {
  key = e.keyCode || e.wich;

  teclado = String.fromCharCode(key).toUpperCase();

  letras = " ABCDEFGHIJKLMNOPQRSTUVWXYZÑ";

  especiales = "8-37-38-46-164";

  teclado_especial = false;

  for (var i in especiales) {
    if (key == especiales[i]) {
      teclado_especial = true;
      break;
    }
  }

  if (letras.indexOf(teclado) == -1 && !teclado_especial) {
    return false;
  }
}

/*==============================================
    =        VALIDACION SOLO NUMEROS           =
    ==============================================*/
function solonumeros(e) {
  key = e.keyCode || e.wich;

  teclado = String.fromCharCode(key).toUpperCase();

  letras = "1234567890";

  especiales = "8-37-38-46-164";

  teclado_especial = false;

  for (var i in especiales) {
    if (key == especiales[i]) {
      teclado_especial = true;
      break;
    }
  }

  if (letras.indexOf(teclado) == -1 && !teclado_especial) {
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
/*      VALIDAION QUE SOLO PERMITA UN ESPACIO          
  */
    
    function validate(s){
    if (/^(\w+\s?)*\s*$/.test(s)){
      return s.replace(/\s+$/,  '');
    }
    return 'NOT ALLOWED';
    }
    
    