<?php
class Usuario {
	private $id_bds;
	public $usuario;
	public $nombre;
	private $apellido;
	private $nombre_completo;
	private $mail;
	private $telefono;
	private $negocio_id;
	
	public function __construct () {
		if ( $this->revisa_login () ) {
			if ( $datos_usr = $this->trae_datos($_SESSION["mail"])) {
				$this->id_bds = $datos_usr["id"];
				$this->usuario = $datos_usr["usuario"];
				$this->nombre = $datos_usr["nombre"];
				$this->apellido = $datos_usr["apellido"];
				$this->nombre_completo = $datos_usr["nombre_completo"];
				$this->mail = $datos_usr["mail"];
				$this->telefono = $datos_usr["telefono"];
				if ( $info_negocio = $this->info_negocio() ) {
					$this->negocio_id = $info_negocio["id"];
				} else {
					$this->negocio_id = false;
				}
			}
		} else {
			foreach ( $this as $var ) {
				$var = false;
			}
		}
	}
	
	public function __destruct() {
		// clean up here
	}
	
	public function info () {
		foreach ( $this as $var => $val ) {
			$info[$var] = $val;
		}
		return $info;
	}
	public function esAdmin () {
		//*** Revisar si se usará para asignar super usuarios ***
		/*if ( in_array($this->id_bds, array_keys($this->admins)) ) {
			return true;
		} else {
			return false;
		}*/
	}
	
