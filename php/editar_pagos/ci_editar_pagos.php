<?php
class ci_editar_pagos extends guc_ci
{
	function ini__operacion()
	{
		$this->dep('datos')->cargar();
	}

	function evt__guardar()
	{
		$this->dep('datos')->sincronizar();
		$this->dep('datos')->resetear();
		$this->dep('datos')->cargar();
	}

	function evt__formulario__modificacion($datos)
	{
		echo("modificacion");
		$this->dep('datos')->sincronizar();
		$this->dep('datos')->resetear();
		$this->dep('datos')->cargar();
		
	}
	
	function evt__formulario__editarContenido($datos){
		echo("evento editarCont");
		$this->dep('datos')->procesar_filas($datos);
	}

	function conf__formulario(toba_ei_formulario_ml $componente)
	{
		$componente->set_datos($this->dep('datos')->get_filas());
	}

}
?>