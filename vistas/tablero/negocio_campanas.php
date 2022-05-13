<?php
$usr_info = $this->usuario->info();
if ( isset( $_POST["nombre_campana"] ) && count($_POST) > 0 ) {
	if ( isset( $_POST["perfil_campana"] ) ) {
		$_POST["perfil_campana"] = htmlentities($_POST["perfil_campana"], ENT_QUOTES | ENT_HTML5);
		$datos = $_POST;
		$datos["usuario_id"] = $usr_info["id_bds"];
		$datos["negocio_id"] = $usr_info["negocio_id"];
		if ( $cups = preg_grep("/cupon[0-9]+/", array_keys($datos)) ) {
			$datos["cupones"] = array();
			foreach ( $cups as $key => $val ) {
				$datos["cupones"][] = $datos[$val];
			}
		}
		$campanias->crea_campania($datos);
	}
}
$campanias_por_negocio = $campanias->campanias_por_negocio($this->usuario);
$tipos = $campanias->trae_tipos();
$cupones = new Cupones($this->usuario);

?>
<!--Contenido de Campañas por negocio-->
<div class="col-sm-12 mb-5">
	<div id="cont_boton_campnueva">
		<h3>¡Crea una campaña nueva!</h3>
		<button class="btn btn-primary" type="button" id="crear_campania">Nueva Campaña<i class="far fa-paper-plane ml-2"></i></button>
	</div>
	<div id="cont_forma_campana_nueva" class="d-none mt-5">
		<form id="forma_campana_nueva" method="post" action="<?php echo DOMINIO . "miperfil" ?>">
			<div class="form-row">
				<div class="form-group col-sm-6">
					<!--Input de Tipo de Campaña-->
					<div class="row pb-1">
						<label class="col-md-4" for="tipo">Tipo de Campaña</label>
						<div class="col-md-8">
							<div class="input-group">
								<div class="input-group-prepend">
									<label class="input-group-text" for="inputGroupSelect01">Tipos</label>
								</div>
								<select class="custom-select" id="tipo" name="tipo_campana" aria-describedby="tipoHelp" required>
									<option selected>Escoge un tipo...</option>
									<?php
									foreach ( $tipos as $tipo ){
									?>
										<option value="<?php echo $tipo["id"] ?>"><?php echo $tipo["tipo"] ?></option>
									<?php
									}
									?>
								</select>
							</div>
							<small id="tipoHelp" class="form-text text-muted mb-2">Escoge el tipo de campaña que deseas crear</small>
						</div>
					</div>
					<!--Input de Nombre Campaña-->
					<div class="row pb-1">
						<label class="col-md-4" for="campana">Nombre de Campaña</label>
						<div class="col-md-8">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="far fa-user"></i></div>
								</div>
								<input type="text" class="form-control" id="campana" name="nombre_campana" aria-describedby="campanaHelp" placeholder="Mi Campaña de Afiliados" required>
							</div>
							<small id="campanaHelp" class="form-text text-muted mb-2">Escoge el nombre que mejor describa a tu campaña</small>
						</div>
					</div>
					<!--Input de Descripción Campaña-->
					<div class="row pb-1">
						<label class="col-md-4" for="descripcion">Descripción de Campaña</label>
						<div class="col-md-8">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="far fa-user"></i></div>
								</div>
								<input type="text" class="form-control" id="descripcion" name="descripcion_campana" aria-describedby="descripcionHelp" placeholder="Descripción de mi Campaña de Afiliados" required>
							</div>
							<small id="descripcionHelp" class="form-text text-muted mb-2">Escribe lo que mejor describa tu campaña</small>
						</div>
					</div>
					<!--Input de Puntos por Referencia-->
					<div class="row pb-1">
						<label class="col-md-4" for="puntosxref">Puntos por Referencia</label>
						<div class="col-md-8">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="far fa-user"></i></div>
								</div>
								<input type="number" class="form-control" id="puntosxref" name="puntosxref_campana" aria-describedby="puntosxrefHelp" placeholder="100" min="0" step="1" required>
								<div class="input-group-append">
									<div class="input-group-text">puntos</div>
								</div>
							</div>
							<small id="puntosxrefHelp" class="form-text text-muted mb-2">Ingresa los puntos que ofreces por Referido</small>
						</div>
					</div>
					<!--Input de Puntos por Negocio Concretado-->
					<div class="row pb-1">
						<label class="col-md-4" for="puntosxnc">Puntos por Negocio Concretado</label>
						<div class="col-md-8">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="far fa-user"></i></div>
								</div>
								<input type="number" class="form-control" id="puntosxnc" name="puntosxnc_campana" aria-describedby="puntosxncHelp" placeholder="100" min="0" step="1" required>
								<div class="input-group-append">
									<div class="input-group-text">puntos</div>
								</div>
							</div>
							<small id="puntosxncHelp" class="form-text text-muted mb-2">Ingresa los puntos que ofreces por Negocio Concretado</small>
						</div>
					</div>
					<!--Input de Fecha de Fin de campaña-->
					<div class="row pb-1">
						<label class="col-md-4" for="fechafin">Fecha de Fin de Campaña</label>
						<div class="col-md-8">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="far fa-user"></i></div>
								</div>
								<input type="date" class="form-control" id="fechafin" name="fechafin_campana" aria-describedby="fechafinHelp" min="<?php echo date("Y-m-d", strtotime("+1 day") );?>" required>
								<div class="input-group-append">
									<div class="input-group-text"><i class="far fa-calendar"></i></div>
								</div>
							</div>
							<small id="fechafinHelp" class="form-text text-muted mb-2">Ingresa la fecha de fin para tu campaña</small>
						</div>
					</div>
					<!--Input de Límite de Puntos por Campaña-->
					<div class="row pb-1">
						<label class="col-md-4" for="limite_puntos">Puntos asignados a campaña</label>
						<div class="col-md-8">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="far fa-user"></i></div>
								</div>
								<input type="number" class="form-control" id="limite_puntos" name="limite_puntos_campana" aria-describedby="limite_puntosHelp" placeholder="1000" min="0" step="1" required>
								<div class="input-group-append">
									<div class="input-group-text">puntos</div>
								</div>
							</div>
							<small id="limite_puntosHelp" class="form-text text-muted mb-2">Ingresa el máximo de puntos que puede consumir esta campaña</small>
						</div>
					</div>
					<!--Input de Límite de Puntos por Día-->
					<div class="row pb-1">
						<label class="col-md-4" for="limitexdia_puntos">Consumo máximo de puntos por día</label>
						<div class="col-md-8">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="far fa-user"></i></div>
								</div>
								<input type="number" class="form-control" id="limitexdia_puntos" name="limitexdia_puntos_campana" aria-describedby="limitexdia_puntosHelp" placeholder="1000" min="0" step="1" required>
								<div class="input-group-append">
									<div class="input-group-text">puntos</div>
								</div>
							</div>
							<small id="limitexdia_puntosHelp" class="form-text text-muted mb-2">Ingresa el máximo diario de puntos que puede consumir esta campaña</small>
						</div>
					</div>
					<?php
					if ( $cupones_negocio = $cupones->trae_cupones_negocio () ) {
					?>
					<!--Asignación de cupones a campaña-->
					<div class="row pb-1">
						<label class="col-md-4" for="cupones">Asigna cupones a tu campaña</label>
						<div class="col-md-8">
					<?php
						foreach( $cupones_negocio as $fila => $cupon ) {
						?>
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="<?php echo "cupon{$cupon["id"]}"; ?>" value="<?php echo $cupon["id"]; ?>" id="<?php echo "Cupon{$cupon["id"]}"; ?>">
								<label class="form-check-label" for="<?php echo "Cupon{$cupon["id"]}"; ?>">
								<?php echo $cupon["nombre"]; ?>
								</label>
							</div>
						<?php
						}
					}
					?>
						</div>
					</div>
				</div>
				<div class="form-group col-sm-6">
				<!--Input de Perfil a buscar-->
					<div class="row pb-1">
						<label class="col-md-12" for="perfil">Describe el perfil</label>
						<div class="col-md-12">
							<div class="input-group">
								<!--<div class="input-group-prepend">
									<div class="input-group-text"><i class="far fa-user"></i></div>
								</div>-->
								<textarea id="perfil" class="form-control" name="perfil_campana" aria-describedby="perfilHelp" placeholder="Descripción del perfil de personas que busco conseguir con mi Campaña de Afiliados..."></textarea>
							</div>
							<small id="perfilHelp" class="form-text text-muted mb-2">Escoge el nombre que mejor describa a tu campaña</small>
						</div>
					</div>
				</div>
				<!--Inputs de submit, reset y cancelar-->
				<div class="form-group col-md-2">
					<div class="input-group">
						<input class="btn btn-success" type="submit" value="Crear Campaña &#10003;" />
					</div>
				</div>
				<div class="form-group col-sm-2">
					<div class="input-group">
						<input class="btn btn-warning ml-5" type="reset" value="Borrar Datos &times;" />
					</div>
				</div>
				<div class="form-group col-sm-2">
					<div class="input-group">
						<button id="cancelar_campnueva" class="btn btn-danger ml-5" type="button">Cancelar <i class="fas fa-undo-alt"></i></button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="col-sm-12">
