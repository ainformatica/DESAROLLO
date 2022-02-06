
document.addEventListener("DOMContentLoaded", function(){
 // alert ('me ejecuto cuando la pagina carga');
 fecha_inicio();
 
});

let $dataEmpresa= document.getElementById('frmempresa'),
    $datapractica= document.getElementById('frmPractica');
let $cb_trabaja= document.getElementById('trabaja_institucion');

$cb_trabaja.addEventListener('change',(e)=>{
    let $cargo= document.getElementById('cargo_trabaja'),
    $fechaIngreso= document.getElementById('fechaIngreso'),
    $lb_cargo=document.getElementById('lb_cargo'),
    $lb_fecha=document.getElementById('lb_fechaingreso');

    if ($cb_trabaja.value==1) {
        $cargo.classList.remove('d-none');
        $fechaIngreso.classList.remove('d-none');
        $lb_fecha.classList.remove('d-none');
        $lb_cargo.classList.remove('d-none');
    }else{
        $fechaIngreso.value="2022-01-24";
        $cargo.classList.add('d-none');
        $fechaIngreso.classList.add('d-none');
        $lb_fecha.classList.add('d-none');
        $lb_cargo.classList.add('d-none');

    }
   
})

function informacion(id) {

    if(id.id==1){
        swal({
            title:"Croquis",
            text:"Croquis válido, solo los de Google Earth o Maps.",
            type: "info",
            showConfirmButton: true
            
         });
    }else{
        swal({
            title:"Perfil de institución",
            text:"Perfil de la empresa (breve reseña histórica, misión, visión, valores institucionales).",
            type: "info",
            showConfirmButton: true
            
         });
    }
}

/** VALIDAR LA FECHA DE INICIO EL DIA DE HOY + 8 DIAS */

function fecha_inicio() {
   let $fechaInicial= document.getElementById('fecha_inicio');
   fecha= new Date();
  anio= fecha.getFullYear();
   mes= fecha.getMonth() +1;
   dia= fecha.getDate();
   valido= `${anio}-${mes}-${dia+12}`;
   if (dia>=20) {

    valido= `${anio}-${mes+1}-${dia+7}`;
    
    $fechaInicial.setAttribute('Min',valido);       
   }
   $fechaInicial.setAttribute('Min',valido);    
    
}

// peticiones ajax con fecth() para insertar 

$dataEmpresa.addEventListener('submit', (e)=>{
    e.preventDefault()
    let data = new FormData(frmempresa);
    fetch('../api/registrar_empresa.php',{
        method: 'POST',
        body:data
    })
    .then(respuesta=> respuesta.json())
    .then(datos=>{
        res= datos['Status'];
        if (res==100) {
            
            swal({
                title:"",
                text:"Ya tiene empresa registrada",
                type: "success",
                allowOutsideClick:false,
                showConfirmButton: true,
                }).then(function () {
                
                    siguienteTabs();
                });
               
        }else{

            swal({
                title:"",
                text:"Solicitud enviada...",
                type: "success",
                allowOutsideClick:false,
                showConfirmButton: true,
                }).then(function () {
                
                    siguienteTabs();
                });
            console.log(datos);
        }
    })
})

$datapractica.addEventListener('submit',(e)=>{
    e.preventDefault()
    let data = new FormData(frmPractica); 
    fetch('../api/registrar_empresa.php',{
        method: 'POST',
        body:data
    })
    .then(respuesta=> respuesta.json())
    .then(datos=>{
        res= datos['Status'];
        console.log(datos);
        if (res==100) {
            
            swal({
                title:"",
                text:"Ya tiene práctica registrada",
                type: "info",
                allowOutsideClick:false,
                showConfirmButton: true,
                }).then(function () {
                
                    window.location.href = "menu_estudiantes_practica_vista.php";
                });
               
        }else{

            swal({
                title:"",
                text:"Solicitud enviada...",
                type: "success",
                allowOutsideClick:false,
                showConfirmButton: true,
                }).then(function () {
                    window.location.href = "menu_estudiantes_practica_vista.php";
                   
                });
         
        }

       
    }) 
})

function siguienteTabs() {
    let tab= document.getElementById('tab3').click();
  
}

// let cancelar = document.getElementById('btn_salir');

// cancelar.addEventListener("click",(e)=>{
//     siguienteTabs();
// })




