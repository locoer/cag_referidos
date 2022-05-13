<?php 
$layout = 1;//1 = por línea | 2 = masonry
$campanias = new Campanias();
if ( $campanas_activas = $campanias->trae_activas() ) {
	$total = count($campanas_activas);
	ob_start();
	if ( $total > 0 ) {
		if ( $layout == 2 ) {
			$cols = 12;
			?>
			<div class="card-columns">
			<?php
		} else {
			$cols = 4;
			?>
			<div>
			<?php
		}
		foreach ( $campanas_activas as $fila => $cont ) {
			$cont["perfil"] = html_entity_decode($cont["perfil"], ENT_QUOTES | ENT_HTML5, "UTF-8");
			?>
				<div class="card mb-2">
					<div class="card-body">
						<h5 class="card-title"><?php echo $cont["nombre_campania"] . " - Vence el " . date("d/M/Y", strtotime($cont["fecha_fin"])); ?></h5>
						<h6 class="card-subtitle mb-2 text-muted"><?php echo $cont["negocio"]; ?></h6>
						<p class="card-text"><?php echo $cont["descripcion"]; ?></p>
						<p class="card-text puntos row">
							<span class="col-md-<?php echo $cols; ?>">Puntos X Referencia: <?php echo $cont["pts_ref"]; ?> pts</span>
							<span class="col-md-<?php echo $cols; ?>">Puntos X Negocio Concretado: <?php echo $cont["pts_nc"]; ?> pts</span>
							<span class="col-md-<?php echo $cols; ?>">Cupones: <?php echo $cont["num_cupones"]; ?></span>
						</p>
						<div class="card-text perfil d-none text-break">
							<span class="h5 d-block font-weight-bold">Perfil:</span>
							<span><?php echo $cont["perfil"]; ?></span>
						</div>
						<p class="card-text row">
							<small class="text-muted col-md-<?php echo $cols; ?>">Creado el <?php echo date("d/M/Y", strtotime($cont["fecha_creado"])); ?></small>
							<small class="text-muted col-md-<?php echo $cols; ?>">Tipo de Campaña: <?php echo $cont["tipo"]; ?></small>
						</p>
						<a href="#" class="card-link detalles">Ver Detalles</a>
						<a href="#" class="card-link referir" data-toggle="modal" data-target="#modal_camps" data-id_camp="<?php echo $cont["id"]; ?>">Referir Amigos</a>
					</div>
				</div>
			<?php
		}
		?>
			</div>
		<?php
	} else {
		?>
		<h3 class="mb-5">No hay Campañas disponibles</h3>
		<?php
	}
	$conts_campanias = ob_get_contents();
	ob_end_clean();
} else {
	$total = 0;
	$conts_campanias = "Error al buscar campañas";
}

if( isset( $_POST["nombre_ref"] ) ) {
	if ( !$usuario = $this->usuario->usuario ) {
		header( "Location: " . DOMINIO . "login" );//manda a login si no está logeado
	}
	if ( isset($_POST["campania_id_ref"]) ) {
		$usuario = $this->usuario;
		$camp_id = $_POST["campania_id_ref"];
		$datos_referido = $_POST;
		if ( $campanias->agrega_referido($usuario, $camp_id, $datos_referido) ) {
			ob_start();
			?>
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>¡Referencia Enviada!</strong> Revisa en tu tablero los avances.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>			
			<?php
			$alert_refs = ob_get_contents();
			ob_end_clean();
		}
	}
}
?>
<!-- Inicia el contenido de la página -->
<main role="main">
	<div class="container-fluid px-0">
		<div class="jumbotron">
			<div class="container">
				<h1 class="display-3">Campañas Activas: <?php echo $total; ?></h1>
				<p>Consulta las campañas activas, invita a tus amigos a conocer productos nuevos de marcas que tú ya has probado y gana recompensas.</p>
				<p><a class="btn btn-primary btn-lg" href="#" role="button">Filtrar campañas »</a></p>
			</div>
		</div>
		<div class="container">
			<?php 
			if ( isset($alert_refs) ) {
				echo $alert_refs;
			}
			?>
			<div class="row content">
				<div class="col">
					<?php echo $conts_campanias; ?>
				</div>
			</div>
		</div>
	</div>
	<!-- Ventana Modal -->
	<div class="modal fade" id="modal_camps" tabindex="-1" role="dialog" aria-labelledby="titulo_modal" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="titulo_modal">Título Modal</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Cancelar">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="forma_ref" action="<?php echo DOMINIO . "campanas" ?>" method="post">
					<div class="modal-body">
						<h4 id="ref_campania">Referir Personas</h4>
						<input type="text" class="d-none form-control" name="campania_id_ref" id="campania_id_ref" />
						<div class="form-group">
							<label for="nombre_ref" class="col-form-label">*Nombre:</label>
							<input type="text" class="form-control" id="nombre_ref" name="nombre_ref" required>
						</div>
						<div class="form-group">
							<label for="apellidos_ref" class="col-form-label">*Apellidos:</label>
							<input type="text" class="form-control" id="apellidos_ref" name="apellidos_ref" required>
						</div>
						<div class="form-group">
							<label for="telefono_ref" class="col-form-label">Teléfono:</label>
							<input type="tel" class="form-control" id="telefono_ref" name="telefono_ref">
						</div>
						<div class="form-group">
							<label for="mail_ref" class="col-form-label">Mail:</label>
							<input type="email" class="form-control" id="mail_ref" name="mail_ref">
						</div>
						<div class="form-group">
							<label for="descripcion_ref" class="col-form-label">*Descripción:</label>
							<textarea class="form-control" id="descripcion_ref" name="descripcion_ref" required></textarea>
						</div>
						<small>Los campos marcados con <b>*</b> son requeridos</small>
					</div>
					<div class="modal-footer">
						<button type="button" id="cancelar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						<input type="submit" id="aceptar" class="btn btn-primary" value="Enviar"/>
					</div>
				</form>
			</div>
		</div>
	</div>
</main>
<script type="text/javascript">
$(document).ready( function(){
	let campanas_activas = <?php echo json_encode($campanas_activas); ?>;
	
	$("a.detalles").click( function(event){
		event.preventDefault();
		var link = $(this);
		var perfil = $(this).siblings(".perfil");
		if ( perfil.hasClass("d-none") ) {
			perfil.removeClass("d-none");
			link.text("Ocultar Detalles");
		} else {
			perfil.addClass("d-none");
			link.text("Ver Detalles");
		}
	});
	
	$("a.referir").click( function(event){
		event.preventDefault();
	});
	
	$("button#cancelar, button.close").click( function(){
		$('#forma_ref').trigger("reset");
	});
	
	$('#modal_camps').on('show.bs.modal', function (event) {
		let boton = $(event.relatedTarget);
		let id_camp = boton.data('id_camp');
		let modal = $(this);
		let nombre_campania = '';
		
		campanas_activas.forEach( function(val, key) {
			if ( id_camp == val.id ) {
				nombre_campania = val.nombre_campania;
			}
		});
		modal.find('.modal-title').text('Referir personas a campaña: ' + nombre_campania);
		modal.find('.modal-body #ref_campania').text('Voy a referir a la campaña: ' + id_camp);
		modal.find('.modal-body #campania_id_ref').val(id_camp);
	});
	let alert = $(".alert.show");
	if ( alert.length > 0 ) {
		setTimeout( function() {
			alert.alert('close');
		},6000);
	}
});
</script>