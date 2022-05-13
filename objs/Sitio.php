<?php
class Sitio {
	private $nombre;
	private $headers;
	private $footers;
	private $pagina;
	static public $obj_bds;
	private $usuario;
	private $sesion;

	public function __construct() {
		$this->nombre = NOMBRE_SITIO;
		$this->sesion = new Sesion($this->nombre);
		self::$obj_bds = self::conecta_bds();
		$this->usuario = new Usuario();
		$this->headers = array();
		$this->footers = array();
		$this->agregaHeader("header");
		$this->agregaFooter("footer");
	}

	public function __destruct() {
		// clean up here
	}
	
	public static function conecta_bds () {
		$host = HOST . PUERTO;
		$dbname = DBNAME;
		$usr = USR;
		$psswd = PSSWD;
		$bds = new PDO("mysql:host=$host;dbname=$dbname", $usr, $psswd);
		$bds->exec("SET NAMES utf8");
		return $bds;
	}

	public function render() {
		foreach($this->headers as $header) {
			include $header;
		}
		if ( !empty($this->pagina) ) {
			$this->pagina->render();
		}

		foreach($this->footers as $footer) {
			include $footer;
		}
	}
	
	public function agregaHeader($vista) {
		if ( file_exists("./vistas/$vista.php") ) {
			$this->headers[] = "./vistas/$vista.php";
		} else {
			return false;
		}
	}

	public function agregaFooter($vista) {
		if ( file_exists("./vistas/$vista.php") ) {
			array_unshift($this->footers, "./vistas/$vista.php");
		} else {
			return false;
		}
	}

	public function definePagina(Pagina $pagina) {
		$this->pagina = $pagina;
	}
	
	public function defineVistaURL () {
		if ( isset($_GET["vista"]) ) { //revisa vista del url
			$vista = htmlspecialchars($_GET["vista"]);
			$vista = preg_replace("/[^A-Za-z0-9\/]/", "", $vista);
			$vista = explode("/", $vista);
			switch ($vista[0]) { //hace el switch según la vista y escoge el tipo de página
				case "login":
					//$this->usuario->logout($this->sesion);
					$pagina = new PaginaBase(NOMBRE_SITIO);
					$pagina->defineContenido("login");
					break;
				case "logout":
					$this->usuario->logout($this->sesion);
					break;
				case "campanas":
					if ( isset($vista[1]) && preg_match("/[0-9]/", $vista[1]) ) {
						$pagina = new PaginaBase(NOMBRE_SITIO);
						$pagina->defineContenido("camp_detalle");
					} else {
						$pagina = new PaginaBase(NOMBRE_SITIO);
						$pagina->defineContenido($vista[0]);
					}
					break;
				default:
					$pagina = new PaginaBase(NOMBRE_SITIO);
					$pagina->defineContenido($vista[0]);
					break;
			}
		} else { //Si no hay vista, pero sí está logeado, escoge pagina tablero y vista inicio
			$pagina = new PaginaBase(NOMBRE_SITIO);
			$pagina->defineContenido("inicio");
		}
		
		/*if ( !$this->usuario->nombre ) { //revisa si hay usuario logeado
			//No hay usuario, manda a login
			$pagina = new PaginaBase(NOMBRE_SITIO);
			$pagina->defineContenido("login");
		} else {
		}*/
		$this->definePagina($pagina);
	}
	
	public function usuario_activo () {
		if ( $this->usuario->nombre ) {
			return $this->usuario;
		} else {
			return false;
		}
	}
}
?>