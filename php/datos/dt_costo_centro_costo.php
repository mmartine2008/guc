<?php
class dt_costo_centro_costo extends guc_datos_tabla
{
	function get_listado_pagado($filtro=array()){
		$filtro['pagado'] = '1';
		return $this->get_listado($filtro);
	}
	
	function get_listado_impago($filtro=array()){
		$filtro['pagado'] = '0';
		return $this->get_listado($filtro);
	}
	
	function get_listado($filtro=array())
	{
		$where = array();
		if (isset($filtro['costo_id'])) {
			$where[] = "costo_id = ".quote($filtro['costo_id']);
		}
		if (isset($filtro['centro_costo_id'])) {
			$where[] = "centro_costo_id = ".quote($filtro['centro_costo_id']);
		}
		if (isset($filtro['fecha_vencimiento_d'])) {
			$where[] = "fecha_vencimiento >= ".quote($filtro['fecha_vencimiento_d']);
		}
		if (isset($filtro['fecha_vencimiento_h'])) {
			$where[] = "fecha_vencimiento <= ".quote($filtro['fecha_vencimiento_h']);
		}
		if (isset($filtro['periodo'])) {
			$where[] = "periodo = ".quote($filtro['periodo']);
		}
		if (isset($filtro['numero_pago'])) {
			$where[] = "p.numero_pago = ".quote($filtro['numero_pago']);
		}
		if (isset($filtro['pagado'])) {
			if ($filtro['pagado'] == '1')
				$where[] = "pago_id is not null ";
			else
				$where[] = "pago_id is null ";
		}
		
		
		$sql = "SELECT
					t_ccc.id,
					t_cc.descripcion as centro_costo_id_nombre,
					t_c.descripcion as costo_id_nombre,
					t_ccc.fecha_vencimiento,
					t_ccc.importe,
					t_ccc.periodo,
					t_ccc.anio,
					t_ccc.pago_id,
					t_ccc.costo_id,
					t_ccc.centro_costo_id,
					t_ccc.descripcion,
					p.numero_pago
				FROM  
				costo as t_c,
				centro_costo as t_cc,
				costo_centro_costo t_ccc LEFT OUTER JOIN pagos as p ON (t_ccc.pago_id = p.id)
				WHERE
					t_ccc.costo_id = t_c.id
					AND  t_ccc.centro_costo_id = t_cc.id";
		
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		
		//echo($sql);
		return toba::db('guc')->consultar($sql);
	}




	function get_descripciones()
	{
		$sql = "SELECT id, codigo_barra FROM costo_centro_costo ORDER BY codigo_barra";
		return toba::db('guc')->consultar($sql);
	}

}
?>