<?php
//Define valores de la Base de Datos
define ("HOST","NOMBRE HOST");
define ("DBNAME","NOMBRE BDs");
define ("USR","USUARIO BDs");
define ('PSSWD','PSSWD BDs');
define ("PUERTO","PUERTO BDs");

//Define valores del sitio
define ("NOMBRE_SITIO", "NOMBRE DEL SITIO");
define ("DOMINIO","URL DEL SITIO");

//Establece valores de localización del script
//setlocale(LC_MONETARY,"es_MX");
//setlocale(LC_TIME,"es_MX"); 
setlocale(LC_ALL, 'es_MX.utf8 ');
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");
header('Content-Type: text/html; charset=utf-8' );
//ini_set("log_errors", true);
//ini_set("error_reporting", E_ALL);
//ini_set("error_log", __DIR__ . "/error_log");
//error_log( "Hello, errors!" );
?>