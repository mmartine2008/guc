<?php
/** class ci_costro_centro_costo extends guc_ci
{
	//---- Cuadro -----------------------------------------------------------------------

	function conf__cuadro(toba_ei_cuadro $cuadro)
	{
		$cuadro->set_datos($this->dep('datos')->tabla('costo_centro_costo')->get_listado());
	}

	function evt__cuadro__eliminar($datos)
	{
		$this->dep('datos')->resetear();
		$this->dep('datos')->cargar($datos);
		$this->dep('datos')->eliminar_todo();
		$this->dep('datos')->resetear();
	}

	function evt__cuadro__seleccion($datos)
	{
		$this->dep('datos')->cargar($datos);
		$this->set_pantalla('pant_edicion');
	}

	//---- Formulario -------------------------------------------------------------------

	/**   function conf__formulario(toba_ei_formulario $form)
	{
		if ($this->dep('datos')->esta_cargada()) {
			$form->set_datos($this->dep('datos')->tabla('costo_centro_costo')->get());
		} else {
			$this->pantalla()->eliminar_evento('eliminar');
		}
	}

	function evt__formulario__modificacion($datos)
	{
		$this->dep('datos')->tabla('costo_centro_costo')->set($datos);
	}

	function resetear()
	{
		$this->dep('datos')->resetear();
		$this->set_pantalla('pant_seleccion');
	}

	//---- EVENTOS CI -------------------------------------------------------------------

	/**
	function evt__agregar()
	{
		$this->set_pantalla('pant_edicion');
	}

	function evt__volver()
	{
		$this->resetear();
	}

	function evt__eliminar()
	{
		$this->dep('datos')->eliminar_todo();
		$this->resetear();
	}

	function evt__guardar()
	{
		$this->dep('datos')->sincronizar();
		$this->resetear();
	}

} **/





class ci_costro_centro_costo extends guc_ci
{
		protected $s__datos_seleccionados;
				
	//---- Cuadro -----------------------------------------------------------------------

	function conf__cuadro(toba_ei_cuadro $cuadro)
	{
		$cuadro->set_datos($this->dep('datos')->tabla('costo_centro_costo')->get_listado());
	}

	function evt__cuadro__eliminar($datos)
	{
		$this->dep('datos')->resetear();
		$this->dep('datos')->cargar($datos);
		$this->dep('datos')->eliminar_todo();
		$this->dep('datos')->resetear();
	}

	function evt__cuadro__seleccion($datos)
	{
		$this->dep('datos')->cargar($datos);
		$this->set_pantalla('pant_datos');
	}

	//---- Formulario -------------------------------------------------------------------

	function conf__formulario(toba_ei_formulario $form)
	{
		if ($this->dep('datos')->esta_cargada()) {
			//$form->set_datos($this->dep('datos')->tabla('costo_centro_costo')->get(array('id'=>$this->s__datos_seleccionados)));
			$form->set_datos($this->dep('datos')->tabla('costo_centro_costo')->get());
		} else {
			$this->pantalla()->eliminar_evento('eliminar');
		}
	}

	function evt__formulario__modificacion($datos)
	{
			$this->dep('datos')->tabla('costo_centro_costo')->set($datos);
				

	}

	function resetear()
	{
		$this->dep('datos')->resetear();
		$this->set_pantalla('pant_seleccion');
	}

	//---- EVENTOS CI -------------------------------------------------------------------

	function evt__agregar()
	{
		$this->set_pantalla('pant_edicion');
	}

	function evt__volver()
	{
		$this->resetear();
	}

	function evt__eliminar()
	{
		$this->dep('datos')->eliminar_todo();
		$this->resetear();
	}

		/**
			* Lo cancelamos porque el lectr emite un ENTER
			*/
	function evt__guardar()
	{
		//echo(" evento guardar ");
		//ei_arbol($this->dep('datos'));
		$this->dep('datos')->sincronizar();
		$this->resetear();
	}

		
		function actualizarImporte($costo_id, $codigo_barra)
		{
			die(__file__);
		}

