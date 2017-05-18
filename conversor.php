<?php
header('Access-Control-Allow-Origin: *');  
//$apiUrl = 'http://mindicador.cl/api';
//$apiUrl = 'http://api.fixer.io/latest?base=USD';
//Es necesario tener habilitada la directiva allow_url_fopen para usar file_get_contents
if ( ini_get('allow_url_fopen') ) {
    $json = file_get_contents($apiUrl);
} else {
    //De otra forma utilizamos cURL
    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($curl);
    curl_close($curl);
} 

$jsondata = array();

$cantidad = $_GET["cantidad"];
$monedaOrigen = $_GET["monedaOrigen"];
$monedaDestino = $_GET["monedaDestino"];



function conversor_monedas($moneda_origen,$moneda_destino,$cantidad) {
    $get = file_get_contents("https://www.google.com/finance/converter?a=$cantidad&from=$moneda_origen&to=$moneda_destino");
    $get = explode("<span class=bld>",$get);
    $get = explode("</span>",$get[1]);  
    return preg_replace("/[^0-9\.]/", null, $get[0]);
}


$jsondata["result"] = conversor_monedas($monedaOrigen,$monedaDestino,$cantidad);


header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);


 
?>