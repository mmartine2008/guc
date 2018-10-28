<?php
class dt_tipo_impuesto extends guc_datos_tabla
{
	function get_listado()
	{
		$sql = "SELECT
			t_ti.id,
			t_ti.descripcion
		FROM
			tipo_impuesto as t_ti
		ORDER BY descripcion";
		return toba::db('guc')->consultar($sql);
	}

	function get_descripciones()
	{
		$sql = "SELECT id, descripcion FROM tipo_impuesto ORDER BY descripcion";
		return toba::db('guc')->consultar($sql);
	}











}
?>