	//-----------------------------------------------------------------------------------
	//---- formulario -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__formulario__procesar($datos)
	{
			$this->s__datos_seleccionados = $datos;
			if($this->validar_codigo_form($datos)){
				$this->set_pantalla('pant_datos');
			}else{
				toba::notificacion()->agregar('El codigo de barra ya fue cargado');
			}
	}


	
	function getGenerico($codigo_barra, $inicio, $fin)
	{
		if($inicio != null && $fin != null){
			$cantidad = $fin - $inicio + 1;
			$posInicial = $inicio -1;
			
			$result = substr($codigo_barra, $posInicial , $cantidad);
			return $result;
		}
		return null;
	}
	
	
	function getImporte($codigo_barra, $inicio, $fin, $precisionMonto)
	{
		$importe = $this->getGenerico($codigo_barra, $inicio, $fin);
		
		if($precisionMonto != null && $precisionMonto!=0)
			$importe = $importe / $precisionMonto;
			
		return $importe;
		
	}
	
	
	function getFechaVto($codigo_barra_cargado, $fechaInicio, $fechaFin,  $formatoFechaId )
	{
		$fecha_final = null;  
		if($formatoFechaId!= null){
			$formatos = toba::tabla('formato_fecha');
			$formatos->cargar(array('id' => $formatoFechaId ));
			$filaFormatoFecha = $formatos->get();
			
			$formatoFecha =  $filaFormatoFecha ['formato'];
			
			$fecha = $this->getGenerico($codigo_barra_cargado, $fechaInicio, $fechaFin);
									
			if($formatoFecha == 'ddmmyy'){
				
				$i = 0;
				$dia= substr($fecha, $i, 2);
				
				$i = $i +2;
				$mes= substr($fecha, $i, 2);
				$i = $i +2;
				
				$anio= "20".substr($fecha, $i, 2);
				
				//'fecha_original' => '2006-10-26',
				$fecha_final = $anio."-".$mes."-".$dia;
				
			}else if($formatoFecha == 'ddmmyyyy'){
				$i = 0;
				$dia= substr($fecha, $i, 2);
				
				$i = $i +2;
				$mes= substr($fecha, $i, 2);
				$i = $i +2;
				
				$anio= substr($fecha, $i, 4);
				
				//'fecha_original' => '2006-10-26',
				$fecha_final = $anio."-".$mes."-".$dia;
			} else if($formatoFecha == 'yymmdd'){
				$i = 0;
				$anio= substr($fecha, $i, 2);
				
				$i = $i +2;
				$mes= substr($fecha, $i, 2);
				
				$i = $i +2;
				$dia= substr($fecha, $i, 2);
				
				//'fecha_original' => '2006-10-26',
				$fecha_final = $anio."-".$mes."-".$dia;
			} 
		}      
		return $fecha_final;
		}
	
		
	//-----------------------------------------------------------------------------------
	//---- form_datos -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	
	
	function getIdCentroCostoAsociado($codigo_barra_cargado, $identificadorInicio, 
										$identificadorFin, $tipoIdentId, $idCosto)
	{
		$valor = $this->getGenerico($codigo_barra_cargado, $identificadorInicio, $identificadorFin);
		
		$costos= toba::tabla('costos_asociados');
		$costos->cargar(array('id_tipo_identificador' => $tipoIdentId, 
								'id_costo' => $idCosto, 
								'valor' => $valor ));
		
		$filaCostosAsociados = $costos->get();
		
		
		//$centroCostoId =  $filaCostosAsociados['id_centro_costo'];
		
		/**
		select id_centro_costo from costos_asociados 
		where id_costo =1 
		and id_tipo_identificador = 1
		and valor = '12345'
		*/
		
		//return $centroCostoId;
		
		//ei_arbol($filaCostosAsociados);
		return $filaCostosAsociados;
	}
	
	function validar_codigo_form($datos){
		if ($this->dep('datos')->esta_cargada()) {
						//nada
			} else {
				$costo_id = $this->s__datos_seleccionados['costo_id'];
				$codigo_barra_cargado = $this->s__datos_seleccionados['codigo_barra'];
				
				$longitud = strlen($codigo_barra_cargado);
				
				
				//valido si el codigo de barra ya fue usado
				
				if($codigo_barra_cargado != null){
					return $this->validar_codigo_disponible($costo_id, $codigo_barra_cargado);
						
				}
					
		}
	}
	
	
	function validar_codigo_disponible($costo_id, $codigo_barra_cargado){
		$filaCodigo = null;
		
		$this->dep('datos')->tabla('codigo_barra_usado')->cargar(array('id_costo' => $costo_id,
																		'codigo_barra' => $codigo_barra_cargado));
		$filaCodigo = $this->dep('datos')->tabla('codigo_barra_usado')->get_filas(array('id_costo' => $costo_id,
																						'codigo_barra' => $codigo_barra_cargado));
		
		
		if ($filaCodigo  != null){
			//esta usado
			return false;
		}else{
			return true;
		}
		
	}
	
