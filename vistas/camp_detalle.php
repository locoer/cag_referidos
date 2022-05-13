<?php 
if ( isset($_GET["vista"]) ) {
	$vista = htmlspecialchars($_GET["vista"]);
	$vista = preg_replace("/[^A-Za-z0-9\/]/", "", $vista);
	$vista = explode("/", $vista);
	echo "<h1>Ver campaña con ID: {$vista[1]}</h1>";
}
?>