<?php
class dt_costo_centro_costo extends guc_datos_tabla
{
	function get_listado_pagado($filtro=array()){
		$filtro['pagado'] = '1';
		return $this->get_listado($filtro);
	}
	
	function get_listado_impago($filtro=array()){
		$filtro['pagado'] = '0';
		return $this->get_listado($filtro);
	}
	
	function get_listado($filtro=array())
	{
		$where = array();
		if (isset($filtro['periodo'])) {
			$where[] = "periodo = ".quote($filtro['periodo']);
		}
		if (isset($filtro['anio'])) {
			$where[] = "anio = ".quote($filtro['anio']);
		}
		if (isset($filtro['pagado'])) {
			$where[] = "pagado = ".quote($filtro['pagado']);
		}
		$sql = "SELECT
			t_c.descripcion as costo_id_nombre,
			t_cc.descripcion as centro_costo_id_nombre,
			t_ccc.fecha_vencimiento,
			t_ccc.importe,
			t_ccc.periodo,
			t_ccc.anio,
			t_ccc.pagado,
			t_ccc.codigo_barra,
			t_ccc.id,
		        t_ccc.descripcion
		FROM
			costo_centro_costo as t_ccc,
			costo as t_c,
			centro_costo as t_cc
		WHERE
				t_ccc.costo_id = t_c.id
			AND  t_ccc.centro_costo_id = t_cc.id
		ORDER BY codigo_barra";
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		return toba::db('guc')->consultar($sql);
	}







	function get_descripciones()
	{
		$sql = "SELECT id, codigo_barra FROM costo_centro_costo ORDER BY codigo_barra";
		return toba::db('guc')->consultar($sql);
	}

}
?>