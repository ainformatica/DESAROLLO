
let $Select_charla= document.getElementById('charla'),

    $jornada=document.getElementById('jornada'),
    $expositores=document.getElementById('expositores'),
    $constancia=document.getElementById('constancia_charla'),
    $hora=document.getElementById('hora'),
    $fecha_valida=document.getElementById('fecha_valida'),
    $fecha=document.getElementById('fechahora');
    
 
    

    
$Select_charla.addEventListener('change',(e)=>{
    
    ObtenerDatos($Select_charla.value);
});



function ObtenerDatos(charla_id) {
    
    fetch('../api/Charla.php?id='+charla_id,)
    .then((res)=>{
        //console.log(res);
       return res.json();
    })
    .then(data=>{
        //console.log(data["cupos"]);
        if (data["cupos"]==0) {
       
         swal({
            title:"Control de Cupos",
            text:"Charla con cupos agotados.",
            type: "info",
            showConfirmButton: true,
            
         }); 
         mostrarDatos(data);
        }else{

            mostrarDatos(data);
        }
      
    })
    .catch()

    
}


function mostrarDatos(data) {
    let Matutina=(data[0]['contador']),
        Vespertina=(data[1]['contador']);
    $expositores.value=`${data['expositor1']} / ${data['expositor2']}`;
    $jornada.value=data['jornada_charla'];
    $fecha.value=data['fecha_charla'];
    $hora.value=data['hora_charla'];
    $fecha_valida.value=data['fecha_valida'];
   
    data['jornada_charla']=='MATUTINA' ? $constancia.value=Matutina : $constancia.value=Vespertina ;
   // fecha_valida();

}





