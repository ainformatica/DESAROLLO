
let $Select_charla= document.getElementById('charla'),
  
    $jornada=document.getElementById('jornada'),
    $expositores=document.getElementById('expositores'),
    
    $hora=document.getElementById('hora'),
    $fecha=document.getElementById('fechahora'),
    $tbody=document.getElementById('cuerpo');
 
    

    
$Select_charla.addEventListener('change',(e)=>{
    
    ObtenerDatos($Select_charla.value);
});



function ObtenerDatos(charla) {
    
    fetch('../api/Charla.php?charla='+charla,)
    .then((res)=>{
        //console.log(res);
       return res.json();
    })
    .then(data=>{
       
        // console.log(data);
      
       mostrarDatos(data['charla']);
       
       crear_cuerpo(data['alumnos']);
       
    })
    .catch()

    
}


function mostrarDatos(data) {
  
    $expositores.value=`${data['expositor1']} / ${data['expositor2']}`;
    $jornada.value=data['jornada_charla'];
    $fecha.value=data['fecha_charla'];
    $hora.value=data['hora_charla'];
   
   
   // fecha_valida();

}

function crear_cuerpo(data) {
    
    //console.log(data);
    $tbody.innerHTML="";
    for (let i = 0; i < data.length; i++) {
        const element = data[i];

       
        $tbody.innerHTML=$tbody.innerHTML+
        '<tr>'+
         '<td>'+element['0']+'</td>'+
         '<td>'+element['1']+'</td>'+
         '<td class="text-center">'+
         `<a id="alumno${i}" href="#" class="btn btn-danger" onClick="activar(${element['2']},${i})">
              
         <i id="icono${i}" class="fas fa-user-times"></i>
        
           </a>` +
          '</td>'+
         '<tr>';   
    }
}


function activar(btn,id) {
    $boton= document.getElementById("alumno"+id);
    $icono=document.getElementById("icono"+id)
    clase= $boton.classList.contains('btn-danger');
    if (clase) {
        
        $boton.classList.replace("btn-danger","btn-success");
        $icono.classList.replace("fa-user-times","fa-user-check");
        asiste=1;
        activar2(btn,asiste);

    }else{
        $boton.classList.replace("btn-success","btn-danger");
        $icono.classList.replace("fa-user-check","fa-user-times");
        asiste=0;
        activar2(btn,asiste);


    }
}


function activar2(btn,asiste) {
    fetch('../api/Charla.php?ruby='+btn+'&asiste='+asiste,)
    .then((res)=>{
        //console.log(res);
       return res.json();
    })
    .then(data=>{
       
        console.log(data);
    
       
    })
    .catch()
}






