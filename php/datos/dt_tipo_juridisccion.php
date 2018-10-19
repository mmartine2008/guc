<?php
class dt_tipo_juridisccion extends guc_datos_tabla
{
	function get_listado()
	{
		$sql = "SELECT
			t_tj.id,
			t_tj.descripcion
		FROM
			tipo_juridisccion as t_tj
		ORDER BY descripcion";
		return toba::db('guc')->consultar($sql);
	}

	function get_descripciones()
	{
		$sql = "SELECT id, descripcion FROM tipo_juridisccion ORDER BY descripcion";
		return toba::db('guc')->consultar($sql);
	}

}
?>