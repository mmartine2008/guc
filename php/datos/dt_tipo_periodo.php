<?php
class dt_tipo_periodo extends guc_datos_tabla
{
	function get_listado()
	{
		$sql = "SELECT
			t_tp.id,
			t_tp.descripcion
		FROM
			tipo_periodo as t_tp
		ORDER BY descripcion";
		return toba::db('guc')->consultar($sql);
	}

	function get_descripciones()
	{
		$sql = "SELECT id, descripcion FROM tipo_periodo ORDER BY descripcion";
		return toba::db('guc')->consultar($sql);
	}








}
?>