<?php
class dt_tipo_identificador extends guc_datos_tabla
{
	function get_listado()
	{
		$sql = "SELECT
			t_ti.id,
			t_ti.descripcion
		FROM
			tipo_identificador as t_ti
		ORDER BY descripcion";
		return toba::db('guc')->consultar($sql);
	}

	function get_descripciones()
	{
		$sql = "SELECT id, descripcion FROM tipo_identificador ORDER BY descripcion";
		return toba::db('guc')->consultar($sql);
	}












}
?>