<?php
class dt_costo extends guc_datos_tabla
{
	function get_listado($filtro=array())
	{
		$where = array();
		if (isset($filtro['tipo_impuesto_id'])) {
			$where[] = "tipo_impuesto_id = ".quote($filtro['tipo_impuesto_id']);
		}
		if (isset($filtro['tipo_periodo_id'])) {
			$where[] = "tipo_periodo_id = ".quote($filtro['tipo_periodo_id']);
		}
		$sql = "SELECT
			t_c.id,
			t_ti.descripcion as tipo_impuesto_id_nombre,
			t_tj.descripcion as tipo_jurisdiccion_id_nombre,
			t_tp.descripcion as tipo_periodo_id_nombre,
			t_cb.descripcion as codigo_barra_id_nombre,
			t_c.descripcion
		FROM
			costo as t_c    LEFT OUTER JOIN tipo_impuesto as t_ti ON (t_c.tipo_impuesto_id = t_ti.id)
			LEFT OUTER JOIN tipo_juridisccion as t_tj ON (t_c.tipo_jurisdiccion_id = t_tj.id)
			LEFT OUTER JOIN tipo_periodo as t_tp ON (t_c.tipo_periodo_id = t_tp.id)
			LEFT OUTER JOIN codigo_barra as t_cb ON (t_c.codigo_barra_id = t_cb.id)
		ORDER BY descripcion";
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		return toba::db('guc')->consultar($sql);
	}





		function get_descripciones()
		{
			$sql = "SELECT id, descripcion FROM costo ORDER BY descripcion";
			return toba::db('guc')->consultar($sql);
		}






	function get_listado_pagado($filtro=array()){
			$filtro['pagado'] = '1';
			return $this->get_listado_con_formato($filtro);
	}

	function get_listado_impagado($filtro=array()){
			$filtro['pagado'] = '0';
			return $this->get_listado_con_formato($filtro);
	}
	
	
	function get_listado_con_formato($filtro=array()){
		$where = array();
		if (isset($filtro['costo_id'])) {
			$where[] = "costo_id = ".quote($filtro['costo_id']);
		}
		if (isset($filtro['fecha_vencimiento_d'])) {
			$where[] = "fecha_vencimiento >= ".quote($filtro['fecha_vencimiento_d']);
		}
		if (isset($filtro['fecha_vencimiento_h'])) {
			$where[] = "fecha_vencimiento <= ".quote($filtro['fecha_vencimiento_h']);
		}
		if (isset($filtro['periodo'])) {
			$where[] = "periodo = ".quote($filtro['periodo']);
		}
			if (isset($filtro['pagado'])) {
			$where[] = "pagado= ".quote($filtro['pagado']);
		}
		
		
		$sql = "select ccc.fecha_vencimiento, t_c.descripcion as costo, ccc.descripcion, ccc.periodo, ccc.importe as importe, t_cc.descripcion as CentroCosto, t_cc.id as centroCostoId 
				from costo_centro_costo ccc,
				costo as t_c,
				centro_costo as t_cc
				WHERE
			ccc.costo_id = t_c.id
			AND  ccc.centro_costo_id = t_cc.id";
		
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		
		return toba::db('guc')->consultar($sql);
	}














}
?>