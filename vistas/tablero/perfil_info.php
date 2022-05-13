<?php
$info_usr = $this->usuario->info();
?>
<div class="row">
	<div class="col-sm-4">
		<h3 class="mb-3">Mis datos de perfil</h3>
		<form id="perfil_info" method="post" action="<?php echo DOMINIO ?>">
			<div class="form-row">
				<div class="form-group col-sm-12">
					<!--Input de Usuario-->
					<div class="row pb-1">
						<label class="col-md-3" for="usuario">Usuario</label>
						<div class="col-md-9">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="far fa-user"></i></div>
								</div>
								<input type="text" class="form-control" id="usuario" name="perfil_usuario" aria-describedby="usuarioHelp" placeholder="Usuario" value="<?php echo $info_usr["usuario"]; ?>" required disabled>
							</div>
							<small id="usuarioHelp" class="form-text text-muted mb-2 d-none">Escoge un nombre de usuario con el que te identifiques</small>
						</div>
					</div>
					<!--Input de Correo electrónico-->
					<div class="row pb-1">
						<label class="col-md-3" for="correo">Mail</label>
						<div class="col-md-9">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="far fa-envelope"></i></div>
								</div>
								<input type="text" class="form-control" id="correo" name="perfil_mail" aria-describedby="emailHelp" placeholder="Correo electrónico" value="<?php echo $info_usr["mail"]; ?>" required disabled>
							</div>
							<small id="emailHelp" class="form-text text-muted mb-2 d-none">Nunca compartiremos tu correo con nadie</small>
						</div>
					</div>
					<!--Input de Nombre-->
					<div class="row pb-1">
						<label class="col-md-3" for="nombre">Nombre</label>
						<div class="col-md-9">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="far fa-user"></i></div>
								</div>
								<input type="text" class="form-control" id="nombre" name="perfil_nombre" aria-describedby="nombreHelp" placeholder="Nombre(s)" value="<?php echo $info_usr["nombre"]; ?>" required disabled>
							</div>
							<small id="nombreHelp" class="form-text text-muted mb-2 d-none">Ingresa tu(s) nombre(s)</small>
						</div>
					</div>
					<!--Input de Apellidos-->
					<div class="row pb-1">
						<label class="col-md-3" for="apellidos">Apellidos</label>
						<div class="col-md-9">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="far fa-user"></i></div>
								</div>
								<input type="text" class="form-control" id="apellidos" name="perfil_apellidos" aria-describedby="apellidosHelp" placeholder="Apellidos" value="<?php echo $info_usr["apellido"]; ?>" required disabled>
							</div>
							<small id="apellidosHelp" class="form-text text-muted mb-2 d-none">Ingresa tus apellidos</small>
						</div>
					</div>
					<!--Input de Teléfono-->
					<div class="row pb-1">
						<label class="col-md-3" for="telefono">Teléfono</label>
						<div class="col-md-9">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="far fa-user"></i></div>
								</div>
								<input type="number" class="form-control" id="telefono" name="perfil_telefono" aria-describedby="telefonoHelp" placeholder="Teléfono" value="<?php echo $info_usr["telefono"]; ?>" required disabled>
							</div>
							<small id="telefonoHelp" class="form-text text-muted mb-2 d-none">Nunca compartiremos tu teléfono a personas que no estén relacionadas con la aplicación</small>
						</div>
					</div>
					<div class="input-group d-none">
						<input class="btn btn-success" type="submit" value="Actualizar &#10003;" />
						<button class="btn btn-danger d-none ml-5" type="button" id="perfil_cancelar">Cancelar<i class="fas fa-times ml-2"></i></button>
					</div>
				</div>
			</div>
		</form>
		<button class="btn btn-info" type="button" id="perfil_editar">Cambiar Datos<i class="fas fa-pencil-alt ml-2"></i></button>
	</div>
	<div class="col-sm-6">
		<?php 
		if ( $info_negocio = $this->usuario->info_negocio() ) {
			?>
			<h3 class="mb-3">Mis datos de Negocio</h3>
			<div class="table-responsive-sm table-sm">
				<table class="table table-striped">
					<thead class="thead-light">
						<tr>
							<th scope="col" colspan="2" class="text-center">Información de tu negocio</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th scope="row">Nombre Comercial</th>
							<td><?php echo $info_negocio["nombre_comercial"]; ?></td>
						</tr>
						<tr>
							<th scope="row">Razón Social</th>
							<td><?php echo $info_negocio["razon_social"]; ?></td>
						</tr>
						<tr>
							<th scope="row">Descripción</th>
							<td><?php echo $info_negocio["descripcion"]; ?></td>
						</tr>
						<tr>
							<th scope="row">Mail Contacto</th>
							<td><?php echo $info_negocio["mail"]; ?></td>
						</tr>
						<tr>
							<th scope="row">Dirección</th>
							<td><?php echo $info_negocio["direccion"]; ?></td>
						</tr>
						<tr>
							<th scope="row">Teléfono</th>
							<td><?php echo $info_negocio["telefono"]; ?></td>
						</tr>
						<tr>
							<th scope="row">Sitio Web</th>
							<td><?php echo $info_negocio["sitio_web"]; ?></td>
						</tr>
						<tr>
							<th scope="row">RFC</th>
							<td><?php echo $info_negocio["rfc"]; ?></td>
						</tr>
						<tr>
							<th scope="row">Mail Facturación</th>
							<td><?php echo $info_negocio["mail_factura"]; ?></td>
						</tr>
						<tr>
							<th scope="row">Estatus</th>
							<td><?php echo $info_negocio["estado"]; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<?php
		} else {
			?>
			<h3 class="mb-3">¿Tienes un negocio?</h3>
			<p>Dalo de alta y consigue clientes nuevos</p>
			<?php
		}
		?>
	</div>
</div>
<script type="text/javascript">
$("#perfil_editar").click( function(){
	$(this).addClass("d-none");
	$("#perfil_info input:disabled").each( function (){
		var val = $(this).val();
		console.log(val);
		$(this).removeAttr("disabled");
	});
	$("#perfil_info input[type='submit']").parent().removeClass("d-none");
	$("#perfil_cancelar").removeClass("d-none");
});
$("#perfil_cancelar").click( function(){
	$(this).addClass("d-none");
	$("#perfil_info input").not("input[type='submit']").each( function (){
		var val = $(this).val();
		console.log(val);
		$(this).attr("disabled","disabled");
	});
	$("#perfil_info input[type='submit']").parent().addClass("d-none");
	$("#perfil_editar").removeClass("d-none");
});
</script>