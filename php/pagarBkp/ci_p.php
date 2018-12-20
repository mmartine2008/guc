<?php
class ci_p extends guc_ci
{
	protected $s__datos_filtro;
	protected $seleccionados;


	//---- Filtro -----------------------------------------------------------------------

	function conf__filtro(toba_ei_formulario $filtro)
	{
		if (isset($this->s__datos_filtro)) {
			$filtro->set_datos($this->s__datos_filtro);
		}
	}

	function evt__filtro__filtrar($datos)
	{
		$this->s__datos_filtro = $datos;
	}

	function evt__filtro__cancelar()
	{
		unset($this->s__datos_filtro);
	}

	//---- Cuadro -----------------------------------------------------------------------

	function conf__cuadro(toba_ei_cuadro $cuadro)
	{
		if (isset($this->s__datos_filtro)) {
			$cuadro->set_datos($this->dep('datos')->tabla('costo_centro_costo')->get_listado_pagado($this->s__datos_filtro));
		} else {
			$cuadro->set_datos($this->dep('datos')->tabla('costo_centro_costo')->get_listado_pagado());
		}
	}

	function evt__cuadro__seleccion($datos)
	{
		$this->dep('datos')->cargar($datos);
	}

	//---- Formulario -------------------------------------------------------------------

	function conf__formulario(toba_ei_formulario $form)
	{
		if ($this->dep('datos')->esta_cargada()) {
			$form->set_datos($this->dep('datos')->tabla('costo_centro_costo')->get());
		}
	}

	function evt__formulario__alta($datos)
	{
		$this->dep('datos')->tabla('costo_centro_costo')->set($datos);
		$this->dep('datos')->sincronizar();
		$this->resetear();
	}

	function evt__formulario__modificacion($datos)
	{
		$this->dep('datos')->tabla('costo_centro_costo')->set($datos);
		$this->dep('datos')->sincronizar();
		$this->resetear();
	}

	function evt__formulario__baja()
	{
		$this->dep('datos')->eliminar_todo();
		$this->resetear();
	}

	function evt__formulario__cancelar()
	{
		$this->resetear();
	}

	function resetear()
	{
		$this->dep('datos')->resetear();
	}
	
	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	/**
		* Atrapa la interacción del usuario con el cuadro mediante los checks
		* @param array $datos Ids. correspondientes a las filas chequeadas.
		* El formato es de tipo recordset array(array('clave1' =>'valor', 'clave2' => 'valor'), array(....))
		*/
	function evt__cuadro__click($datos)
	{
		$this->seleccionados = $datos;
	}

	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		if (isset($this->s__datos_filtro)) 
			$datos = $this->dep('datos')->tabla('costo_centro_costo')->get_listado_pagado($this->s__datos_filtro);
		else
			$datos = $this->dep('datos')->tabla('costo_centro_costo')->get_listado_pagado();
		$max = count($datos);

		$js = "{$this->objeto_js}.evt__seleccionar = function()    { ";
		
		for ($i=0; $i<$max; $i++)
		{
			
				$js .= "js_cuadro_5025_cuadro.seleccionar($i, [ 'click' ]);";
			
		}
		$js .= "return false; }";

		echo $js;
	}
	//5025

	
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	/**
		* Atrapa la interacción del usuario a través del botón asociado. El método no recibe parámetros
		*/
	function evt__seleccionar()
	{
	}

	/**
		* Atrapa la interacción del usuario a través del botón asociado. El método no recibe parámetros
		*/
	function evt__pagar()
	{
		try
		{
			$cant = 0;
			$max = count($this->seleccionados);
			for ($i=0; $i<$max; $i++) 
			{
								
				$ccc = $this->seleccionados[$i];
				$ccc_id = $ccc['id'];
				if($ccc_id != null){
					$this->dep('datos')->tabla('costo_centro_costo')->cargar(array('id' => $ccc_id ));
					$filaFactura = $this->dep('datos')->tabla('costo_centro_costo')->get();
					$filaFactura['pagado']= 1;
					//'fecha_original' => '2006-10-26',
					$filaFactura['fecha_pago']=  date("Y-m-d");
					$this->dep('datos')->tabla('costo_centro_costo')->set($filaFactura);
					
					$this->dep('datos')->sincronizar();
				}
			}
			
			
			$this->resetear();
				
		}
		catch (Exception $e)
		{
			print_r($e->getMessage());
		}
		
	}
	
	
	/**
		* Atrapa la interacción del usuario a través del botón asociado. El método no recibe parámetros
		*/
	function evt__eliminar_fact()
	{
		try
		{
			$cant = 0;
			$max = count($this->seleccionados);
			for ($i=0; $i<$max; $i++) 
			{
								
				$ccc = $this->seleccionados[$i];
				$ccc_id = $ccc['id'];
				
				if($ccc_id != null){
					$this->dep('datos')->tabla('costo_centro_costo')->cargar(array('id' => $ccc_id ));
					$filaFactura = $this->dep('datos')->tabla('costo_centro_costo')->get();
					$filaFactura['pago_id']= null;
					//'fecha_original' => '2006-10-26',
					$this->dep('datos')->tabla('costo_centro_costo')->set($filaFactura);
					
					$this->dep('datos')->sincronizar();
				}
			}
			$this->resetear();
		}
		catch (Exception $e)
		{
			print_r($e->getMessage());
		}
		
	}

}
?>