 
let $solicitud=document.getElementById("solicitudpps"),
$documentacion=document.getElementById("documentacion");

$solicitud.addEventListener('click',(e)=>{
    e.preventDefault();
    $id=document.getElementById("id_estudiante").value;
    ObtenerDatos($id);
 
    
})

$documentacion.addEventListener('click',(e)=>{
    e.preventDefault();
    $id=document.getElementById("id_estudiante").value;
    GetData($id);
 
    
})

//funcion ajax para validar que el alumno ya recibio la charla
function ObtenerDatos(id_alumno) {
    
    fetch('../api/Charla.php?python='+id_alumno,)
    .then((res)=>{
        //console.log(res);
       return res.json();
    })
    .then(data=>{
        if (data != null ) {
            
            console.log(data);
            if (data['charla_impartida']==1 && data['estado_asistencia_charla']==1) {
                // console.log(data['charla_impartida']);
                 window.location = $solicitud.href;
            }else{
                swal({
                    title:"",
                    text:"Estimado Estudiante, actualmente usted ya realizó la solicitud de charla para PPS, pero aún no cumple con el requisito de haber recibido la charla de práctica profesional.",
                    type: "info",
                    showConfirmButton: true
                    
                 });
            }
           
        }else{
            
            swal({
                title:"",
                text:"Estimado Estudiante, recuerda que para realizar la solicitud de PPS es necesario cumplir con el requisito de haber recibido la charla de práctica profesional.",
                type: "info",
                showConfirmButton: true
                
             });
        }
      
       
    })
    .catch()
}

//funcion ajax para validar que el alumno ya solicito la PPS
function GetData(id_alumno) {
    
    fetch('../api/Charla.php?perl='+id_alumno,)
    .then((res)=>{
        //console.log(res);
       return res.json();
    })
    .then(data=>{
        if (data != null) {
            
            window.location = $documentacion.href;
        }else{
            
            swal({
                title:"",
                text:"Estimado Estudiante, recuerda que para realizar la solicitud de PPS es necesario cumplir con el requisito de haber recibido la charla de práctica profesional.",
                type: "info",
                showConfirmButton: true
                
             });
        }
      
       
    })
    .catch()
}