<?php
if( !$campanias_por_negocio ) {
	?>
	<h3 class="mb-3">No hay campañas registradas...</h3>
	<?php
} else {
	//print_r ($campanias_por_negocio);
	?>
	<h3 class="mb-3">Campañas registradas:</h3>
	<div class="table-responsive-sm table-sm">
		<table class="table table-striped">
			<thead class="thead-light">
				<tr class="text-center">
					<th scope="col">#</th>
					<th scope="col">Tipo</th>
					<th scope="col">Campaña</th>
					<th scope="col" colspan="2">Descripción</th>
					<th scope="col">Puntos X Referencia</th>
					<th scope="col">Puntos X Negocio Concretado</th>
					<th scope="col">Cupones asignados</th>
					<th scope="col">Estado</th>
					<th scope="col">Fecha de creación</th>
					<th scope="col">Fecha de fin</th>
					<th scope="col">Creada por</th>
					<th scope="col">Acciones</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$num = 1;
			foreach( $campanias_por_negocio as $var => $valor ) {
				?>
				<tr class="text-center">
					<th scope="row"><?php echo $num; ?></th>
					<td><?php echo $valor["tipo"]; ?></td>
					<td><?php echo $valor["nombre_campania"]; ?></td>
					<td><?php echo $valor["descripcion"]; ?></td>
					<td>Ver Perfil</td>
					<td><?php echo $valor["pts_ref"]; ?></td>
					<td><?php echo $valor["pts_nc"]; ?></td>
					<td><?php echo $valor["num_cupones"]; ?></td>
					<td><?php echo $valor["estado"]; ?></td>
					<td><?php echo date("d/M/Y", strtotime($valor["fecha_creado"])); ?></td>
					<td><?php echo date("d/M/Y", strtotime($valor["fecha_fin"])); ?></td>
					<td><?php echo $valor["nombre_completo"]; ?></td>
					<td>
						<div class="btn-group" role="group" aria-label="Edición Campañas">
					<?php 
					switch ( $valor["id_estado"] ) {
						case 1: //estado: borrador
						?>
						<button class="btn btn-link activar" type="button" data-toggle="modal" data-target="#modal_perfil" data-id_camp="<?php echo $valor["id"]; ?>" data-accion="activar"><i class="far fa-play-circle"></i></button>
						<button class="btn btn-link editar" type="button"><i class="fas fa-pencil-alt"></i></button>
						<button class="btn btn-link borrar" type="button"><i class="far fa-trash-alt"></i></button>
						<?php
						break;
						case 2: //estado: activa
						?>
						<button class="btn btn-link pausar" type="button" data-toggle="modal" data-target="#modal_perfil" data-id_camp="<?php echo $valor["id"]; ?>" data-accion="pausar"><i class="far fa-pause-circle"></i></button>
						<button class="btn btn-link stats" type="button"><i class="fas fa-chart-line"></i></button>
						<?php
						break;
						case 3: //estado: pausada
						?>
						<button class="btn btn-link reactivar" type="button" data-toggle="modal" data-target="#modal_perfil" data-id_camp="<?php echo $valor["id"]; ?>" data-accion="activar"><i class="far fa-play-circle"></i></button>
						<button class="btn btn-link stats" type="button"><i class="fas fa-chart-line"></i></button>
						<?php
						break;
						case 4: //estado: completada
						?>
						<button class="btn btn-link stats" type="button"><i class="fas fa-chart-line"></i></button>
						<?php
						break;
						case 5: //estado: sin fondos
						?>
						<button class="btn btn-link fondear" type="button"><i class="fas fa-piggy-bank"></i></button>
						<button class="btn btn-link stats" type="button"><i class="fas fa-chart-line"></i></button>
						<?php
						break;
						case 6: //estado: Cancelada
						break;
						default:
						break;
					}
					?>
						</div>
					</td>
				</tr>
				<?php
				$num ++;
			}
			?>
			</tbody>
		</table>
	</div>
	<?php
}
?>
</div>
<script type="text/javascript">
$(document).ready( function(){
	let campanias_por_negocio = <?php echo json_encode($campanias_por_negocio); ?>;
	let url_ajax = <?php echo "'" . DOMINIO . "ajax.php'"; ?>;
	$('textarea#perfil').tinymce({    
	menubar: false,
	height: 550,
	toolbar_drawer: 'sliding',
	branding: false,
	language: 'es_MX',
	plugins: 'lists, advlist, fullscreen',
	toolbar: 'undo redo | styleselect | alignleft aligncenter alignright alignjustify| bold italic underline strikethrough | bullist numlist | indent outdent | fullscreen'
	});
	let tipos = <?php echo json_encode($tipos); ?>;
	$("select#tipo").change( function(){
		let val = $(this).val() - 1;
		if ( isNaN(val) ) {
			$("#tipoHelp").text("Escoge el tipo de campaña que deseas crear");
		} else {
			let descr = tipos[val].descripcion;
			$("#tipoHelp").text(descr);
		}
	});
	$("button#crear_campania").click( function (){
		if ( $("div#cont_forma_campana_nueva").hasClass("d-none") ) {
			$("div#cont_forma_campana_nueva").removeClass("d-none");
			$("#crear_campania").addClass("d-none");
		}
	});
	$("button#cancelar_campnueva").click( function (){
		if ( !$("div#cont_forma_campana_nueva").hasClass("d-none") ) {
			$("div#cont_forma_campana_nueva").addClass("d-none");
			$("#crear_campania").removeClass("d-none");
		}
	});
	//Acción de las ventanas modales
	$('#modal_perfil').on('show.bs.modal', function (event) {
		let boton = $(event.relatedTarget); // Button that triggered the modal
		let id_camp = boton.data('id_camp'); // Extract info from data-* attributes
		let accion_btn = boton.data('accion');
		let modal = $(this);
		let campana = {};
		let titulo = '';
		let contenido = '';
		let txt_boton = '';
		campanias_por_negocio.forEach( function(item, index) {
			if( item.id == id_camp ) {
				campana.id = item.id;
				campana.nombre = item.nombre_campania;
			}
		});
		switch ( accion_btn ) {
			case 'activar':
			titulo = 'Activación de Campaña'
			contenido = '<p>Se activará la campaña: <br><b>' + campana.nombre + '</b><br><br>¿Deseas continuar?</p>';
			txt_boton = 'Activar';
			break;
			case 'pausar':
			titulo = 'Detener Campaña'
			contenido = '<p>Se detendrá la campaña: <br><b>' + campana.nombre + '</b><br><br>¿Deseas continuar?</p><small>Podrás reactivarla después</small>';
			txt_boton = 'Pausar';
			break;
		}
		modal.find('.modal-title').text(titulo);
		modal.find('.modal-body').html(contenido);
		modal.find('button#aceptar').text(txt_boton).click( function(){
			$(this).addClass('d-none');
			modal.find('button#cancelar').addClass('d-none');
			$.ajax({
				method: "POST",
				url: url_ajax,
				data: { idCamp: campana.id, accion: accion_btn },
				dataType: "html"
			}).done(function( cont ) {
				modal.find('button#cancelar').text('Cerrar').removeClass('d-none');
				modal.find('.modal-body').html(cont);
			}).fail( function(jqXHR, textStatus){
				alert("Algo falló al mandar la info: " + textStatus);
			});
		});
	});
});
</script>