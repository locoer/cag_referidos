<?php
$cupones = new Cupones($this->usuario);
if( isset($_POST["nombre_cupon"]) ) {
	$datos = $_POST;
	$cupones->crea_cupon($datos);
}
$cupones_por_negocio = $cupones->trae_cupones_negocio();
$tipos_cupones = $cupones->trae_tipos();
?>
<!--Contenido de Campañas por negocio-->
<div class="col-sm-12 mb-5">
	<div id="cont_boton_nuevocupon">
		<h3>¡Crea un cupón para tus futuros clientes!</h3>
		<button class="btn btn-primary" type="button" id="crear_cupon">Nuevo Cupón<i class="far fa-paper-plane ml-2"></i></button>
	</div>
	<div id="cont_forma_nuevo_cupon" class="mt-5 d-none">
		<form id="forma_nuevo_cupon" method="post" action="<?php echo DOMINIO . "miperfil" ?>">
			<div class="form-row">
				<div class="form-group col-sm-6">
					<!--Input de Tipo de Cupón-->
					<div class="row pb-1">
						<label class="col-md-4" for="tipo_cupon">Tipo de Cupón</label>
						<div class="col-md-8">
							<div class="input-group">
								<div class="input-group-prepend">
									<label class="input-group-text" for="tipo_cupon">Tipos</label>
								</div>
								<select class="custom-select" id="tipo_cupon" name="tipo_cupon" aria-describedby="tipo_cuponHelp" required>
									<option selected>Escoge un tipo...</option>
									<?php
									foreach ( $tipos_cupones as $tipo ){
									?>
										<option value="<?php echo $tipo["id"] ?>"><?php echo $tipo["tipo"] ?></option>
									<?php
									}
									?>
								</select>
							</div>
							<small id="tipo_cuponHelp" class="form-text text-muted mb-2">Escoge el tipo de cupón que deseas crear</small>
						</div>
					</div>
					<!--Input de Nombre Cupón-->
					<div class="row pb-1">
						<label class="col-md-4" for="cupon">Nombre de Cupón</label>
						<div class="col-md-8">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="far fa-user"></i></div>
								</div>
								<input type="text" class="form-control" id="cupon" name="nombre_cupon" aria-describedby="cuponHelp" placeholder="Mi Cupón de Descuento" required>
							</div>
							<small id="cuponHelp" class="form-text text-muted mb-2">Escoge el nombre que mejor describa a tu cupón</small>
						</div>
					</div>
					<!--Input de Descuento del cupón-->
					<div class="row pb-1">
						<label class="col-md-4" for="descuento">Monto de Descuento</label>
						<div class="col-md-8">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="far fa-user"></i></div>
								</div>
								<input type="number" class="form-control" id="descuento" name="descuento_cupon" aria-describedby="descuentoHelp" placeholder="10" min="0" max="100" step="1" required>
								<div class="input-group-append">
									<div class="input-group-text"><i class="fas fa-percent"></i></div>
								</div>
							</div>
							<small id="descuentoHelp" class="form-text text-muted mb-2">Ingresa el porcentaje de descuento del cupón</small>
						</div>
					</div>
					<!--Input de días de vigencia-->
					<div class="row pb-1">
						<label class="col-md-4" for="vigencia">Vigencia del cupón</label>
						<div class="col-md-8">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="far fa-user"></i></div>
								</div>
								<input type="number" class="form-control" id="vigencia" name="vigencia_cupon" aria-describedby="vigenciaHelp" placeholder="30" min="0" step="1" max="365" required>
								<div class="input-group-append">
									<div class="input-group-text">días</div>
								</div>
							</div>
							<small id="vigenciaHelp" class="form-text text-muted mb-2">Ingresa los días de vigencia que tendrá el cupón después de haberse enviado</small>
						</div>
					</div>
				</div>
				<div class="form-group col-sm-6">
				</div>
				<div class="form-group col-sm-6">
					<!--Inputs de submit y reset-->
					<div class="input-group">
						<input class="btn btn-success" type="submit" value="Crear Cupón &#10003;" />
						<input class="btn btn-warning ml-5" type="reset" value="Borrar Datos &times;" />
						<button id="cancelar_nuevo_cupon" class="btn btn-danger ml-5" type="button">Cancelar <i class="fas fa-undo-alt"></i></button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="col-sm-12">
<?php
if( !$cupones_por_negocio ) {
	?>
	<h3 class="mb-3">No hay cupones registrados...</h3>
	<?php
} else {
	//print_r ($cupones_por_negocio);
	?>
	<h3 class="mb-3">Cupones registrados:</h3>
	<div class="table-responsive-sm table-sm">
		<table class="table table-striped">
			<thead class="thead-light">
				<tr class="text-center">
					<th scope="col">#</th>
					<th scope="col">Tipo</th>
					<th scope="col">Cupón</th>
					<th scope="col">Descuento</th>
					<th scope="col">Duración</th>
					<th scope="col">Campañas que lo usan</th>
					<th scope="col">Fecha de creación</th>
					<th scope="col">Creado por</th>
					<th scope="col">Acciones</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$num = 1;
			foreach( $cupones_por_negocio as $var => $valor ) {
				?>
				<tr class="text-center">
					<th scope="row"><?php echo $num; ?></th>
					<td><?php echo $valor["tipo"]; ?></td>
					<td><?php echo $valor["nombre"]; ?></td>
					<td><?php echo $valor["descuento"]; ?></td>
					<td><?php echo $valor["duracion"]; ?> días</td>
					<td><?php echo $valor["cuenta_camps"]; ?> campaña<?php echo ($valor["cuenta_camps"] > 1) ? "s":""; ?></td>
					<td><?php echo date("d/M/Y", strtotime($valor["fecha_creacion"])); ?></td>
					<td><?php echo $valor["creado_por"]; ?></td>
					<td></td>
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
let tipos_cupones = <?php echo json_encode($tipos_cupones); ?>;
$("select#tipo_cupon").change( function(){
	let val = $(this).val();
	let descr = "Escoge el tipo de cupón que deseas crear";
	if ( isNaN(val) ) {
		$("#tipo_cuponHelp").text(descr);
	} else {
		tipos_cupones.forEach( function(filas){
			if( filas.id == val ) {
				descr = filas.descripcion;
				$("#tipo_cuponHelp").text(descr);
			}
		});	
	}	
});
$("button#crear_cupon").click( function (){
	if ( $("div#cont_forma_nuevo_cupon").hasClass("d-none") ) {
		$("div#cont_forma_nuevo_cupon").removeClass("d-none");
		$("#crear_cupon").addClass("d-none");
	}
});
$("button#cancelar_nuevo_cupon").click( function (){
	if ( !$("div#cont_forma_nuevo_cupon").hasClass("d-none") ) {
		$("div#cont_forma_nuevo_cupon").addClass("d-none");
		$("#crear_cupon").removeClass("d-none");
	}
});
</script>