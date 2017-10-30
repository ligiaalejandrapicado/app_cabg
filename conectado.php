<?php 

/*define("dbName","mundoatl_soltaxi");
define("dbUser","mundoatl_soltaxi"); 
define("dbHost","localhost"); 
define("dbPassw","sol1234taxi");
$DB = mysql_connect(dbHost, dbUser, dbPassw) or die(mysql_error());
mysql_select_db(dbName);




define("dbName","ad_control");
define("dbUser","root"); 
define("dbHost","localhost"); 
define("dbPassw","123456");
$DB = mysql_connect(dbHost, dbUser, dbPassw) or die(mysql_error());
mysql_select_db(dbName,$DB); */





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
?>
