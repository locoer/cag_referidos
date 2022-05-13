<?php
ob_start();//ob_start("ob_gzhandler");
function __autoload($class) {
	include "./objs/$class.php";
}
include_once "./config.php";
$sitio = new Sitio;

if ( $usr = $sitio->usuario_activo() ) {
	$campanias = new Campanias();
	if ( isset( $_POST["idCamp"] ) ) {
		if( isset($_POST["accion"]) ){
			switch ( $_POST["accion"] ) {
				case "activar":
					$nuevo_estado_id = 2;
					break;
				case "pausar":
					$nuevo_estado_id = 3;
					break;
				default:
					$nuevo_estado_id = 1;
					break;
			}
			if ( $campanias->cambia_estado($_POST["idCamp"], $nuevo_estado_id) ){
				?>
				<h5>Se hizo el cambio de estado de la campaña, favor de validarlo</h5>
				<?php
			} else {
				?>
				<h5>Algo falló al hacer el cambio de estado...</h5>
				<?php
			}
		}
	}
}

ob_end_flush();
?>