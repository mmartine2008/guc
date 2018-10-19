<?php
class dt_tipo_centro_costo extends guc_datos_tabla
{
	function get_listado()
	{
		$sql = "SELECT
			t_tcc.id,
			t_tcc.descripcion
		FROM
			tipo_centro_costo as t_tcc
		ORDER BY descripcion";
		return toba::db('guc')->consultar($sql);
	}

		function get_descripciones()
		{
			$sql = "SELECT id, descripcion FROM tipo_centro_costo ORDER BY descripcion";
			return toba::db('guc')->consultar($sql);
		}









}
?>