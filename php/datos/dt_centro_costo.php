<?php
class dt_centro_costo extends guc_datos_tabla
{
	function get_listado($filtro=array())
	{
		$where = array();
		if (isset($filtro['tipo_centro_costo_id'])) {
			$where[] = "tipo_centro_costo_id = ".quote($filtro['tipo_centro_costo_id']);
		}
		$sql = "SELECT
			t_cc.id,
			t_cc.descripcion,
			t_tcc.descripcion as tipo_centro_costo_id_nombre
		FROM
			centro_costo as t_cc,
			tipo_centro_costo as t_tcc
		WHERE
				t_cc.tipo_centro_costo_id = t_tcc.id
		ORDER BY descripcion";
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		return toba::db('guc')->consultar($sql);
	}



		function get_descripciones()
		{
			$sql = "SELECT id, descripcion FROM centro_costo ORDER BY descripcion";
			return toba::db('guc')->consultar($sql);
		}




























}
?>