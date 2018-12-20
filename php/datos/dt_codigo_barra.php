<?php
class dt_codigo_barra extends guc_datos_tabla
{
	function get_listado()
	{
		$sql = "SELECT
			t_cb.id,
			t_cb.identificador_inicio,
			t_cb.identificador_fin,
			t_cb.vto_inicio,
			t_cb.vto_fin,
			t_cb.monto_inicio,
			t_cb.monto_fin,
			t_cb.longitud_total,
			t_ff.formato as formato_fecha_id_nombre,
			t_cb.descripcion,
			t_cb.precision_monto,
			t_cb.periodo_inicio,
			t_cb.periodo_fin
		FROM
			codigo_barra as t_cb	LEFT OUTER JOIN formato_fecha as t_ff ON (t_cb.formato_fecha_id = t_ff.id)
		ORDER BY descripcion";
		return toba::db('guc')->consultar($sql);
	}




	function get_listado_por_longitud($long){
		$sql = $this->get_query_basica();
		
		$sql = $sql." where t_cb.longitud_total = ".$long;
		
		return toba::db('guc')->consultar($sql);
	}


	function get_descripciones()
	{
		$sql = "SELECT id, descripcion FROM codigo_barra ORDER BY descripcion";
		return toba::db('guc')->consultar($sql);
	}

	
	function get_query_basica(){
		$query = "SELECT
			t_cb.id,
			t_cb.identificador_inicio,
			t_cb.identificador_fin,
			t_cb.vto_inicio,
			t_cb.vto_fin,
			t_cb.monto_inicio,
			t_cb.monto_fin,
			t_cb.longitud_total,
			t_cb.descripcion,
			t_cb.precision_monto,
			t_cb.periodo_inicio,
			t_cb.periodo_fin,
			t_ff.formato
					FROM
						codigo_barra as t_cb    
						LEFT OUTER JOIN formato_fecha as t_ff ON (t_cb.formato_fecha_id = t_ff.id)";
		
		return $query;
	}



}
?>