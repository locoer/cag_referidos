<?php
class Cupones {
	private $id_negocio;
	private $id_usuario;
	
	public function __construct(Usuario $usr) {
		$info_usr = $usr->info ();
		$this->id_negocio = $info_usr["negocio_id"];
		$this->id_usuario = $info_usr["id_bds"];
	}

	public function __destruct() {
		// clean up here
	}
	
	public function trae_cupones_negocio () {
		$id_negocio = $this->id_negocio;
		if ( !$id_negocio ){
			return false;
		}
		$obj_con = Sitio::$obj_bds;
		$txt_qry = "
			SELECT cupones.id AS id, cupones.nombre AS nombre, cupones.descuento AS descuento, cupones.duracion AS duracion, cupones.fecha_creacion AS fecha_creacion,
			tipo.tipo AS tipo,
			CONCAT(usrs.nombre, ' ', usrs.apellido ) AS creado_por,
			IFNULL(cuponesxcamp.cuenta_camps,0) AS cuenta_camps
			FROM cupones JOIN tipo_cupon AS tipo ON cupones.tipo_id = tipo.id
			JOIN usuarios AS usrs ON cupones.creado_por = usrs.id
			LEFT JOIN (
				SELECT cupon_id, COUNT(id) AS cuenta_camps 
				FROM cupones_x_campania
				WHERE asignado = 1
				GROUP BY cupon_id
			) AS cuponesxcamp ON cupones.id = cuponesxcamp.cupon_id
			WHERE cupones.borrado = 0
			AND cupones.negocio_id = :negocio_id
			ORDER BY cupones.fecha_creacion DESC
		";
		$vals_qry = array (
			":negocio_id" => $id_negocio
		);
		$qry = $obj_con->prepare($txt_qry);
		if ( $qry->execute($vals_qry) ){
			$datos = $qry->fetchAll(PDO::FETCH_ASSOC);
			return $datos;
		} else {
			return false;
		}
	}
	public function trae_tipos () {
		$obj_con = Sitio::$obj_bds;
		$txt_qry = "
			SELECT id, tipo, descripcion
			FROM tipo_cupon
		";
		if ( $qry = $obj_con->query($txt_qry) ){
			$filas = $qry->rowCount();
			if( $filas ) {
				$datos = $qry->fetchAll(PDO::FETCH_ASSOC);
				return $datos;
			} else {
				return false;
			}
		}
	}
	public function crea_cupon ($datos) {
		$id_negocio = $this->id_negocio;
		$id_usuario = $this->id_usuario;
		if (  
			!isset ( $datos["nombre_cupon"] ) ||
			!isset ( $datos["descuento_cupon"] ) ||
			!isset ( $datos["tipo_cupon"] ) ||
			!isset ( $datos["vigencia_cupon"] ) ||
			!$id_negocio ||
			!$id_usuario
		){
			echo "Favor de llenar todos los campos para crear un cupón nuevo";
			return false;
		}
		$obj_con = Sitio::$obj_bds;
		$txt_qry = "
			INSERT INTO cupones (nombre, descuento, tipo_id, duracion, negocio_id, creado_por, fecha_creacion) VALUES (:nombre, :descuento, :tipo_id, :duracion, :negocio_id, :creado_por, CURRENT_TIMESTAMP())
		";
		$vals_qry = array (
			":nombre" => $datos["nombre_cupon"],
			":descuento" => $datos["descuento_cupon"],
			":tipo_id" => $datos["tipo_cupon"],
			":duracion" => $datos["vigencia_cupon"],
			":negocio_id" => $id_negocio,
			":creado_por" => $id_usuario
		);
		$qry = $obj_con->prepare($txt_qry);
		if ( $qry->execute($vals_qry) ){
			return true;
		} else {
			echo "Hubo un error al crear el cupón, favor de contactar al admin del sitio web <br/>";
			var_dump ($qry->errorInfo());
			return false;
		}
		
	}
}
?>