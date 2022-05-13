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
					<h3>Ingresa a la aplicación</h3>
						<form method="post" action="<?php echo DOMINIO ?>">
							<div class="form-row">
								<div class="form-group col-xs-12">
									<label class="sr-only" for="correo">Correo Electrónico</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"><i class="far fa-envelope"></i></div>
										</div>
										<input type="text" class="form-control" id="correo" name="mail" aria-describedby="emailHelp" placeholder="Correo electrónico" required>
									</div>
									<small id="emailHelp" class="form-text text-muted mb-2">Nunca compartiremos tu correo con nadie</small>
									<label class="sr-only" for="psswd">Contraseña</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"><i class="fas fa-unlock-alt"></i></div>
										</div>
										<input type="password" class="form-control" id="psswd" name="clave" placeholder="Contraseña" required>
									</div>
									<div class="input-group mt-2">
										<input class="btn btn-primary" type="submit" value="Entrar" />
									</div>
								</div>
							</div>
						</form>
				</div> 
			</div>
		</div>
	</div>
</main>