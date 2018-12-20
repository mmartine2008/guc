<?php
class ci_reporte_prueba extends guc_ci
{
	protected $s__datos_filtro;


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

		private function calcularDatos($filtro=array())
		{
			//select ccc.fecha_vencimiento, t_c.descripcion as Costo, ccc.descripcion, ccc.periodo, ccc.importe as importe, t_cc.descripcion as CentroCosto
			$datosProcesar = $this->dep('datos')->tabla('costo')->get_listado_impagado($filtro);
			
			$max = count($datosProcesar);
			$datos = array ();
				for ($i=0; $i<$max; $i++) 
				{
					$fila = $datosProcesar[$i];
					$colVariable = 'cc'.$fila['centrocostoid'];
					$filaArray = array('id' => $i+1, 
						'fecha_vencimiento'=> $fila['fecha_vencimiento'],
						'descripcion' => $fila['descripcion'],
						'periodo' => $fila['periodo'],
							'costo' => $fila['costo'],
							$colVariable =>  $fila['importe'],
							'total' =>  $fila['importe']);
					
					$datos[$i+1] = $filaArray; 
				}
			
			return $datos;
			
		}        
				
	function conf__cuadro(toba_ei_cuadro $cuadro)
	{
			/*if (isset($this->s__datos_filtro)) {
				$datos = $this->dep('datos')->tabla('costo')->get_listado($this->s__datos_filtro);
			} else {
				$datos = $this->dep('datos')->tabla('costo')->get_listado();
			}*/
				
			$datos = $this->calcularDatos($this->s__datos_filtro);

			$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($datos)
	{
		$this->dep('datos')->cargar($datos);
		$this->set_pantalla('pant_edicion');
	}

	//---- Formulario -------------------------------------------------------------------

	function conf__formulario(toba_ei_formulario $form)
	{
		if ($this->dep('datos')->esta_cargada()) {
			$form->set_datos($this->dep('datos')->tabla('costo')->get_listado_pagado());
		} else {
			$this->pantalla()->eliminar_evento('eliminar');
		}
	}

	function evt__formulario__modificacion($datos)
	{
		$this->dep('datos')->tabla('costo')->set($datos);
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

	function evt__guardar()
	{
		$this->dep('datos')->sincronizar();
		$this->resetear();
	}

}
?>