<?php 
//peticion get
//$ch = curl_init();
//curl_setopt($ch,CURLOPT_URL,'URL');
//curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
//$response = curl_exec($ch);

//if (curl_errno($ch)) echo curl_error($ch);
//else $decoded = json_decode($response, true);
//var_dump($decoded);

//curl_close($ch);
if(!isset($_SESSION)){ 
     session_start();
}
     ob_start();
//peticion post
function consumoApi($url, $datos){
        $ch = curl_init();     
$data = json_encode($datos);
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_POST,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type:application/json'));
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
$response = curl_exec($ch);
if (curl_errno($ch)){
     echo curl_error($ch);
}else{
     $decoded = json_decode($response, true);
}
curl_close($ch);
return $decoded;
    

}
ob_end_flush();



//peticion put o patch
// $ch = curl_init();
// $array = [ 'name' => 'carlos',
//             'job' => 'programmer'
// ];
// $data = http_build_query($array);
// curl_setopt($ch,CURLOPT_URL,'URL');
// curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'PUT');
// curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
// curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
// $response = curl_exec($ch);
// if (curl_errno($ch)) echo curl_error($ch);
// else $decoded = json_decode($response, true);

// foreach($decoded as $index => $value){
//     echo "$index: $value";
// }

// curl_close($ch);
?>