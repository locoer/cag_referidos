<?php
$usuario = $this->usuario;
$info_usuario = $usuario->info();
?>
<nav class="navbar sticky-top navbar-expand-md navbar-dark bg-dark">
	<a class="navbar-brand" href="<?php echo DOMINIO; ?>">Referidos</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu_base" aria-controls="menu_base" aria-expanded="false" aria-label="Toggle navigation">
	<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="menu_base">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
				<a class="nav-link" href="<?php echo DOMINIO . "inicio"; ?>">Inicio <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo DOMINIO . "campanas"; ?>">Campañas</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Contacto</a>
			</li>
			<li class="nav-item">
				<a class="nav-link disabled" href="#">Deshabilitado</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
				<div class="dropdown-menu" aria-labelledby="dropdown04">
					<a class="dropdown-item" href="#">Action</a>
					<a class="dropdown-item" href="#">Another action</a>
					<a class="dropdown-item" href="#">Something else here</a>
				</div>
			</li>
		</ul>
		<ul class="navbar-nav ml-auto">
		<?php
			if ($info_usuario['nombre_completo']) {
				?>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="dropdownusuario" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $info_usuario['usuario']; ?></a>
					<div class="dropdown-menu" aria-labelledby="dropdownusuario">
						<a class="dropdown-item" href="<?php echo DOMINIO . "miperfil"; ?>">Mi Perfil</a>
						<a class="dropdown-item" href="<?php echo DOMINIO . "logout"; ?>">Cerrar Sesión</a>
					</div>
				</li>
				<?php
			} else {
				?>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo DOMINIO . "login"; ?>">Login</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo DOMINIO . "registro"; ?>">Registro</a>
				</li>
				<?php
			}
		?>
		</ul>
		<form class="form-inline my-2 my-md-0">
			<input class="form-control" type="text" placeholder="Buscar">
		</form>
	</div>
</nav>