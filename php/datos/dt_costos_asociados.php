<?php
class dt_costos_asociados extends guc_datos_tabla
{
	function get_listado($filtro=array())
	{
		$where = array();
		if (isset($filtro['id_centro_costo'])) {
			$where[] = "id_centro_costo = ".quote($filtro['id_centro_costo']);
		}
		if (isset($filtro['id_costo'])) {
			$where[] = "id_costo = ".quote($filtro['id_costo']);
		}
		$sql = "SELECT
			t_ca.id,
			t_cc.descripcion as id_centro_costo_nombre,
			t_c.descripcion as id_costo_nombre,
			t_ti.descripcion as id_tipo_identificador_nombre,
			t_ca.valor,
			t_ca.descripcion,
			t_imp.descripcion as tipo_impuesto
		FROM
			costos_asociados as t_ca,
			centro_costo as t_cc,
			costo as t_c,
			tipo_identificador as t_ti,
			tipo_impuesto as t_imp
		WHERE
				t_ca.id_centro_costo = t_cc.id
			AND  t_ca.id_costo = t_c.id
			AND  t_ca.id_tipo_identificador = t_ti.id
			and t_c.tipo_impuesto_id = t_imp.id
		ORDER BY id_centro_costo_nombre";
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		return toba::db('guc')->consultar($sql);
	}


}
?>