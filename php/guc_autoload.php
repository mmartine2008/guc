<?php
/**
 * Esta clase fue y será generada automáticamente. NO EDITAR A MANO.
 * @ignore
 */
class guc_autoload 
{
	static function existe_clase($nombre)
	{
		return isset(self::$clases[$nombre]);
	}

	static function cargar($nombre)
	{
		if (self::existe_clase($nombre)) { 
			 require_once(dirname(__FILE__) .'/'. self::$clases[$nombre]); 
		}
	}

	static protected $clases = array(
		'guc_ci' => 'extension_toba/componentes/guc_ci.php',
		'guc_cn' => 'extension_toba/componentes/guc_cn.php',
		'guc_datos_relacion' => 'extension_toba/componentes/guc_datos_relacion.php',
		'guc_datos_tabla' => 'extension_toba/componentes/guc_datos_tabla.php',
		'guc_ei_arbol' => 'extension_toba/componentes/guc_ei_arbol.php',
		'guc_ei_archivos' => 'extension_toba/componentes/guc_ei_archivos.php',
		'guc_ei_calendario' => 'extension_toba/componentes/guc_ei_calendario.php',
		'guc_ei_codigo' => 'extension_toba/componentes/guc_ei_codigo.php',
		'guc_ei_cuadro' => 'extension_toba/componentes/guc_ei_cuadro.php',
		'guc_ei_esquema' => 'extension_toba/componentes/guc_ei_esquema.php',
		'guc_ei_filtro' => 'extension_toba/componentes/guc_ei_filtro.php',
		'guc_ei_firma' => 'extension_toba/componentes/guc_ei_firma.php',
		'guc_ei_formulario' => 'extension_toba/componentes/guc_ei_formulario.php',
		'guc_ei_formulario_ml' => 'extension_toba/componentes/guc_ei_formulario_ml.php',
		'guc_ei_grafico' => 'extension_toba/componentes/guc_ei_grafico.php',
		'guc_ei_mapa' => 'extension_toba/componentes/guc_ei_mapa.php',
		'guc_servicio_web' => 'extension_toba/componentes/guc_servicio_web.php',
		'guc_comando' => 'extension_toba/guc_comando.php',
		'guc_modelo' => 'extension_toba/guc_modelo.php',
	);
}
?>