	function conf__form_datos(guc_ei_formulario $form)
	{
			$importe = null;
			$fecha = null;
			$centro_costo_id = null;
			$descripcion = null;
			$periodo = null;
				if ($this->dep('datos')->esta_cargada()) {
					$datos = $this->dep('datos')->tabla('costo_centro_costo')->get();
				} else {
					$costo_id = $this->s__datos_seleccionados['costo_id'];
					$codigo_barra_cargado = $this->s__datos_seleccionados['codigo_barra'];
					
					//valido si el codigo de barra ya fue usado
					
					if($codigo_barra_cargado != null){
						
							if($this->validar_codigo_disponible($costo_id, $codigo_barra_cargado)){
																
								//obtengo el id del codigo de barra 
								$this->dep('datos')->tabla('costo')->cargar(array('id' => $costo_id));
								$filaCosto = $this->dep('datos')->tabla('costo')->get();
								$idCodBarra = $filaCosto['codigo_barra_id'];
								
								if($idCodBarra != null){
									$codigosBarra = toba::tabla('codigo_barra');
									$codigosBarra->cargar(array('id' => $idCodBarra ));
									$filaCodigoBarra = $codigosBarra->get();
									
									
									$identificadorInicio =  $filaCodigoBarra['identificador_inicio'];
									$identificadorFin =  $filaCodigoBarra['identificador_fin'];
									$tipoIdentId =  $filaCodigoBarra['tipo_identificador_id'];
									
									
									// $centro_costo_id = $this->getIdCentroCostoAsociado($codigo_barra_cargado, $identificadorInicio, 
									//                                                     $identificadorFin, $tipoIdentId, $costo_id);
									$filaCostosAsociados = $this->getIdCentroCostoAsociado($codigo_barra_cargado, $identificadorInicio, 
																						$identificadorFin, $tipoIdentId, $costo_id);
									if($filaCostosAsociados != null){
										$centro_costo_id = $filaCostosAsociados['id_centro_costo'];
										$descripcion = $filaCostosAsociados['descripcion'];
									}else{
										// no hay costo asociado
										toba::notificacion()->agregar('El codigo de barra no pertenece a un costo asociado');
										// }
									}    
									
									$fechaInicio =  $filaCodigoBarra['vto_inicio'];
									$fechaFin = $filaCodigoBarra['vto_fin'];
									$formatoFechaId = $filaCodigoBarra['formato_fecha_id'];
									
									$fecha = $this->getFechaVto($codigo_barra_cargado, $fechaInicio, $fechaFin,  $formatoFechaId );
									
									$montoInicio =  $filaCodigoBarra['monto_inicio'];
									$montoFin = $filaCodigoBarra['monto_fin'];
									$precisionMonto = $filaCodigoBarra['precision_monto'];
									
									
									$importe = $this->getImporte($codigo_barra_cargado, $montoInicio, $montoFin, $precisionMonto);
									
									$periodoInicio = $filaCodigoBarra['periodo_inicio'];
									$periodoFin = $filaCodigoBarra['periodo_fin'];
									$periodo = $this->getGenerico($codigo_barra_cargado, $periodoInicio, $periodoFin);
									
								}
								
								$datos['codigo_barra'] = $codigo_barra_cargado;
								$datos['importe'] = $importe;
								$datos['fecha_vencimiento'] = $fecha;
								$datos['costo_id'] = $costo_id;
								$datos['centro_costo_id'] = $centro_costo_id;
								$datos['descripcion'] = $descripcion;
								$datos['periodo'] = $periodo;
								
								$this->pantalla()->eliminar_evento('eliminar');
							}
						
					}
				}
		
				$form->set_datos($datos);            
			
	}

	function evt__form_datos__modificacion($datos)
	{
		//echo(" evt__form_datos__modificacion ");
		
		if ($this->dep('datos')->esta_cargada()) {
			//echo(" modif ");
			//ei_arbol($datos);
			$this->dep('datos')->sincronizar();
			$this->resetear();
			
			//es una modificacion;
			/* if($datos['pagado'] == '0'){
				$datos['fecha_pago']=  null;
			}
			else{ //esta pagado
				if($datos['fecha_pago'] == null){
					*/
					// esta pagado, si no tiene fecha de pago se la seteo 
					//(asumo que esta cambiando de NO PAGADO a PAGADO) 
			/*        $datos['fecha_pago']=  date("Y-m-d");
				}
			}
			*/
			
		} else {
			//es un alta
			/*echo(" alta ");
			ei_arbol($datos);
			*/
			/*if($datos['pagado']){
				$datos['fecha_pago']=  date("Y-m-d");
			}
			*/
			//cargo el nuevo codigo de barra usado
			if($datos['codigo_barra'] != null){
				$codUsado = $this->agregarCodigoUsado($datos);
				$this->dep('datos')->tabla('codigo_barra_usado')->set($codUsado);
				}
			$this->dep('datos')->tabla('costo_centro_costo')->set($datos);
		
			$this->dep('datos')->sincronizar();
		
		}
				
		
	}
	
	function agregarCodigoUsado($datos){
		$usados= toba::tabla('codigo_barra_usado');
		$usados->cargar();
		
		$nuevoCodigo['codigo_barra'] =  $datos['codigo_barra'];
		$nuevoCodigo['id_costo'] =  $datos['costo_id'];
		$nuevoCodigo['fecha_utilizacion'] =  date("Y-m-d");
		$nuevoCodigo['id'] = $usados->get_proximo_id( )+1;
		
		//$this->dep('datos')->tabla('codigo_barra_usado')->set($nuevoCodigo);
		
		return $nuevoCodigo;
	}

}
?>