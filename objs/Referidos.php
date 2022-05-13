<?php
class Referidos {
	public function trae_referidos_usuario(Usuario $usuario) {
		$info_usr = $usuario->info();
		if( !$id_bds = $info_usr["id_bds"] ) {
			return false;
		}
		$obj_con = Sitio::$obj_bds;
		$txt_qry = "
			SELECT refs.id AS id, refs.nombre AS nombre, refs.apellidos AS apellidos, CONCAT(refs.nombre, ' ', refs.apellidos) AS nombre_completo, refs.telefono AS tel, refs.mail AS mail, refs.descripcion AS descripcion, refs.siguiente_paso AS siguiente_paso, refs.fecha_creacion AS fecha_creacion,
			camps.nombre AS nombre_campania,
			negs.nombre_comercial AS negocio,
			tipo_camp.tipo AS tipo_campania,
			estado.estado AS estado_referencia, estado.descripcion AS descr_estado_referencia
			FROM referencias AS refs
			JOIN campanias AS camps ON refs.campania_id = camps.id
			AND refs.referido_por = :referido_por
			JOIN negocios AS negs ON camps.negocio_id = negs.id
			JOIN estado_referencias AS estado ON refs.estado_id = estado.id
			JOIN tipo_campania AS tipo_camp ON camps.tipo_id = tipo_camp.id
			WHERE refs.borrado = 0
			ORDER BY negs.nombre_comercial ASC, camps.nombre ASC, refs.fecha_creacion DESC
		";
		$vals_qry = array(
			":referido_por" => $id_bds
		);
		$qry = $obj_con->prepare($txt_qry);
		if ( $qry->execute($vals_qry) ){
			$filas = $qry->rowCount();
			if ( $filas ) {
				return $qry->fetchAll(PDO::FETCH_ASSOC);
			} else {
				return false;
			}
		} else {
			echo "Hubo un error al buscar referidos asignados, favor de contactar al admin del sitio web <br/>";
			var_dump ($qry->errorInfo());
			return false;
		}
	}
	public function trae_referidos_negocio(Usuario $usuario) {
		$info_usr = $usuario->info();
		if( !$id_negs = $info_usr["negocio_id"] ) {
			return false;
		}
		$obj_con = Sitio::$obj_bds;
		$txt_qry = "
			SELECT refs.id AS id, refs.nombre AS nombre, refs.apellidos AS apellidos, CONCAT(refs.nombre, ' ', refs.apellidos) AS nombre_completo, refs.telefono AS tel, refs.mail AS mail, refs.descripcion AS descripcion, refs.siguiente_paso AS siguiente_paso, refs.fecha_creacion AS fecha_creacion,
			camps.nombre AS nombre_campania,
			negs.nombre_comercial AS negocio,
			tipo_camp.tipo AS tipo_campania,
			estado.estado AS estado_referencia, estado.descripcion AS descr_estado_referencia,
			usr.usuario AS referidor_usuario, CONCAT(usr.nombre, ' ', usr.apellido) AS referidor_nombre 
			FROM referencias AS refs
			JOIN usuarios AS usr ON refs.referido_por = usr.id
			JOIN campanias AS camps ON refs.campania_id = camps.id
			JOIN negocios AS negs ON camps.negocio_id = negs.id
			AND negs.id = :id_negs
			JOIN estado_referencias AS estado ON refs.estado_id = estado.id
			JOIN tipo_campania AS tipo_camp ON camps.tipo_id = tipo_camp.id
			WHERE refs.borrado = 0
			ORDER BY camps.nombre ASC, usr.usuario ASC, refs.fecha_creacion DESC
		";
		$vals_qry = array(
			":id_negs" => $id_negs
		);
		$qry = $obj_con->prepare($txt_qry);
		if ( $qry->execute($vals_qry) ){
			$filas = $qry->rowCount();
			if ( $filas ) {
				return $qry->fetchAll(PDO::FETCH_ASSOC);
			} else {
				return false;
			}
		} else {
			echo "Hubo un error al buscar referidos asignados, favor de contactar al admin del sitio web <br/>";
			var_dump ($qry->errorInfo());
			return false;
		}
	}
}
?>