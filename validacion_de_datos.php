



<?php

/* Define los valores que seran evaluados, en este ejemplo son valores estaticos,
en una verdadera aplicacion generalmente son dinamicos a partir de una base de datos */




/* Extrae los valores enviados desde la aplicacion movil */
$usuarioEnviado = $_GET['usuario'];
$passwordEnviado = $_GET['password'];

define("dbName","colegiod_appmovil");
define("dbUser","colegiod_appmovi"); 
define("dbHost","localhost"); 
define("dbPassw","app1234movil2017");
$mysqli = new mysqli(dbHost, dbUser, dbPassw, dbName);
if ($mysqli->connect_errno) {
	echo "Lo sentimos, este sitio web está experimentando problemas.";
echo "Error: Fallo al conectarse a MySQL debido a: \n";
    echo "Errno: " . $mysqli->connect_errno . "\n";
    echo "Error: " . $mysqli->connect_error . "\n";
     exit;
}

$sql = "SELECT * FROM usuarios WHERE login='$usuarioEnviado'  ORDER BY login ";
$rese = $mysqli->query($sql);
$rowe=$rese->num_rows;



/* crea un array con datos arbitrarios que seran enviados de vuelta a la aplicacion */
$resultados = array();
$resultados["hora"] = date("F j, Y, g:i a"); 
$resultados["generador"] = "Enviado desde APP" ;
if($rowe>0){
	 $rege=$rese->fetch_array();  

/* verifica que el usuario y password concuerden correctamente */
if(  $rege[0] == $usuarioEnviado && $rege[1] == $passwordEnviado){
	/*esta informacion se envia solo si la validacion es correcta */
	$resultados["mensaje"] = "Validacion Correcta";
	$resultados["validacion"] = "ok";
	$resultados["ced"] = $rege[1];
	$_SESSION['ced']=$rege[1];

}}else{
	/*esta informacion se envia si la validacion falla */
	$resultados["mensaje"] = "Usuario y password incorrectos";
	$resultados["validacion"] = "error";
	
}


/*convierte los resultados a formato json*/
$resultadosJson = json_encode($resultados);

/*muestra el resultado en un formato que no da problemas de seguridad en browsers */
echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';

?>