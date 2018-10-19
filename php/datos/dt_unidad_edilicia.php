<?php
class dt_unidad_edilicia extends guc_datos_tabla
{
	function get_listado()
	{
		$sql = "SELECT
			t_ue.id,
			t_ue.partida_inmobiliaria,
			t_cc.descripcion as centro_costo_id_nombre,
			t_ue.descripcion
		FROM
			unidad_edilicia as t_ue	LEFT OUTER JOIN centro_costo as t_cc ON (t_ue.centro_costo_id = t_cc.id)
		ORDER BY descripcion";
		return toba::db('guc')->consultar($sql);
	}


}
?>