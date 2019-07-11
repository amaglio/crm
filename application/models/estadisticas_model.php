<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estadisticas_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();

	}


	// Periodo de ingreso a la universidad por consulta

	function periodo_de_ingreso_anios($anio_principio=null, $anio_final=null)
	{
		chrome_log("periodo_de_ingreso_anios"); 

		$resultado = $this->db->query("	SELECT count(cpi.id_crm_periodo||'-'||cpi.anio) as cantidad, cp.descripcion||'-'||cpi.anio as descripcion
										FROM  crm_consulta c, 
										      crm_cons_periodo_ingreso cpi,
										      crm_periodo_ingreso cp
										WHERE c.id_crm_consulta = cpi.id_crm_consulta 
										AND cpi.id_crm_periodo = cp.id_periodo_ingreso
										group by (cp.descripcion||'-'||cpi.anio) "
											                				    		);

		return $resultado->result_array();
		 

		return $resultado;
	}

	// Trae los medios de consulta por periodo

	function medios_de_consulta_por_periodo_anios($anio_principio=null, $anio_final=null)
	{
		chrome_log("medios_de_consulta_por_periodo_anios");

		$resultado = $this->db->query("	SELECT cm.descripcion,count(cm.id_medio_consulta) as cantidad
										FROM crm_consulta c, crm_medio_consulta cm 
										WHERE   c.id_medio_consulta = cm.id_medio_consulta 
										GROUP BY Cm.descripcion "
											                				    		);

		return $resultado->result_array();


	}

	// Trae la informacion de interes

	function informacion_interes_por_periodo_anios($anio_principio=null, $anio_final=null)
	{
		chrome_log("informacion_interes_por_periodo_anios");

		$resultado = $this->db->query("	SELECT count(cii.id_info_interes) as cantidad,  ii.descripcion
										FROM  crm_consulta c, 
										      crm_consulta_info_interes cii,
										      crm_informacion_interes ii
										WHERE c.id_crm_consulta = cii.id_crm_consulta 
										AND cii.id_info_interes = ii.id_info_interes
										group by (ii.descripcion) " );

		return $resultado->result_array();


	}

}

/* End of file  */
/* Location: ./application/models/ */