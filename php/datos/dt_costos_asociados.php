<?php
class dt_costos_asociados extends guc_datos_tabla
{
	function get_listado()
	{
		$sql = "SELECT
			t_ca.id,
			t_cc.descripcion as id_centro_costo_nombre,
			t_c.descripcion as id_costo_nombre,
			t_ti.descripcion as id_tipo_identificador_nombre,
			t_ca.valor,
			t_ca.descripcion
		FROM
			costos_asociados as t_ca,
			centro_costo as t_cc,
			costo as t_c,
			tipo_identificador as t_ti
		WHERE
				t_ca.id_centro_costo = t_cc.id
			AND  t_ca.id_costo = t_c.id
			AND  t_ca.id_tipo_identificador = t_ti.id
		ORDER BY descripcion";
		return toba::db('guc')->consultar($sql);
	}

}

?>