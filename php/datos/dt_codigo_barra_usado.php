<?php
class dt_codigo_barra_usado extends guc_datos_tabla
{
	function get_listado()
	{
		$sql = "SELECT
			t_cbu.id,
			t_c.descripcion as id_costo_nombre,
			t_cbu.codigo_barra,
			t_cbu.fecha_utilizacion
		FROM
			codigo_barra_usado as t_cbu,
			costo as t_c
		WHERE
				t_cbu.id_costo = t_c.id
		ORDER BY codigo_barra";
		return toba::db('guc')->consultar($sql);
	}

}

?>