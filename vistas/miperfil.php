<?php
if ( !$this->usuario->usuario ) {
	header( "Location: " . DOMINIO . "login" );//manda a login si no está logeado
}
$campanias = new Campanias();
?>
<!--Carga plugin de TinyMCE-->
<script src="<?php echo DOMINIO; ?>libs/tinymce/tinymce.min.js"></script>
<script src="<?php echo DOMINIO; ?>libs/tinymce/jquery.tinymce.min.js"></script>
<!--Inicia contenido de página-->
<div class="container-fluid">
	<div class="row">
		<nav class="col-md-2 bg-light sidebar">
			<div class="sticky-top">
				<ul class="nav flex-md-column nav-pills" id="menu_perfil" role="tablist" aria-orientation="vertical">
					<li class="nav-item">
						<a class="nav-link active" id="menu_perfil_info" href="#cont_perfil_info" data-toggle="pill" role="tab" aria-controls="cont_perfil_info" aria-selected="true">Mi Perfil</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="menu_perfil_cupones" href="#cont_perfil_cupones" data-toggle="pill" role="tab" aria-controls="cont_perfil_cupones" aria-selected="false">Mis Cupones</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="menu_perfil_campanas" href="#cont_perfil_campanas" data-toggle="pill" role="tab" aria-controls="cont_perfil_campanas" aria-selected="false">Mis Campañas</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="menu_perfil_referidos" href="#cont_perfil_referidos" data-toggle="pill" role="tab" aria-controls="cont_perfil_referidos" aria-selected="false">Mis Referidos</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="menu_perfil_transacciones" href="#cont_perfil_transacciones" data-toggle="pill" role="tab" aria-controls="cont_perfil_transacciones" aria-selected="true">Mis Transacciones</a>
					</li>
					<!-- División de negocio y de perfil usuario -->
					<li class="nav-item"> 
						<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">
							<h6 class="sidebar-heading d-flex justify-content-between align-items-left pl-0 pr-3 mt-4 mb-1 text-muted">
								<span>Mi Negocio</span>
								<a class="d-flex align-items-center text-muted" href="#">+</a>
							</h6>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="menu_negocios_campanas" href="#cont_negocios_campanas" data-toggle="pill" role="tab" aria-controls="cont_negocios_campanas" aria-selected="false">Campañas</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="menu_negocios_cupones" href="#cont_negocios_cupones" data-toggle="pill" role="tab" aria-controls="cont_negocios_cupones" aria-selected="false">Cupones</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="menu_negocios_referidos" href="#cont_negocios_referidos" data-toggle="pill" role="tab" aria-controls="cont_negocios_referidos" aria-selected="false">Referidos</a>
					</li>
					
				</ul>
				<!-- <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
					<span>Mi Negocio</span>
					<a class="d-flex align-items-center text-muted" href="#">+</a>
				</h6>
				<ul class="nav flex-md-column mb-2">
					<li class="nav-item">
						<a class="nav-link" href="#">Campañas</a>
					</li>
				</ul> -->
			</div>
		</nav>
		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
			<div class="tab-content pt-2" id="v-pills-tabContent">
				<div class="tab-pane fade show active pl-2" id="cont_perfil_info" role="tabpanel" aria-labelledby="menu_perfil_info">
					<?php include_once("./vistas/tablero/perfil_info.php") ?>
				</div>
				<div class="tab-pane fade" id="cont_perfil_cupones" role="tabpanel" aria-labelledby="menu_perfil_cupones">
					Contenido para el tab de Cuponsirris =D
				</div>
				<div class="tab-pane fade" id="cont_perfil_campanas" role="tabpanel" aria-labelledby="menu_perfil_campanas">
					Contenido para el tab de Campañas en las que participé a la bestia
				</div>
				<div class="tab-pane fade" id="cont_perfil_referidos" role="tabpanel" aria-labelledby="menu_perfil_referidos">
					<?php include_once("./vistas/tablero/perfil_referidos.php") ?>
				</div>
				<div class="tab-pane fade" id="cont_perfil_transacciones" role="tabpanel" aria-labelledby="menu_perfil_transacciones">
					Contenido con las transacciones del usuario a la bestia
				</div>
				<div class="tab-pane fade" id="cont_negocios_campanas" role="tabpanel" aria-labelledby="menu_negocios_campanas">
					<?php include_once("./vistas/tablero/negocio_campanas.php") ?>
				</div>
				<div class="tab-pane fade" id="cont_negocios_cupones" role="tabpanel" aria-labelledby="menu_negocios_cupones">
					<?php include_once("./vistas/tablero/negocio_cupones.php") ?>
				</div>
				<div class="tab-pane fade" id="cont_negocios_referidos" role="tabpanel" aria-labelledby="menu_negocios_referidos">
					<?php include_once("./vistas/tablero/negocio_referidos.php") ?>
				</div>
			</div>
			<div class="modal fade" id="modal_perfil" tabindex="-1" role="dialog" aria-labelledby="titulo_modal" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="titulo_modal">Título Modal</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Cancelar">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<p>Contenido Ventana Modal</p>
						</div>
						<div class="modal-footer">
							<button type="button" id="cancelar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
							<button type="button" id="aceptar" class="btn btn-primary">Aceptar</button>
						</div>
					</div>
				</div>
			</div>
		</main>
	</div>
</div>
<style type="text/css">
@media (min-width: 768px) {
	.sidebar {
		height: calc(100vh - 56px); /* La altura del menú y footer */
		height: 100%;
		min-height: calc(100vh - 112px);
		position: -webkit-sticky;
		position: sticky;
		top: 56px;
	}
}
</style>