<?php
class dt_formato_fecha extends guc_datos_tabla
{
	function get_listado()
	{
		$sql = "SELECT
			t_ff.id,
			t_ff.formato
		FROM
			formato_fecha as t_ff
		ORDER BY formato";
		return toba::db('guc')->consultar($sql);
	}





	function get_descripciones()
	{
		$sql = "SELECT id, formato FROM formato_fecha ORDER BY formato";
		return toba::db('guc')->consultar($sql);
	}



}
?>