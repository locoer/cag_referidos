<?php
$referidos = new Referidos();
ob_start();
if ( $referidos_usuario = $referidos->trae_referidos_usuario($this->usuario) ) {
?>
	<h3 class="mb-3">Referidos registrados:</h3>
	<div class="table-responsive-sm table-sm">
		<table class="table table-striped">
			<thead class="thead-light">
				<tr class="text-center">
					<th scope="col">#</th>
					<th scope="col">Negocio</th>
					<th scope="col">Campaña</th>
					<th scope="col">Tipo</th>
					<th scope="col">Referido</th>
					<th scope="col">Teléfono</th>
					<th scope="col">Mail</th>
					<th scope="col">Descripción</th>
					<th scope="col">Estado</th>
					<th scope="col">Fecha Creado</th>
					<th scope="col">Acción</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach( $referidos_usuario as $fila => $referido ) { ?>
				<tr class="text-center">
					<th scope="row"><?php echo $fila; ?></th>
					<td><?php echo $referido["negocio"]; ?></td>
					<td><?php echo $referido["nombre_campania"]; ?></td>
					<td><?php echo $referido["tipo_campania"]; ?></td>
					<td><?php echo $referido["nombre_completo"]; ?></td>
					<td><?php echo $referido["tel"]; ?></td>
					<td><?php echo $referido["mail"]; ?></td>
					<td><?php echo $referido["descripcion"]; ?></td>
					<td><?php echo $referido["estado_referencia"]; ?></td>
					<td><?php echo date("d/M/Y", strtotime($referido["fecha_creacion"])); ?></td>
					<td></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<?php
} else {
?>
	<h3 class="mb-3">No hay referidos registrados...</h3>
<?php
}
$cont_refs = ob_get_contents();
ob_end_clean();

echo $cont_refs;
?>
