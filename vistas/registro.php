<?php
if ( $this->usuario->usuario ) {
	header( "Location: " . DOMINIO . "miperfil" );//
}
?>
<main role="main">
	<div class="container-fluid">
		<div class="container vh-100">
			<div class="row align-items-center justify-content-center h-50">
				<div class="col-4 col-auto mt-5">
					<h3>Regístrate</h3>
						<form method="post" action="<?php echo DOMINIO ?>">
							<div class="form-row">
								<div class="form-group col-xs-12">
									<!--Input de Usuario-->
									<label class="sr-only" for="usuario">Usuario</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"><i class="far fa-user"></i></div>
										</div>
										<input type="text" class="form-control" id="usuario" name="rgtro_usuario" aria-describedby="usuarioHelp" placeholder="Usuario" required>
									</div>
									<small id="usuarioHelp" class="form-text text-muted mb-2">Escoge un nombre de usuario con el que te identifiques</small>
									<!--Input de Correo electrónico-->
									<label class="sr-only" for="correo">Correo Electrónico</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"><i class="far fa-envelope"></i></div>
										</div>
										<input type="text" class="form-control" id="correo" name="rgtro_mail" aria-describedby="emailHelp" placeholder="Correo electrónico" required>
									</div>
									<small id="emailHelp" class="form-text text-muted mb-2">Nunca compartiremos tu correo con nadie</small>
									<!--Input de Contraseña-->
									<label class="sr-only" for="psswd">Contraseña</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"><i class="fas fa-unlock-alt"></i></div>
										</div>
										<input type="password" class="form-control" id="psswd" name="rgtro_clave" placeholder="Contraseña" required>
									</div>
									<!--Input de Nombre-->
									<label class="sr-only" for="nombre">Nombre</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"><i class="far fa-user"></i></div>
										</div>
										<input type="text" class="form-control" id="nombre" name="rgtro_nombre" aria-describedby="nombreHelp" placeholder="Nombre(s)" required>
									</div>
									<small id="nombreHelp" class="form-text text-muted mb-2">Ingresa tu(s) nombre(s)</small>
									<!--Input de Apellidos-->
									<label class="sr-only" for="apellidos">Apellidos</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"><i class="far fa-user"></i></div>
										</div>
										<input type="text" class="form-control" id="apellidos" name="rgtro_apellidos" aria-describedby="apellidosHelp" placeholder="Apellidos" required>
									</div>
									<small id="apellidosHelp" class="form-text text-muted mb-2">Ingresa tus apellidos</small>
									<!--Input de Teléfono-->
									<label class="sr-only" for="telefono">Teléfono</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"><i class="far fa-user"></i></div>
										</div>
										<input type="number" class="form-control" id="telefono" name="rgtro_telefono" aria-describedby="telefonoHelp" placeholder="Teléfono" required>
									</div>
									<small id="telefonoHelp" class="form-text text-muted mb-2">Nunca compartiremos tu teléfono a personas que no estén relacionadas con la aplicación</small>
									<!--Input de Términos y Condiciones-->
									<div class="input-group">
										<input type="checkbox" class="form-check-input" id="tyc" name="rgtro_tyc" required>
										<label class="form-check-label" for="tyc">Acepto los <a href="#" target="_blank">términos y condiciones</a></label>
									</div>
									<div class="input-group">
										<input class="btn btn-primary" type="submit" value="Registrarse" />
									</div>
								</div>
							</div>
						</form>
				</div> 
			</div>
		</div>
	</div>
</main>