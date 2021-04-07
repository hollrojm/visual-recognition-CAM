<?php
/*
    @author parzibyte.me/blog
   
*/
#print_r('Hola');
$imagenCodificada = file_get_contents("php://input"); //Obtener la imagen
	//dd($imagenCodificada);
	if(strlen($imagenCodificada) <= 0){
	 
	}

//La imagen traerá al inicio data:image/png;base64, cosa que debemos remover
$imagenCodificadaLimpia = str_replace("data:image/png;base64,", "", urldecode($imagenCodificada));

//Venía en base64 pero sólo la codificamos así para que viajara por la red, ahora la decodificamos y
//todo el contenido lo guardamos en un archivo
$imagenDecodificada = base64_decode($imagenCodificadaLimpia);

//Calcular un nombre único
$nombreImagenGuardada = "foto_" . uniqid() . ".png";

//Escribir el archivo
file_put_contents($nombreImagenGuardada, $imagenDecodificada);

//Terminar y regresar el nombre de la foto
//exit($nombreImagenGuardada);
function save_image($nombreImagenGuardada,$name = null){
	
    $API_KEY = '22e8da3a7500b4db5fceb571f55b2c35';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://api.imgbb.com/1/upload?key='.$API_KEY);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	$extension = pathinfo($nombreImagenGuardada['name'],PATHINFO_EXTENSION);
	$file_name = ($name)? $name.'.'.$extension : $nombreImagenGuardada['name'] ;
	$data = array('image' => base64_encode(file_get_contents($nombreImagenGuardada['tmp_name'])), 'name' => $file_name);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	dd($data);
	$result = curl_exec($ch);
    
	if (curl_errno($ch)) {
	    return 'Error:' . curl_error($ch);
	}else{
		return json_decode($result, true);
	}
	curl_close($ch);
	/*
	print_r($result);
	$curl = curl_init();

	$httpheader = ['iam_apikey: 4vyPKa81piMdMQTruEpk0BQqih1Hy3GGgv9mVMCxv_uJ'];
	$url = $result;
	
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETORNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $httpheader);
	$resultado = curl_exec($curl);
	
	print_r($resultado);
	curl_close($ch);
	curl_close($curl);*/
}

if (!empty($_FILES['image'])) {
	$return = save_record_image($_FILES['record_image'],'test');
	echo $return['data']['url'];
}

?>
