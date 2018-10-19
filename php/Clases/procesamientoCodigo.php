<?php

class procesamientoCodigo
{
      
    static function get_importe($costo, $codigo)
    {
          if ($costo.codigoBarra != null) {
             if ($costo.codigoBarra.montoInicio != null && $costo.codigoBarra.montoFin != null) {
					$result = substr($codigo, $costo.codigoBarra.montoInicio, $costo.codigoBarra.montoFin);
                  return $result;
              } else{
                  return null;
              }
          } 
          return null;
    }

	static function get_fecha_vencimiento($costo, $codigo)
      {
          if ($costo.codigoBarra != null) {
              if ($costo.codigoBarra.vto_inicio != null && $costo.codigoBarra.vto_inicio != null) {
					$result = substr($codigo, $costo.codigoBarra.vto_inicio, $costo.codigoBarra.vto_inicio);
					//formatear fecha con el campo de formato
                  return $result;
              } else{
                  return null;
              }
          } 
          return null;
      }

	static function get_periodo($costo, $codigo)
      {
          if ($costo.codigoBarra != null) {
              //y el periodo?
              
          }
          return null;
      }
}