	public function trae_datos($mail) {
		//$sitio = $GLOBALS["sitio"];
		$obj_con = Sitio::$obj_bds;
		$mail = preg_replace("/[^a-zA-Z0-9.@_\-]/","", $mail); //limpia mail
		if( preg_match("/^[a-z0-9._\-]+@[a-z]+.[a-z.]+/", $mail) ) { //revisa que sea un mail
			$txt_qry = "
				SELECT id, usuario, psswd, nombre, apellido, CONCAT(nombre, ' ', apellido) AS nombre_completo, mail, telefono
				FROM usuarios
				WHERE mail = :mail
			";
			$vals_qry = array (
				":mail" => $mail
			);
			$qry = $obj_con->prepare($txt_qry);
			if ( $qry->execute($vals_qry) ){
				$datos = $qry->fetch(PDO::FETCH_ASSOC);
				return $datos;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function revisa_login () {
		//Revisa si hay variables de login para llamar a la función
		if ( isset($_POST["mail"], $_POST["clave"]) ){
			//var_dump( $_POST );
			if ( !$login = $this->login($_POST["mail"], $_POST["clave"]) ) { //que haga login
				return false;
			}
		}
		//Revisa si están las variables del registro para registar a un nuevo usuario
		if( isset( $_POST["rgtro_usuario"], $_POST["rgtro_mail"], $_POST["rgtro_clave"], $_POST["rgtro_nombre"], $_POST["rgtro_apellidos"], $_POST["rgtro_telefono"],$_SERVER["HTTP_REFERER"]) ) { 
			//var_dump($_POST);
			//var_dump($_SERVER["HTTP_REFERER"]);
			if( $_SERVER["HTTP_REFERER"] == DOMINIO . "registro" ) { //Revisa que el registro se haya hecho en la página
				if ( $registro = $this->registra_usuario () ) {
					if ( !$login = $this->login($_POST["rgtro_mail"], $_POST["rgtro_clave"]) ) { //que haga login después del registro
					return false;
					}
				}
			}
		}
		if ( isset($_SESSION["txt_login"], $_SESSION["mail"]) ) {
			$mail = $_SESSION["mail"];
			if ($datos_usr = $this->trae_datos($mail)) { //trae datos desde la bds según el mail
				$browser = $_SERVER['HTTP_USER_AGENT'];
				$txt_login_bds = $datos_usr["id"] . $browser . $datos_usr["psswd"]; //arma el txt_login con la info de la BDs
				$txt_login_bds = sha1($txt_login_bds);
				if ( $txt_login_bds == $_SESSION["txt_login"] ) { //lo revisa con el text login de la sesión
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function login ($mail, $clave) {
		if( preg_match("/^[a-z0-9._\-]+@[a-z]+.[a-z.]+/", $mail) ) { //revisa que sí sea un mail y trae datos desde la bds
			$datos_usr = $this->trae_datos($mail);
		} else {
			return false;
		}
		if ($datos_usr) { //Revisa que haya datos
			if ( password_verify($clave, $datos_usr["psswd"]) ) { //Revisa la clave con el hash del psswd de la BDs
				//el login es correcto, guarda datos de sesión
				$browser = $_SERVER['HTTP_USER_AGENT'];
				$id_bds = preg_replace("/[^0-9]+/", "", $datos_usr["id"]);
				$psswd = $datos_usr["psswd"];
				$txt_login = sha1($id_bds . $browser . $psswd);
				$_SESSION["mail"] = $mail;
				$_SESSION["txt_login"] = $txt_login;
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function logout (Sesion $sesion) {
		foreach ( $this as $var ) {
			$var = false;
		}
		$sesion->termina_sesion();
		//redirecciona al index del sitio
		header ('Location: ' . DOMINIO );
	}
	
	private function registra_usuario () {
		//Funcion para registrar usuarios nuevos
		$obj_con = Sitio::$obj_bds;
		$mail = $_POST["rgtro_mail"];
		$txt_qry = "
			SELECT id, usuario, nombre, apellido, mail
			FROM usuarios
			WHERE mail = :mail
		";
		$vals_qry = array (
			":mail" => $mail
		);
		$qry = $obj_con->prepare($txt_qry);
		if ( $qry->execute($vals_qry) ){
			$filas = $qry->rowCount();
			if( $filas ) {
				echo "Ya está registradirri el mail: $mail";
				$_SESSION["error_registro"] = "Ya existe el usuario con el correo: $mail";
				return false;
			} else {
				$txt_qry_rgtro = "
					INSERT INTO usuarios (usuario, psswd, nombre, apellido, mail, telefono) VALUES (:usuario, :psswd, :nombre, :apellidos, :mail, :telefono)
				";
				$psswd = password_hash($_POST["rgtro_clave"], PASSWORD_DEFAULT);
				$vals_qry = array (
					":usuario" => $_POST["rgtro_usuario"], 
					":psswd" => $psswd, 
					":nombre" => $_POST["rgtro_nombre"], 
					":apellidos" => $_POST["rgtro_apellidos"], 
					":mail" => $mail, 
					":telefono" => $_POST["rgtro_telefono"]
				);
				$qry = $obj_con->prepare($txt_qry_rgtro);
				if ( $qry->execute($vals_qry) ){
					return true;
				} else {
					echo "Hubo un error en el registro, favor de contactar al admin del sitio web <br/>";
					var_dump ($qry->errorInfo());
					return false;
				}
			}
		} else {
			var_dump ($qry->errorInfo());
			return false;
		}
	}
	public function info_negocio() {
		if ( !$id_usr = $this->id_bds ) {
			return false;
		}
		$obj_con = Sitio::$obj_bds;
		$txt_qry = "
			SELECT negocios.id AS id, negocios.nombre_comercial AS nombre_comercial, negocios.razon_social AS razon_social, negocios.rfc AS rfc, negocios.mail_factura AS mail_factura, negocios.descripcion AS descripcion, negocios.telefono AS telefono, negocios.direccion AS direccion, negocios.sitio_web AS sitio_web, negocios.mail AS mail, negocios.propietario_id AS usr_id,
			estado.estado AS estado
			FROM negocios
			JOIN estado_negocios AS estado ON negocios.estado_id = estado.id
			WHERE borrado = 0
			AND propietario_id = :propietario_id
		";
		$vals_qry = array (
			":propietario_id" => $id_usr
		);
		$qry = $obj_con->prepare($txt_qry);
		if ( $qry->execute($vals_qry) ){
			$filas = $qry->rowCount();
			if( $filas ) {
				$datos = $qry->fetch(PDO::FETCH_ASSOC);
				return $datos;
			} else {
				return false;
			}
		}
		
	}
}

?>