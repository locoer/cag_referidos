<?php
class Campanias {
	private $fecha_desde;
	private $fecha_hasta;
	
	public function __construct() {
		$this->fecha_desde = "2019-10-10";
		$this->fecha_hasta = date("Y-m-d", strtotime("Next Year"));
	}

	public function __destruct() {
		// clean up here
	}
	
	public function trae_info_campania($id_campania) {
		$obj_con = Sitio::$obj_bds;
		if( is_numeric($id_campania) ) {
			$txt_qry = "
				SELECT id, nombre, descripcion, perfil, puntos_referencia, puntos_nc, limite_puntos, limite_puntos_xdia, tipo_id, estado_id, negocio_id, creado_por, fecha_creado, fecha_vigencia, fecha_modificacion, borrado
				FROM campanias
				WHERE id = :id
			";
			$vals_qry = array(
				":id" => $id_campania
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
			} else {
				return false;
			}
		}
	}
	
	public function trae_activas () {
		$obj_con = Sitio::$obj_bds;
		$hoy = date("Y-m-d");
		$txt_qry = "
			SELECT camps.id AS id, camps.nombre AS nombre_campania, camps.descripcion AS descripcion, camps.perfil AS perfil, camps.puntos_referencia AS pts_ref, camps.puntos_nc AS pts_nc, camps.fecha_creado AS fecha_creado, camps.fecha_vigencia AS fecha_fin,
			negs.nombre_comercial as negocio,
			usrs.usuario AS usuario, CONCAT(usrs.nombre, ' ', usrs.apellido) AS nombre_completo,
			tipo.tipo AS tipo,
			estado.estado AS estado,
			IFNULL(cuponesxcamps.cupones,0) AS num_cupones
			FROM campanias AS camps JOIN negocios AS negs ON camps.negocio_id = negs.id
			JOIN usuarios AS usrs ON camps.creado_por = usrs.id
			JOIN tipo_campania AS tipo ON camps.tipo_id = tipo.id
			JOIN estado_campania AS estado ON camps.estado_id = estado.id
			LEFT JOIN (
				SELECT campania_id, COUNT(id) AS cupones 
				FROM cupones_x_campania
				WHERE asignado = 1
				GROUP BY campania_id
			) AS cuponesxcamps ON camps.id = cuponesxcamps.campania_id
			WHERE camps.estado_id = 2
			AND camps.borrado = 0
			AND camps.fecha_vigencia >= :hoy
			AND camps.fecha_creado >= :fecha_desde
			AND camps.fecha_vigencia <= :fecha_hasta
			ORDER BY camps.fecha_creado DESC
		";
		$vals_qry = array (
			":hoy" => $hoy,
			":fecha_desde" => $this->fecha_desde,
			":fecha_hasta" => $this->fecha_hasta
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
			FROM tipo_campania
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
	public function campanias_por_negocio (Usuario $usuario) {
		if ( !$id_usr = $usuario->info()["id_bds"] ) {
			return false;
		}
		$obj_con = Sitio::$obj_bds;
		$txt_qry = "
			SELECT camps.id AS id, camps.nombre AS nombre_campania, camps.descripcion AS descripcion, camps.perfil AS perfil, camps.puntos_referencia AS pts_ref, camps.puntos_nc AS pts_nc, camps.fecha_creado AS fecha_creado, camps.fecha_vigencia AS fecha_fin,
			negs.nombre_comercial as negocio,
			usrs.usuario AS usuario, CONCAT(usrs.nombre, ' ', usrs.apellido) AS nombre_completo,
			tipo.tipo AS tipo,
			estado.id AS id_estado, estado.estado AS estado,
			IFNULL(cuponesxcamps.cupones,0) AS num_cupones
			FROM campanias AS camps JOIN negocios AS negs ON camps.negocio_id = negs.id
			JOIN usuarios AS usrs ON camps.creado_por = usrs.id
			JOIN tipo_campania AS tipo ON camps.tipo_id = tipo.id
			JOIN estado_campania AS estado ON camps.estado_id = estado.id
			LEFT JOIN (
				SELECT campania_id, COUNT(id) AS cupones 
				FROM cupones_x_campania
				WHERE asignado = 1
				GROUP BY campania_id
			) AS cuponesxcamps ON camps.id = cuponesxcamps.campania_id
			WHERE camps.borrado = 0
			AND negs.propietario_id = :propietario_id
			ORDER BY camps.fecha_creado
		";
		$vals_qry = array (
			":propietario_id" => $id_usr
		);
		$qry = $obj_con->prepare($txt_qry);
		if ( $qry->execute($vals_qry) ){
			$filas = $qry->rowCount();
			if( $filas ) {
				$datos = $qry->fetchAll(PDO::FETCH_ASSOC);
				return $datos;
			} else {
				return false;
			}
		}
	}
	
	public function crea_campania ($datos) {
		if ( 
			!isset( $datos["tipo_campana"] ) ||
			!isset( $datos["nombre_campana"] ) ||
			!isset( $datos["descripcion_campana"] ) ||
			!isset( $datos["puntosxref_campana"] ) ||
			!isset( $datos["puntosxnc_campana"] ) ||
			!isset( $datos["fechafin_campana"] ) ||
			!isset( $datos["limite_puntos_campana"] ) ||
			!isset( $datos["limitexdia_puntos_campana"] ) ||
			!isset( $datos["perfil_campana"] ) ||
			!isset( $datos["usuario_id"] ) ||
			!isset( $datos["negocio_id"] )
		){
			echo "Favor de llenar todos los campos para crear una campaña";
			return false;
		}
		$obj_con = Sitio::$obj_bds;
		$txt_qry = "
			INSERT INTO campanias (nombre, descripcion, perfil, puntos_referencia, puntos_nc, limite_puntos, limite_puntos_xdia, tipo_id, estado_id, negocio_id, creado_por, fecha_vigencia, borrado, fecha_creado, fecha_modificacion) VALUES (:nombre, :descripcion, :perfil, :puntos_referencia, :puntos_nc, :limite_puntos, :limite_puntos_xdia, :tipo_id, 1, :negocio_id, :creado_por, :fecha_vigencia, 0, CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP())
		";
		$vals_qry = array (
			":nombre" => $datos["nombre_campana"], 
			":descripcion" => $datos["descripcion_campana"], 
			":perfil" => $datos["perfil_campana"], 
			":puntos_referencia" => $datos["puntosxref_campana"],
			":puntos_nc" => $datos["puntosxnc_campana"],			
			":limite_puntos" => $datos["limite_puntos_campana"],
			":limite_puntos_xdia" => $datos["limitexdia_puntos_campana"], 
			":tipo_id" => $datos["tipo_campana"],
			":negocio_id" => $datos["negocio_id"], 
			":creado_por" => $datos["usuario_id"],
			":fecha_vigencia" => $datos["fechafin_campana"]
		);
		$qry = $obj_con->prepare($txt_qry);
		if ( $qry->execute($vals_qry) ){
			$campania_id = $obj_con->lastInsertId();
			if( isset($datos["cupones"]) && count($datos["cupones"]) > 0 ) {
				if ( $respuesta = $this->asigna_cupones($campania_id, $datos["cupones"]) ) {
					//Respuesta de que se asignaron correctamente los cupones...
				}
			}
			return true;
		} else {
			echo "Hubo un error al crear la campaña, favor de contactar al admin del sitio web <br/>";
			var_dump ($qry->errorInfo());
			return false;
		}
	}
	
	private function revisa_campania ($id_campania) {
		if ( !is_numeric($id_campania) ) {
			return false;
		}
		$obj_con = Sitio::$obj_bds;
		$txt_qry_revisa_camp = "
			SELECT id
			FROM campanias
			WHERE borrado = 0
			AND id = :id_campania
		";
		$vals_qry_revisa_camp = array (
			":id_campania" => $id_campania
		);
		$qry = $obj_con->prepare($txt_qry_revisa_camp);
		if ( $qry->execute($vals_qry_revisa_camp) ){
			$filas = $qry->rowCount();
			if ( $filas ) {
				return true;
			} else {
				return false;
			}
		} else {
			echo "Hubo un error al validar la campaña, favor de contactar al admin del sitio web <br/>";
			var_dump ($qry->errorInfo());
			return false;
		}
	}
	
	private function asigna_cupones ($campania_id, $cupones) {
		$respuesta = array();
		$obj_con = Sitio::$obj_bds;
		$txt_qry_revisa_cup = "
			SELECT id
			FROM cupones
			WHERE borrado = 0
			AND id = :id_cupon
		";
		$txt_qry = "
			INSERT INTO cupones_x_campania (campania_id, cupon_id, asignado, fecha_asignacion, fecha_modificacion) VALUES (:campania_id, :cupon_id, 1, CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP())
		";
		
		if ( $this->revisa_campania($campania_id) ){
				if ( !is_array($cupones) ){
					return false;
				}
				foreach ( $cupones as $key => $cupon_id ) {
					$vals_qry_revisa_cup = array (
						":id_cupon" => $cupon_id
					);
					$qry_cup = $obj_con->prepare($txt_qry_revisa_cup);
					if ( $qry_cup->execute($vals_qry_revisa_cup) ){
						$filas_cup = $qry_cup->rowCount();
						if ( $filas_cup ) {
							$vals_qry = array (
								":campania_id" => $campania_id,
								":cupon_id" => $cupon_id
							);
							$qry_asig = $obj_con->prepare($txt_qry);
							if ( $qry_asig->execute($vals_qry) ){
								$respuesta[] = array (
									$campania_id => $cupon_id
								);
							}else {
								echo "Hubo un error al validar la campaña, favor de contactar al admin del sitio web <br/>";
								var_dump ($qry->errorInfo());
								return false;
							}
						}
					}else {
						echo "Hubo un error al validar la campaña, favor de contactar al admin del sitio web <br/>";
						var_dump ($qry->errorInfo());
						return false;
					}
				}
			if( count($respuesta) > 0 ) {
				return $respuesta;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	public function cambia_estado ($campania_id, $estado_nuevo) {
		$obj_con = Sitio::$obj_bds;
		//Revisa que exista el estado nuevo
		if ( is_numeric($estado_nuevo) ) {  
			$txt_qry_estado = "
				SELECT id, estado, descripcion
				FROM estado_campania
				WHERE id = :id
			";
			$vals_qry_estado = array(
				":id" => $estado_nuevo
			);
		}elseif ( is_string($estado_nuevo) ) {
			$txt_qry_estado = "
				SELECT id, estado, descripcion
				FROM estado_campania
				WHERE estado LIKE '%:estado%'
			";
			$vals_qry_estado = array(
				":estado" => $estado_nuevo
			);
		}
		$qry_estado = $obj_con->prepare($txt_qry_estado);
		if ( $qry_estado->execute($vals_qry_estado) ){
			$filas = $qry_estado->rowCount();
			if( $filas > 0 ){
				$estado = $qry_estado->fetch(PDO::FETCH_ASSOC);
			}else {
				return false;
			}
		}else {
			echo "Hubo un error al validar el estado nuevo, favor de contactar al admin del sitio web <br/>";
			var_dump ($qry_estado->errorInfo());
			return false;
		}
		//Trae datos de la campaña y revisa que sí se pueda cambiar al estado nuevo solicitado
		if ( $datos_camp = $this->trae_info_campania($campania_id) ){
			if ( $this->valida_cambio_estado( $datos_camp["estado_id"], $estado["id"] ) ) {
				$txt_qry = "
					UPDATE campanias
					SET estado_id = :estado_id, fecha_modificacion = CURRENT_TIMESTAMP()
					WHERE id = :camp_id
				";
				$vals_qry = array(
					":estado_id" => $estado["id"],
					":camp_id" => $datos_camp["id"]
				);
				$qry = $obj_con->prepare($txt_qry);
				if ( $qry->execute($vals_qry) ){
					return true;
				} else {
					return false;
				}
			}
		}
	}
	
	public function valida_cambio_estado($estado_actual, $estado_nuevo) {
		if ( !is_numeric($estado_actual) || !is_numeric($estado_nuevo) ){
			return false;
		}
		$cambios_permitidos = array(
			"1" => array(
				"1" => true,
				"2" => true,
				"3" => false,
				"4" => false,
				"5" => false,
				"6" => true
			),
			"2" => array(
				"1" => false,
				"2" => true,
				"3" => true,
				"4" => true,
				"5" => true,
				"6" => true
			),
			"3" => array(
				"1" => false,
				"2" => true,
				"3" => true,
				"4" => true,
				"5" => true,
				"6" => true
			),
			"4" => array(
				"1" => false,
				"2" => false,
				"3" => false,
				"4" => true,
				"5" => false,
				"6" => false
			),
			"5" => array(
				"1" => false,
				"2" => true,
				"3" => true,
				"4" => true,
				"5" => true,
				"6" => true
			),
			"6" => array(
				"1" => false,
				"2" => false,
				"3" => false,
				"4" => true,
				"5" => false,
				"6" => true
			)
		);
		return $cambios_permitidos[$estado_actual][$estado_nuevo];
	}
	
	public function agrega_referido(Usuario $usuario, $camp_id, $datos_referido) {
		if ( !$id_usr = $usuario->info()["id_bds"] ) {
			return false;
		}
		if ( !$this->revisa_campania($camp_id) ) {
			return false;
		}
		if ( 
			!isset ( $datos_referido["nombre_ref"] ) ||
			!isset ( $datos_referido["apellidos_ref"] ) ||
			!isset ( $datos_referido["descripcion_ref"] )
		) {
			return false;
		}
		$obj_con = Sitio::$obj_bds;
		$txt_qry = "
			INSERT INTO referencias (nombre, apellidos, telefono, mail, descripcion, campania_id, referido_por, estado_id, siguiente_paso, fecha_creacion)
			VALUES (:nombre, :apellidos, :telefono, :mail, :descripcion, :campania_id, :referido_por, 1, 'Calificar Referido', CURRENT_TIMESTAMP())
		";
		if ( isset($datos_referido["telefono_ref"]) && !empty($datos_referido["telefono_ref"]) ) {
			$telefono = $datos_referido["telefono_ref"];
		} else {
			$telefono = "ND";
		}
		if ( isset( $datos_referido["mail_ref"] ) && !empty($datos_referido["mail_ref"]) ) {
			$mail = $datos_referido["mail_ref"];
		} else {
			$mail = "ND";
		}
		$vals_qry = array(
			":nombre" => $datos_referido["nombre_ref"], 
			":apellidos" => $datos_referido["apellidos_ref"], 
			":telefono" => $telefono, 
			":mail" => $mail, 
			":descripcion" => $datos_referido["descripcion_ref"], 
			":campania_id" => $camp_id, 
			":referido_por" => $id_usr
		);
		$qry = $obj_con->prepare($txt_qry);
		if ( $qry->execute($vals_qry) ){
			return true;
		} else {
			return false;
		}
	}
}
?>