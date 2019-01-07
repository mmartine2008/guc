<?php
class extension_seleccion_evt extends guc_ei_cuadro
{
	
	function conf_evt__seleccion($evento, $fila)
		{
			if (!($this->datos[$fila]['pago_id'] == null)) {
				$evento->anular();
			}
		}

	function conf_evt__eliminar($evento, $fila)
	{
			if (!($this->datos[$fila]['pago_id'] == null) ) {
				$evento->anular();    
			}
		}
	
}
?>