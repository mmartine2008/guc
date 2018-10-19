<?php
class dt_codigo_barra extends guc_datos_tabla
{
	function get_listado()
	{
		$sql = "SELECT
			t_cb.id,
			t_ti.descripcion as tipo_identificador_id_nombre,
			t_cb.identificador_inicio,
			t_cb.identificador_fin,
			t_cb.vto_inicio,
			t_cb.vto_fin,
			t_cb.monto_inicio,
			t_cb.monto_fin,
			t_cb.longitud_total,
			t_cb.descripcion,
			t_cb.precision_monto,
			t_ff.formato
					FROM
						codigo_barra as t_cb    
						LEFT OUTER JOIN tipo_identificador as t_ti ON (t_cb.tipo_identificador_id = t_ti.id)
						LEFT OUTER JOIN formato_fecha as t_ff ON (t_cb.formato_fecha_id = t_ff.id)";
		return toba::db('guc')->consultar($sql);
	}




	function get_descripciones()
	{
		$sql = "SELECT
			t_cb.id,
			'(' || t_cb.id  || ')' || t_ti.descripcion || ' - '|| t_cb.descripcion as descripcion
		FROM
			codigo_barra as t_cb    
			LEFT OUTER JOIN tipo_identificador as t_ti 
			ON (t_cb.tipo_identificador_id = t_ti.id)";

		return toba::db('guc')->consultar($sql);
	}

}
?>