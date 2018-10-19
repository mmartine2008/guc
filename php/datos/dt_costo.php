<?php
class dt_costo extends guc_datos_tabla
{
	function get_listado()
	{
		$sql = "SELECT
			t_c.id,
			t_c.descripcion as descripcion,
			t_ti.descripcion as tipo_impuesto_id_nombre,
			t_tj.descripcion as tipo_jurisdiccion_id_nombre,
			t_tp.descripcion as tipo_periodo_id_nombre,
			t_cb.id  as codigo_barra_id_nombre
		FROM
			costo as t_c    LEFT OUTER JOIN tipo_impuesto as t_ti ON (t_c.tipo_impuesto_id = t_ti.id)
			LEFT OUTER JOIN tipo_juridisccion as t_tj ON (t_c.tipo_jurisdiccion_id = t_tj.id)
			LEFT OUTER JOIN tipo_periodo as t_tp ON (t_c.tipo_periodo_id = t_tp.id)
			LEFT OUTER JOIN codigo_barra as t_cb ON (t_c.codigo_barra_id = t_cb.id)";
		return toba::db('guc')->consultar($sql);
	}


	function get_descripciones()
	{
		$sql = "SELECT id, descripcion FROM costo ORDER BY descripcion";
		return toba::db('guc')->consultar($sql);
	}



















}
?>