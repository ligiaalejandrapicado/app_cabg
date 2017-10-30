<?php

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


/* Extrae los valores enviados desde la aplicacion movil */
$ci_sim = $_GET['ci_sim'];
$x = $_GET['x'];



//$ci_sim=preg_replace("/[^0-9]/i","",$ci);



$band=0;
if(empty($ci_sim) ){ $var="*C.I\n"; $band=1;}


$sql = "SELECT * FROM inscripcion a, curso b WHERE  a.ci_ste='$ci_sim' && b.cod_cso=a.cod_cso ORDER BY  a.ci_ste  ";
$rese = $mysqli->query($sql);
$rowe=$rese->num_rows;


/* crea un array con datos arbitrarios que seran enviados de vuelta a la aplicacion */
$resultados = array();
$resultados["hora"] = date("F j, Y, g:i a"); 
$resultados["generador"] = "Enviado desde APP " ;


if($band==1){
	
	$resultados["mensaje"] = "Por favor verificar: \n".$var;
	$resultados["validacion"] = "error";
	
	} else if($band==0){


			if($rowe>0){
				
					$resultados["mensaje"] .= "<table width='90%' border='0' align='center' cellpadding='3' cellspacing='3'>
  <tr>
    <td width='10%' align='center' valign='middle' bgcolor='#FFFFFF'>COD</td>
    <td width='70%' align='center' valign='middle' bgcolor='#FFFFFF'>CURSO, TALLER O DIPLOMADO</td>
    <td width='20%' align='center' valign='middle' bgcolor='#FFFFFF'>INSCRITO</td>
  </tr>
</table>

";
								
					/*CONSULTAR LOS DATOS EN LA BASE DE DATOS*/
					while( $rege=$rese->fetch_array() ){
						
						$resultados["mensaje"] .= "
						
						<table width='90%' border='0' align='center' cellpadding='3' cellspacing='3'>
  <tr>
    <td width='10%' align='center' valign='middle' bgcolor='#FFDFDF'>$rege[0]</td>
    <td width='70%' align='center' valign='middle' bgcolor='#FFDFDF'>$rege[7]</td>
    <td width='20%' align='center' valign='middle' bgcolor='#FFDFDF'>$rege[3]</td>
  </tr>
</table>

						
						
						                         <br>";
						
					}//END WHILE
			
 			}else if($rowe<=0){
				
						$resultados["mensaje"] = "LA C.I ".$ci_sim ." DEL ESTUDIANTE NO POSEE REGISTRO EN NUESTRO SISTEMA \n";
				
				}//END IF MENOR A CERO
	
	$resultados["validacion"] = "ok";

	}// BAND igual a cero

/*convierte los resultados a formato json*/
$resultadosJson = json_encode($resultados);

/*muestra el resultado en un formato que no da problemas de seguridad en browsers */
echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';

?>