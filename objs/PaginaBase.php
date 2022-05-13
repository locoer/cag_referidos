<?php 
class PaginaBase extends Pagina {
	public function __construct($titulo) {
		parent::__construct($titulo);
		$this->defineMenu("menubase");
		$this->definePie("footerbase");
	}
	public function render() {
		echo $this->menu;
		echo $this->contenido;
		echo $this->pie_pagina;
	}
}
?>